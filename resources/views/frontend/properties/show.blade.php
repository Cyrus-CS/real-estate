@extends('base')

@section('title', $property->address . ' – EstateVista')
@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
@endphp
@push('styles')
<style>
/* ── Hero Carousel ── */
.property-carousel {
    border-radius: 1.25rem;
    overflow: hidden;
    background: var(--text-main);
    position: relative;
}

.property-carousel .carousel-inner {
    max-height: 520px;
}

.property-carousel .carousel-item img {
    width: 100%;
    height: 520px;
    object-fit: cover;
    opacity: .93;
}

.carousel-control-prev,
.carousel-control-next {
    width: 44px;
    height: 44px;
    top: 50%;
    transform: translateY(-50%);
    border-radius: 50%;
    background: rgba(255, 255, 255, .15);
    backdrop-filter: blur(8px);
    border: 1.5px solid rgba(255, 255, 255, .25);
    transition: background .2s;
    opacity: 1;
}

.carousel-control-prev {
    left: 1rem;
}

.carousel-control-next {
    right: 1rem;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background: rgba(108, 58, 255, .6);
}

.carousel-control-prev.disabled-nav,
.carousel-control-next.disabled-nav {
    opacity: .25 !important;
    pointer-events: none;
}

.carousel-counter {
    position: absolute;
    bottom: 1rem;
    right: 1.25rem;
    background: rgba(26, 26, 46, .6);
    backdrop-filter: blur(6px);
    color: #fff;
    font-size: .78rem;
    font-weight: 600;
    padding: .3rem .75rem;
    border-radius: 2rem;
    z-index: 10;
}

/* Thumbnails strip */
.thumb-strip {
    display: flex;
    gap: .5rem;
    margin-top: .75rem;
    overflow-x: auto;
    padding-bottom: .25rem;
    scrollbar-width: thin;
}

.thumb-strip::-webkit-scrollbar {
    height: 4px;
}

.thumb-strip::-webkit-scrollbar-thumb {
    background: var(--border);
    border-radius: 4px;
}

.thumb-item {
    flex-shrink: 0;
    width: 72px;
    height: 54px;
    border-radius: .5rem;
    overflow: hidden;
    border: 2px solid transparent;
    cursor: pointer;
    transition: border-color .2s;
}

.thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumb-item.active {
    border-color: var(--primary);
}

/* ── Badges ── */
.badge-status {
    font-size: .72rem;
    font-weight: 700;
    padding: .35em .85em;
    border-radius: .5rem;
    letter-spacing: .04em;
    text-transform: uppercase;
}

.badge-for_rent {
    background: var(--badge-green);
    color: var(--badge-green-t);
}

.badge-for_sale {
    background: var(--primary-soft);
    color: var(--primary);
}

.badge-sold {
    background: var(--badge-red);
    color: var(--badge-red-t);
}

.badge-rented {
    background: #FFF3E0;
    color: #E65100;
}

.badge-off_market {
    background: var(--surface);
    color: var(--text-muted);
}

/* ── Section label ── */
.section-label {
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--primary);
    margin-bottom: .35rem;
}

.divider {
    border: none;
    border-top: 1.5px solid var(--border);
    margin: 1.75rem 0;
}

/* ── Stat pill ── */
.stat-pill {
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    background: var(--surface);
    border-radius: .75rem;
    padding: .55rem 1rem;
    font-size: .875rem;
    font-weight: 600;
    color: var(--text-main);
    border: 1px solid var(--border);
}

.stat-pill i {
    color: var(--primary);
    font-size: 1rem;
}

/* ── Amenity chip ── */
.amenity-chip {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: var(--primary-soft);
    color: var(--primary);
    border-radius: .6rem;
    padding: .4rem .85rem;
    font-size: .8rem;
    font-weight: 600;
}

/* ── Sidebar cards ── */
.side-card {
    background: var(--white);
    border: 1.5px solid var(--border);
    border-radius: 1.25rem;
    padding: 1.75rem;
    box-shadow: 0 2px 12px rgba(108, 58, 255, .07);
    margin-bottom: 1.25rem;
}

.price-tag {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
    letter-spacing: -.02em;
    line-height: 1;
}

/* ── Agent card ── */
.agent-avatar {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid var(--primary-soft);
}

