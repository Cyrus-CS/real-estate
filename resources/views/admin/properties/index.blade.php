@extends('admin.admin')

@section('title', 'Mes Propriétés')
@php
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container-fluid px-4 py-4">

    <!-- En-tête avec actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-main">Mes Propriétés</h2>
            <p class="text-muted mb-0">Gérez vos biens immobiliers</p>
        </div>
        <a href="{{ route('admin.property.create') }}" class="btn btn-primary px-4">
            <i class="bi bi-plus-circle me-2"></i>
            Nouveau bien
        </a>
    </div>

    <!-- Filtres et recherche -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Rechercher un bien..."
                            id="searchInput">
                    </div>
                </div>
                <div class="col-md-2">
                    <x-select-property name="filterType" label="" :options="$types" placeholder="Tous les types"
                        :compact="true" id="filterType">
                    </x-select-property>
                </div>
                <div class="col-md-2">
                    <x-select-property name="filterStatus" label="" :options="$statuses" placeholder="Tous les statuts"
                        :compact="true" id="filterStatus">
                    </x-select-property>
                </div>
                <div class="col-md-4 text-end">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary active" id="viewGrid">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="viewList">
                            <i class="bi bi-list-ul"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary-soft p-3">
                                <i class="bi bi-house-door fs-4 text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Biens</h6>
                            <h3 class="mb-0 fw-bold">{{ $properties->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="bi bi-check-circle fs-4 text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Publiés</h6>
                            <h3 class="mb-0 fw-bold">{{ $properties->where('is_published', true)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="bi bi-star fs-4 text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">En Vedette</h6>
                            <h3 class="mb-0 fw-bold">{{ $properties->where('is_featured', true)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="bi bi-currency-dollar fs-4 text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Valeur Totale</h6>
                            <h3 class="mb-0 fw-bold">${{ number_format($properties->sum('price'), 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des propriétés (Grid View) -->
    <div id="gridView" class="row g-4">
        @forelse($properties as $property)
        <div class="col-lg-4 col-md-6 property-card" data-type="{{ $property->type->value }}"
            data-status="{{ $property->status->value }}" data-title="{{ strtolower($property->title) }}">
            <div class="card border-0 shadow-sm h-100 property-item">
                <!-- Image -->
                <div class="position-relative overflow-hidden" style="height: 220px;">
                    @if($property->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $property->cover_image) }}"
                        class="card-img-top h-100 object-fit-cover" alt="{{ $property->title }}">
                    @else
                    <div class="bg-surface h-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                    </div>
                    @endif

                    <!-- Badges -->
                    <div class="position-absolute top-0 start-0 p-3 w-100">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span
                                    class="badge {{ $property->status->value === 'for_sale' ? 'bg-primary' : 'bg-info' }} mb-1">
                                    {{ $property->status->label() }}
                                </span>
                                @if($property->is_featured)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-star-fill me-1"></i>Vedette
                                </span>
                                @endif
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.property.edit', $property) }}">
                                            <i class="bi bi-pencil me-2"></i>Modifier
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#"
                                            onclick="event.preventDefault(); if(confirm('Confirmer la suppression ?')) document.getElementById('delete-{{ $property->id }}').submit();">
                                            <i class="bi bi-trash me-2"></i>Supprimer
                                        </a>
                                        <form id="delete-{{ $property->id }}"
                                            action="{{ route('admin.property.destroy', $property) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu -->
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-surface text-muted">{{ $property->type->label() }}</span>
                        <h5 class="mb-0 text-primary fw-bold">${{ number_format($property->price, 0) }}</h5>
                    </div>

                    <h6 class="fw-bold mb-2">{{ Str::limit($property->title, 50) }}</h6>

                    <p class="text-muted small mb-3">
                        <i class="bi bi-geo-alt me-1"></i>
                        {{ $property->city }}, {{ $property->state }}
                    </p>

                    <!-- Caractéristiques -->
                    <div class="d-flex gap-3 mb-3 text-muted small">
                        <span><i class="bi bi-door-closed me-1"></i>{{ $property->bedrooms }} ch.</span>
                        <span><i class="bi bi-droplet me-1"></i>{{ $property->bathrooms }} sdb</span>
                        <span><i class="bi bi-arrows-angle-expand me-1"></i>{{ $property->surface }} m²</span>
                    </div>

                    <!-- Statut publication -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox"
                                {{ $property->is_published ? 'checked' : '' }} disabled>
                            <label class="form-check-label small text-muted">
                                {{ $property->is_published ? 'Publié' : 'Brouillon' }}
                            </label>
                        </div>
                        <a href="{{ route('admin.property.edit', $property) }}" class="btn btn-sm btn-outline-primary">
                            Gérer
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-house-x text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3">Aucune propriété pour le moment</h5>
                    <p class="text-muted">Commencez par créer votre premier bien immobilier</p>
                    <a href="{{ route('admin.property.create') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-circle me-2"></i>Créer un bien
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Liste des propriétés (List View) - Caché par défaut -->
    <div id="listView" class="d-none">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-surface">
                        <tr>
                            <th class="border-0">Bien</th>
                            <th class="border-0">Type</th>
                            <th class="border-0">Statut</th>
                            <th class="border-0">Prix</th>
                            <th class="border-0">Localisation</th>
                            <th class="border-0">Publication</th>
                            <th class="border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($properties as $property)
                        <tr class="property-row" data-type="{{ $property->type->value }}"
                            data-status="{{ $property->status->value }}"
                            data-title="{{ strtolower($property->title) }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        @if($property->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $property->images->first()->image_path) }}"
                                            class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                        <div class="bg-surface rounded d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{ Str::limit($property->title, 40) }}</h6>
                                        <small class="text-muted">{{ $property->bedrooms }} ch. ·
                                            {{ $property->surface }} m²</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-surface text-muted">{{ $property->type->label() }}</span>
                            </td>
                            <td>
                                <span
                                    class="badge {{ $property->status->value === 'for_sale' ? 'bg-primary' : 'bg-info' }}">
                                    {{ $property->status->label() }}
                                </span>
                            </td>
                            <td class="fw-bold text-primary">${{ number_format($property->price, 0) }}</td>
                            <td>
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $property->city }}
                                </small>
                            </td>
                            <td>
                                <span class="badge {{ $property->is_published ? 'bg-success' : 'bg-warning' }}">
                                    {{ $property->is_published ? 'Publié' : 'Brouillon' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.property.edit', $property) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger"
                                    onclick="if(confirm('Confirmer ?')) document.getElementById('delete-list-{{ $property->id }}').submit();">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <form id="delete-list-{{ $property->id }}"
                                    action="{{ route('admin.property.destroy', $property) }}" method="POST"
                                    class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="mt-3 text-muted">Aucune propriété trouvée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
:root {
    --primary: #6C3AFF;
    --primary-soft: #EDE8FF;
    --primary-hover: #5628E8;
    --surface: #F4F5F7;
    --white: #FFFFFF;
    --text-main: #1A1A2E;
    --text-muted: #8A8FA8;
    --border: #ECEEF4;
    --shadow-card: 0 2px 12px rgba(108, 58, 255, .08);
    --transition: .2s ease;
}

.bg-primary-soft {
    background-color: var(--primary-soft) !important;
}

.bg-surface {
    background-color: var(--surface) !important;
}

.text-main {
    color: var(--text-main) !important;
}

.text-muted {
    color: var(--text-muted) !important;
}

.shadow-sm {
    box-shadow: var(--shadow-card) !important;
}

.property-item {
    transition: var(--transition);
}

.property-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(108, 58, 255, .15) !important;
}

.btn-primary {
    background-color: var(--primary);
    border-color: var(--primary);
}

.btn-primary:hover {
    background-color: var(--primary-hover);
    border-color: var(--primary-hover);
}

.text-primary {
    color: var(--primary) !important;
}

.object-fit-cover {
    object-fit: cover;
}
</style>
@endpush

@push('scripts')
<script>
// Toggle entre vue grille et liste
document.getElementById('viewGrid').addEventListener('click', function() {
    document.getElementById('gridView').classList.remove('d-none');
    document.getElementById('listView').classList.add('d-none');
    this.classList.add('active');
    document.getElementById('viewList').classList.remove('active');
});

document.getElementById('viewList').addEventListener('click', function() {
    document.getElementById('listView').classList.remove('d-none');
    document.getElementById('gridView').classList.add('d-none');
    this.classList.add('active');
    document.getElementById('viewGrid').classList.remove('active');
});

// Recherche
document.getElementById('searchInput').addEventListener('keyup', function() {
    const search = this.value.toLowerCase();
    filterProperties();
});

// Filtres
document.getElementById('filterType').addEventListener('change', filterProperties);
document.getElementById('filterStatus').addEventListener('change', filterProperties);

function filterProperties() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const type = document.getElementById('filterType').value;
    const status = document.getElementById('filterStatus').value;

    // Filtrer les cartes
    document.querySelectorAll('.property-card').forEach(card => {
        const title = card.dataset.title;
        const cardType = card.dataset.type;
        const cardStatus = card.dataset.status;

        const matchSearch = title.includes(search);
        const matchType = !type || cardType === type;
        const matchStatus = !status || cardStatus === status;

        card.style.display = (matchSearch && matchType && matchStatus) ? '' : 'none';
    });

    // Filtrer les lignes du tableau
    document.querySelectorAll('.property-row').forEach(row => {
        const title = row.dataset.title;
        const rowType = row.dataset.type;
        const rowStatus = row.dataset.status;

        const matchSearch = title.includes(search);
        const matchType = !type || rowType === type;
        const matchStatus = !status || rowStatus === status;

        row.style.display = (matchSearch && matchType && matchStatus) ? '' : 'none';
    });
}
</script>
@endpush
@endsection