@php
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
@endphp
@extends('base')

@section('title', 'Propriétés - EstateVista')

@push('styles')
<style>
/* ============================================================
   PAGE HEADER
   ============================================================ */
.page-header {
    background: linear-gradient(135deg, #1A1A2E 0%, #2d1b69 55%, #1A1A2E 100%);
    position: relative;
    overflow: hidden;
    padding: 5rem 0 3.5rem;
}

.page-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 20% 50%, rgba(108, 58, 255, .3) 0%, transparent 55%),
        radial-gradient(ellipse at 80% 20%, rgba(167, 139, 250, .15) 0%, transparent 50%);
    pointer-events: none;
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 60px;
    background: var(--surface, #F4F5F7);
    clip-path: ellipse(55% 100% at 50% 100%);
}

.page-header .container {
    position: relative;
    z-index: 1;
}

.page-header-eyebrow {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: #a78bfa;
    margin-bottom: .6rem;
}

.page-header-title {
    font-size: clamp(1.9rem, 4vw, 2.8rem);
    font-weight: 800;
    color: #fff;
    letter-spacing: -.025em;
    margin-bottom: .5rem;
    line-height: 1.15;
}

.page-header-sub {
    font-size: .95rem;
    color: rgba(255, 255, 255, .6);
}

.breadcrumb-custom {
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: .78rem;
    color: rgba(255, 255, 255, .45);
    margin-bottom: 1.25rem;
}

.breadcrumb-custom a {
    color: rgba(255, 255, 255, .55);
    text-decoration: none;
    transition: color .2s;
}

.breadcrumb-custom a:hover {
    color: #fff;
}

.breadcrumb-custom .sep {
    opacity: .35;
}

/* ============================================================
   LAYOUT: SIDEBAR + MAIN
   ============================================================ */
.props-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 2rem;
    align-items: start;
}

@media(max-width:992px) {
    .props-layout {
        grid-template-columns: 1fr;
    }
}

/* ============================================================
   FILTER SIDEBAR
   ============================================================ */
