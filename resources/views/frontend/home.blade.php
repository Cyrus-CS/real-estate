@extends('base')
@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
Auth::loginUsingId(3);
@endphp
@section('title', 'EstateVista - Propriétés d\'Exception')

@push('styles')
<style>
/* ============================================================
   VARIABLES & RESETS
   ============================================================ */
:root {
    --primary: #6C3AFF;
    --primary-soft: #EDE8FF;
    --primary-hover: #5628E8;
    --surface: #F4F5F7;
    --white: #FFFFFF;
    --text-main: #1A1A2E;
    --text-muted: #8A8FA8;
    --text-light: #B4B9CC;
    --border: #ECEEF4;
    --badge-green: #E6F9F0;
    --badge-green-t: #1DB97A;
    --badge-red: #FEEAEA;
    --badge-red-t: #E84545;
    --shadow-card: 0 4px 24px rgba(108, 58, 255, .10);
    --transition: .25s cubic-bezier(.4, 0, .2, 1);
    --gold: #F5A623;
}

/* ============================================================
   HERO
   ============================================================ */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background: url('https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=2000&q=90') center/cover no-repeat;
    overflow: hidden;
}

.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(165deg, rgba(10, 8, 30, .82) 0%, rgba(26, 10, 60, .72) 50%, rgba(10, 8, 30, .88) 100%);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    flex: 1;
    display: flex;
    align-items: center;
    padding: 8rem 0 3rem;
}

.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: rgba(108, 58, 255, .18);
    border: 1px solid rgba(108, 58, 255, .35);
    color: #c4b5fd;
    font-size: .78rem;
    font-weight: 600;
    letter-spacing: .12em;
    text-transform: uppercase;
    padding: .4rem 1rem;
    border-radius: 100px;
    margin-bottom: 1.5rem;
}

.hero-title {
    font-size: clamp(2.4rem, 5vw, 4rem);
    font-weight: 800;
    color: var(--white);
    line-height: 1.15;
    margin-bottom: 1.25rem;
    letter-spacing: -.02em;
}

.hero-title span {
    background: linear-gradient(90deg, #a78bfa, #6C3AFF);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.05rem;
    color: rgba(255, 255, 255, .72);
    margin-bottom: 2.5rem;
    max-width: 500px;
    line-height: 1.7;
}

/* ── Scroll indicator ── */
.hero-scroll-indicator {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .4rem;
    color: rgba(255, 255, 255, .45);
    font-size: .75rem;
    letter-spacing: .1em;
    text-transform: uppercase;
    animation: bounce 2s infinite;
}

.hero-scroll-indicator .scroll-line {
    width: 1px;
    height: 40px;
    background: linear-gradient(to bottom, rgba(255, 255, 255, .5), transparent);
}

@keyframes bounce {

    0%,
    100% {
        transform: translateX(-50%) translateY(0)
    }

    50% {
        transform: translateX(-50%) translateY(6px)
    }
}

/* ── Stats bar ── */
.hero-stats-bar {
    position: relative;
    z-index: 2;
    background: rgba(255, 255, 255, .06);
    backdrop-filter: blur(16px);
    border-top: 1px solid rgba(255, 255, 255, .08);
    padding: 1.25rem 0;
}

.hero-stat-item {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .5rem 1.5rem;
    border-right: 1px solid rgba(255, 255, 255, .1);
    color: var(--white);
}

.hero-stat-item:last-child {
    border-right: none;
}

.hero-stat-num {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1;
    color: var(--white);
}

.hero-stat-label {
    font-size: .78rem;
    color: rgba(255, 255, 255, .55);
    line-height: 1.4;
}

.hero-stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(108, 58, 255, .25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: #a78bfa;
    flex-shrink: 0;
}

/* ============================================================
   SEARCH FORM
   ============================================================ */
.search-form-wrapper {
    background: rgba(255, 255, 255, .07);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 20px;
    padding: 1.5rem;
    box-shadow: 0 32px 80px rgba(0, 0, 0, .35);
}

.search-tabs .nav-link {
    color: rgba(255, 255, 255, .5);
    font-size: .85rem;
    font-weight: 600;
    padding: .45rem 1.1rem;
    border-radius: 8px;
    border: none;
    letter-spacing: .04em;
    transition: all var(--transition);
}

.search-tabs .nav-link.active,
.search-tabs .nav-link:hover {
    background: rgba(108, 58, 255, .3);
    color: var(--white);
}

.search-tabs {
    margin-bottom: 1.25rem;
}

.sf-group {
    position: relative;
}

.sf-group .sf-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255, 255, 255, .45);
    font-size: 1rem;
    pointer-events: none;
    z-index: 5;
}

.sf-input {
    height: 52px;
    background: rgba(255, 255, 255, .08);
    border: 1.5px solid rgba(255, 255, 255, .12);
    color: var(--white);
    border-radius: 12px;
    padding-left: 2.75rem;
    font-size: .9rem;
    transition: all var(--transition);
    width: 100%;
}