.agent-avatar-placeholder {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--primary-soft);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    font-weight: 800;
    border: 3px solid var(--primary-soft);
}

.btn-agent-action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    width: 100%;
    padding: .6rem 1rem;
    border-radius: .75rem;
    font-size: .85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    border: 1.5px solid var(--border);
    color: var(--text-main);
    background: var(--surface);
}

.btn-agent-action:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-soft);
}

.btn-agent-action.primary {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
    box-shadow: 0 4px 14px rgba(108, 58, 255, .3);
}

.btn-agent-action.primary:hover {
    background: var(--primary-hover);
    border-color: var(--primary-hover);
    color: #fff;
}

/* ── Rent form card ── */
.rent-card {
    background: linear-gradient(145deg, #1A1A2E 0%, #2d1b69 100%);
    border-radius: 1.25rem;
    padding: 1.75rem;
    margin-bottom: 1.25rem;
    position: relative;
    overflow: hidden;
    border: 1.5px solid rgba(108, 58, 255, .25);
    box-shadow: 0 8px 32px rgba(108, 58, 255, .2);
}

.rent-card::before {
    content: '';
    position: absolute;
    top: -40px;
    right: -40px;
    width: 160px;
    height: 160px;
    border-radius: 50%;
    background: rgba(108, 58, 255, .15);
    pointer-events: none;
}

.rent-card::after {
    content: '';
    position: absolute;
    bottom: -30px;
    left: -30px;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(167, 139, 250, .1);
    pointer-events: none;
}

.rent-card .rc-label {
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: #a78bfa;
    margin-bottom: .3rem;
}

.rent-card .rc-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: .3rem;
    line-height: 1.2;
}

.rent-card .rc-sub {
    font-size: .78rem;
    color: rgba(255, 255, 255, .55);
    margin-bottom: 1.25rem;
    line-height: 1.6;
}

.rc-input {
    width: 100%;
    background: rgba(255, 255, 255, .08);
    border: 1.5px solid rgba(255, 255, 255, .15);
    color: #fff;
    border-radius: .75rem;
    padding: .6rem .9rem;
    font-size: .85rem;
    font-family: inherit;
    transition: all .2s;
    margin-bottom: .85rem;
}

.rc-input:focus {
    outline: none;
    background: rgba(255, 255, 255, .14);
    border-color: rgba(108, 58, 255, .7);
    box-shadow: 0 0 0 4px rgba(108, 58, 255, .18);
    color: #fff;
}

.rc-input::placeholder {
    color: rgba(255, 255, 255, .35);
}

.rc-input option {
    background: #1A1A2E;
    color: #fff;
}

.rc-label-field {
    display: block;
    font-size: .74rem;
    font-weight: 600;
    color: rgba(255, 255, 255, .6);
    margin-bottom: .3rem;
}

.btn-rc-submit {
    width: 100%;
    height: 48px;
    border: none;
    border-radius: .75rem;
    font-size: .9rem;
    font-weight: 700;
    background: #fff;
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    cursor: pointer;
    transition: all .2s;
    box-shadow: 0 4px 16px rgba(0, 0, 0, .15);
    position: relative;
    z-index: 1;
}

.btn-rc-submit:hover {
    background: var(--primary-soft);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, .2);
}

.is-invalid-rc {
    border-color: #E84545 !important;
}

.error-msg {
    font-size: .72rem;
    color: #fca5a5;
    margin-top: -.6rem;
    margin-bottom: .7rem;
    display: block;
}

/* ── Status info box ── */
.status-info-box {
    text-align: center;
    padding: 1.5rem 1rem;
    border-radius: 1rem;
    border: 1.5px dashed var(--border);
}

.status-info-box .sib-icon {
    font-size: 2rem;
    margin-bottom: .5rem;
}

.status-info-box h6 {
    font-size: .9rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: .3rem;
}

.status-info-box p {
    font-size: .8rem;
    color: var(--text-muted);
    margin: 0;
}

/* ── Guest CTA ── */
.guest-cta {
    text-align: center;
    padding: 1.5rem 1rem;
}

.guest-cta-icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: var(--primary-soft);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto .85rem;
    font-size: 1.4rem;
    color: var(--primary);
}

