<?php

namespace App\Http\Requests;

use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $propertyId = $this->route('property')?->id;

        return [
             //  Agent optionnel en validation (sera ajouté automatiquement)
            'agent_id' => ['nullable', 'exists:agents,id'], 
            
            // Informations générales
            'title' => ['required', 'string', 'max:200'],
            'slug' => [
                'nullable',  //  Le slug sera auto-généré
                'string',
                'max:220',
                Rule::unique('properties', 'slug')->ignore($propertyId)
            ],
            'description' => ['nullable', 'string'],

            // Type et statut (Enums)
            'type' => [
                'required',
                Rule::enum(PropertyType::class)  //  Meilleure validation pour Enum
            ],
            'status' => [
                'required',
                Rule::enum(PropertyStatus::class)  //  Meilleure validation pour Enum
            ],

            // Prix et dimensions
            'price' => ['required', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'gt:price'],
            'min_price' => ['nullable', 'numeric','gt:price'],
            'surface' => ['nullable', 'integer', 'min:0'],

            // Caractéristiques
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:255'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:255'],
            'floors' => ['nullable', 'integer', 'min:0', 'max:255'],
            'year_built' => [
                'nullable',
                'integer',
                'min:1800',
                'max:' . (date('Y') + 5) 
            ],

            // Adresse
            'address' => ['required', 'string', 'max:155'],
            'city' => ['required', 'string', 'max:50'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:80'],

            // Options de publication
            'is_featured' => ['nullable', 'boolean'],  //  nullable pour les checkboxes
            'is_published' => ['nullable', 'boolean'], //  nullable pour les checkboxes
            // Accepte un seul fichier image pour la couverture (interdit les tableaux / envois multiples)
            'cover_image' => ['nullable', 'file', 'image', 'max:4048', 'mimes:jpeg,png,jpg,gif,svg,webp'],
            'cover_image.*' => ['prohibited'],
            'images'   => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['exists:amenities,id'],

        ];
    }

    /**
     * Préparer les données avant validation
     */
    protected function prepareForValidation(): void
    {
        // Convertir les checkboxes
        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
            'is_published' => $this->boolean('is_published'),
        ]);

        // Auto-générer le slug
        if (empty($this->slug) && !empty($this->title)) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->title)
            ]);
        }

        //  AUTO-ASSIGNATION DE L'AGENT
        if (empty($this->agent_id) && Auth::check()) {
            $agentId = $this->resolveAgentId();
            if ($agentId) {
                $this->merge(['agent_id' => $agentId]);
            }
        }
    }

    /**
     * Résoudre l'ID de l'agent selon le rôle de l'utilisateur connecté
     */
    protected function resolveAgentId(): ?int
    {
        $user = Auth::user();

        // Si l'utilisateur est un agent, utiliser son ID agent
        if ($user->role === 'agent') {
            $agent = Agent::where('user_id', $user->id)->first();
            
            if (!$agent) {
                // L'utilisateur a le rôle agent mais pas d'entrée dans la table agents
                abort(403, 'Votre profil agent n\'est pas encore configuré. Contactez l\'administrateur.');
            }
            
            return $agent->id;
        }

        // Si admin, prendre le premier agent actif
        if ($user->role === 'admin') {
            $firstAgent = Agent::where('is_active', true)->first();
            
            if (!$firstAgent) {
                abort(500, 'Aucun agent actif disponible dans le système.');
            }
            
            return $firstAgent->id;
        }

        // Les buyers ne peuvent pas créer de propriétés
        if ($user->role === 'buyer') {
            abort(403, 'Les acheteurs ne peuvent pas créer de biens immobiliers.');
        }

        return null;
    }

    /**
     *  GESTION DES ERREURS DE VALIDATION AVEC DEBUG
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // En développement, afficher les erreurs avec dd()
        if (config('app.debug')) {
            dd([
                'errors' => $validator->errors()->toArray(),
                'request_data' => $this->all(),
                'user' => Auth::user(),
                'agent_id_resolved' => $this->agent_id ?? 'non défini',
            ]);
        }

        // En production, comportement normal
        parent::failedValidation($validator);
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre du bien est obligatoire.',
            'title.max' => 'Le titre ne peut pas dépasser 200 caractères.',

            'description.required' => 'Une description est nécessaire.',

            'type.required' => 'Veuillez sélectionner un type de bien.',
            'type.enum' => 'Le type de bien sélectionné est invalide.',

            'status.required' => 'Veuillez sélectionner un statut.',
            'status.enum' => 'Le statut sélectionné est invalide.',

            'price.required' => 'Le prix est obligatoire.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix ne peut pas être négatif.',

            'bedrooms.integer' => 'Le nombre de chambres doit être un entier.',
            'bathrooms.integer' => 'Le nombre de salles de bain doit être un entier.',

            'year_built.integer' => 'L\'année de construction doit être un nombre.',
            'year_built.min' => 'L\'année de construction ne peut pas être antérieure à 1800.',
            'year_built.max' => 'L\'année de construction semble incorrecte.',

            'address.required' => 'L\'adresse est obligatoire.',
            'city.required' => 'La ville est obligatoire.',

            'slug.unique' => 'Ce slug est déjà utilisé par un autre bien.',
        ];
    }

    /**
     * Attributs personnalisés pour les messages d'erreur
     */
    public function attributes(): array
    {
        return [
            'title' => 'titre',
            'description' => 'description',
            'type' => 'type de bien',
            'status' => 'statut',
            'price' => 'prix',
            'surface' => 'surface',
            'bedrooms' => 'nombre de chambres',
            'bathrooms' => 'nombre de salles de bain',
            'floors' => 'nombre d\'étages',
            'year_built' => 'année de construction',
            'address' => 'adresse',
            'city' => 'ville',
            'state' => 'région',
            'zip_code' => 'code postal',
            'country' => 'pays',
            'is_featured' => 'mise en avant',
            'is_published' => 'publication',
        ];
    }
}