.sf-input:focus {
    outline: none;
    background: rgba(255, 255, 255, .13);
    border-color: rgba(108, 58, 255, .7);
    box-shadow: 0 0 0 4px rgba(108, 58, 255, .15);
    color: var(--white);
}

.sf-input::placeholder {
    color: rgba(255, 255, 255, .45);
}

.sf-input option {
    background: #1a1a2e;
    color: var(--white);
}

select.sf-input {
    appearance: none;
    cursor: pointer;
}

.sf-label {
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, .45);
    margin-bottom: .4rem;
    display: block;
}

.btn-search-main {
    height: 52px;
    background: linear-gradient(135deg, var(--primary), #4c1db8);
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: .95rem;
    color: var(--white);
    letter-spacing: .04em;
    transition: all var(--transition);
    box-shadow: 0 8px 24px rgba(108, 58, 255, .4);
}

.btn-search-main:hover {
    background: linear-gradient(135deg, var(--primary-hover), #3d14a0);
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(108, 58, 255, .5);
    color: var(--white);
}

.advanced-toggle {
    color: rgba(255, 255, 255, .5);
    font-size: .82rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    transition: color var(--transition);
    border: none;
    background: none;
    padding: 0;
}

.advanced-toggle:hover {
    color: rgba(255, 255, 255, .9);
}

.form-divider {
    border: none;
    border-top: 1px solid rgba(255, 255, 255, .08);
    margin: 1rem 0;
}

/* ============================================================
   SECTION COMMONS
   ============================================================ */
.section-eyebrow {
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--primary);
    margin-bottom: .6rem;
}

.section-title {
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 800;
    color: var(--text-main);
    line-height: 1.2;
    letter-spacing: -.02em;
}

.section-subtitle {
    color: var(--text-muted);
    font-size: 1rem;
    line-height: 1.7;
    max-width: 520px;
}

/* ============================================================
   PROPERTY CARD
   ============================================================ */
.prop-card {
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid var(--border);
    background: var(--white);
    transition: transform .3s ease, box-shadow .3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.prop-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(108, 58, 255, .13);
}

.prop-img-wrap {
    position: relative;
    height: 220px;
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
    transform: scale(1.07);
}

.prop-status-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    font-size: .72rem;
    font-weight: 700;
    padding: .3rem .8rem;
    border-radius: 7px;
    letter-spacing: .06em;
    text-transform: uppercase;
    z-index: 2;
}

.badge-sale {
    background: var(--badge-green);
    color: var(--badge-green-t);
}

.badge-rent {
    background: var(--primary-soft);
    color: var(--primary);
}

.badge-sold {
    background: var(--badge-red);
    color: var(--badge-red-t);
}

.badge-featured {
    background: var(--primary);
    color: #fff;
}

.prop-fav-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .9);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: .9rem;
    z-index: 2;
    transition: all var(--transition);
    cursor: pointer;
}

.prop-fav-btn:hover {
    background: #fff;
    color: var(--badge-red-t);
}

.prop-type-chip {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: rgba(0, 0, 0, .5);
    backdrop-filter: blur(8px);
    color: #fff;
    font-size: .72rem;
    font-weight: 600;
    padding: .25rem .65rem;
    border-radius: 6px;
    letter-spacing: .04em;
    text-transform: capitalize;
    z-index: 2;
}

.prop-body {
    padding: 1rem 1.1rem 1.1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.prop-price {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
    margin-bottom: .45rem;
}

.prop-title {
    font-size: .92rem;
    font-weight: 600;
    color: var(--text-main);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: .35rem;
}

.prop-location {
    font-size: .8rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: .3rem;
    margin-bottom: .75rem;
}

.prop-location i {
    color: var(--primary);
    font-size: .85rem;
}

.prop-features {
    display: flex;
    gap: 1rem;
    padding-top: .75rem;
    border-top: 1px solid var(--border);
    margin-top: auto;
}

.prop-feat {
    display: flex;
    align-items: center;
    gap: .3rem;
    font-size: .78rem;
    color: var(--text-muted);
}

.prop-feat i {
    color: var(--primary);
    font-size: .85rem;
}

/* ============================================================
   CAROUSEL (HERO CAROUSEL)
   ============================================================ */
.carousel-properties .carousel-item {
    padding: 0 .5rem;
}

.carousel-properties .carousel-control-prev,
.carousel-properties .carousel-control-next {
    width: 44px;
    height: 44px;
    background: var(--white);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    border: 1px solid var(--border);
    box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
    opacity: 1;
}

.carousel-properties .carousel-control-prev {
    left: -22px;
}

.carousel-properties .carousel-control-next {
    right: -22px;
}

.carousel-properties .carousel-control-prev-icon,
.carousel-properties .carousel-control-next-icon {
    filter: invert(1) sepia(1) saturate(5) hue-rotate(220deg);
    width: 14px;
    height: 14px;
}

/* Multi-item carousel approach */
.carousel-multi-wrapper {
    overflow: hidden;
}

.carousel-multi-track {
    display: flex;
    gap: 1.5rem;
    transition: transform .5s cubic-bezier(.4, 0, .2, 1);
}

.carousel-multi-track .prop-card-wrap {
    flex: 0 0 calc(33.333% - 1rem);
    min-width: calc(33.333% - 1rem);
}

@media(max-width:992px) {
    .carousel-multi-track .prop-card-wrap {
        flex: 0 0 calc(50% - .75rem);
        min-width: calc(50% - .75rem);
    }
}

@media(max-width:576px) {
    .carousel-multi-track .prop-card-wrap {
        flex: 0 0 100%;
        min-width: 100%;
    }
}

.carousel-nav-btn {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: var(--white);
    border: 1.5px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--transition);
    color: var(--text-main);
    font-size: 1.1rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
    flex-shrink: 0;
}