.success-box {
    background: var(--badge-green);
    border-radius: .85rem;
    padding: 1rem 1.1rem;
    display: flex;
    align-items: flex-start;
    gap: .65rem;
    font-size: .83rem;
    color: var(--badge-green-t);
    margin-bottom: 1rem;
}

.success-box i {
    font-size: 1.1rem;
    flex-shrink: 0;
    margin-top: .05rem;
}

.error-box {
    background: var(--badge-red);
    border-radius: .85rem;
    padding: 1rem 1.1rem;
    display: flex;
    align-items: flex-start;
    gap: .65rem;
    font-size: .83rem;
    color: var(--badge-red-t);
    margin-bottom: 1rem;
}

.error-box i {
    font-size: 1.1rem;
    flex-shrink: 0;
    margin-top: .05rem;
}

/* ── Similar cards ── */
.similar-card {
    border: 1.5px solid var(--border);
    border-radius: 1.25rem;
    overflow: hidden;
    background: var(--white);
    box-shadow: var(--shadow-card);
    transition: transform .25s, box-shadow .25s;
    text-decoration: none;
    color: inherit;
    display: block;
}

.similar-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(108, 58, 255, .14);
}

.similar-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.similar-card .card-body {
    padding: 1rem 1.25rem;
}
</style>
@endpush

@section('content')

{{-- ── Breadcrumb ── --}}
<div style="background:var(--surface);border-bottom:1px solid var(--border);" class="py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size:.85rem">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none" style="color:var(--primary)">
                        <i class="bi bi-house-door me-1"></i>Accueil
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('properties.index') }}" class="text-decoration-none" style="color:var(--primary)">
                        Propriétés
                    </a>
                </li>
                <li class="breadcrumb-item active text-truncate" style="max-width:280px;color:var(--text-muted)">
                    {{ Str::limit($property->address, 45) }}
                </li>
            </ol>
        </nav>
    </div>
</div>

