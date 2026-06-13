use Illuminate\Support\Str;
@extends('base')

@section('title', 'Mes Favoris — EstateVista')

@push('styles')
<style>
/* ── Page Header ── */
.page-header {
    background: linear-gradient(135deg, #1A1A2E 0%, #2d1b69 55%, #1A1A2E 100%);
    position: relative;
    overflow: hidden;
    padding: 5rem 0 4rem;
}

.page-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 20% 60%, rgba(108, 58, 255, .28) 0%, transparent 55%),
        radial-gradient(ellipse at 80% 20%, rgba(167, 139, 250, .14) 0%, transparent 50%);
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

.page-eyebrow {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: #a78bfa;
    margin-bottom: .6rem;
}

.page-title {
    font-size: clamp(1.9rem, 4vw, 2.8rem);
    font-weight: 800;
    color: #fff;
    letter-spacing: -.025em;
    margin-bottom: .5rem;
    line-height: 1.15;
}

.page-sub {
    font-size: .95rem;
    color: rgba(255, 255, 255, .6);
}

/* Count badge in header */
.fav-count-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: rgba(232, 69, 69, .2);
    border: 1px solid rgba(232, 69, 69, .35);
    color: #fca5a5;
    font-size: .75rem;
    font-weight: 700;
    padding: .35rem .9rem;
    border-radius: 100px;
    margin-top: .85rem;
}

