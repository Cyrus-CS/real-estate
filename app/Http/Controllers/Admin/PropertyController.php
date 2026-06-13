<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Http\Requests\PropertyRequest;
use App\Models\Agent;
use App\Models\Amenity;
use App\Models\Property;
use App\Models\Rent;
use App\Models\Transaction;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertyController extends BaseController
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !in_array(Auth::user()->role, ['agent', 'admin'])) {
                abort(403, 'Accès refusé. Seuls les agents et administrateurs peuvent gérer les biens.');
            }
            return $next($request);
        });
    }
    
    public function index()
    {
        $user = Auth::user();
        
        // Si agent, filtrer uniquement ses propriétés
        if ($user->role === 'agent') {
            $agent = Agent::where('user_id', $user->id)->firstOrFail();
            $properties = Property::with('images')
                ->where('agent_id', $agent->id)
                ->latest()
                ->get();
        } else {
            // Admin voit toutes les propriétés
            $properties = Property::with('images', 'amenities')->get();
        }
        
        return view('admin.properties.index', [
            'properties' => $properties,
            'totalProperties' => $properties->count(),
            'soldProperties' => $properties->where('status', 'sold')->count(),
            'rents' => Rent::count(),
            'totalRevenue' => Transaction::sum('amount_cents') ?? 0,
            'cities' => $properties->pluck('city')->unique()->sort()->values(),
            'statuses' => PropertyStatus::toArray(),
            'types' => PropertyType::toArray(),
        ]);
    }


    public function create()
    {
        $property = new Property();
        $property->fill([
            'title' => 'Appartement à louer',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, doloremque, cumque, dolores deleniti doloremque, cumque, dolores deleniti doloremque, cumque, dolores deleniti doloremque, cumque, dolores deleniti doloremque, cum',
            'type' => PropertyType::APARTMENT->value,    // Utilisez ->value
            'status' => PropertyStatus::FOR_SALE->value,
            'price' => 1500, 
            'surface' => 80,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'floors' => 1,
            'year_built' => 2010,
            'address' => '123 Main St',
            'city' => 'New York',
            'state' => 'NY',
            'zip_code' => '10001',
            'country' => 'USA',
            'is_featured' => true,
            'is_published' => false  
        ]);
        
        return view('share.form',[
            'property' => $property,
            'types' => PropertyType::toArray(),      // Options pour le select
            'statuses' => PropertyStatus::toArray() ,
            'amenities' => Amenity::all()->pluck('name', 'id')->toArray() // Liste des amenities pour le multi-select
        ]);
    }

    public function store(PropertyRequest $request)
    {
        try {
            $validated = $request->validated();

            // Vérification finale (normalement déjà fait dans prepareForValidation)
            if (empty($validated['agent_id'])) {
                return back()
                    ->withInput()
                    ->withErrors(['agent_id' => 'Impossible d\'assigner un agent. Vérifiez votre profil.']);
            }

            $property = Property::create(collect($validated)->except(['images', 'amenities'])->toArray());
            $this->saveImage($request, $property);
            $this->syncAmenities($property, $request);

            return redirect()
                ->route('admin.property.index')
                ->with('success', 'Bien créé avec succès.');

        } catch (\Exception $e) {
            // DEBUG en développement
            if (config('app.debug')) {
                dd([
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'validated_data' => $validated ?? 'validation échouée',
                    'user' => Auth::user(),
                ]);
            }

            return back()
                ->withInput()
                ->withErrors(['error' => 'Erreur lors de la création : ' . $e->getMessage()]);
        }

    }

    public function edit(Property $property)
    {
        return view('share.form',[
            'property' => $property,
            'types' => PropertyType::toArray(),    
            'statuses' => PropertyStatus::toArray() ,
            'amenities' => Amenity::all()->pluck('name', 'id')->toArray() 
        ]);
    }

    public function update(PropertyRequest $request, Property $property)
    {
        $validated = $request->validated();
        // Exclure `cover_image` de la mise à jour de masse pour laisser `saveImage` gérer le fichier
        $property->update(collect($validated)->except(['images', 'amenities', 'cover_image'])->toArray());
        
        $this->saveImage($request, $property);
        $this->syncAmenities($property, $request);
        
        return redirect()->route('admin.properties.index')->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('admin.properties.index')->with('success', 'Property deleted successfully.');
    }


    public function saveImage(PropertyRequest $request, Property $property)
    {
        // ── Image principale ─────────
        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image');

            // Ignorer si le fichier est invalide (la validation devrait prévenir ceci)
            if (!$cover->isValid()) {
                return;
            }

            // Supprimer l'ancienne image principale si elle existe et si le fichier est présent
            if ($property->cover_image && Storage::disk('public')->exists($property->cover_image)) {
                Storage::disk('public')->delete($property->cover_image);
            }

            // Stocker et sauvegarder le nouveau chemin
            $path = $cover->store('properties/covers', 'public');
            if ($path) {
                $property->cover_image = $path;
                $property->save();
            }
        }

        // ── Images secondaires ──────
        if ($request->hasFile('images')) {
            // Supprimer les anciennes images secondaires
            foreach ($property->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->image_path);
            }
            $property->images()->delete();

            foreach ($request->file('images') as $index => $image) {
                if (!$image->isValid()) {
                    return back()->withErrors([
                        'images' => 'Image invalide : ' . $image->getClientOriginalName()
                    ]);
                }

                $property->images()->create([
                    'image_path' => $image->store('properties/gallery', 'public'),
                    'sort_order' => $index,
                ]);
            }
        }
    }

    public function syncAmenities(Property $property, PropertyRequest $request) {
        $property->amenities()->sync($request->validated()['amenities'] ?? []);
    }
}