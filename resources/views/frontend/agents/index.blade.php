@extends('base')

@section('title', 'Nos Agents — EstateVista')

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
        radial-gradient(ellipse at 15% 60%, rgba(108, 58, 255, .3) 0%, transparent 55%),
        radial-gradient(ellipse at 85% 20%, rgba(167, 139, 250, .15) 0%, transparent 50%);
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 60px;
    background: #F4F5F7;
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

/* ── Search bar ── */
.agents-search-bar {
    background: rgba(255, 255, 255, .08);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, .12);
    border-radius: 14px;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.asb-input-wrap {
    flex: 1;
    min-width: 200px;
    position: relative;
}

.asb-input-wrap i {
    position: absolute;
    left: .9rem;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255, 255, 255, .4);
    font-size: .9rem;
    pointer-events: none;
}

.asb-input {
    width: 100%;
    height: 44px;
    background: rgba(255, 255, 255, .08);
    border: 1.5px solid rgba(255, 255, 255, .12);
    border-radius: 10px;
    color: #fff;
    padding: 0 .85rem 0 2.5rem;
    font-size: .85rem;
    transition: border-color .2s;
}

.asb-input:focus {
    outline: none;
    border-color: rgba(108, 58, 255, .7);
    background: rgba(255, 255, 255, .12);
}

.asb-input::placeholder {
    color: rgba(255, 255, 255, .4);
}

.asb-btn {
    height: 44px;
    padding: 0 1.5rem;
    background: var(--primary, #6C3AFF);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-size: .85rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: .4rem;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
    flex-shrink: 0;
}

.asb-btn:hover {
    background: #5628E8;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(108, 58, 255, .4);
}

/* ── Toolbar ── */
.agents-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.agents-count {
    font-size: .85rem;
    color: var(--text-muted, #8A8FA8);
}

.agents-count strong {
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

/* ── Agent Card ── */
.agent-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid var(--border, #ECEEF4);
    overflow: hidden;
    transition: transform .3s ease, box-shadow .3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.agent-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 20px 50px rgba(108, 58, 255, .13);
}

.agent-img-wrap {
    position: relative;
    height: 220px;
    overflow: hidden;
}

.agent-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
}

.agent-card:hover .agent-img-wrap img {
    transform: scale(1.06);
}

.agent-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(26, 26, 46, .7) 0%, transparent 55%);
    opacity: 0;
    transition: opacity .3s ease;
}

.agent-card:hover .agent-img-overlay {
    opacity: 1;
}

.agent-socials {
    position: absolute;
    bottom: 1rem;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    gap: .5rem;
    transform: translateY(10px);
    opacity: 0;
    transition: all .3s ease;
}

.agent-card:hover .agent-socials {
    transform: translateY(0);
    opacity: 1;
}

.social-btn {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, .25);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: .85rem;
    text-decoration: none;
    transition: background .2s;
}

.social-btn:hover {
    background: var(--primary, #6C3AFF);
    color: #fff;
    border-color: var(--primary);
}

.agent-badge-active {
    position: absolute;
    top: 12px;
    right: 12px;
    background: #E6F9F0;
    color: #1DB97A;
    font-size: .65rem;
    font-weight: 700;
    padding: .25rem .65rem;
    border-radius: 100px;
    letter-spacing: .06em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: .3rem;
}

.agent-badge-active::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #1DB97A;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {

    0%,
    100% {
        opacity: 1;
        transform: scale(1)
    }

    50% {
        opacity: .6;
        transform: scale(1.3)
    }
}

.agent-body {
    padding: 1.25rem 1.25rem 1.4rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.agent-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-main, #1A1A2E);
    margin-bottom: .2rem;
}