.carousel-nav-btn:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
    transform: scale(1.05);
}

/* ============================================================
   GALLERY / SOLD PROPERTIES
   ============================================================ */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
}

.gallery-grid .prop-card-wrap:nth-child(1) {
    grid-column: span 2;
    grid-row: span 2;
}

.gallery-grid .prop-card-wrap:nth-child(1) .prop-img-wrap {
    height: 380px;
}

@media(max-width:992px) {
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .gallery-grid .prop-card-wrap:nth-child(1) {
        grid-column: span 2;
    }
}

@media(max-width:576px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }

    .gallery-grid .prop-card-wrap:nth-child(1) {
        grid-column: 1;
        grid-row: 1;
    }

    .gallery-grid .prop-card-wrap:nth-child(1) .prop-img-wrap {
        height: 240px;
    }
}

/* ============================================================
   SOLD PROPERTIES MOSAIC
   ============================================================ */
.sold-label {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: var(--badge-red);
    color: var(--badge-red-t);
    font-size: .7rem;
    font-weight: 700;
    padding: .3rem .75rem;
    border-radius: 6px;
    letter-spacing: .06em;
    text-transform: uppercase;
}

.sold-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(26, 26, 46, .85) 0%, transparent 55%);
    z-index: 1;
}

.sold-card-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 2;
    padding: 1rem 1.1rem;
    color: #fff;
}

.sold-card-info .prop-price {
    color: #fff;
    font-size: 1.15rem;
}

.sold-card-info .prop-title {
    color: rgba(255, 255, 255, .9);
    font-size: .83rem;
}

.sold-card-info .prop-location {
    color: rgba(255, 255, 255, .6);
    font-size: .75rem;
    margin-bottom: 0;
}

.sold-card {
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    border: none;
    background: #111;
    height: 100%;
    transition: transform .3s ease, box-shadow .3s ease;
}

.sold-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(0, 0, 0, .2);
}

.sold-card .prop-img-wrap {
    height: 210px;
}

/* ============================================================
   TESTIMONIALS
   ============================================================ */
.testi-section {
    background: var(--surface);
}

.testi-card {
    background: var(--white);
    border-radius: 18px;
    padding: 1.75rem;
    border: 1px solid var(--border);
    transition: transform .3s ease, box-shadow .3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

.testi-card::before {
    content: '\201C';
    font-size: 8rem;
    line-height: 1;
    color: var(--primary-soft);
    position: absolute;
    top: -1rem;
    right: 1.2rem;
    font-family: Georgia, serif;
    pointer-events: none;
}

.testi-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-card);
}

.testi-stars {
    color: var(--gold);
    font-size: .85rem;
    margin-bottom: 1rem;
}

.testi-text {
    color: var(--text-main);
    font-size: .92rem;
    line-height: 1.75;
    flex: 1;
    margin-bottom: 1.25rem;
    font-style: italic;
    position: relative;
    z-index: 1;
}

.testi-author {
    display: flex;
    align-items: center;
    gap: .85rem;
}

.testi-avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--primary-soft);
}

.testi-name {
    font-size: .88rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: .1rem;
}

.testi-role {
    font-size: .75rem;
    color: var(--text-muted);
}

/* ============================================================
   STATS BAND
   ============================================================ */
.stats-band {
    background: linear-gradient(135deg, #1A1A2E 0%, #2d1b69 50%, #1A1A2E 100%);
    position: relative;
    overflow: hidden;
}

.stats-band::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 30% 50%, rgba(108, 58, 255, .25) 0%, transparent 60%),
        radial-gradient(ellipse at 70% 50%, rgba(167, 139, 250, .12) 0%, transparent 60%);
}

.stats-band .container {
    position: relative;
    z-index: 1;
}

.stat-box {
    text-align: center;
    padding: 1rem;
}

.stat-num {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: var(--white);
    line-height: 1;
    margin-bottom: .35rem;
}

.stat-num span {
    color: var(--primary);
}

.stat-lbl {
    font-size: .82rem;
    color: rgba(255, 255, 255, .55);
    letter-spacing: .08em;
    text-transform: uppercase;
}

/* ============================================================
   CTA
   ============================================================ */
.cta-section {
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    position: relative;
    overflow: hidden;
}

.cta-section::before {
    content: '';
    position: absolute;
    right: -80px;
    top: -80px;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .06);
    pointer-events: none;
}

