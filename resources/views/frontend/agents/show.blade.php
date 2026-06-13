@extends('base')
@php
use Illuminate\Support\Str;
@endphp
@section('title', $agent->user->name . ' ' . $agent->user->last_name . ' — Agent EstateVista')

@push('styles')
<style>
/* ── Hero Agent ── */
.agent-hero {
    background: linear-gradient(135deg, #1A1A2E 0%, #2d1b69 55%, #1A1A2E 100%);
    position: relative;
    overflow: hidden;
    padding: 4rem 0 0;
}

.agent-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 70% 40%, rgba(108, 58, 255, .28) 0%, transparent 55%),
        radial-gradient(ellipse at 15% 70%, rgba(167, 139, 250, .12) 0%, transparent 50%);
    pointer-events: none;
}

.agent-hero .container {
    position: relative;
    z-index: 1;
}

/* Wave bottom */
.agent-hero-wave {
    position: relative;
    margin-top: 3rem;
    height: 60px;
    overflow: hidden;
}

.agent-hero-wave::before {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 60px;
    background: var(--surface, #F4F5F7);
    clip-path: ellipse(55% 100% at 50% 100%);
}

/* Breadcrumb */
.breadcrumb-custom {
    display: flex;
    align-items: center;
    gap: .5rem;
    font-size: .78rem;
    color: rgba(255, 255, 255, .45);
    margin-bottom: 2rem;
    flex-wrap: wrap;
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

/* Agent avatar large */
.agent-avatar-wrap {
    position: relative;
    display: inline-block;
}

.agent-avatar-lg {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(108, 58, 255, .5);
    box-shadow: 0 0 0 6px rgba(108, 58, 255, .12), 0 16px 40px rgba(0, 0, 0, .3);
}

.agent-avatar-placeholder-lg {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    background: rgba(108, 58, 255, .25);
    border: 4px solid rgba(108, 58, 255, .5);
    box-shadow: 0 0 0 6px rgba(108, 58, 255, .12);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 800;
    color: #a78bfa;
}

.agent-active-dot {
    position: absolute;
    bottom: 6px;
    right: 6px;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #1DB97A;
    border: 3px solid #1A1A2E;
    box-shadow: 0 0 0 3px rgba(29, 185, 122, .2);
    animation: pulse 2s infinite;
}

@keyframes pulse {

    0%,
    100% {
        box-shadow: 0 0 0 3px rgba(29, 185, 122, .2);
    }

    50% {
        box-shadow: 0 0 0 7px rgba(29, 185, 122, .08);
    }
}

/* Agent hero info */
.agent-hero-name {
    font-size: clamp(1.6rem, 3.5vw, 2.4rem);
    font-weight: 800;
    color: #fff;
    letter-spacing: -.025em;
    line-height: 1.15;
    margin-bottom: .3rem;
}

.agent-hero-agency {
    font-size: .9rem;
    color: rgba(255, 255, 255, .6);
    margin-bottom: .85rem;
    display: flex;
    align-items: center;
    gap: .4rem;
}

.agent-hero-agency i {
    color: #a78bfa;
}

/* Hero stats */
.hero-stats-row {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-top: 1.25rem;
}

.hero-stat {
    display: flex;
    flex-direction: column;
}

.hero-stat-num {
    font-size: 1.6rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}

.hero-stat-lbl {
    font-size: .72rem;
    color: rgba(255, 255, 255, .45);
    text-transform: uppercase;
    letter-spacing: .08em;
    margin-top: .15rem;
}

.hero-stat-sep {
    width: 1px;
    background: rgba(255, 255, 255, .12);
    margin: .15rem 0;
}

/* Badges hero */
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    padding: .3rem .8rem;
    border-radius: 100px;
    margin-right: .4rem;
    margin-bottom: .4rem;
}

.hero-badge-verified {
    background: rgba(29, 185, 122, .15);
    color: #4ade80;
    border: 1px solid rgba(29, 185, 122, .25);
}

.hero-badge-license {
    background: rgba(108, 58, 255, .2);
    color: #a78bfa;
    border: 1px solid rgba(108, 58, 255, .3);
}

.hero-badge-rate {
    background: rgba(245, 166, 35, .15);
    color: #fbbf24;
    border: 1px solid rgba(245, 166, 35, .25);
}

/* Action buttons hero */
.hero-actions {
    display: flex;
    gap: .75rem;
    flex-wrap: wrap;
    margin-top: 1.5rem;
}

.btn-hero-primary {
    height: 46px;
    padding: 0 1.5rem;
    background: var(--primary, #6C3AFF);
    border: none;
    border-radius: 12px;
    color: #fff;
    font-weight: 700;
    font-size: .88rem;
    display: inline-flex;
    align-items: center;
    gap: .45rem;
    text-decoration: none;
    transition: all .2s;
    box-shadow: 0 6px 20px rgba(108, 58, 255, .4);
}

.btn-hero-primary:hover {
    background: #5628E8;
    color: #fff;
    transform: translateY(-2px);
}

.btn-hero-ghost {
    height: 46px;
    padding: 0 1.25rem;
    border: 1.5px solid rgba(255, 255, 255, .25);
    border-radius: 12px;
    color: rgba(255, 255, 255, .8);
    font-weight: 600;
    font-size: .85rem;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    text-decoration: none;
    background: transparent;
    transition: all .2s;
}

.btn-hero-ghost:hover {
    border-color: #fff;
    color: #fff;
    background: rgba(255, 255, 255, .08);
}

/* ── Layout ── */
.agent-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 2rem;
    align-items: start;
}

@media(max-width:992px) {
    .agent-layout {
        grid-template-columns: 1fr;
    }
}

/* ── Section commons ── */
.section-eyebrow {
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--primary, #6C3AFF);
    margin-bottom: .35rem;
}

.section-title-sm {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--text-main, #1A1A2E);
    letter-spacing: -.02em;
    margin-bottom: 1.25rem;
}

/* ── Content cards ── */
.content-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid var(--border, #ECEEF4);
    padding: 1.75rem;
    box-shadow: 0 2px 16px rgba(108, 58, 255, .05);
    margin-bottom: 1.5rem;
}

/* ── Bio ── */
.bio-text {
    font-size: .93rem;
    color: var(--text-main);
    line-height: 1.85;
}

.bio-text.collapsed {
    display: -webkit-box;
    -webkit-line-clamp: 5;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.btn-read-more {
    background: none;
    border: none;
    padding: 0;
    color: var(--primary);
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    margin-top: .5rem;
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    transition: color .2s;
}

.btn-read-more:hover {
    color: #5628E8;
}

/* ── Stats grid ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

@media(max-width:576px) {
    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }
}

.stat-box {
    background: var(--surface, #F4F5F7);
    border-radius: 14px;
    padding: 1.25rem 1rem;
    text-align: center;
    border: 1px solid var(--border);
    transition: all .2s;
}

.stat-box:hover {
    border-color: var(--primary);
    background: var(--primary-soft, #EDE8FF);
}

.stat-box-num {
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
    margin-bottom: .25rem;
}

.stat-box-lbl {
    font-size: .7rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: .07em;
}

/* ── Expertise chips ── */
.expertise-chip {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: var(--primary-soft);
    color: var(--primary);
    border-radius: .6rem;
    padding: .4rem .85rem;
    font-size: .78rem;
    font-weight: 600;
    margin: .25rem;
}

/* ── Property cards (listings) ── */
.prop-mini-card {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid var(--border);
    background: #fff;
    transition: transform .3s, box-shadow .3s;
    display: flex;
    flex-direction: column;
    height: 100%;
    text-decoration: none;
    color: inherit;
}

.prop-mini-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(108, 58, 255, .12);
}

.prop-mini-img {
    position: relative;
    height: 175px;
    overflow: hidden;
    flex-shrink: 0;
}

.prop-mini-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s;
}

