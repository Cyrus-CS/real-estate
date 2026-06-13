@php
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str;
@endphp
@extends('admin.admin')

@section('title', 'Dashboard')

@section('content')
<div class="content-wrapper">

    <!-- PAGE HEADER -->
    <div class="page-header mb-4">
        <div>
            <h2 class="page-title mb-1">
                @if($isAgent)
                Bienvenue, {{ Auth::user()->name }}
                @else
                Dashboard Administrateur
                @endif
            </h2>
            <p class="page-subtitle text-muted mb-0">
                @if($isAgent)
                {{ $agent->agency_name }} | Gérez vos biens immobiliers
                @else
                Vue d'ensemble de la plateforme EstateVista
                @endif
            </p>
        </div>
        <a href="{{ route('admin.property.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>
            Ajouter un bien
        </a>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-buildings"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $totalProperties }}</h3>
                    <p class="stat-label">Total Properties</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $soldProperties }}</h3>
                    <p class="stat-label">Sold Properties</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="bi bi-key"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $rents }}</h3>
                    <p class="stat-label">Rent Requests</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div>
                    <h3 class="stat-value">${{ number_format($totalRevenue, 0) }}</h3>
                    <p class="stat-label">Revenue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTERS -->
    <div class="filter-card mb-4">
        <div class="row g-3">
            <div class="col-12 col-md-6 col-xl-3">
                <x-select-property name="filterStatus" label="" :options="$statuses" placeholder="Tous les statuts"
                    :compact="true" id="filterStatus">
                </x-select-property>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <x-select-property name="filterType" label="" :options="$types" placeholder="Tous les types"
                    :compact="true" id="filterType">
                </x-select-property>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <select class="form-select" id="filterLocation">
                    <option value="">Location</option>
                    @foreach($cities as $city)
                    <option value="{{ $city }}">{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-6 col-xl-3">
                <button class="btn btn-primary w-100" id="searchBtn">
                    <i class="bi bi-search me-2"></i>
                    Search
                </button>
            </div>
        </div>
    </div>

    <!-- PROPERTIES -->
    <div class="row g-4" id="propertiesGrid">
        @forelse($properties as $property)
        <div class="col-12 col-sm-6 col-xl-3 property-item" data-status="{{ $property->status->value }}"
            data-type="{{ $property->type->value }}" data-city="{{ $property->city }}">
            <div class="property-card">
                <div class="property-image position-relative">
                    @if($property->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $property->cover_image) }}" alt="{{ $property->title }}"
                        class="w-100 h-100 object-fit-cover">
                    @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="bi bi-image text-white fs-1"></i>
                    </div>
                    @endif

                    <button class="favorite-btn">
                        <i class="bi bi-heart{{ $property->is_featured ? '-fill text-danger' : '' }}"></i>
                    </button>

                    <span class="property-badge">
                        {{ $property->status->label() }}
                    </span>
                </div>

                <div class="property-body">
                    <h3 class="property-title">{{ Str::limit($property->title, 30) }}</h3>

                    <div class="property-location">
                        <i class="bi bi-geo-alt"></i>
                        {{ $property->city }}, {{ $property->state }}
                    </div>

                    <div class="property-meta">
                        <span>
                            <i class="bi bi-door-open"></i>
                            {{ $property->bedrooms }} Beds
                        </span>
                        <span>
                            <i class="bi bi-droplet"></i>
                            {{ $property->bathrooms }} Baths
                        </span>
                    </div>

                    <div class="property-footer">
                        <h4 class="property-price">${{ number_format($property->price, 0) }}</h4>
                        <a href="{{ route('admin.property.edit', $property) }}" class="details-btn">
                            Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-3">Aucune propriété</h5>
                <p class="text-muted">Commencez par créer votre premier bien</p>
                <a href="{{ route('admin.property.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-lg me-2"></i>
                    Créer un bien
                </a>
            </div>
        </div>
        @endforelse
    </div>

</div>

@push('scripts')
<script>
// Filtrage des propriétés
document.getElementById('searchBtn').addEventListener('click', filterProperties);

function filterProperties() {
    const status = document.getElementById('filterStatus').value;
    const type = document.getElementById('filterType').value;
    const city = document.getElementById('filterLocation').value;

    document.querySelectorAll('.property-item').forEach(item => {
        const itemStatus = item.dataset.status;
        const itemType = item.dataset.type;
        const itemCity = item.dataset.city;

        const matchStatus = !status || itemStatus === status;
        const matchType = !type || itemType === type;
        const matchCity = !city || itemCity === city;

        item.style.display = (matchStatus && matchType && matchCity) ? '' : 'none';
    });
}
</script>
@endpush
@endsection