.cta-section::after {
    content: '';
    position: absolute;
    left: -60px;
    bottom: -60px;
    width: 280px;
    height: 280px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .04);
    pointer-events: none;
}

.cta-section .container {
    position: relative;
    z-index: 1;
}

/* ============================================================
   AGENT CARD
   ============================================================ */
.agent-card {
    background: var(--white);
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid var(--border);
    transition: transform .3s ease, box-shadow .3s ease;
    text-align: center;
    padding-bottom: 1.5rem;
}

.agent-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-card);
}

.agent-img-wrap {
    height: 180px;
    overflow: hidden;
    position: relative;
    margin-bottom: 1.2rem;
}

.agent-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
}

.agent-card:hover .agent-img-wrap img {
    transform: scale(1.06);
}

.agent-name {
    font-size: .95rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: .2rem;
}

.agent-agency {
    font-size: .78rem;
    color: var(--text-muted);
    margin-bottom: .6rem;
}

.agent-badge {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    background: var(--primary-soft);
    color: var(--primary);
    font-size: .72rem;
    font-weight: 600;
    padding: .25rem .7rem;
    border-radius: 100px;
}

/* ============================================================
   MISC
   ============================================================ */
.btn-outline-primary-custom {
    border: 2px solid var(--primary);
    color: var(--primary);
    font-weight: 600;
    border-radius: 10px;
    padding: .55rem 1.5rem;
    transition: all var(--transition);
    background: transparent;
    font-size: .88rem;
}

.btn-outline-primary-custom:hover {
    background: var(--primary);
    color: #fff;
}

.btn-primary-custom {
    background: var(--primary);
    border: 2px solid var(--primary);
    color: #fff;
    font-weight: 600;
    border-radius: 10px;
    padding: .55rem 1.5rem;
    transition: all var(--transition);
    font-size: .88rem;
}

.btn-primary-custom:hover {
    background: var(--primary-hover);
    border-color: var(--primary-hover);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(108, 58, 255, .35);
}

.btn-white-outline {
    border: 2px solid rgba(255, 255, 255, .35);
    color: #fff;
    font-weight: 600;
    border-radius: 10px;
    padding: .65rem 2rem;
    transition: all var(--transition);
    background: transparent;
    font-size: .95rem;
}

.btn-white-outline:hover {
    background: rgba(255, 255, 255, .12);
    border-color: #fff;
    color: #fff;
}

.section-link-all {
    font-size: .85rem;
    font-weight: 600;
    color: var(--primary);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    transition: gap var(--transition);
}

.section-link-all:hover {
    gap: .7rem;
    color: var(--primary-hover);
}
</style>
@endpush

@section('content')

