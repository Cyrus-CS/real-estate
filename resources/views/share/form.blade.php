@extends('admin.admin')
@section('title', $property->exists ? "Modifier le bien" : "Création d'un nouveau bien")

@section('content')

<div class="container-fluid px-4">

    <!-- En-tête avec breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <!--<nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.property.index') }}">Biens immobiliers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $property->exists ? 'Modifier' : 'Créer' }}
                    </li>
                </ol>
            </nav>-->
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0 fw-bold text-center mt-2">
                    @yield('title')
                </h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <form method="post"
        action="{{ $property->exists ? route('admin.property.update', $property) : route('admin.property.store') }}"
        enctype="multipart/form-data" id="propertyForm">
        @method($property->exists ? 'PUT' : 'POST')
        @csrf

        <div class="row g-4">
            <!-- Colonne principale (gauche) -->
            <div class="col-lg-8">

                <!-- Section 1: Informations générales -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Informations générales
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Titre du bien -->
                        <div class="mb-4">
                            <x-input-property name="title" label="Titre du bien" :value="old('title', $property->title)"
                                id="title" placeholder="Ex: Magnifique appartement avec vue sur mer">
                            </x-input-property>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-property name="description" label="Description détaillée" type="textarea"
                                :value="old('description', $property->description)" id="description"
                                placeholder="Décrivez les caractéristiques, les atouts et l'environnement du bien...">
                            </x-input-property>
                            <small class="text-muted">
                                <i class="bi bi-lightbulb me-1"></i>
                                Une description complète augmente vos chances de vente
                            </small>
                        </div>

                        <!-- Prix et Surface -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <x-input-property name="price" label="Prix" :value="old('price', $property->price)"
                                    id="price" placeholder="0.00">
                                    <template #prepend>
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-currency-dollar"></i>
                                        </span>
                                    </template>
                                </x-input-property>
                            </div>
                            <div class="col-md-6">
                                <x-input-property name="surface" label="Surface"
                                    :value="old('surface', $property->surface)" id="surface" placeholder="0">
                                    <template #append>
                                        <span class="input-group-text bg-light">m²</span>
                                    </template>
                                </x-input-property>
                            </div>

                        </div>
                        {{-- Image principale : un seul fichier --}}
                        <div class="mb-3">
                            <x-input-property name="cover_image" label="Image principale" type="file" id="cover_image">
                            </x-input-property>
                        </div>
                        {{-- Images secondaires  --}}
                        <div class="mb-4 mt-3">
                            <x-input-property name="images" label="Images du bien" id="images" type="file" multiple>
                            </x-input-property>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Caractéristiques -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-rulers me-2"></i>
                            Caractéristiques du bien
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <x-input-property name="bedrooms" label="Chambres"
                                    :value="old('bedrooms', $property->bedrooms)" id="bedrooms" type="number" min="0">
                                    <template #prepend>
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-door-closed"></i>
                                        </span>
                                    </template>
                                </x-input-property>
                            </div>
                            <div class="col-md-4">
                                <x-input-property name="bathrooms" label="Salles de bain"
                                    :value="old('bathrooms', $property->bathrooms)" id="bathrooms" type="number"
                                    min="0">
                                    <template #prepend>
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-droplet"></i>
                                        </span>
                                    </template>
                                </x-input-property>
                            </div>
                            <div class="col-md-4">
                                <x-input-property name="floors" label="Étages" :value="old('floors', $property->floors)"
                                    id="floors" type="number" min="0">
                                    <template #prepend>
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-building"></i>
                                        </span>
                                    </template>
                                </x-input-property>
                            </div>

                        </div>
                        <div class="mt-4">
                            <x-select-property name="amenities" label="Équipements & Commodités"
                                :value="old('amenities', $property->amenities->pluck('id')->toArray() ?? [])"
                                :options="$amenities" id="amenities" :multiple="true">
                            </x-select-property>
                        </div>

                        <div class=" mt-3">
                            <x-input-property name="year_built" label="Année de construction"
                                :value="old('year_built', $property->year_built)" type="number" min="1800"
                                max="{{ date('Y') + 5 }}" placeholder="Ex: 2020">
                                <template #prepend>
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-calendar-event"></i>
                                    </span>
                                </template>
                            </x-input-property>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Localisation -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-geo-alt me-2"></i>
                            Localisation
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <x-input-property name="address" label="Adresse complète"
                                :value="old('address', $property->address)" id="address"
                                placeholder="Numéro et nom de rue">
                                <template #prepend>
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-house-door"></i>
                                    </span>
                                </template>
                            </x-input-property>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <x-input-property name="city" label="Ville" :value="old('city', $property->city)"
                                    id="city" placeholder="Ex: Paris">
                                </x-input-property>
                            </div>
                            <div class="col-md-6">
                                <x-input-property name="state" label="Région / État"
                                    :value="old('state', $property->state)" id="state" placeholder="Ex: Île-de-France">
                                </x-input-property>
                            </div>
                        </div>

                        <div class="mt-3">
                            <x-input-property name="zip_code" label="Code postal"
                                :value="old('zip_code', $property->zip_code)" id="zip_code" placeholder="Ex: 75001">
                                <template #prepend>
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-mailbox"></i>
                                    </span>
                                </template>
                            </x-input-property>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Colonne secondaire (droite) -->
            <div class="col-lg-4">

                <!-- Section: Statut et Type -->
                <div class="card shadow-sm mb-4 position-sticky" style="top: 20px;">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-gear me-2"></i>
                            Configuration
                        </h5>
                    </div>
                    <div class="card-body p-4">

                        <!-- Type de bien -->
                        <div class="mb-4">
                            <x-select-property name="type" label="Type de bien"
                                :value="old('type', $property->type?->value ?? '')" :options="$types" id="type">
                                <template #icon>
                                    <i class="bi bi-house"></i>
                                </template>
                            </x-select-property>
                        </div>

                        <!-- Statut -->Type de
                        <div class="mb-4">
                            <x-select-property name="status" label="Statut"
                                :value="old('status', $property->status?->value ?? '')" :options="$statuses"
                                id="status">
                                <template #icon>
                                    <i class="bi bi-flag"></i>
                                </template>
                            </x-select-property>
                        </div>

                        <hr class="my-4">

                        <!-- Options de publication -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold mb-3">
                                <i class="bi bi-toggles me-2"></i>
                                Options de publication
                            </label>

                            <div class="form-check form-switch mb-3 p-3 bg-light rounded">
                                <x-checkbox-property name="is_published" label="Publier le bien"
                                    :value="old('is_published', $property->is_published)" id="is_published">
                                </x-checkbox-property>
                                <small class="text-muted d-block mt-1">
                                    Le bien sera visible sur le site
                                </small>
                            </div>

                            <div class="form-check form-switch p-3 bg-warning bg-opacity-10 rounded">
                                <x-checkbox-property name="is_featured" label="Mettre en avant"
                                    :value="old('is_featured', $property->is_featured)" id="is_featured">
                                </x-checkbox-property>
                                <small class="text-muted d-block mt-1">
                                    <i class="bi bi-star-fill text-warning me-1"></i>
                                    Affichage prioritaire
                                </small>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Boutons d'action -->
                        <div class="d-grid gap-2">
                            <button type="submit"
                                class="btn btn-lg {{ $property->exists ? 'btn-success' : 'btn-primary' }}">
                                <i class="bi bi-check-circle me-2"></i>
                                @if($property->exists)
                                Mettre à jour
                                @else
                                Créer le bien
                                @endif
                            </button>

                            @if($property->exists)
                            <a href="{{ route('admin.property.edit', $property) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-eye me-2"></i>
                                Prévisualiser
                            </a>
                            @endif
                        </div>

                        <!-- Métadonnées (si édition) -->
                        @if($property->exists)
                        <div class="mt-4 pt-3 border-top">
                            <small class="text-muted">
                                <div class="mb-2">
                                    <i class="bi bi-calendar-plus me-2"></i>
                                    Créé le {{ $property->created_at->format('d/m/Y à H:i') }}
                                </div>
                                <div>
                                    <i class="bi bi-calendar-check me-2"></i>
                                    Modifié le {{ $property->updated_at->format('d/m/Y à H:i') }}
                                </div>
                            </small>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