/* ── Toolbar ── */
.fav-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.fav-count-label {
    font-size: .85rem;
    color: var(--text-muted, #8A8FA8);
}

.fav-count-label strong {
    color: var(--text-main, #1A1A2E);
}

.sort-select {
    height: 40px;
    border: 1.5px solid var(--border, #ECEEF4);
    border-radius: 10px;
    padding: 0 2rem 0 .85rem;
    font-size: .82rem;
    font-weight: 500;
    color: var(--text-main, #1A1A2E);
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 16 16'%3E%3Cpath fill='%238A8FA8' d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat right .75rem center;
    appearance: none;
    cursor: pointer;
    transition: border-color .2s;
}

.sort-select:focus {
    outline: none;
    border-color: var(--primary, #6C3AFF);
}

.btn-clear-all {
    height: 40px;
    padding: 0 1.1rem;
    border: 1.5px solid #FEEAEA;
    background: #FEEAEA;
    border-radius: 10px;
    font-size: .82rem;
    font-weight: 600;
    color: #E84545;
    display: flex;
    align-items: center;
    gap: .4rem;
    cursor: pointer;
    transition: all .2s;
}

.btn-clear-all:hover {
    background: #E84545;
    border-color: #E84545;
    color: #fff;
}

/* ── Property Card ── */
.prop-card {
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid var(--border, #ECEEF4);
    background: #fff;
    transition: transform .3s ease, box-shadow .3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
}

.prop-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(108, 58, 255, .12);
}

.prop-img-wrap {
    position: relative;
    height: 210px;
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

/* Remove fav button */
.remove-fav-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(232, 69, 69, .9);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: .85rem;
    z-index: 2;
    cursor: pointer;
    transition: all .25s;
    box-shadow: 0 2px 8px rgba(232, 69, 69, .4);
}

.remove-fav-btn:hover {
    background: #E84545;
    transform: scale(1.1);
    box-shadow: 0 4px 14px rgba(232, 69, 69, .5);
}

/* "Removing" state animation */
.prop-card-wrap.removing {
    animation: fadeOut .35s ease forwards;
}

@keyframes fadeOut {
    to {
        opacity: 0;
        transform: scale(.95);
    }
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

/* Date added chip */
.date-added-chip {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: rgba(0, 0, 0, .45);
    backdrop-filter: blur(6px);
    color: rgba(255, 255, 255, .85);
    font-size: .65rem;
    font-weight: 500;
    padding: .2rem .6rem;
    border-radius: 6px;
    z-index: 2;
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
    color: var(--primary, #6C3AFF);
    line-height: 1;
    margin-bottom: .35rem;
}

.prop-price small {
    font-size: .65rem;
    font-weight: 500;
    color: var(--text-muted);
    vertical-align: middle;
    margin-left: .2rem;
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

/* Visit btn */
.btn-visit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    width: 100%;
    height: 40px;
    border-radius: 10px;
    background: var(--primary-soft, #EDE8FF);
    color: var(--primary, #6C3AFF);
    font-size: .82rem;
    font-weight: 700;
    text-decoration: none;
    margin-top: .75rem;
    border: none;
    cursor: pointer;
    transition: all .2s;
}

.btn-visit:hover {
    background: var(--primary);
    color: #fff;
    box-shadow: 0 6px 18px rgba(108, 58, 255, .3);
}

/* ── Empty State ── */
.empty-state {
    text-align: center;
    padding: 5rem 2rem;
    background: #fff;
    border-radius: 24px;
    border: 2px dashed var(--border);
    position: relative;
    overflow: hidden;
}

.empty-state::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 50% 0%, rgba(108, 58, 255, .04) 0%, transparent 60%);
    pointer-events: none;
}

.empty-heart {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: #FEEAEA;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.4rem;
    color: #E84545;
    animation: heartbeat 1.8s ease-in-out infinite;
}

@keyframes heartbeat {

    0%,
    100% {
        transform: scale(1);
    }

    14% {
        transform: scale(1.12);
    }

    28% {
        transform: scale(1);
    }

    42% {
        transform: scale(1.08);
    }

    56% {
        transform: scale(1);
    }
}

.empty-state h3 {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--text-main);
    margin-bottom: .5rem;
    letter-spacing: -.02em;
}

.empty-state p {
    font-size: .9rem;
    color: var(--text-muted);
    max-width: 360px;
    margin: 0 auto 2rem;
    line-height: 1.7;
}

.btn-explore {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .75rem 2rem;
    border-radius: 12px;
    background: var(--primary, #6C3AFF);
    color: #fff;
    font-size: .9rem;
    font-weight: 700;
    text-decoration: none;
    transition: all .2s;
    box-shadow: 0 6px 20px rgba(108, 58, 255, .35);
}

.btn-explore:hover {
    background: #5628E8;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(108, 58, 255, .45);
}

.empty-suggestions {
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}

.empty-suggestions p {
    font-size: .78rem;
    color: var(--text-muted);
    margin-bottom: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .08em;
}

.suggestion-chips {
    display: flex;
    justify-content: center;
    gap: .5rem;
    flex-wrap: wrap;
}

.suggestion-chip {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    padding: .4rem 1rem;
    border-radius: 100px;
    border: 1.5px solid var(--border);
    font-size: .78rem;
    font-weight: 600;
    color: var(--text-muted);
    text-decoration: none;
    transition: all .2s;
}

.suggestion-chip:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-soft);
}

/* ── Pagination ── */
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
    background: var(--primary-soft, #EDE8FF);
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

/* ── Toast notification ── */
.fav-toast {
    position: fixed;
    bottom: 1.5rem;
    left: 50%;
    transform: translateX(-50%) translateY(80px);
    background: #1A1A2E;
    color: #fff;
    font-size: .85rem;
    font-weight: 500;
    padding: .75rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, .25);
    z-index: 9999;
    white-space: nowrap;
    transition: transform .35s cubic-bezier(.4, 0, .2, 1);
    display: flex;
    align-items: center;
    gap: .6rem;
}

.fav-toast.show {
    transform: translateX(-50%) translateY(0);
}

.fav-toast i {
    color: #E84545;
}

/* ── CTA suggest ── */
.fav-cta-band {
    background: #fff;
    border-radius: 20px;
    border: 1px solid var(--border);
    padding: 2rem 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-top: 3rem;
}

.fav-cta-icon {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    background: var(--primary-soft);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}

.fav-cta-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: .2rem;
}

.fav-cta-sub {
    font-size: .82rem;
    color: var(--text-muted);
}

.btn-cta-action {
    height: 44px;
    padding: 0 1.5rem;
    background: var(--primary);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-size: .85rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    text-decoration: none;
    transition: all .2s;
    white-space: nowrap;
    flex-shrink: 0;
}

.btn-cta-action:hover {
    background: #5628E8;
    color: #fff;
    box-shadow: 0 6px 18px rgba(108, 58, 255, .35);
}
</style>
@endpush

@section('content')

{{-- ── Page Header ── --}}
<div class="page-header">
    <div class="container">
        <div class="breadcrumb-custom">
            <a href="{{ route('home') }}">Accueil</a>
            <span><i class="bi bi-chevron-right"></i></span>
            <span>Mes favoris</span>
        </div>
        <p class="page-eyebrow"><i class="bi bi-heart-fill me-1"></i>Ma liste de favoris</p>
        <h1 class="page-title">Mes Propriétés Favorites</h1>
        <p class="page-sub">Retrouvez tous les biens que vous avez sauvegardés</p>
        @if($properties->total() > 0)
        <div class="fav-count-badge">
            <i class="bi bi-heart-fill"></i>
            {{ $properties->total() }} bien{{ $properties->total() > 1 ? 's' : '' }}
            sauvegardé{{ $properties->total() > 1 ? 's' : '' }}
        </div>
        @endif
    </div>
</div>

{{-- ── Main ── --}}
<div style="background:var(--surface,#F4F5F7);min-height:60vh;padding:2.5rem 0 5rem">
    <div class="container">

        @if($properties->isEmpty())
        {{-- ── Empty state ── --}}
        <div class="empty-state">
            <div class="empty-heart">
                <i class="bi bi-heart"></i>
            </div>
            <h3>Aucun favori pour l'instant</h3>
            <p>
                Parcourez nos propriétés et cliquez sur le cœur <i class="bi bi-heart-fill text-danger"></i>
                pour sauvegarder les biens qui vous intéressent.
            </p>
            <a href="{{ route('properties.index') }}" class="btn-explore">
                <i class="bi bi-search"></i>
                Parcourir les propriétés
            </a>

            <div class="empty-suggestions">
                <p>Explorer par catégorie</p>
                <div class="suggestion-chips">
                    <a href="{{ route('properties.index') }}?status=for_sale" class="suggestion-chip">
                        <i class="bi bi-tag"></i> À vendre
                    </a>
                    <a href="{{ route('properties.index') }}?status=for_rent" class="suggestion-chip">
                        <i class="bi bi-key"></i> À louer
                    </a>
                    <a href="{{ route('properties.index') }}?type=villa" class="suggestion-chip">
                        <i class="bi bi-house-heart"></i> Villas
                    </a>
                    <a href="{{ route('properties.index') }}?type=apartment" class="suggestion-chip">
                        <i class="bi bi-building"></i> Appartements
                    </a>
                    <a href="{{ route('properties.index') }}?is_featured=1" class="suggestion-chip">
                        <i class="bi bi-star"></i> En vedette
                    </a>
                </div>
            </div>
        </div>

        @else

        {{-- ── Toolbar ── --}}
        <div class="fav-toolbar">
            <p class="fav-count-label mb-0">
                <strong>{{ $properties->total() }}</strong>
                propriété{{ $properties->total() > 1 ? 's' : '' }} sauvegardée{{ $properties->total() > 1 ? 's' : '' }}
            </p>
            <div class="d-flex align-items-center gap-2">
                <select class="sort-select" onchange="window.location.href=this.value">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}"
                        {{ !request('sort') || request('sort') === 'latest' ? 'selected' : '' }}>
                        Plus récents
                    </option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}"
                        {{ request('sort') === 'price_asc' ? 'selected' : '' }}>
                        Prix croissant
                    </option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}"
                        {{ request('sort') === 'price_desc' ? 'selected' : '' }}>
                        Prix décroissant
                    </option>
                </select>
                <button class="btn-clear-all" id="clearAllBtn" onclick="confirmClearAll()">
                    <i class="bi bi-trash3"></i> Tout supprimer
                </button>
            </div>
        </div>

        {{-- ── Grid ── --}}
        <div class="row g-4" id="favGrid">
            @foreach($properties as $property)
            <div class="col-xl-3 col-lg-4 col-md-6 prop-card-wrap" id="card-{{ $property->id }}">
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
                        $si = $statusMap[$property->status->value] ?? ['class' => 'badge-off', 'label' =>
                        $property->status->value];
                        @endphp
                        <span class="prop-badge {{ $si['class'] }}">{{ $si['label'] }}</span>

                        {{-- Remove from favorites --}}
                        <button class="remove-fav-btn" title="Retirer des favoris" data-id="{{ $property->id }}"
                            onclick="removeFav(this.dataset.id, this)">
                            <i class="bi bi-heart-fill"></i>
                        </button>

                        {{-- Type tag --}}
                        <span class="prop-type-tag">{{ $property->type->label() }}</span>

                        {{-- Date added --}}
                        <span class="date-added-chip">
                            <i class="bi bi-clock me-1"></i>
                            {{ optional($property->pivot->created_at ?? $property->created_at)->diffForHumans() ?? '' }}
                        </span>
                    </div>

                    <div class="prop-body">
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

                        <div class="prop-features">
                            @if($property->bedrooms)
                            <div class="prop-feat">
                                <i class="bi bi-door-open"></i> {{ $property->bedrooms }} ch.
                            </div>
                            @endif
                            @if($property->bathrooms)
                            <div class="prop-feat">
                                <i class="bi bi-droplet"></i> {{ $property->bathrooms }} sdb.
                            </div>
                            @endif
                            @if($property->surface)
                            <div class="prop-feat">
                                <i class="bi bi-rulers"></i> {{ number_format($property->surface) }} m²
                            </div>
                            @endif
                        </div>

                        <a href="{{ route('properties.show', $property->slug ?? $property->id) }}" class="btn-visit">
                            <i class="bi bi-eye"></i> Voir la propriété
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ── Pagination ── --}}
        @if($properties->hasPages())
        <nav class="pagination-custom">
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
            <li class="page-item {{ !$properties->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $properties->nextPageUrl() }}">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </nav>
        <p class="text-center text-muted mt-2" style="font-size:.75rem">
            Affichage {{ $properties->firstItem() }} - {{ $properties->lastItem() }}
            sur {{ $properties->total() }} favoris
        </p>
        @endif

        {{-- ── CTA ── --}}
        <div class="fav-cta-band">
            <div class="fav-cta-icon"><i class="bi bi-search-heart"></i></div>
            <div class="flex-grow-1">
                <div class="fav-cta-title">Découvrir d'autres propriétés</div>
                <div class="fav-cta-sub">Des nouveaux biens sont ajoutés chaque semaine — ne ratez rien.</div>
            </div>
            <a href="{{ route('properties.index') }}" class="btn-cta-action">
                <i class="bi bi-grid"></i> Voir tous les biens
            </a>
        </div>

        @endif

    </div>