{{-- ============================================================
     HERO SECTION
============================================================ --}}
<section class="hero-section">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <div class="container">
            <div class="row align-items-center g-5">

                {{-- Left copy --}}
                <div class="col-lg-5">
                    <span class="hero-eyebrow">
                        <i class="bi bi-shield-check-fill"></i>
                        Plateforme N°1 en immobilier
                    </span>
                    <h1 class="hero-title">
                        Trouvez la Propriété <span>de Vos Rêves</span>
                    </h1>
                    <p class="hero-subtitle">
                        Des milliers de biens d'exception vous attendent. Appartements, villas, terrains —
                        nous vous accompagnons à chaque étape de votre projet.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('properties.index') }}" class="btn btn-primary px-4 py-2 fw-600 rounded-3"
                            style="background:var(--primary);border:none;">
                            <i class="bi bi-grid me-2"></i>Voir tous les biens
                        </a>
                        <a href="{{ route('agents.index') }}" class="btn btn-white-outline px-4 py-2">
                            <i class="bi bi-person-badge me-2"></i>Nos agents
                        </a>
                    </div>
                </div>

                {{-- Search form --}}
                <div class="col-lg-7" id="hero-form-col">
                    <div class="search-form-wrapper">

                        {{-- Tabs --}}
                        <ul class="nav search-tabs" id="searchTypeTabs">
                            <li class="nav-item">
                                <button class="nav-link active" data-status="for_sale">
                                    <i class="bi bi-tag me-1"></i>Acheter
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-status="for_rent">
                                    <i class="bi bi-key me-1"></i>Louer
                                </button>
                            </li>
                        </ul>

                        <form action="{{ route('properties.index') }}" method="GET" id="heroSearchForm">
                            <input type="hidden" name="status" id="statusInput" value="for_sale">

                            {{-- Row 1 --}}
                            <div class="row g-2 mb-2">
                                <div class="col-md-4">
                                    <label class="sf-label">Type de bien</label>
                                    <div class="sf-group">
                                        <i class="bi bi-house sf-icon"></i>
                                        <select name="type" class="sf-input">
                                            <option value="">Tous les types</option>
                                            <option value="apartment">Appartement</option>
                                            <option value="villa">Villa</option>
                                            <option value="studio">Studio</option>
                                            <option value="penthouse">Penthouse</option>
                                            <option value="townhouse">Maison de ville</option>
                                            <option value="commercial">Commercial</option>
                                            <option value="land">Terrain</option>
                                            <option value="farmhouse">Ferme</option>
                                            <option value="cottage">Cottage</option>
                                            <option value="loft">Loft</option>
                                            <option value="duplex">Duplex</option>
                                            <option value="triplex">Triplex</option>
                                            <option value="ranch">Ranch</option>
                                            <option value="mobile_home">Mobil-home</option>
                                            <option value="condo">Condo</option>
                                            <option value="bungalow">Bungalow</option>
                                            <option value="castle">Château</option>
                                        </select>
                                        <!--<x-select-property name="type" label="" :options="$types" class="sf-input"
                                            id="type">
                                        </x-select-property>-->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="sf-label">Pays</label>
                                    <div class="sf-group">
                                        <i class="bi bi-globe sf-icon"></i>
                                        <select name="country" class="sf-input">
                                            <option value="">Tous les pays</option>
                                            <option value="US">États-Unis</option>
                                            <option value="FR">France</option>
                                            <option value="CA">Canada</option>
                                            <option value="GB">Royaume-Uni</option>
                                            <option value="DE">Allemagne</option>
                                            <option value="ES">Espagne</option>
                                            <option value="IT">Italie</option>
                                            <option value="BE">Belgique</option>
                                            <option value="CH">Suisse</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="sf-label">Prix maximum</label>
                                    <div class="sf-group">
                                        <i class="bi bi-currency-dollar sf-icon"></i>
                                        <input type="number" name="max_price" class="sf-input" placeholder="Ex: 500000">
                                    </div>
                                </div>
                            </div>

                            {{-- Advanced filters (collapsed) --}}
                            <div class="collapse" id="advancedFilters">
                                <div class="row g-2 mb-2">
                                    <div class="col-md-4">
                                        <label class="sf-label">Chambres (min)</label>
                                        <div class="sf-group">
                                            <i class="bi bi-door-open sf-icon"></i>
                                            <input type="number" name="bedrooms" class="sf-input" placeholder="0"
                                                min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="sf-label">Salles de bain (min)</label>
                                        <div class="sf-group">
                                            <i class="bi bi-droplet sf-icon"></i>
                                            <input type="number" name="bathrooms" class="sf-input" placeholder="0"
                                                min="0">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="sf-label">Surface min (m²)</label>
                                        <div class="sf-group">
                                            <i class="bi bi-rulers sf-icon"></i>
                                            <input type="number" name="surface" class="sf-input" placeholder="Ex: 80">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="form-divider">

                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <button class="advanced-toggle" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#advancedFilters" aria-expanded="false">
                                    <i class="bi bi-sliders2"></i>
                                    <span>Filtres avancés</span>
                                    <i class="bi bi-chevron-down" style="font-size:.7rem"></i>
                                </button>
                                <button type="submit" class="btn btn-search-main px-4 d-flex align-items-center gap-2">
                                    <i class="bi bi-search"></i>
                                    Rechercher
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats bar --}}
    <div class="hero-stats-bar">
        <div class="container">
            <div class="row g-0 justify-content-center">
                <div class="col-auto">
                    <div class="hero-stat-item">
                        <div class="hero-stat-icon"><i class="bi bi-buildings"></i></div>
                        <div>
                            <div class="hero-stat-num counter" data-target="1250">0</div>
                            <div class="hero-stat-label">Biens vendus</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="hero-stat-item">
                        <div class="hero-stat-icon"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <div class="hero-stat-num counter" data-target="850">0</div>
                            <div class="hero-stat-label">Clients satisfaits</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="hero-stat-item">
                        <div class="hero-stat-icon"><i class="bi bi-person-badge-fill"></i></div>
                        <div>
                            <div class="hero-stat-num counter" data-target="45">0</div>
                            <div class="hero-stat-label">Agents experts</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="hero-stat-item">
                        <div class="hero-stat-icon"><i class="bi bi-award-fill"></i></div>
                        <div>
                            <div class="hero-stat-num counter" data-target="15">0</div>
                            <div class="hero-stat-label">Années d'expérience</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hero-scroll-indicator">
        <div class="scroll-line"></div>
        <span>Défiler</span>
    </div>
</section>

{{-- ============================================================
     FEATURED PROPERTIES CAROUSEL
     ============================================================ --}}