/* Améliorations visuelles personnalisées */
.card {
    border: none;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.card-header {
    border: none;
    padding: 1rem 1.5rem;
}

.form-label {
    font-weight: 500;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.form-control,
.form-select {
    border-radius: 0.5rem;
    border: 1px solid #dee2e6;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
}

.input-group-text {
    border-radius: 0.5rem 0 0 0.5rem;
    border-right: none;
}

.input-group .form-control {
    border-left: none;
    border-radius: 0 0.5rem 0.5rem 0;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.btn {
    border-radius: 0.5rem;
    padding: 0.625rem 1.25rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-lg {
    padding: 0.875rem 1.5rem;
    font-size: 1.1rem;
}

.breadcrumb {
    background-color: transparent;
    padding: 0;
    margin-bottom: 1rem;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.075) !important;
}

@media (max-width: 991.98px) {
    .position-sticky {
        position: relative !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Validation et améliorations UX
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('propertyForm');

    // Auto-formatage du prix
    const priceInput = document.getElementById('price');
    if (priceInput) {
        priceInput.addEventListener('blur', function() {
            if (this.value) {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });
    }

    // Confirmation avant réinitialisation
    const resetBtn = form.querySelector('button[type="reset"]');
    if (resetBtn) {
        resetBtn.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ?')) {
                e.preventDefault();
            }
        });
    }

    // Sauvegarde automatique dans localStorage (brouillon)
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        // Charger les valeurs sauvegardées
        const savedValue = localStorage.getItem(`property_${input.name}`);
        if (savedValue && !input.value) {
            input.value = savedValue;
        }

        // Sauvegarder les modifications
        input.addEventListener('change', function() {
            localStorage.setItem(`property_${this.name}`, this.value);
        });
    });

    // Nettoyer le localStorage après soumission
    form.addEventListener('submit', function() {
        inputs.forEach(input => {
            localStorage.removeItem(`property_${input.name}`);
        });
    });
});
</script>
@endpush
@endsection