{{-- ── Main ── --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4">

            {{-- ═══════════════════════════════
                 LEFT COLUMN
                 ═══════════════════════════════ --}}
            <div class="col-lg-8">

                {{-- Carousel --}}
                @php
                $images = $property->images->sortBy('sort_order')->values();
                $totalImages = $images->count();
                @endphp

                <div class="property-carousel">
                    @if($totalImages > 0)
                    <div id="carouselProperty" class="carousel slide" data-bs-ride="false"
                        data-total="{{ $totalImages }}">
                        <div class="carousel-inner">
                            @foreach($images as $i => $img)
                            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/'.$img->image_path) }}" alt="Photo {{ $i+1 }}"
                                    loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
                            </div>
                            @endforeach
                        </div>
                        @if($totalImages > 1)
                        <button class="carousel-control-prev disabled-nav" id="btnPrev" type="button"
                            data-bs-target="#carouselProperty" data-bs-slide="prev">
                            <i class="bi bi-chevron-left" style="font-size:1.2rem;color:#fff"></i>
                        </button>
                        <button class="carousel-control-next" id="btnNext" type="button"
                            data-bs-target="#carouselProperty" data-bs-slide="next">
                            <i class="bi bi-chevron-right" style="font-size:1.2rem;color:#fff"></i>
                        </button>
                        @endif
                        <span class="carousel-counter" id="carouselCounter">1 / {{ $totalImages }}</span>
                    </div>

                    {{-- Thumbnails --}}
                    @if($totalImages > 1)
                    <div class="thumb-strip" id="thumbStrip">
                        @foreach($images as $i => $img)
                        <div class="thumb-item {{ $i === 0 ? 'active' : '' }}" data-index="{{ $i }}"
                            onclick="goToSlide('{{ $i }}')">
                            <img src="{{ asset('storage/'.$img->image_path) }}" alt="Thumb {{ $i+1 }}">
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @elseif($property->cover_image)
                    <img src="{{ asset('storage/'.$property->cover_image) }}" alt="{{ $property->address }}"
                        style="width:100%;height:520px;object-fit:cover;">
                    @else
                    <div class="d-flex align-items-center justify-content-center"
                        style="height:380px;background:var(--surface)">
                        <div class="text-center text-muted">
                            <i class="bi bi-image" style="font-size:3rem;color:var(--text-light)"></i>
                            <p class="mt-2 mb-0" style="color:var(--text-light)">Aucune photo disponible</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- ── Header ── --}}
                <div class="mt-4" id="propHeader">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <span class="badge-status badge-{{ $property->status->value }}">
                            {{ $property->status->label() }}
                        </span>
                        <span class="badge-status" style="background:var(--surface);color:var(--text-muted)">
                            {{ $property->type->label() }}
                        </span>
                        @if($property->is_featured)
                        <span class="badge-status" style="background:#FFF8E1;color:#F59E0B">
                            <i class="bi bi-star-fill me-1"></i>Coup de cœur
                        </span>
                        @endif
                    </div>

                    <h1 class="fw-800 mb-1" style="font-size:1.65rem;color:var(--text-main);line-height:1.25">
                        {{ $property->address }}
                    </h1>
                    <p class="mb-0" style="color:var(--text-muted);font-size:.95rem">
                        <i class="bi bi-geo-alt me-1" style="color:var(--primary)"></i>
                        {{ $property->city }}@if($property->state), {{ $property->state }}@endif
                        @if($property->zip_code) {{ $property->zip_code }}@endif
                        – {{ $property->country }}
                    </p>
                </div>

                <hr class="divider">

                {{-- ── Stats ── --}}
                <div class="d-flex flex-wrap gap-2" id="propStats">
                    @if($property->bedrooms)
                    <span class="stat-pill">
                        <i class="bi bi-door-open"></i>
                        {{ $property->bedrooms }} chambre{{ $property->bedrooms > 1 ? 's' : '' }}
                    </span>
                    @endif
                    @if($property->bathrooms)
                    <span class="stat-pill">
                        <i class="bi bi-droplet"></i>
                        {{ $property->bathrooms }} sdb.
                    </span>
                    @endif
                    @if($property->surface)
                    <span class="stat-pill">
                        <i class="bi bi-aspect-ratio"></i>
                        {{ number_format($property->surface, 0, ',', ' ') }} m²
                    </span>
                    @endif
                    @if($property->floors)
                    <span class="stat-pill">
                        <i class="bi bi-building"></i>
                        {{ $property->floors }} étage{{ $property->floors > 1 ? 's' : '' }}
                    </span>
                    @endif
                    @if($property->year_built)
                    <span class="stat-pill">
                        <i class="bi bi-calendar3"></i>
                        Construit en {{ $property->year_built }}
                    </span>
                    @endif
                </div>

                <hr class="divider">

                {{-- ── Description ── --}}
                @if($property->description)
                <div id="propDesc">
                    <p class="section-label">Description</p>
                    <div style="color:var(--text-main);line-height:1.85;font-size:.95rem">
                        {!! nl2br(e($property->description)) !!}
                    </div>
                </div>
                <hr class="divider">
                @endif

                {{-- ── Amenities ── --}}
                @if($property->amenities->isNotEmpty())
                <div id="propAmenities">
                    <p class="section-label">Équipements & Services</p>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach($property->amenities as $amenity)
                        <span class="amenity-chip">
                            <i class="bi bi-check-circle-fill"></i>{{ $amenity->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
                <hr class="divider">
                @endif

                {{-- ── Map placeholder ── --}}
                <div id="propMap">
                    <p class="section-label">Localisation</p>
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                        style="height:220px;background:var(--surface);border:1.5px dashed var(--border)">
                        <div class="text-center">
                            <i class="bi bi-map" style="font-size:2.5rem;color:var(--text-light)"></i>
                            <p class="mt-2 mb-0" style="color:var(--text-muted);font-size:.88rem">
                                {{ $property->address }}, {{ $property->city }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>{{-- /col-lg-8 --}}

            {{-- ═══════════════════════════════
                 RIGHT COLUMN
                 ═══════════════════════════════ --}}
            <div class="col-lg-4">
                <div class="sticky-top" style="top:88px">

                    {{-- ── Prix ── --}}
                    <div class="side-card">
                        <p class="section-label mb-1">Prix</p>
                        <div class="price-tag">
                            ${{ number_format($property->price, 0, ',', ' ') }}
                            @if($property->status === \App\Enums\PropertyStatus::FOR_RENT)
                            <span style="font-size:1rem;font-weight:500;color:var(--text-muted)">/mois</span>
                            @endif
                        </div>
                        @if($property->surface)
                        <p class="mb-0 mt-1" style="color:var(--text-muted);font-size:.82rem">
                            ≈ ${{ number_format($property->price / $property->surface, 0, ',', ' ') }} / m²
                        </p>
                        @endif
                    </div>

                    {{-- ══════════════════════════════════
                         RENT FORM / STATUS BLOCK
                         Logique : $property->status->value === 'for_rent'
                         ══════════════════════════════════ --}}
                    @if($property->status->value === 'for_rent')

                    @auth
                    @php $userRole = Auth::user()->role instanceof \BackedEnum ? Auth::user()->role->value :
                    Auth::user()->role; @endphp

                    @if($userRole === 'buyer')

                    @if($hasActiveRent)
                    {{-- Demande déjà en cours --}}
                    <div class="rent-card" style="position:relative;z-index:1">
                        <div class="text-center" style="position:relative;z-index:1">
                            <div
                                style="width:54px;height:54px;border-radius:50%;background:rgba(29,185,122,.2);display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;font-size:1.5rem">
                                <i class="bi bi-envelope-check" style="color:#FFF"></i>
                            </div>
                            <div class=" rc-title">Demande envoyée !
                            </div>
                            <p class="rc-sub">
                                Votre demande est en cours de traitement.<br>
                                L'agent vous contactera bientôt.
                            </p>
                            <span
                                style="display:inline-flex;align-items:center;gap:.4rem;background:rgba(29,185,122,.15);color:#4ade80;font-size:.75rem;font-weight:600;padding:.3rem .85rem;border-radius:100px;border:1px solid rgba(29,185,122,.3)">
                                <span
                                    style="width:6px;height:6px;border-radius:50%;background:#1DB97A;animation:pulse 1.5s infinite"></span>
                                En attente de réponse
                            </span>
                        </div>
                    </div>

                    @else
                    {{-- Formulaire de demande de location --}}
                    <div class="rent-card">
                        <div style="position:relative;z-index:1">
                            <p class="rc-label"><i class="bi bi-key-fill me-1"></i>Demande de location</p>
                            <div class="rc-title">Intéressé par ce bien ?</div>
                            <p class="rc-sub">Remplissez ce formulaire et l'agent vous recontactera sous 24h.</p>

                            @if(session('success'))
                            <div class="success-box">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                            @endif
                            @if(session('error'))
                            <div class="error-box">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                            @endif

                            <form action="{{ route('rents.store', $property) }}" method="POST" novalidate>
                                @csrf

                                <label class="rc-label-field">
                                    <i class="bi bi-calendar-event me-1"></i>Date d'emménagement
                                </label>
                                <input type="date" name="desired_move_in"
                                    class="rc-input @error('desired_move_in') is-invalid-rc @enderror"
                                    min="{{ date('Y-m-d') }}" value="{{ old('desired_move_in') }}">
                                @error('desired_move_in')
                                <span class="error-msg">{{ $message }}</span>
                                @enderror

                                <label class="rc-label-field">
                                    <i class="bi bi-clock me-1"></i>Durée souhaitée
                                </label>
                                <select name="lease_duration_months"
                                    class="rc-input @error('lease_duration_months') is-invalid-rc @enderror">
                                    <option value="">Choisir une durée</option>
                                    @foreach([1,2,3,6,9,12,18,24,36] as $m)
                                    <option value="{{ $m }}" {{ old('lease_duration_months') == $m ? 'selected' : '' }}>
                                        {{ $m }} mois{{ $m >= 12 ? ' ('.($m/12).' an'.($m > 12 ? 's' : '').')' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('lease_duration_months')
                                <span class="error-msg">{{ $message }}</span>
                                @enderror

                                <label class="rc-label-field">
                                    <i class="bi bi-chat-text me-1"></i>Message
                                    <span style="opacity:.5;font-weight:400">(optionnel)</span>
                                </label>
                                <textarea name="message" rows="3"
                                    class="rc-input @error('message') is-invalid-rc @enderror"
                                    placeholder="Présentez-vous, posez vos questions…" maxlength="2000"
                                    style="resize:none;height:90px">{{ old('message') }}</textarea>
                                @error('message')
                                <span class="error-msg">{{ $message }}</span>
                                @enderror

                                <button type="submit" class="btn-rc-submit">
                                    <i class="bi bi-send-fill"></i>
                                    Envoyer ma demande
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    @else
                    {{-- Admin ou Agent -- --}}
                    <div class="side-card">
                        <div class="status-info-box">
                            <div class="sib-icon">🛡️</div>
                            <h6>Mode {{ ucfirst($userRole) }}</h6>
                            <p>Les demandes de location sont réservées aux acheteurs.</p>
                        </div>
                    </div>
                    @endif

                    @else
                    {{-- Non connecté --}}
                    <div class="side-card">
                        <div class="guest-cta">
                            <div class="guest-cta-icon"><i class="bi bi-lock-fill"></i></div>
                            <h6 class="fw-800 mb-1" style="color:var(--text-main)">Intéressé par ce bien ?</h6>
                            <p style="color:var(--text-muted);font-size:.83rem;line-height:1.65;margin-bottom:1.25rem">
                                Connectez-vous pour envoyer une demande de location à l'agent.
                            </p>
                            <a href="{{ route('login') }}" class="btn-agent-action primary mb-2">
                                <i class="bi bi-person-circle"></i>Se connecter
                            </a>
                            <p style="font-size:.76rem;color:var(--text-muted);margin:0">
                                Pas de compte ?
                                <a href="{{ route('register') }}"
                                    style="color:var(--primary);font-weight:600;text-decoration:none">
                                    S'inscrire gratuitement
                                </a>
                            </p>
                        </div>
                    </div>
                    @endauth

                    @else
                    {{-- Bien non dispo à la location --}}
                    <div class="side-card">
                        <div class="status-info-box">
                            <div class="sib-icon">
                                @switch($property->status->value)
                                @case('sold') 🏷️ @break
                                @case('rented') 🔑 @break
                                @case('for_sale') 🏠 @break
                                @default 🚫
                                @endswitch
                            </div>
                            <h6>
                                @switch($property->status->value)
                                @case('sold') Ce bien a été vendu @break
                                @case('rented') Ce bien est déjà loué @break
                                @case('for_sale') Ce bien est à vendre @break
                                @case('off_market') Bien hors marché @break
                                @default Non disponible
                                @endswitch
                            </h6>
                            <p>
                                @if($property->status->value === 'for_sale')
                                Contactez l'agent pour plus d'informations sur l'achat.
                                @else
                                Ce bien n'est plus disponible actuellement.
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif

                    {{-- ── Agent Card ── --}}
                    @if($property->agent)
                    <div class="side-card">
                        <p class="section-label mb-3">Votre agent</p>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            @if($property->agent->user->avatar)
                            <img src="{{ asset('storage/'.$property->agent->user->avatar) }}"
                                alt="{{ $property->agent->user->name }}" class="agent-avatar">
                            @else
                            <div class="agent-avatar-placeholder">
                                {{ strtoupper(substr($property->agent->user->name, 0, 1)) }}
                            </div>
                            @endif
                            <div>
                                <p class="mb-0 fw-700" style="color:var(--text-main);font-size:.92rem">
                                    {{ $property->agent->user->name }} {{ $property->agent->user->last_name }}
                                </p>
                                @if($property->agent->agency_name)
                                <p class="mb-0" style="color:var(--text-muted);font-size:.8rem">
                                    <i class="bi bi-building me-1" style="color:var(--primary)"></i>
                                    {{ $property->agent->agency_name }}
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2">
                            @if($property->agent->user->phone)
                            <a href="tel:{{ $property->agent->user->phone }}" class="btn-agent-action">
                                <i class="bi bi-telephone-fill"></i>
                                {{ $property->agent->user->phone }}
                            </a>
                            @endif
                            <a href="mailto:{{ $property->agent->user->email }}" class="btn-agent-action">
                                <i class="bi bi-envelope-fill"></i>
                                Envoyer un email
                            </a>
                            <a href="{{ route('agents.show', $property->agent->id) }}" class="btn-agent-action primary">
                                <i class="bi bi-person-badge-fill"></i>
                                Voir le profil
                            </a>
                        </div>
                    </div>
                    @endif

                </div>{{-- /sticky-top --}}
            </div>{{-- /col-lg-4 --}}

        </div>{{-- /row --}}
    </div>
</section>

{{-- ── Biens similaires ── --}}
@if($similarProperties->isNotEmpty())
<section class="py-5" style="background:var(--surface)">
    <div class="container">
        <p class="section-label">Biens similaires</p>
        <h2 class="fw-800 mb-4" style="font-size:1.4rem;color:var(--text-main)">Vous pourriez aussi aimer</h2>
        <div class="row g-4" id="similarGrid">
            @foreach($similarProperties as $item)
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('properties.show', $item->id) }}" class="similar-card">
                    @if($item->cover_image)
                    <img src="{{ asset('storage/'.$item->cover_image) }}" alt="{{ $item->address }}" loading="lazy">
                    @elseif($item->images->first())
                    <img src="{{ asset('storage/'.$item->images->first()->image_path) }}" alt="{{ $item->address }}"
                        loading="lazy">
                    @else
                    <div class="d-flex align-items-center justify-content-center"
                        style="height:180px;background:var(--surface)">
                        <i class="bi bi-image" style="font-size:2rem;color:var(--text-light)"></i>
                    </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <span class="badge-status badge-{{ $item->status->value }}" style="font-size:.68rem">
                                {{ $item->status->label() }}
                            </span>
                            <span class="fw-700" style="color:var(--primary);font-size:.92rem">
                                ${{ number_format($item->price, 0, ',', ' ') }}
                            </span>
                        </div>
                        <p class="mb-1 fw-600" style="font-size:.85rem;color:var(--text-main)">
                            {{ Str::limit($item->address, 38) }}
                        </p>
                        <p class="mb-0" style="font-size:.78rem;color:var(--text-muted)">
                            <i class="bi bi-geo-alt me-1" style="color:var(--primary)"></i>{{ $item->city }}
                        </p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ── Carousel ── */
    const carouselEl = document.getElementById('carouselProperty');
    if (carouselEl) {
        const total = parseInt(carouselEl.dataset.total, 10);
        const btnPrev = document.getElementById('btnPrev');
        const btnNext = document.getElementById('btnNext');
        const counter = document.getElementById('carouselCounter');
        const thumbs = document.querySelectorAll('.thumb-item');
        let current = 0;

        const updateUI = () => {
            if (counter) counter.textContent = (current + 1) + ' / ' + total;
            if (btnPrev) btnPrev.classList.toggle('disabled-nav', current === 0);
            if (btnNext) btnNext.classList.toggle('disabled-nav', current === total - 1);
            thumbs.forEach((t, i) => t.classList.toggle('active', i === current));
        };

        carouselEl.addEventListener('slid.bs.carousel', function(e) {
            current = e.to;
            updateUI();
        });

        updateUI();
    }

    window.goToSlide = function(index) {
        const el = document.getElementById('carouselProperty');
        if (!el) return;
        const carousel = bootstrap.Carousel.getOrCreateInstance(el);
        carousel.to(index);
    };

    /* ── GSAP ── */
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        gsap.from('.property-carousel', {
            opacity: 0,
            y: 24,
            duration: .7,
            ease: 'power2.out'
        });
        gsap.from('#propHeader', {
            opacity: 0,
            y: 20,
            duration: .6,
            delay: .15,
            ease: 'power2.out'
        });
        gsap.from('.side-card, .rent-card', {
            opacity: 0,
            x: 20,
            duration: .6,
            stagger: .1,
            delay: .2,
            ease: 'power2.out'
        });

        ['#propStats', '#propDesc', '#propAmenities', '#propMap'].forEach(function(sel, i) {
            const el = document.querySelector(sel);
            if (!el) return;
            gsap.from(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top 88%'
                },
                opacity: 0,
                y: 18,
                duration: .55,
                delay: i * .07,
                ease: 'power2.out'
            });
        });

        const simItems = document.querySelectorAll('#similarGrid .col-md-6');
        if (simItems.length) {
            gsap.from(simItems, {
                scrollTrigger: {
                    trigger: '#similarGrid',
                    start: 'top 85%'
                },
                opacity: 0,
                y: 22,
                stagger: .08,
                duration: .5,
                ease: 'power2.out'
            });
        }
    }
});
</script>
@endpush