.filter-sidebar {
    background: #fff;
    border-radius: 18px;
    border: 1px solid var(--border, #ECEEF4);
    overflow: hidden;
    position: sticky;
    top: 88px;
    box-shadow: 0 2px 16px rgba(108, 58, 255, .06);
}

.filter-header {
    padding: 1.1rem 1.4rem;
    background: var(--primary, #6C3AFF);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.filter-header h3 {
    font-size: .88rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
    display: flex;
    align-items: center;
    gap: .5rem;
}

.filter-reset {
    font-size: .72rem;
    color: rgba(255, 255, 255, .7);
    text-decoration: none;
    font-weight: 500;
    transition: color .2s;
}

.filter-reset:hover {
    color: #fff;
}

.filter-section {
    padding: 1.1rem 1.4rem;
    border-bottom: 1px solid var(--border, #ECEEF4);
}

.filter-section:last-child {
    border-bottom: none;
}

.filter-section-title {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--text-muted, #8A8FA8);
    margin-bottom: .85rem;
}

/* Range price */
.price-range-display {
    display: flex;
    justify-content: space-between;
    font-size: .78rem;
    font-weight: 600;
    color: var(--primary, #6C3AFF);
    margin-bottom: .5rem;
}

.price-inputs {
    display: flex;
    gap: .5rem;
}

.price-inputs input {
    flex: 1;
    height: 38px;
    border: 1.5px solid var(--border, #ECEEF4);
    border-radius: 9px;
    padding: 0 .75rem;
    font-size: .8rem;
    color: var(--text-main, #1A1A2E);
    transition: border-color .2s;
    background: var(--surface, #F4F5F7);
}

.price-inputs input:focus {
    outline: none;
    border-color: var(--primary, #6C3AFF);
    background: #fff;
}

/* Status pills */
.status-pills {
    display: flex;
    flex-wrap: wrap;
    gap: .4rem;
}

.status-pill {
    padding: .3rem .75rem;
    border-radius: 100px;
    border: 1.5px solid var(--border, #ECEEF4);
    font-size: .75rem;
    font-weight: 600;
    color: var(--text-muted, #8A8FA8);
    cursor: pointer;
    transition: all .2s;
    background: transparent;
}

.status-pill:hover,
.status-pill.active {
    border-color: var(--primary, #6C3AFF);
    color: var(--primary, #6C3AFF);
    background: var(--primary-soft, #EDE8FF);
}

/* Type grid */
.type-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .35rem;
}

.type-chip {
    padding: .35rem .5rem;
    border-radius: 8px;
    border: 1.5px solid var(--border, #ECEEF4);
    font-size: .72rem;
    font-weight: 600;
    color: var(--text-muted, #8A8FA8);
    cursor: pointer;
    transition: all .2s;
    background: transparent;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.type-chip:hover,
.type-chip.active {
    border-color: var(--primary, #6C3AFF);
    color: var(--primary, #6C3AFF);
    background: var(--primary-soft, #EDE8FF);
}

/* Stepper inputs */
.stepper {
    display: flex;
    align-items: center;
    gap: .5rem;
}

.stepper-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1.5px solid var(--border, #ECEEF4);
    background: var(--surface, #F4F5F7);
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .2s;
    color: var(--text-main, #1A1A2E);
    font-weight: 700;
    flex-shrink: 0;
}

.stepper-btn:hover {
    background: var(--primary-soft, #EDE8FF);
    border-color: var(--primary, #6C3AFF);
    color: var(--primary, #6C3AFF);
}

.stepper-val {
    width: 40px;
    text-align: center;
    font-size: .88rem;
    font-weight: 700;
    color: var(--text-main, #1A1A2E);
    border: none;
    background: none;
}

.stepper-label {
    font-size: .75rem;
    color: var(--text-muted);
    margin-bottom: .4rem;
}

/* Btn apply */
.btn-filter-apply {
    width: 100%;
    height: 44px;
    background: var(--primary, #6C3AFF);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: .88rem;
    font-weight: 700;
    transition: all .25s;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
}

.btn-filter-apply:hover {
    background: var(--primary-hover, #5628E8);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(108, 58, 255, .35);
}

/* ============================================================
   MAIN CONTENT: TOOLBAR + GRID
   ============================================================ */
.props-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.props-count {
    font-size: .85rem;
    color: var(--text-muted);
}

.props-count strong {
    color: var(--text-main);
    font-weight: 700;
}

.toolbar-right {
    display: flex;
    align-items: center;
    gap: .75rem;
}

/* Sort select */
.sort-select {
    height: 40px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 0 2rem 0 .85rem;
    font-size: .82rem;
    font-weight: 500;
    color: var(--text-main);
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 16 16'%3E%3Cpath fill='%238A8FA8' d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat right .75rem center;
    appearance: none;
    cursor: pointer;
    transition: border-color .2s;
}

.sort-select:focus {
    outline: none;
    border-color: var(--primary);
}

/* View toggle */
.view-toggle {
    display: flex;
    gap: .3rem;
}

.view-btn {
    width: 38px;
    height: 38px;
    border-radius: 9px;
    border: 1.5px solid var(--border);
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: .9rem;
    color: var(--text-muted);
    transition: all .2s;
}

.view-btn.active,
.view-btn:hover {
    background: var(--primary-soft);
    border-color: var(--primary);
    color: var(--primary);
}

/* Active filters chips */
.active-filters {
    display: flex;
    flex-wrap: wrap;
    gap: .4rem;
    margin-bottom: 1.2rem;
}

.active-filter-chip {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: var(--primary-soft);
    color: var(--primary);
    font-size: .75rem;
    font-weight: 600;
    padding: .3rem .75rem;
    border-radius: 100px;
}

.active-filter-chip a {
    color: var(--primary);
    text-decoration: none;
    font-size: .8rem;
    line-height: 1;
    opacity: .7;
    transition: opacity .2s;
}

.active-filter-chip a:hover {
    opacity: 1;
}

/* ============================================================
   PROPERTY CARDS
   ============================================================ */
.props-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.25rem;
}

.props-grid.list-view {
    grid-template-columns: 1fr;
}

/* Card - grid view */
.prop-card {
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--border);
    background: #fff;
    transition: transform .3s ease, box-shadow .3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.prop-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(108, 58, 255, .12);
}

.prop-img-wrap {
    position: relative;
    height: 200px;
    overflow: hidden;
    flex-shrink: 0;
}

.prop-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
}

.prop-card:hover .prop-img-wrap img {
    transform: scale(1.06);
}

/* Card - list view */
.props-grid.list-view .prop-card {
    flex-direction: row;
    height: 170px;
}

.props-grid.list-view .prop-img-wrap {
    width: 250px;
    height: 100%;
    flex-shrink: 0;
}

.props-grid.list-view .prop-body {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1rem 1.25rem;
    flex: 1;
    flex-wrap: wrap;
}

.props-grid.list-view .prop-main {
    flex: 1;
    min-width: 160px;
}

.props-grid.list-view .prop-features {
    border-top: none;
    padding-top: 0;
    margin-top: 0;
}

.props-grid.list-view .prop-price {
    font-size: 1.25rem;
}

@media(max-width:640px) {
    .props-grid.list-view .prop-card {
        flex-direction: column;
        height: auto;
    }

    .props-grid.list-view .prop-img-wrap {
        width: 100%;
        height: 180px;
    }
}

/* Badges */
.prop-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: .68rem;
    font-weight: 700;
    padding: .28rem .7rem;
    border-radius: 7px;
    letter-spacing: .06em;
    text-transform: uppercase;
    z-index: 2;
}

.badge-sale {
    background: #E6F9F0;
    color: #1DB97A;
}

.badge-rent {
    background: #EDE8FF;
    color: #6C3AFF;
}

.badge-sold {
    background: #FEEAEA;
    color: #E84545;
}

.badge-rented {
    background: #FFF3E0;
    color: #F5A623;
}

.badge-off {
    background: #F0F0F0;
    color: #888;
}

.badge-featured {
    background: #6C3AFF;
    color: #fff;
}

.prop-fav-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .92);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: .85rem;
    z-index: 2;
    transition: all .2s;
    cursor: pointer;
}

.prop-fav-btn:hover,
.prop-fav-btn.favorited {
    color: #E84545;
    background: #fff;
}

.prop-type-tag {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0, 0, 0, .5);
    backdrop-filter: blur(6px);
    color: #fff;
    font-size: .68rem;
    font-weight: 600;
    padding: .22rem .6rem;
    border-radius: 6px;
    z-index: 2;
    text-transform: capitalize;
}

.prop-body {
    padding: .9rem 1rem 1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.prop-price {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
    margin-bottom: .35rem;
}

.prop-price small {
    font-size: .65rem;
    font-weight: 500;
    color: var(--text-muted);
    vertical-align: middle;
    margin-left: .25rem;
}

.prop-title {
    font-size: .88rem;
    font-weight: 600;
    color: var(--text-main);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: .3rem;
}

.prop-location {
    font-size: .76rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: .3rem;
    margin-bottom: .7rem;
}

.prop-location i {
    color: var(--primary);
    font-size: .8rem;
}

.prop-features {
    display: flex;
    gap: .85rem;
    padding-top: .7rem;
    border-top: 1px solid var(--border);
    margin-top: auto;
}

.prop-feat {
    display: flex;
    align-items: center;
    gap: .3rem;
    font-size: .74rem;
    color: var(--text-muted);
}

.prop-feat i {
    color: var(--primary);
    font-size: .8rem;
}

/* Agent micro */
.prop-agent {
    display: flex;
    align-items: center;
    gap: .5rem;
    padding-top: .65rem;
    margin-top: .5rem;
    border-top: 1px solid var(--border);
}

.prop-agent img {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    object-fit: cover;
    border: 1.5px solid var(--primary-soft);
}

.prop-agent-name {
    font-size: .72rem;
    color: var(--text-muted);
    font-weight: 500;
}

/* ============================================================
   EMPTY STATE
   ============================================================ */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    background: #fff;
    border-radius: 18px;
    border: 2px dashed var(--border);
}

.empty-state-icon {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: var(--primary-soft);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 2rem;
    color: var(--primary);
}

.empty-state h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: .5rem;
}

.empty-state p {
    font-size: .88rem;
    color: var(--text-muted);
    max-width: 320px;
    margin: 0 auto 1.5rem;
}

/* ============================================================
   PAGINATION
   ============================================================ */
.pagination-custom {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .3rem;
    margin-top: 2.5rem;
    flex-wrap: wrap;
}

.pagination-custom .page-item .page-link {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    border: 1.5px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    font-weight: 600;
    color: var(--text-main);
    transition: all .2s;
    background: #fff;
}

.pagination-custom .page-item .page-link:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-soft);
}

.pagination-custom .page-item.active .page-link {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
    box-shadow: 0 4px 14px rgba(108, 58, 255, .35);
}

.pagination-custom .page-item.disabled .page-link {
    opacity: .4;
    pointer-events: none;
}

/* ============================================================
   MOBILE FILTER DRAWER
   ============================================================ */
.mobile-filter-btn {
    display: none;
}

@media(max-width:992px) {
    .mobile-filter-btn {
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .filter-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 300px;
        z-index: 1050;
        overflow-y: auto;
        transform: translateX(-100%);
        transition: transform .35s cubic-bezier(.4, 0, .2, 1);
        border-radius: 0 18px 18px 0;
    }

    .filter-sidebar.open {
        transform: translateX(0);
        box-shadow: 4px 0 40px rgba(0, 0, 0, .25);
    }

    .filter-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .4);
        z-index: 1049;
        backdrop-filter: blur(2px);
    }

    .filter-backdrop.show {
        display: block;
    }
}

/* ============================================================
   MAP TOGGLE BUTTON
   ============================================================ */
.map-toggle-btn {
    height: 40px;
    padding: 0 1rem;
    border: 1.5px solid var(--border);
    background: #fff;
    border-radius: 10px;
    font-size: .82rem;
    font-weight: 600;
    color: var(--text-main);
    display: flex;
    align-items: center;
    gap: .4rem;
    cursor: pointer;
    transition: all .2s;
}

.map-toggle-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-soft);
}
</style>
@endpush

@section('content')

{{-- ── Page Header ── --}}
<div class="page-header">
    <div class="container">
        <div class="breadcrumb-custom">
            <a href="{{ route('home') }}">Accueil</a>
            <span class="sep"><i class="bi bi-chevron-right"></i></span>
            <span>Propriétés</span>
        </div>
        <h1 class="page-header-title">
            @if(request('status') === 'for_sale') Biens à Vendre
            @elseif(request('status') === 'for_rent') Biens à Louer
            @elseif(request('status') === 'sold') Biens Vendus
            @else Toutes les Propriétés
            @endif
        </h1>
        <p class="page-header-sub">
            <strong class="text-white">{{ $properties->total() }}</strong>
            bien{{ $properties->total() > 1 ? 's' : '' }} trouvé{{ $properties->total() > 1 ? 's' : '' }}
            @if(request()->hasAny(['status','type','city','min_price','max_price','bedrooms']))
            selon vos critères
            @else
            sur notre plateforme
            @endif
        </p>
    </div>
</div>

{{-- ── Main Layout ── --}}
<div class="bg-surface py-4" style="background:var(--surface,#F4F5F7);min-height:calc(100vh - 300px)">
    <div class="container">

        {{-- Mobile filter button --}}
        <div class="d-flex justify-content-between align-items-center mb-3 d-lg-none">
            <button class="btn btn-sm btn-primary mobile-filter-btn" id="openFilters">
                <i class="bi bi-sliders2"></i> Filtres
                @if(request()->hasAny(['status','type','city','min_price','max_price','bedrooms']))
                <span class="badge bg-white text-primary ms-1" style="font-size:.65rem">
                    {{ count(array_filter(request()->only(['status','type','city','min_price','max_price','bedrooms']))) }}
                </span>
                @endif
            </button>
            <div class="d-flex gap-2">
                <select class="sort-select" id="mobileSortSelect" onchange="applySort(this.value)">
                    <option value="latest" {{ !request('sort') || request('sort')=='latest' ? 'selected' : '' }}>Plus
                        récents</option>
                    <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Prix croissant
                    </option>
                    <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Prix décroissant
                    </option>
                </select>
            </div>
        </div>

        {{-- Filter backdrop --}}
        <div class="filter-backdrop" id="filterBackdrop"></div>

        <div class="props-layout">

            {{-- ════════════════════════════════
                 FILTER SIDEBAR
                 ════════════════════════════════ --}}
            <aside class="filter-sidebar" id="filterSidebar">
                <div class="filter-header">
                    <h3><i class="bi bi-sliders2"></i> Filtres</h3>
                    <a href="{{ route('properties.index') }}" class="filter-reset">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Réinitialiser
                    </a>
                </div>

                <form action="{{ route('properties.index') }}" method="GET" id="filterForm">
                    @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    {{-- Status --}}
                    <div class="filter-section">
                        <div class="filter-section-title">Transaction</div>
                        <div class="status-pills">
                            <button type="button" class="status-pill {{ !request('status') ? 'active' : '' }}"
                                data-val="" data-target="status">Tous</button>
                            <button type="button"
                                class="status-pill {{ request('status')==='for_sale' ? 'active' : '' }}"
                                data-val="for_sale" data-target="status">À vendre</button>
                            <button type="button"
                                class="status-pill {{ request('status')==='for_rent' ? 'active' : '' }}"
                                data-val="for_rent" data-target="status">À louer</button>
                            <button type="button" class="status-pill {{ request('status')==='sold' ? 'active' : '' }}"
                                data-val="sold" data-target="status">Vendus</button>
                            <button type="button" class="status-pill {{ request('status')==='rented' ? 'active' : '' }}"
                                data-val="rented" data-target="status">Loués</button>
                        </div>
                        <input type="hidden" name="status" id="statusHidden" value="{{ request('status') }}">
                    </div>

                    {{-- Type --}}
                    <div class="filter-section">
                        <div class="filter-section-title">Type de bien</div>
                        <div class="type-grid">
                            @php
                            $types = \App\Enums\PropertyType::cases();
                            @endphp
                            @foreach($types as $t)
                            <button type="button" class="type-chip {{ request('type') === $t->value ? 'active' : '' }}"
                                data-val="{{ $t->value }}" data-target="type">
                                {{ $t->label() }}
                            </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="type" id="typeHidden" value="{{ request('type') }}">
                    </div>

                    {{-- Price --}}
                    <div class="filter-section">
                        <div class="filter-section-title">Budget</div>
                        <div class="price-inputs">
                            <input type="number" name="min_price" placeholder="Min $"
                                value="{{ request('min_price') }}">
                            <input type="number" name="max_price" placeholder="Max $"
                                value="{{ request('max_price') }}">
                        </div>
                    </div>

                    {{-- Bedrooms --}}
                    <div class="filter-section">
                        <div class="stepper-label">Chambres (minimum)</div>
                        <div class="stepper">
                            <button type="button" class="stepper-btn" data-action="decrement"
                                data-target="bedroomsVal">−</button>
                            <input type="hidden" name="bedrooms" id="bedroomsHidden"
                                value="{{ request('bedrooms', 0) }}">
                            <input class="stepper-val" id="bedroomsVal" value="{{ request('bedrooms', 0) }}" readonly>
                            <button type="button" class="stepper-btn" data-action="increment"
                                data-target="bedroomsVal">+</button>
                            <span style="font-size:.75rem;color:var(--text-muted);margin-left:.25rem">ch.</span>
                        </div>
                    </div>

                    {{-- City --}}
                    <div class="filter-section">
                        <div class="filter-section-title">Ville</div>
                        <div class="sf-group" style="position:relative">
                            <i class="bi bi-geo-alt"
                                style="position:absolute;left:.85rem;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:.9rem;pointer-events:none;z-index:1"></i>
                            <input type="text" name="city" placeholder="Ex: Paris, New York…"
                                value="{{ request('city') }}"
                                style="width:100%;height:40px;border:1.5px solid var(--border);border-radius:10px;padding:0 .85rem 0 2.4rem;font-size:.82rem;color:var(--text-main);background:var(--surface);transition:border-color .2s"
                                onfocus="this.style.borderColor='var(--primary)';this.style.background='#fff'"
                                onblur="this.style.borderColor='var(--border)';this.style.background='var(--surface)'">
                        </div>
                    </div>

                    {{-- Apply --}}
                    <div class="filter-section">
                        <button type="submit" class="btn-filter-apply">
                            <i class="bi bi-search"></i> Appliquer les filtres
                        </button>
                    </div>
                </form>
            </aside>

            {{-- ════════════════════════════════
                 MAIN PROPERTIES AREA
                 ════════════════════════════════ --}}
            <main>
                {{-- Active filter chips --}}
                @if(request()->hasAny(['status','type','city','min_price','max_price','bedrooms']))
                <div class="active-filters">
                    @if(request('status'))
                    <span class="active-filter-chip">
                        {{ match(request('status')) {
                            'for_sale' => 'À vendre',
                            'for_rent' => 'À louer',
                            'sold' => 'Vendus',
                            'rented' => 'Loués',
                            default => request('status')
                        } }}
                        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}">×</a>
                    </span>
                    @endif
                    @if(request('type'))
                    <span class="active-filter-chip">
                        {{ \App\Enums\PropertyType::from(request('type'))->label() }}
                        <a href="{{ request()->fullUrlWithQuery(['type' => null]) }}">×</a>
                    </span>
                    @endif
                    @if(request('city'))
                    <span class="active-filter-chip">
                        <i class="bi bi-geo-alt"></i> {{ request('city') }}
                        <a href="{{ request()->fullUrlWithQuery(['city' => null]) }}">×</a>
                    </span>
                    @endif
                    @if(request('min_price') || request('max_price'))
                    <span class="active-filter-chip">
                        <i class="bi bi-currency-dollar"></i>
                        {{ request('min_price') ? '$'.number_format(request('min_price')) : '0' }}
                        - {{ request('max_price') ? '$'.number_format(request('max_price')) : '∞' }}
                        <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}">×</a>
                    </span>
                    @endif
                    @if(request('bedrooms') > 0)
                    <span class="active-filter-chip">
                        <i class="bi bi-door-open"></i> {{ request('bedrooms') }}+ chambres
                        <a href="{{ request()->fullUrlWithQuery(['bedrooms' => null]) }}">×</a>
                    </span>
                    @endif
                </div>
                @endif

                {{-- Toolbar --}}
                <div class="props-toolbar">
                    <p class="props-count mb-0">
                        <strong>{{ $properties->total() }}</strong>
                        propriété{{ $properties->total() > 1 ? 's' : '' }}
                        trouvée{{ $properties->total() > 1 ? 's' : '' }}
                        <span class="d-none d-md-inline text-muted">(page
                            {{ $properties->currentPage() }}/{{ $properties->lastPage() }})</span>
                    </p>
                    <div class="toolbar-right">
                        <select class="sort-select d-none d-md-block" id="sortSelect" onchange="applySort(this.value)">
                            <option value="latest"
                                {{ !request('sort') || request('sort')=='latest' ? 'selected' : '' }}>Plus récents
                            </option>
                            <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Prix
                                croissant</option>
                            <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Prix
                                décroissant</option>
                        </select>
                        <div class="view-toggle">
                            <button class="view-btn active" id="gridViewBtn" title="Vue grille">
                                <i class="bi bi-grid"></i>
                            </button>
                            <button class="view-btn" id="listViewBtn" title="Vue liste">
                                <i class="bi bi-list-ul"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Grid --}}
                <div class="props-grid" id="propsGrid">
                    @forelse($properties as $property)
                    <div class="prop-card-item">
                        <a href="{{ route('properties.show', $property->slug ?? $property->id) }}"
                            class="text-decoration-none d-block h-100">
                            <div class="prop-card">
                                <div class="prop-img-wrap">
                                    <img src="{{ $property->cover_image ?? ($property->images->first()?->image_path ?? 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80') }}"
                                        alt="{{ $property->address }}" loading="lazy">

                                    {{-- Status badge --}}
                                    @php
                                    $statusMap = [
                                    'for_sale' => ['class' => 'badge-sale', 'label' => 'À vendre'],
                                    'for_rent' => ['class' => 'badge-rent', 'label' => 'À louer'],
                                    'sold' => ['class' => 'badge-sold', 'label' => 'Vendu'],
                                    'rented' => ['class' => 'badge-rented', 'label' => 'Loué'],
                                    'off_market' => ['class' => 'badge-off', 'label' => 'Hors marché'],
                                    ];
                                    $statusInfo = $statusMap[$property->status->value] ??
                                    ['class'=>'badge-off','label'=>$property->status->value];
                                    @endphp
                                    <span
                                        class="prop-badge {{ $statusInfo['class'] }}">{{ $statusInfo['label'] }}</span>

                                    {{-- Favorite --}}
                                    @auth
                                    <button
                                        class="prop-fav-btn fav-toggle {{ auth()->user()->favoriteProperties()->where('property_id',$property->id)->exists() ? 'favorited' : '' }}"
                                        data-property="{{ $property->id }}"
                                        onclick="event.preventDefault(); toggleFav(this, '{{ $property->id }}')">
                                        <i
                                            class="bi {{ auth()->user()->favoriteProperties()->where('property_id',$property->id)->exists() ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                    @endauth

                                    {{-- Type chip --}}
                                    <span class="prop-type-tag">{{ $property->type->label() }}</span>
                                </div>

                                <div class="prop-body">
                                    <div class="prop-main">
                                        <div class="prop-price">
                                            ${{ number_format($property->price) }}
                                            @if($property->status->value === 'for_rent')
                                            <small>/mois</small>
                                            @endif
                                        </div>
                                        <div class="prop-title">{{ Str::limit($property->address, 40) }}</div>
                                        <div class="prop-location">
                                            <i class="bi bi-geo-alt-fill"></i>
                                            {{ $property->city }}@if($property->country), {{ $property->country }}@endif
                                        </div>
                                    </div>

                                    <div class="prop-features">
                                        @if($property->bedrooms)
                                        <div class="prop-feat">
                                            <i class="bi bi-door-open"></i>
                                            {{ $property->bedrooms }} ch.
                                        </div>
                                        @endif
                                        @if($property->bathrooms)
                                        <div class="prop-feat">
                                            <i class="bi bi-droplet"></i>
                                            {{ $property->bathrooms }} sdb.
                                        </div>
                                        @endif
                                        @if($property->surface)
                                        <div class="prop-feat">
                                            <i class="bi bi-rulers"></i>
                                            {{ number_format($property->surface) }} m²
                                        </div>
                                        @endif
                                    </div>

                                    @if($property->agent && $property->agent->user)
                                    <div class="prop-agent">
                                        <img src="/storage/{{ $property->agent->user->avatar ?? 'https://i.pravatar.cc/80?img='.($loop->index + 5) }}"
                                            alt="{{ $property->agent->user->name }}">
                                        <span class="prop-agent-name">{{ $property->agent->user->name }}
                                            {{ $property->agent->user->last_name }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="bi bi-house-slash"></i></div>
                        <h4>Aucune propriété trouvée</h4>
                        <p>Essayez de modifier vos critères de recherche pour obtenir plus de résultats.</p>
                        <a href="{{ route('properties.index') }}" class="btn btn-primary px-4 py-2"
                            style="border-radius:10px">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>Réinitialiser les filtres
                        </a>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($properties->hasPages())
                <nav class="pagination-custom">
                    {{-- Prev --}}
                    <li class="page-item {{ $properties->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $properties->previousPageUrl() }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>

                    @foreach($properties->getUrlRange(max(1, $properties->currentPage()-2), min($properties->lastPage(),
                    $properties->currentPage()+2)) as $page => $url)
                    <li class="page-item {{ $page == $properties->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                    @endforeach

                    {{-- Next --}}
                    <li class="page-item {{ !$properties->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $properties->nextPageUrl() }}">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </nav>
                <p class="text-center text-muted mt-3" style="font-size:.78rem">
                    Affichage {{ $properties->firstItem() }}–{{ $properties->lastItem() }}
                    sur {{ $properties->total() }} propriétés
                </p>
                @endif
            </main>
        </div>{{-- /props-layout --}}
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ── Mobile sidebar ── */
    const sidebar = document.getElementById('filterSidebar');
    const backdrop = document.getElementById('filterBackdrop');
    const openBtn = document.getElementById('openFilters');

    const closeSidebar = () => {
        sidebar?.classList.remove('open');
        backdrop?.classList.remove('show');
        document.body.style.overflow = '';
    };

    openBtn?.addEventListener('click', () => {
        sidebar.classList.add('open');
        backdrop.classList.add('show');
        document.body.style.overflow = 'hidden';
    });
    backdrop?.addEventListener('click', closeSidebar);

    /* ── Pill / chip toggles ── */
    document.querySelectorAll('.status-pill').forEach(pill => {
        pill.addEventListener('click', () => {
            document.querySelectorAll('.status-pill').forEach(p => p.classList.remove(
                'active'));
            pill.classList.add('active');
            document.getElementById('statusHidden').value = pill.dataset.val;
        });
    });

    document.querySelectorAll('.type-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            const wasActive = chip.classList.contains('active');
            document.querySelectorAll('.type-chip').forEach(c => c.classList.remove('active'));
            if (!wasActive) {
                chip.classList.add('active');
                document.getElementById('typeHidden').value = chip.dataset.val;
            } else {
                document.getElementById('typeHidden').value = '';
            }
        });
    });

    /* ── Steppers ── */
    document.querySelectorAll('.stepper-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.dataset.target;
            const display = document.getElementById(targetId);
            const hidden = document.getElementById('bedroomsHidden');
            let val = parseInt(display.value) || 0;

            if (btn.dataset.action === 'increment') val++;
            else val = Math.max(0, val - 1);

            display.value = val;
            if (hidden) hidden.value = val;
        });
    });

    /* ── View toggle (grid / list) ── */
    const grid = document.getElementById('propsGrid');
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');

    gridBtn?.addEventListener('click', () => {
        grid.classList.remove('list-view');
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
        localStorage.setItem('propsView', 'grid');
    });

    listBtn?.addEventListener('click', () => {
        grid.classList.add('list-view');
        listBtn.classList.add('active');
        gridBtn.classList.remove('active');
        localStorage.setItem('propsView', 'list');
    });

    // Restore view preference
    if (localStorage.getItem('propsView') === 'list') {
        grid?.classList.add('list-view');
        listBtn?.classList.add('active');
        gridBtn?.classList.remove('active');
    }

    /* ── Sort ── */
    window.applySort = function(val) {
        const url = new window.URL(window.location.href);
        url.searchParams.set('sort', val);
        window.location.href = url.toString();
    };

    /* ── Favorite toggle ── */
    const isAuthenticated = <?php echo  Illuminate\Support\Facades\Auth::check() ? 'true' : 'false'; ?>;
    const loginUrl = "<?php echo route('login'); ?>";

    window.toggleFav = function(btn, propertyId) {
        if (!isAuthenticated) {
            window.location.href = loginUrl;
            return;
        }

        fetch(`/properties/${propertyId}/favorite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                const icon = btn.querySelector('i');
                if (data.favorited) {
                    btn.classList.add('favorited');
                    icon.className = 'bi bi-heart-fill';
                } else {
                    btn.classList.remove('favorited');
                    icon.className = 'bi bi-heart';
                }
            })
            .catch(console.error);
    };

    /* ── GSAP ── */
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        gsap.from('.page-header-title', {
            opacity: 0,
            y: 20,
            duration: .7,
            ease: 'power3.out'
        });
        gsap.from('.page-header-sub', {
            opacity: 0,
            y: 15,
            duration: .6,
            delay: .15,
            ease: 'power3.out'
        });
        gsap.from('.filter-sidebar', {
            opacity: 0,
            x: -20,
            duration: .6,
            delay: .1,
            ease: 'power2.out'
        });

        document.querySelectorAll('.prop-card-item').forEach((el, i) => {
            gsap.from(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top bottom-=60',
                    toggleActions: 'play none none reverse'
                },
                opacity: 0,
                y: 24,
                duration: .45,
                delay: (i % 3) * .06,
                ease: 'power2.out'
            });
        });
    }
});
</script>
@endpush