.agent-agency {
    font-size: .78rem;
    color: var(--text-muted, #8A8FA8);
    margin-bottom: .85rem;
}

.agent-stats {
    display: flex;
    gap: 1rem;
    padding: .75rem 0;
    border-top: 1px solid var(--border, #ECEEF4);
    border-bottom: 1px solid var(--border, #ECEEF4);
    margin-bottom: .85rem;
}

.agent-stat {
    text-align: center;
    flex: 1;
}

.agent-stat-num {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--primary, #6C3AFF);
    line-height: 1;
}

.agent-stat-lbl {
    font-size: .68rem;
    color: var(--text-muted);
    margin-top: .15rem;
    text-transform: uppercase;
    letter-spacing: .06em;
}

.agent-commission {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    background: var(--primary-soft, #EDE8FF);
    color: var(--primary, #6C3AFF);
    font-size: .72rem;
    font-weight: 600;
    padding: .25rem .7rem;
    border-radius: 100px;
    margin-bottom: .85rem;
}

.btn-agent-contact {
    width: 100%;
    height: 42px;
    background: var(--primary, #6C3AFF);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-size: .83rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    text-decoration: none;
    transition: all .2s;
    margin-top: auto;
}

.btn-agent-contact:hover {
    background: #5628E8;
    color: #fff;
    box-shadow: 0 6px 18px rgba(108, 58, 255, .35);
}

/* ── Empty state ── */
.empty-state {
    text-align: center;
    padding: 5rem 2rem;
    background: #fff;
    border-radius: 20px;
    border: 2px dashed var(--border);
}

.empty-state-icon {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: var(--primary-soft, #EDE8FF);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 2rem;
    color: var(--primary, #6C3AFF);
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

/* ── CTA band ── */
.agents-cta {
    background: linear-gradient(135deg, #1A1A2E 0%, #2d1b69 100%);
    border-radius: 20px;
    padding: 3rem 2.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    margin-top: 4rem;
}

.agents-cta::before {
    content: '';
    position: absolute;
    top: -60px;
    right: -60px;
    width: 250px;
    height: 250px;
    border-radius: 50%;
    background: rgba(108, 58, 255, .2);
}

.agents-cta .container {
    position: relative;
    z-index: 1;
}
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="container">
        <div class="breadcrumb-custom">
            <a href="{{ route('home') }}">Accueil</a>
            <span><i class="bi bi-chevron-right"></i></span>
            <span>Agents</span>
        </div>
        <p class="page-header-eyebrow"><i class="bi bi-person-badge me-1"></i>Notre équipe</p>
        <h1 class="page-header-title">Des Experts à Votre Service</h1>
        <p class="page-header-sub">
            {{ $agents->total() }} agent{{ $agents->total() > 1 ? 's' : '' }}
            qualifié{{ $agents->total() > 1 ? 's' : '' }} prêts à vous accompagner
        </p>

        <form action="{{ route('agents.index') }}" method="GET" class="agents-search-bar">
            <div class="asb-input-wrap">
                <i class="bi bi-search"></i>
                <input type="text" name="search" class="asb-input" placeholder="Nom de l'agent ou agence…"
                    value="{{ request('search') }}">
            </div>
            <div class="asb-input-wrap">
                <i class="bi bi-geo-alt"></i>
                <input type="text" name="city" class="asb-input" placeholder="Ville…" value="{{ request('city') }}">
            </div>
            <button type="submit" class="asb-btn">
                <i class="bi bi-search"></i> Rechercher
            </button>
            @if(request()->hasAny(['search','city']))
            <a href="{{ route('agents.index') }}" class="asb-btn" style="background:rgba(255,255,255,.1)">
                <i class="bi bi-x-lg"></i>
            </a>
            @endif
        </form>
    </div>
</div>

<div style="background:var(--surface,#F4F5F7);min-height:60vh" class="py-5">
    <div class="container">

        <div class="agents-toolbar">
            <p class="agents-count mb-0">
                <strong>{{ $agents->total() }}</strong>
                agent{{ $agents->total() > 1 ? 's' : '' }} trouvé{{ $agents->total() > 1 ? 's' : '' }}
            </p>
            <select class="sort-select" onchange="window.location.href=this.value">
                <option value="{{ request()->fullUrlWithQuery(['sort'=>'latest']) }}"
                    {{ !request('sort') || request('sort')==='latest' ? 'selected' : '' }}>
                    Plus récents
                </option>
                <option value="{{ request()->fullUrlWithQuery(['sort'=>'properties']) }}"
                    {{ request('sort')==='properties' ? 'selected' : '' }}>
                    Nombre de biens
                </option>
                <option value="{{ request()->fullUrlWithQuery(['sort'=>'commission']) }}"
                    {{ request('sort')==='commission' ? 'selected' : '' }}>
                    Commission
                </option>
            </select>
        </div>

        @if($agents->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-person-slash"></i></div>
            <h4 class="fw-700 mb-2">Aucun agent trouvé</h4>
            <p class="text-muted mb-3">Essayez de modifier vos critères de recherche.</p>
            <a href="{{ route('agents.index') }}" class="btn btn-primary px-4 py-2" style="border-radius:10px">
                <i class="bi bi-arrow-counterclockwise me-2"></i>Réinitialiser
            </a>
        </div>
        @else
        <div class="row g-4">
            @foreach($agents as $agent)
            <div class="col-xl-3 col-lg-4 col-md-6 agent-item">
                <div class="agent-card">
                    <div class="agent-img-wrap">
                        <img src="/storage/{{$agent->user->avatar ?? 'https://i.pravatar.cc/400?img='.($loop->index + 10) }}"
                            alt="{{ $agent->user->name }} {{ $agent->user->last_name }}" loading="lazy">
                        <div class="agent-img-overlay"></div>
                        <span class="agent-badge-active">Actif</span>
                        <div class="agent-socials">
                            <a href="tel:{{ $agent->user->phone }}" class="social-btn" title="Appeler">
                                <i class="bi bi-telephone-fill"></i>
                            </a>
                            <a href="mailto:{{ $agent->user->email }}" class="social-btn" title="Email">
                                <i class="bi bi-envelope-fill"></i>
                            </a>
                            <a href="{{ route('agents.show', $agent->id) }}" class="social-btn" title="Profil">
                                <i class="bi bi-person-fill"></i>
                            </a>
                        </div>
                    </div>
                    <div class="agent-body">
                        <div class="agent-name">{{ $agent->user->name }} {{ $agent->user->last_name }}</div>
                        <div class="agent-agency">
                            <i class="bi bi-building me-1" style="color:var(--primary)"></i>
                            {{ $agent->agency_name ?? 'Agent indépendant' }}
                        </div>
                        <div class="agent-stats">
                            <div class="agent-stat">
                                <div class="agent-stat-num">{{ $agent->properties_count }}</div>
                                <div class="agent-stat-lbl">Biens</div>
                            </div>
                            <div class="agent-stat">
                                <div class="agent-stat-num">{{ number_format($agent->commission_rate, 0) }}%</div>
                                <div class="agent-stat-lbl">Commission</div>
                            </div>
                            <div class="agent-stat">
                                <div class="agent-stat-num">{{ $agent->transactions_count ?? '—' }}</div>
                                <div class="agent-stat-lbl">Ventes</div>
                            </div>
                        </div>
                        @if($agent->license_number)
                        <div class="agent-commission mb-3">
                            <i class="bi bi-shield-check"></i>
                            Lic. {{ $agent->license_number }}
                        </div>
                        @endif
                        <a href="{{ route('agents.show', $agent->id) }}" class="btn-agent-contact">
                            <i class="bi bi-person-lines-fill"></i>Voir le profil
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($agents->hasPages())
        <nav class="pagination-custom">
            <li class="page-item {{ $agents->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $agents->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
            </li>
            @foreach($agents->getUrlRange(max(1,$agents->currentPage()-2),
            min($agents->lastPage(),$agents->currentPage()+2)) as $page => $url)
            <li class="page-item {{ $page == $agents->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endforeach
            <li class="page-item {{ !$agents->hasMorePages() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $agents->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
            </li>
        </nav>
        @endif
        @endif

        {{-- CTA recrutement --}}
        <div class="agents-cta mt-5">
            <div style="position:relative;z-index:1">
                <p
                    style="font-size:.75rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#a78bfa;margin-bottom:.5rem">
                    Rejoindre l'équipe
                </p>
                <h3 style="font-size:1.9rem;font-weight:800;color:#fff;margin-bottom:.75rem;letter-spacing:-.02em">
                    Vous êtes Agent Immobilier ?
                </h3>
                <p style="color:rgba(255,255,255,.65);font-size:.95rem;max-width:460px;margin:0 auto 1.75rem">
                    Rejoignez notre réseau d'experts et accédez à des milliers de clients qualifiés chaque mois.
                </p>
                <a href="{{ route('contact') }}" class="btn btn-light fw-700 px-5 py-3 rounded-3"
                    style="color:var(--primary);font-size:.95rem">
                    <i class="bi bi-send me-2"></i>Nous contacter
                </a>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        gsap.from('.page-header-title', {
            opacity: 0,
            y: 20,
            duration: .7,
            ease: 'power3.out'
        });
        gsap.from('.agents-search-bar', {
            opacity: 0,
            y: 15,
            duration: .6,
            delay: .2,
            ease: 'power2.out'
        });
        document.querySelectorAll('.agent-item').forEach((el, i) => {
            gsap.from(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top bottom-=60',
                    toggleActions: 'play none none reverse'
                },
                opacity: 0,
                y: 28,
                duration: .5,
                delay: (i % 4) * .07,
                ease: 'power2.out'
            });
        });
    }
});
</script>
@endpush