<section class="py-5 my-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <p class="section-eyebrow mb-1"><i class="bi bi-star-fill me-1"></i>Sélection exclusive</p>
                <h2 class="section-title mb-1">Propriétés en Vedette</h2>
                <p class="section-subtitle mb-0">Des biens d'exception sélectionnés par nos experts</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <button class="carousel-nav-btn" id="featPrev"><i class="bi bi-chevron-left"></i></button>
                <button class="carousel-nav-btn" id="featNext"><i class="bi bi-chevron-right"></i></button>
            </div>
        </div>

        <div class="carousel-multi-wrapper">
            <div class="carousel-multi-track" id="featuredTrack">
                @forelse($featuredProperties as $property)
                <div class="prop-card-wrap">
                    <a href="{{ route('properties.show', $property->id) }}" class="text-decoration-none d-block h-100">
                        <div class="prop-card">
                            <div class="prop-img-wrap">
                                <img src="{{ $property->cover_image ?? ($property->images->first()->image_path ?? 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80') }}"
                                    alt="{{ $property->address }}" loading="lazy">
                                <span class="prop-status-badge badge-featured">
                                    <i class="bi bi-star-fill me-1"></i>Vedette
                                </span>
                                <button class="prop-fav-btn" onclick="event.preventDefault()">
                                    <i class="bi bi-heart"></i>
                                </button>
                                <span class="prop-type-chip">{{ $property->type->label() }}</span>
                            </div>
                            <div class="prop-body">
                                <div class="prop-price">${{ number_format($property->price) }}</div>
                                <div class="prop-title">{{ Str::limit($property->address, 38) }}</div>
                                <div class="prop-location">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    {{ $property->city }}, {{ $property->country }}
                                </div>
                                <div class="prop-features">
                                    <div class="prop-feat"><i class="bi bi-door-open"></i>{{ $property->bedrooms }} ch.
                                    </div>
                                    <div class="prop-feat"><i class="bi bi-droplet"></i>{{ $property->bathrooms }} sdb.
                                    </div>
                                    @if($property->surface)
                                    <div class="prop-feat"><i
                                            class="bi bi-rulers"></i>{{ number_format($property->surface) }} m²</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12 py-5 text-center text-muted">Aucune propriété en vedette.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     FOR SALE GALLERY (Biens en vente)
     ============================================================ --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-end mb-4">
            <div class="col-md-7">
                <p class="section-eyebrow mb-1"><i class="bi bi-tag me-1"></i>À vendre</p>
                <h2 class="section-title mb-1">Biens Disponibles à la Vente</h2>
                <p class="section-subtitle mb-0">Notre sélection de propriétés actuellement sur le marché</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <a href="{{ route('properties.index') }}?status=for_sale" class="section-link-all">
                    Voir tous les biens à vendre <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="gallery-grid">
            @foreach($latestProperties->where('status','for_sale')->take(5) as $property)
            <div class="prop-card-wrap">
                <a href="{{ route('properties.show', $property->id) }}" class="text-decoration-none d-block h-100">
                    <div class="prop-card">
                        <div class="prop-img-wrap">
                            <img src="{{ $property->cover_image ?? ($property->images->first()->image_path ?? 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=600&q=80') }}"
                                alt="{{ $property->address }}" loading="lazy">
                            <span class="prop-status-badge badge-sale">À vendre</span>
                            <span class="prop-type-chip">{{ $property->type->label() }}</span>
                        </div>
                        <div class="prop-body">
                            <div class="prop-price">${{ number_format($property->price) }}</div>
                            <div class="prop-title">{{ Str::limit($property->address, 36) }}</div>
                            <div class="prop-location">
                                <i class="bi bi-geo-alt-fill"></i>{{ $property->city }}, {{ $property->country }}
                            </div>
                            <div class="prop-features">
                                <div class="prop-feat"><i class="bi bi-door-open"></i>{{ $property->bedrooms }} ch.
                                </div>
                                <div class="prop-feat"><i class="bi bi-droplet"></i>{{ $property->bathrooms }} sdb.
                                </div>
                                @if($property->surface)
                                <div class="prop-feat"><i
                                        class="bi bi-rulers"></i>{{ number_format($property->surface) }} m²</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     STATS BAND
     ============================================================ --}}
<section class="stats-band py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="stat-num"><span class="counter" data-target="1250">0</span><span>+</span></div>
                    <div class="stat-lbl">Propriétés vendues</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="stat-num"><span class="counter" data-target="850">0</span><span>+</span></div>
                    <div class="stat-lbl">Clients satisfaits</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="stat-num"><span class="counter" data-target="45">0</span></div>
                    <div class="stat-lbl">Agents experts</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-box">
                    <div class="stat-num"><span class="counter" data-target="15">0</span></div>
                    <div class="stat-lbl">Années d'expérience</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SOLD PROPERTIES (8 biens vendus)
     ============================================================ --}}