.prop-mini-card:hover .prop-mini-img img {
    transform: scale(1.06);
}

.prop-mini-badge {
    position: absolute;
    top: 9px;
    left: 9px;
    font-size: .65rem;
    font-weight: 700;
    padding: .25rem .65rem;
    border-radius: 6px;
    letter-spacing: .05em;
    text-transform: uppercase;
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

.prop-mini-body {
    padding: .85rem 1rem 1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.prop-mini-price {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: .25rem;
}

.prop-mini-title {
    font-size: .82rem;
    font-weight: 600;
    color: var(--text-main);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: .25rem;
}

.prop-mini-loc {
    font-size: .74rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: .25rem;
    margin-bottom: .6rem;
}

.prop-mini-loc i {
    color: var(--primary);
    font-size: .78rem;
}

.prop-mini-feats {
    display: flex;
    gap: .65rem;
    font-size: .72rem;
    color: var(--text-muted);
    margin-top: auto;
    padding-top: .6rem;
    border-top: 1px solid var(--border);
}

.prop-mini-feat {
    display: flex;
    align-items: center;
    gap: .25rem;
}

.prop-mini-feat i {
    color: var(--primary);
    font-size: .76rem;
}

/* ── Pagination ── */
.pagination-custom {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .3rem;
    margin-top: 2rem;
    flex-wrap: wrap;
}

.pagination-custom .page-item .page-link {
    width: 38px;
    height: 38px;
    border-radius: 9px;
    border: 1.5px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .82rem;
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
    box-shadow: 0 4px 14px rgba(108, 58, 255, .3);
}

.pagination-custom .page-item.disabled .page-link {
    opacity: .4;
    pointer-events: none;
}

/* ── Sidebar ── */
.sidebar-card {
    background: #fff;
    border-radius: 18px;
    border: 1px solid var(--border);
    padding: 1.5rem;
    box-shadow: 0 2px 16px rgba(108, 58, 255, .05);
    margin-bottom: 1.25rem;
    position: sticky;
    top: 92px;
}

.contact-action {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .85rem 1rem;
    border-radius: 12px;
    border: 1.5px solid var(--border);
    text-decoration: none;
    color: var(--text-main);
    font-size: .85rem;
    font-weight: 600;
    transition: all .2s;
    margin-bottom: .6rem;
    background: var(--surface);
}

.contact-action:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-soft);
}