</div>

{{-- Toast --}}
<div class="fav-toast" id="favToast">
    <i class="bi bi-heart-fill"></i>
    <span id="favToastMsg">Retiré des favoris</span>
</div>

{{-- Confirm modal --}}
<div class="modal fade" id="clearModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:18px;border:none">
            <div class="modal-body text-center p-4">
                <div
                    style="width:60px;height:60px;border-radius:50%;background:#FEEAEA;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.6rem;color:#E84545">
                    <i class="bi bi-trash3"></i>
                </div>
                <h5 style="font-weight:800;color:var(--text-main);margin-bottom:.5rem">Tout supprimer ?</h5>
                <p style="font-size:.85rem;color:var(--text-muted);margin-bottom:1.5rem">
                    Cette action retirera tous vos biens des favoris. Elle est irréversible.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-light px-4 py-2 fw-600 rounded-3" data-bs-dismiss="modal">Annuler</button>
                    <button class="btn btn-danger px-4 py-2 fw-600 rounded-3" id="confirmClearBtn">
                        <i class="bi bi-trash3 me-1"></i>Supprimer tout
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<div id="favorites-data" data-total="{{ $properties->total() }}" style="display:none">
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const toast = document.getElementById('favToast');
    const toastMsg = document.getElementById('favToastMsg');

    /* ── Show toast ── */
    function showToast(msg, isError = false) {
        toastMsg.textContent = msg;
        toast.querySelector('i').style.color = isError ? '#F5A623' : '#E84545';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    /* ── Remove single fav ── */
    window.removeFav = function(propertyId, btn) {
        const wrap = document.getElementById('card-' + propertyId);

        fetch(`/properties/${propertyId}/favorite`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (!data.favorited) {
                    wrap?.classList.add('removing');
                    setTimeout(() => {
                        wrap?.remove();
                        updateCount(-1);
                        checkEmpty();
                    }, 380);
                    showToast('Retiré des favoris');
                }
            })
            .catch(() => showToast('Erreur réseau', true));
    };

    /* ── Update count display ── */
    const favoritesData = document.getElementById('favorites-data');
    let totalCount = parseInt(favoritesData.dataset.total, 10) || 0;
    // let totalCount = parseInt(document.body.dataset.favoritesCount, 10) || 0;

    function updateCount(delta) {
        totalCount += delta;
        document.querySelectorAll('.fav-count-label strong').forEach(el => {
            el.textContent = totalCount;
        });
    }

    /* ── Check if grid is empty ── */
    function checkEmpty() {
        const grid = document.getElementById('favGrid');
        if (grid && grid.querySelectorAll('.prop-card-wrap:not(.removing)').length === 0) {
            setTimeout(() => location.reload(), 400);
        }
    }

    /* ── Clear all confirm ── */
    window.confirmClearAll = function() {
        const modal = new bootstrap.Modal(document.getElementById('clearModal'));
        modal.show();
    };

    document.getElementById('confirmClearBtn')?.addEventListener('click', function() {
        const cards = document.querySelectorAll('.prop-card-wrap');
        const promises = [];

        cards.forEach(card => {
            const id = card.id.replace('card-', '');
            promises.push(
                fetch(`/properties/${id}/favorite`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                    }
                }).then(r => r.json())
            );
        });

        Promise.all(promises).then(() => {
            bootstrap.Modal.getInstance(document.getElementById('clearModal'))?.hide();
            showToast('Tous les favoris supprimés');
            setTimeout(() => location.reload(), 900);
        }).catch(() => showToast('Erreur lors de la suppression', true));
    });

    /* ── GSAP animations ── */
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        gsap.from('.page-title', {
            opacity: 0,
            y: 20,
            duration: .7,
            ease: 'power3.out'
        });
        gsap.from('.fav-count-badge', {
            opacity: 0,
            y: 10,
            duration: .5,
            delay: .3,
            ease: 'power2.out'
        });

        document.querySelectorAll('.prop-card-wrap').forEach((el, i) => {
            gsap.from(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top bottom-=60',
                    toggleActions: 'play none none reverse'
                },
                opacity: 0,
                y: 24,
                duration: .45,
                delay: (i % 4) * .07,
                ease: 'power2.out'
            });
        });

        if (document.querySelector('.empty-heart')) {
            gsap.from('.empty-heart', {
                opacity: 0,
                scale: .7,
                duration: .6,
                ease: 'back.out(1.4)'
            });
            gsap.from('.empty-state h3', {
                opacity: 0,
                y: 14,
                duration: .5,
                delay: .2,
                ease: 'power2.out'
            });
            gsap.from('.suggestion-chip', {
                opacity: 0,
                y: 10,
                stagger: .06,
                duration: .4,
                delay: .4,
                ease: 'power2.out'
            });
        }
    }
});
</script>
@endpush