<section class="py-5 my-4">
    <div class="container">
        <div class="row align-items-end mb-4">
            <div class="col-md-7">
                <p class="section-eyebrow mb-1"><i class="bi bi-check-circle-fill me-1"></i>Transactions réussies</p>
                <h2 class="section-title mb-1">Biens Récemment Vendus</h2>
                <p class="section-subtitle mb-0">La preuve de notre expertise et de la confiance de nos clients</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <a href="{{ route('properties.index') }}?status=sold" class="section-link-all">
                    Voir tous les biens vendus <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="row g-3">
            @php $soldProps = $latestProperties->where('status','sold')->take(8); @endphp
            @forelse($soldProps as $property)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="{{ route('properties.show', $property->id) }}" class="text-decoration-none d-block h-100">
                    <div class="sold-card">
                        <div class="prop-img-wrap" style="height:210px">
                            <img src="{{ $property->cover_image ?? ($property->images->first()->image_path ?? 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=600&q=80') }}"
                                alt="{{ $property->address }}" loading="lazy"
                                style="width:100%;height:100%;object-fit:cover">
                        </div>
                        <div class="sold-overlay"></div>
                        <div class="sold-card-info">
                            <span class="sold-label mb-2"><i class="bi bi-check-lg me-1"></i>Vendu</span>
                            <div class="prop-price mt-2">${{ number_format($property->price) }}</div>
                            <div class="prop-title" style="color:rgba(255,255,255,.88)">
                                {{ Str::limit($property->address, 32) }}</div>
                            <div class="prop-location" style="color:rgba(255,255,255,.55);margin-bottom:0">
                                <i class="bi bi-geo-alt"></i>{{ $property->city }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            {{-- Fallback placeholders si pas encore de biens vendus --}}
            @for($i = 0; $i < 8; $i++) <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="sold-card" style="opacity:.45">
                    <div class="prop-img-wrap" style="height:210px;background:var(--surface)"></div>
                    <div class="sold-overlay"></div>
                    <div class="sold-card-info">
                        <span class="sold-label"><i class="bi bi-check-lg me-1"></i>Vendu</span>
                        <div class="prop-price mt-2">—</div>
                        <div class="prop-title" style="color:rgba(255,255,255,.6)">À venir</div>
                    </div>
                </div>
        </div>
        @endfor
        @endforelse
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('properties.index') }}" class="btn btn-primary-custom px-5 py-3 fs-6">
            <i class="bi bi-grid me-2"></i>Voir tous les biens
        </a>
    </div>
    </div>
</section>

{{-- ============================================================
     TOP AGENTS
     ============================================================ --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <p class="section-eyebrow mb-1"><i class="bi bi-person-badge me-1"></i>Notre équipe</p>
            <h2 class="section-title">Nos Agents Experts</h2>
            <p class="section-subtitle mx-auto">Des professionnels de l'immobilier à votre service</p>
        </div>

        <div class="row g-3 justify-content-center">
            @forelse($topAgents as $agent)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="agent-card">
                    <div class="agent-img-wrap">
                        <img src="/storage/{{ $agent->user->avatar ?? 'https://i.pravatar.cc/300?img=' . ($loop->index + 10) }}"
                            alt="{{ $agent->user->name }}">
                    </div>
                    <div class="agent-name">{{ $agent->user->name }} {{ $agent->user->last_name }}</div>
                    <div class="agent-agency">{{ $agent->agency_name ?? 'Agent indépendant' }}</div>
                    <div class="agent-badge">
                        <i class="bi bi-buildings"></i>
                        {{ $agent->properties_count }} bien{{ $agent->properties_count > 1 ? 's' : '' }}
                    </div>
                </div>
            </div>
            @empty
            @for($i = 0; $i < 4; $i++) <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="agent-card" style="opacity:.4">
                    <div class="agent-img-wrap" style="background:var(--surface)"></div>
                    <div class="agent-name">Agent</div>
                    <div class="agent-agency">Disponible bientôt</div>
                </div>
        </div>
        @endfor
        @endforelse
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('agents.index') }}" class="section-link-all">
            Voir tous nos agents <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    </div>
</section>

{{-- ============================================================
     TESTIMONIALS
     ============================================================ --}}
<section class="testi-section py-5">
    <div class="container">
        <div class="text-center mb-4">
            <p class="section-eyebrow mb-1"><i class="bi bi-chat-quote me-1"></i>Témoignages</p>
            <h2 class="section-title">Ce Que Disent Nos Clients</h2>
            <p class="section-subtitle mx-auto">Des milliers de clients nous font confiance chaque année</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6 testi-item">
                <div class="testi-card">
                    <div class="testi-stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="testi-text">
                        Une expérience exceptionnelle ! L'équipe m'a aidé à trouver la maison parfaite pour ma famille.
                        Service professionnel et très attentif.
                    </p>
                    <div class="testi-author">
                        <img src="https://i.pravatar.cc/100?img=1" alt="Sarah Martin" class="testi-avatar">
                        <div>
                            <div class="testi-name">Sarah Martin</div>
                            <div class="testi-role">Acheteuse • Paris</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 testi-item">
                <div class="testi-card">
                    <div class="testi-stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="testi-text">
                        Processus d'achat fluide et transparent. Les agents sont compétents et réactifs. Je recommande
                        vivement à tous ceux qui cherchent un bien !
                    </p>
                    <div class="testi-author">
                        <img src="https://i.pravatar.cc/100?img=12" alt="Thomas Dubois" class="testi-avatar">
                        <div>
                            <div class="testi-name">Thomas Dubois</div>
                            <div class="testi-role">Investisseur • Lyon</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 testi-item">
                <div class="testi-card">
                    <div class="testi-stars">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>
                    <p class="testi-text">
                        Plateforme intuitive et catalogue impressionnant. J'ai trouvé mon appartement de rêve en
                        quelques semaines seulement. Merci à toute l'équipe !
                    </p>
                    <div class="testi-author">
                        <img src="https://i.pravatar.cc/100?img=5" alt="Marie Laurent" class="testi-avatar">
                        <div>
                            <div class="testi-name">Marie Laurent</div>
                            <div class="testi-role">Locataire • Bordeaux</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     CTA
     ============================================================ --}}