.contact-action.primary {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
    box-shadow: 0 4px 16px rgba(108, 58, 255, .3);
}

.contact-action.primary:hover {
    background: #5628E8;
    border-color: #5628E8;
    color: #fff;
}

.contact-action-icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .95rem;
    flex-shrink: 0;
    background: rgba(108, 58, 255, .1);
    color: var(--primary);
}

.contact-action.primary .contact-action-icon {
    background: rgba(255, 255, 255, .2);
    color: #fff;
}

/* Contact form inside sidebar */
.sidebar-form-input {
    width: 100%;
    height: 42px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: 0 .9rem;
    font-size: .83rem;
    color: var(--text-main);
    background: var(--surface, #F4F5F7);
    font-family: inherit;
    transition: all .2s;
    margin-bottom: .65rem;
}

.sidebar-form-input:focus {
    outline: none;
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(108, 58, 255, .1);
}

.sidebar-form-input::placeholder {
    color: var(--text-light);
}

.sidebar-form-textarea {
    width: 100%;
    min-height: 100px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    padding: .7rem .9rem;
    font-size: .83rem;
    color: var(--text-main);
    background: var(--surface);
    font-family: inherit;
    resize: none;
    transition: all .2s;
    margin-bottom: .65rem;
}

.sidebar-form-textarea:focus {
    outline: none;
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(108, 58, 255, .1);
}

.sidebar-form-textarea::placeholder {
    color: var(--text-light);
}

.btn-form-submit {
    width: 100%;
    height: 44px;
    background: var(--primary);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-size: .88rem;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
}

.btn-form-submit:hover {
    background: #5628E8;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(108, 58, 255, .35);
}

/* Info rows */
.info-row {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .65rem 0;
    border-bottom: 1px solid var(--border);
    font-size: .82rem;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row-icon {
    width: 32px;
    height: 32px;
    border-radius: 9px;
    background: var(--primary-soft);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    flex-shrink: 0;
}

.info-row-label {
    font-size: .68rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: .06em;
}

.info-row-value {
    font-weight: 600;
    color: var(--text-main);
}

/* ── Empty state ── */
.empty-props {
    text-align: center;
    padding: 3rem 2rem;
    background: var(--surface);
    border-radius: 16px;
    border: 2px dashed var(--border);
}

.empty-props i {
    font-size: 2.5rem;
    color: var(--text-light);
    display: block;
    margin-bottom: .85rem;
}

.empty-props p {
    font-size: .85rem;
    color: var(--text-muted);
    margin: 0;
}

.filter-tab {
    display: inline-flex;
    align-items: center;
    padding: .3rem .75rem;
    border-radius: 8px;
    font-size: .75rem;
    font-weight: 600;
    text-decoration: none;
    transition: all .2s;
    background: var(--surface);
    color: var(--text-muted);
    border: 1px solid var(--border);
}

.filter-tab-active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
}
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════
     HERO AGENT
     ═══════════════════════════════ --}}
<div class="agent-hero">
    <div class="container">

        {{-- Breadcrumb --}}
        <div class="breadcrumb-custom">
            <a href="{{ route('home') }}">Accueil</a>
            <span class="sep"><i class="bi bi-chevron-right"></i></span>
            <a href="{{ route('agents.index') }}">Agents</a>
            <span class="sep"><i class="bi bi-chevron-right"></i></span>
            <span>{{ $agent->user->name }} {{ $agent->user->last_name }}</span>
        </div>

        <div class="row align-items-end g-4 pb-4">
            <div class="col-lg-8">
                <div class="d-flex align-items-end gap-4 flex-wrap">

                    {{-- Avatar --}}
                    <div class="agent-avatar-wrap flex-shrink-0">
                        @if($agent->user->avatar)
                        <img src="{{ asset('storage/'.$agent->user->avatar) }}" alt="{{ $agent->user->name }}"
                            class="agent-avatar-lg">
                        @else
                        <div class="agent-avatar-placeholder-lg">
                            {{ strtoupper(substr($agent->user->name, 0, 1)) }}
                        </div>
                        @endif
                        @if($agent->is_active)
                        <div class="agent-active-dot" title="Agent actif"></div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-grow-1">
                        <h1 class="agent-hero-name">
                            {{ $agent->user->name }} {{ $agent->user->last_name }}
                        </h1>
                        <div class="agent-hero-agency">
                            <i class="bi bi-building"></i>
                            {{ $agent->agency_name ?? 'Agent indépendant' }}
                        </div>

                        {{-- Badges --}}
                        <div class="mb-2">
                            @if($agent->is_active)
                            <span class="hero-badge hero-badge-verified">
                                <i class="bi bi-shield-check-fill"></i> Agent vérifié
                            </span>
                            @endif
                            @if($agent->license_number)
                            <span class="hero-badge hero-badge-license">
                                <i class="bi bi-card-text"></i> Lic. {{ $agent->license_number }}
                            </span>
                            @endif
                            <span class="hero-badge hero-badge-rate">
                                <i class="bi bi-percent"></i> Commission
                                {{ number_format($agent->commission_rate, 1) }}%
                            </span>
                        </div>

                        {{-- Métriques --}}
                        <div class="hero-stats-row">
                            <div class="hero-stat">
                                <span class="hero-stat-num">{{ $properties->total() }}</span>
                                <span class="hero-stat-lbl">Biens</span>
                            </div>
                            <div class="hero-stat-sep"></div>
                            <div class="hero-stat">
                                <span class="hero-stat-num">{{ $agent->transactions_count ?? '—' }}</span>
                                <span class="hero-stat-lbl">Ventes</span>
                            </div>
                            <div class="hero-stat-sep"></div>
                            <div class="hero-stat">
                                <span class="hero-stat-num">{{ $agent->created_at->diffInYears(now()) ?: '< 1' }}</span>
                                <span class="hero-stat-lbl">Ans exp.</span>
                            </div>
                            <div class="hero-stat-sep"></div>
                            <div class="hero-stat">
                                <span class="hero-stat-num">4.9</span>
                                <span class="hero-stat-lbl">⭐ Note</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="hero-actions">
                    @if($agent->user->phone)
                    <a href="tel:{{ $agent->user->phone }}" class="btn-hero-primary">
                        <i class="bi bi-telephone-fill"></i>
                        {{ $agent->user->phone }}
                    </a>
                    @endif
                    <a href="mailto:{{ $agent->user->email }}" class="btn-hero-ghost">
                        <i class="bi bi-envelope-fill"></i>
                        Envoyer un email
                    </a>
                </div>
            </div>

            {{-- Right hero side : mini stats --}}
            <div class="col-lg-4 d-none d-lg-block">
                <div
                    style="background:rgba(255,255,255,.06);backdrop-filter:blur(14px);border:1px solid rgba(255,255,255,.1);border-radius:16px;padding:1.25rem">
                    <p
                        style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:.85rem">
                        Spécialités
                    </p>
                    <div style="display:flex;flex-wrap:wrap;gap:.4rem">
                        @php
                        $expertises = ['Résidentiel','Luxe','Investissement','Location','Vente','Neuf'];
                        @endphp
                        @foreach($expertises as $e)
                        <span
                            style="display:inline-flex;align-items:center;background:rgba(108,58,255,.2);color:#c4b5fd;font-size:.72rem;font-weight:600;padding:.3rem .75rem;border-radius:100px;border:1px solid rgba(108,58,255,.3)">
                            {{ $e }}
                        </span>
                        @endforeach
                    </div>
                    <hr style="border-color:rgba(255,255,255,.08);margin:1rem 0">
                    <p
                        style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:.6rem">
                        Membre depuis
                    </p>
                    <p style="font-size:.9rem;color:rgba(255,255,255,.7);font-weight:600;margin:0">
                        {{ $agent->created_at->format('F Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="agent-hero-wave"></div>
</div>

{{-- ═══════════════════════════════
     MAIN CONTENT
     ═══════════════════════════════ --}}
<div style="background:var(--surface,#F4F5F7);padding:2.5rem 0 5rem">
    <div class="container">
        <div class="agent-layout">

            {{-- ═══════════════════
                 LEFT COLUMN
                 ═══════════════════ --}}
            <div>

                {{-- Bio --}}
                @if($agent->bio)
                <div class="content-card bio-section">
                    <p class="section-eyebrow"><i class="bi bi-person-lines-fill me-1"></i>À propos</p>
                    <div class="section-title-sm mb-2">Présentation</div>
                    <div class="bio-text collapsed" id="bioText">{{ $agent->bio }}</div>
                    <button class="btn-read-more" id="bioToggle" onclick="toggleBio()">
                        <i class="bi bi-chevron-down" id="bioChevron"></i>
                        <span id="bioToggleLabel">Lire plus</span>
                    </button>
                </div>
                @endif

                {{-- Stats --}}
                <div class="content-card">
                    <p class="section-eyebrow"><i class="bi bi-bar-chart me-1"></i>Performances</p>
                    <div class="section-title-sm">Chiffres clés</div>
                    <div class="stats-grid">
                        <div class="stat-box">
                            <div class="stat-box-num">{{ $properties->total() }}</div>
                            <div class="stat-box-lbl">Biens actifs</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-box-num">{{ $agent->transactions_count ?? 0 }}</div>
                            <div class="stat-box-lbl">Transactions</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-box-num">{{ number_format($agent->commission_rate, 1) }}%</div>
                            <div class="stat-box-lbl">Commission</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-box-num">4.9</div>
                            <div class="stat-box-lbl">⭐ Note moy.</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-box-num">{{ $agent->created_at->diffInYears(now()) ?: '< 1' }}</div>
                            <div class="stat-box-lbl">Ans exp.</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-box-num">24h</div>
                            <div class="stat-box-lbl">Délai réponse</div>
                        </div>
                    </div>
                </div>

                {{-- Expertises --}}
                <div class="content-card">
                    <p class="section-eyebrow"><i class="bi bi-stars me-1"></i>Domaines</p>
                    <div class="section-title-sm">Expertises</div>
                    <div>
                        @foreach(['Immobilier résidentiel','Biens de luxe','Investissement locatif','Gestion de
                        location','Vente en VEFA','Rénovation & estimation'] as $exp)
                        <span class="expertise-chip">
                            <i class="bi bi-check-circle-fill"></i>{{ $exp }}
                        </span>
                        @endforeach
                    </div>
                </div>

                {{-- Properties listing --}}
                <div class="content-card">
                    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                        <div>
                            <p class="section-eyebrow mb-0"><i class="bi bi-buildings me-1"></i>Portefeuille</p>
                            <div class="section-title-sm mb-0">
                                Biens de {{ $agent->user->name }}
                                <span style="font-size:.85rem;font-weight:400;color:var(--text-muted)">
                                    ({{ $properties->total() }})
                                </span>
                            </div>
                        </div>
                        {{-- Filter tabs --}}
                        @php
                        $tabs = [
                        'Tous' => null,
                        'À vendre' => 'for_sale',
                        'À louer' => 'for_rent',
                        'Vendus' => 'sold',
                        ];
                        @endphp

                        <div class="d-flex gap-1">
                            @foreach($tabs as $label => $value)
                            @php
                            $active = request('status') === $value
                            || ($value === null && ! request('status'));
                            @endphp

                            <a href="{{ request()->fullUrlWithQuery(['status' => $value, 'page' => null]) }}"
                                @class([ 'filter-tab' , 'filter-tab-active'=> $active,
                                ])
                                >
                                {{ $label }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    @if($properties->isEmpty())
                    <div class="empty-props">
                        <i class="bi bi-house-slash"></i>
                        <p>Aucun bien disponible dans cette catégorie.</p>
                    </div>
                    @else
                    <div class="row g-3" id="propsGrid">
                        @foreach($properties as $property)
                        <div class="col-sm-6 col-xl-4 prop-item">
                            <a href="{{ route('properties.show', $property->id) }}" class="prop-mini-card">
                                <div class="prop-mini-img">
                                    <img src="{{ $property->cover_image
                                        ? asset('storage/'.$property->cover_image)
                                        : ($property->images->first()
                                            ? asset('storage/'.$property->images->first()->image_path)
                                            : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=400&q=80')
                                        }}" alt="{{ $property->address }}" loading="lazy">
                                    @php
                                    $bmap = ['for_sale'=>['badge-sale','À vendre'],'for_rent'=>['badge-rent','À
                                    louer'],'sold'=>['badge-sold','Vendu'],'rented'=>['badge-rented','Loué']];
                                    $b = $bmap[$property->status->value] ?? ['',''];
                                    @endphp
                                    <span class="prop-mini-badge {{ $b[0] }}">{{ $b[1] }}</span>
                                </div>
                                <div class="prop-mini-body">
                                    <div class="prop-mini-price">${{ number_format($property->price) }}</div>
                                    <div class="prop-mini-title">{{ Str::limit($property->address, 36) }}</div>
                                    <div class="prop-mini-loc">
                                        <i class="bi bi-geo-alt-fill"></i>{{ $property->city }}
                                    </div>
                                    <div class="prop-mini-feats">
                                        @if($property->bedrooms)
                                        <div class="prop-mini-feat">
                                            <i class="bi bi-door-open"></i>{{ $property->bedrooms }}
                                        </div>
                                        @endif
                                        @if($property->bathrooms)
                                        <div class="prop-mini-feat">
                                            <i class="bi bi-droplet"></i>{{ $property->bathrooms }}
                                        </div>
                                        @endif
                                        @if($property->surface)
                                        <div class="prop-mini-feat">
                                            <i class="bi bi-rulers"></i>{{ number_format($property->surface) }} m²
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($properties->hasPages())
                    <nav class="pagination-custom">
                        <li class="page-item {{ $properties->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $properties->previousPageUrl() }}">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                        @foreach($properties->getUrlRange(max(1,$properties->currentPage()-2),
                        min($properties->lastPage(),$properties->currentPage()+2)) as $page => $url)
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
                    @endif
                    @endif
                </div>

            </div>{{-- /left --}}

            {{-- ═══════════════════
                 RIGHT SIDEBAR
                 ═══════════════════ --}}
            <div>
                <div class="sidebar-card">

                    {{-- Quick contact --}}
                    <p
                        style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:1rem">
                        Contacter l'agent
                    </p>

                    @if($agent->user->phone)
                    <a href="tel:{{ $agent->user->phone }}" class="contact-action primary">
                        <div class="contact-action-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <div style="font-size:.68rem;opacity:.7;margin-bottom:.1rem">Appeler</div>
                            <div style="font-size:.85rem">{{ $agent->user->phone }}</div>
                        </div>
                    </a>
                    @endif

                    <a href="mailto:{{ $agent->user->email }}" class="contact-action">
                        <div class="contact-action-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <div style="font-size:.68rem;color:var(--text-muted);margin-bottom:.1rem">Email</div>
                            <div
                                style="font-size:.82rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px">
                                {{ $agent->user->email }}
                            </div>
                        </div>
                    </a>

                    <hr style="border-color:var(--border);margin:1.1rem 0">

                    {{-- Message form --}}
                    <p style="font-size:.72rem;font-weight:700;color:var(--text-muted);margin-bottom:.75rem">
                        Envoyer un message
                    </p>

                    @auth
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                        <input type="hidden" name="first_name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="last_name" value="{{ Auth::user()->last_name }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <input type="hidden" name="phone" value="{{ Auth::user()->phone }}">
                        <input type="hidden" name="subject" value="contact-agent">

                        <textarea name="message" class="sidebar-form-textarea"
                            placeholder="Bonjour, je suis intéressé par un de vos biens…" required></textarea>

                        <button type="submit" class="btn-form-submit">
                            <i class="bi bi-send-fill"></i>Envoyer
                        </button>
                    </form>
                    @else
                    <div
                        style="text-align:center;padding:.75rem;background:var(--surface);border-radius:12px;border:1.5px dashed var(--border)">
                        <p style="font-size:.8rem;color:var(--text-muted);margin-bottom:.75rem">
                            Connectez-vous pour envoyer un message
                        </p>
                        <a href="{{ route('login') }}" class="contact-action primary" style="justify-content:center">
                            <i class="bi bi-person-circle"></i> Se connecter
                        </a>
                    </div>
                    @endauth

                    <hr style="border-color:var(--border);margin:1.1rem 0">

                    {{-- Infos agent --}}
                    <p
                        style="font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:.5rem">
                        Informations
                    </p>

                    <div class="info-row">
                        <div class="info-row-icon"><i class="bi bi-building"></i></div>
                        <div>
                            <div class="info-row-label">Agence</div>
                            <div class="info-row-value">{{ $agent->agency_name ?? '—' }}</div>
                        </div>
                    </div>

                    @if($agent->license_number)
                    <div class="info-row">
                        <div class="info-row-icon"><i class="bi bi-shield-check"></i></div>
                        <div>
                            <div class="info-row-label">Licence</div>
                            <div class="info-row-value">{{ $agent->license_number }}</div>
                        </div>
                    </div>
                    @endif

                    <div class="info-row">
                        <div class="info-row-icon"><i class="bi bi-percent"></i></div>
                        <div>
                            <div class="info-row-label">Commission</div>
                            <div class="info-row-value">{{ number_format($agent->commission_rate, 1) }}%</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon"><i class="bi bi-calendar-check"></i></div>
                        <div>
                            <div class="info-row-label">Membre depuis</div>
                            <div class="info-row-value">{{ $agent->created_at->format('M Y') }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-row-icon"><i class="bi bi-clock"></i></div>
                        <div>
                            <div class="info-row-label">Disponibilité</div>
                            <div class="info-row-value" style="color:#1DB97A">Lun – Sam, 9h–18h</div>
                        </div>
                    </div>

                </div>

                {{-- CTA voir tous biens --}}
                <div
                    style="background:linear-gradient(135deg,var(--primary),#4c1db8);border-radius:16px;padding:1.5rem;text-align:center">
                    <i class="bi bi-grid-fill"
                        style="font-size:1.5rem;color:rgba(255,255,255,.5);display:block;margin-bottom:.5rem"></i>
                    <p style="font-size:.85rem;font-weight:700;color:#fff;margin-bottom:.3rem">
                        Tous les biens
                    </p>
                    <p style="font-size:.75rem;color:rgba(255,255,255,.55);margin-bottom:1rem">
                        Parcourez l'ensemble de notre catalogue
                    </p>
                    <a href="{{ route('properties.index') }}"
                        style="display:inline-flex;align-items:center;gap:.4rem;padding:.55rem 1.25rem;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);border-radius:9px;color:#fff;font-size:.82rem;font-weight:600;text-decoration:none;transition:all .2s"
                        onmouseover="this.style.background='rgba(255,255,255,.2)'"
                        onmouseout="this.style.background='rgba(255,255,255,.12)'">
                        <i class="bi bi-arrow-right-circle"></i>Voir tout
                    </a>
                </div>

            </div>{{-- /sidebar --}}

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ── Bio toggle ── */
    window.toggleBio = function() {
        const text = document.getElementById('bioText');
        const label = document.getElementById('bioToggleLabel');
        const chevron = document.getElementById('bioChevron');
        const isCollapsed = text.classList.contains('collapsed');

        text.classList.toggle('collapsed', !isCollapsed);
        label.textContent = isCollapsed ? 'Réduire' : 'Lire plus';
        chevron.className = isCollapsed ? 'bi bi-chevron-up' : 'bi bi-chevron-down';
    };

    /* ── GSAP ── */
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        gsap.from('.agent-hero-name', {
            opacity: 0,
            y: 20,
            duration: .7,
            ease: 'power3.out'
        });
        gsap.from('.hero-stats-row', {
            opacity: 0,
            y: 14,
            duration: .6,
            delay: .2,
            ease: 'power2.out'
        });
        gsap.from('.hero-actions', {
            opacity: 0,
            y: 12,
            duration: .5,
            delay: .35,
            ease: 'power2.out'
        });
        gsap.from('.sidebar-card', {
            opacity: 0,
            x: 20,
            duration: .6,
            delay: .15,
            ease: 'power2.out'
        });

        document.querySelectorAll('.content-card').forEach(function(el, i) {
            gsap.from(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top bottom-=70',
                    toggleActions: 'play none none reverse'
                },
                opacity: 0,
                y: 22,
                duration: .5,
                delay: i * .06,
                ease: 'power2.out'
            });
        });

        document.querySelectorAll('.prop-item').forEach(function(el, i) {
            gsap.from(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top bottom-=50',
                    toggleActions: 'play none none reverse'
                },
                opacity: 0,
                y: 18,
                duration: .4,
                delay: (i % 3) * .07,
                ease: 'power2.out'
            });
        });
    }
});
</script>
@endpush