<section class="cta-section py-5">
    <div class="container py-3 text-center">
        <h2 class="section-title text-white mb-2" style="letter-spacing:-.02em">Prêt à Trouver Votre Propriété ?</h2>
        <p style="color:rgba(255,255,255,.75);font-size:1rem;margin-bottom:2rem;max-width:480px;margin-inline:auto">
            Rejoignez des milliers de clients satisfaits et concrétisez votre projet immobilier aujourd'hui.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('properties.index') }}" class="btn btn-light fw-700 px-5 py-3 rounded-3"
                style="color:var(--primary);font-size:.95rem;font-weight:700">
                <i class="bi bi-search me-2"></i>Parcourir les biens
            </a>
            <a href="{{ route('contact') }}" class="btn btn-white-outline px-5 py-3">
                <i class="bi bi-envelope me-2"></i>Nous contacter
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ── Counter animation ── */
    const counters = document.querySelectorAll('.counter');
    const counterObserver = new window.IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = parseInt(el.dataset.target);
            const duration = 1800;
            const step = target / (duration / 16);
            let current = 0;
            const tick = () => {
                current = Math.min(current + step, target);
                el.textContent = Math.floor(current).toLocaleString('fr-FR');
                if (current < target) requestAnimationFrame(tick);
            };
            tick();
            counterObserver.unobserve(el);
        });
    }, {
        threshold: 0.5
    });
    counters.forEach(c => counterObserver.observe(c));

    /* ── Search tabs ── */
    const tabs = document.querySelectorAll('#searchTypeTabs .nav-link');
    const statusInput = document.getElementById('statusInput');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            statusInput.value = tab.dataset.status;
        });
    });

    /* ── Featured carousel ── */
    const track = document.getElementById('featuredTrack');
    const prevBtn = document.getElementById('featPrev');
    const nextBtn = document.getElementById('featNext');
    if (track && prevBtn && nextBtn) {
        let currentIndex = 0;
        const getVisibleCount = () => {
            if (window.innerWidth < 576) return 1;
            if (window.innerWidth < 992) return 2;
            return 3;
        };
        const items = track.querySelectorAll('.prop-card-wrap');
        const totalItems = items.length;

        const updateCarousel = () => {
            const visible = getVisibleCount();
            const maxIndex = Math.max(0, totalItems - visible);
            currentIndex = Math.min(currentIndex, maxIndex);
            const itemWidth = items[0] ? items[0].offsetWidth + 24 : 0; // 24 = gap
            track.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
            prevBtn.style.opacity = currentIndex === 0 ? '.4' : '1';
            prevBtn.style.pointerEvents = currentIndex === 0 ? 'none' : '';
            nextBtn.style.opacity = currentIndex >= maxIndex ? '.4' : '1';
            nextBtn.style.pointerEvents = currentIndex >= maxIndex ? 'none' : '';
        };

        prevBtn.addEventListener('click', () => {
            currentIndex = Math.max(0, currentIndex - 1);
            updateCarousel();
        });
        nextBtn.addEventListener('click', () => {
            const visible = getVisibleCount();
            currentIndex = Math.min(totalItems - visible, currentIndex + 1);
            updateCarousel();
        });
        window.addEventListener('resize', updateCarousel);
        updateCarousel();
    }

    /* ── GSAP animations ── */
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        // Hero
        gsap.from('.hero-eyebrow', {
            opacity: 0,
            y: 20,
            duration: .7,
            ease: 'power3.out'
        });
        gsap.from('.hero-title', {
            opacity: 0,
            y: 30,
            duration: .8,
            delay: .15,
            ease: 'power3.out'
        });
        gsap.from('.hero-subtitle', {
            opacity: 0,
            y: 20,
            duration: .7,
            delay: .3,
            ease: 'power3.out'
        });
        gsap.from('#hero-form-col', {
            opacity: 0,
            x: 40,
            duration: .9,
            delay: .2,
            ease: 'power3.out'
        });
        gsap.from('.hero-stats-bar', {
            opacity: 0,
            y: 20,
            duration: .6,
            delay: .5,
            ease: 'power2.out'
        });

        // Sections on scroll
        gsap.utils.toArray('.prop-card, .sold-card, .testi-card, .agent-card').forEach((el, i) => {
            gsap.from(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top bottom-=80',
                    toggleActions: 'play none none reverse'
                },
                opacity: 0,
                y: 30,
                duration: .55,
                delay: (i % 4) * .07,
                ease: 'power2.out'
            });
        });

        gsap.utils.toArray('.stat-box').forEach((el, i) => {
            gsap.from(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top bottom-=60'
                },
                opacity: 0,
                y: 20,
                duration: .5,
                delay: i * .1,
                ease: 'power2.out'
            });
        });
    }
});
</script>
@endpush