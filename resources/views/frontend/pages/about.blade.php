@extends('base')

@section('title', 'À Propos — EstateVista')

@push('styles')
<style>
/* ── Hero ── */
.about-hero {
    position: relative;
    min-height: 85vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0e0c1e;
}

.about-hero-bg {
    position: absolute;
    inset: 0;
    background: url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=2000&q=85') center/cover no-repeat;
    opacity: .18;
    transform: scale(1.05);
    animation: slowZoom 18s ease-in-out infinite alternate;
}

@keyframes slowZoom {
    from {
        transform: scale(1.05);
    }

    to {
        transform: scale(1.12);
    }
}

.about-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 60% 40%, rgba(108, 58, 255, .25) 0%, transparent 55%),
        radial-gradient(ellipse at 10% 80%, rgba(167, 139, 250, .12) 0%, transparent 50%);
}

.about-hero .container {
    position: relative;
    z-index: 1;
}

.about-hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: rgba(108, 58, 255, .2);
    border: 1px solid rgba(108, 58, 255, .4);
    color: #c4b5fd;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    padding: .4rem 1rem;
    border-radius: 100px;
    margin-bottom: 1.5rem;
}

.about-hero-title {
    font-size: clamp(2.5rem, 5.5vw, 4.2rem);
    font-weight: 800;
    color: #fff;
    line-height: 1.12;
    letter-spacing: -.03em;
    margin-bottom: 1.5rem;
}

.about-hero-title em {
    font-style: normal;
    background: linear-gradient(90deg, #a78bfa, #6C3AFF);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.about-hero-text {
    font-size: 1.05rem;
    color: rgba(255, 255, 255, .7);
    line-height: 1.75;
    max-width: 480px;
    margin-bottom: 2rem;
}

.about-hero-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.btn-hero-primary {
    height: 50px;
    padding: 0 2rem;
    background: var(--primary, #6C3AFF);
    border: none;
    border-radius: 12px;
    color: #fff;
    font-weight: 700;
    font-size: .9rem;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    text-decoration: none;
    transition: all .2s;
    box-shadow: 0 8px 24px rgba(108, 58, 255, .4);
}

.btn-hero-primary:hover {
    background: #5628E8;
    color: #fff;
    transform: translateY(-2px);
}

.btn-hero-ghost {
    height: 50px;
    padding: 0 2rem;
    border: 1.5px solid rgba(255, 255, 255, .3);
    border-radius: 12px;
    color: #fff;
    font-weight: 600;
    font-size: .9rem;
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    text-decoration: none;
    transition: all .2s;
    background: transparent;
}

.btn-hero-ghost:hover {
    border-color: #fff;
    background: rgba(255, 255, 255, .08);
    color: #fff;
}

/* Floating card */
.about-hero-card {
    background: rgba(255, 255, 255, .06);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, .1);
    border-radius: 20px;
    padding: 2rem;
}

.metric-row {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.metric-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.1rem;
    background: rgba(255, 255, 255, .05);
    border-radius: 14px;
    border: 1px solid rgba(255, 255, 255, .08);
    transition: background .2s;
}

.metric-item:hover {
    background: rgba(108, 58, 255, .15);
}

.metric-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: rgba(108, 58, 255, .25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: #a78bfa;
    flex-shrink: 0;
}

.metric-num {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}

.metric-lbl {
    font-size: .75rem;
    color: rgba(255, 255, 255, .55);
    margin-top: .1rem;
}

/* ── Section commons ── */
.section-eyebrow {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .14em;
    text-transform: uppercase;
    color: var(--primary, #6C3AFF);
    margin-bottom: .6rem;
}

.section-title {
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 800;
    color: var(--text-main, #1A1A2E);
    line-height: 1.2;
    letter-spacing: -.02em;
}

.section-sub {
    font-size: 1rem;
    color: var(--text-muted, #8A8FA8);
    line-height: 1.7;
    max-width: 520px;
}

/* ── Story section ── */
.story-section {
    padding: 6rem 0;
}

.story-img-stack {
    position: relative;
}

.story-img-main {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(108, 58, 255, .12);
}

.story-img-main img {
    width: 100%;
    height: 380px;
    object-fit: cover;
    display: block;
}

.story-img-accent {
    position: absolute;
    bottom: -30px;
    right: -30px;
    width: 200px;
    border-radius: 16px;
    overflow: hidden;
    border: 4px solid #fff;
    box-shadow: 0 12px 30px rgba(0, 0, 0, .15);
}

.story-img-accent img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    display: block;
}

.story-badge {
    position: absolute;
    top: -20px;
    left: -20px;
    background: var(--primary, #6C3AFF);
    border-radius: 14px;
    padding: 1rem 1.25rem;
    text-align: center;
    color: #fff;
    box-shadow: 0 8px 24px rgba(108, 58, 255, .4);
    border: 3px solid #fff;
}

.story-badge-num {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
}

.story-badge-lbl {
    font-size: .72rem;
    opacity: .85;
}

.story-content {
    padding-left: 2rem;
}

@media(max-width:768px) {
    .story-content {
        padding-left: 0;
        margin-top: 3.5rem;
    }
}

.story-feature {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.story-feature-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--primary-soft, #EDE8FF);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: var(--primary, #6C3AFF);
    flex-shrink: 0;
    margin-top: .1rem;
}

.story-feature-title {
    font-size: .9rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: .25rem;
}

.story-feature-text {
    font-size: .83rem;
    color: var(--text-muted);
    line-height: 1.6;
    margin: 0;
}

/* ── Values section ── */
.values-section {
    background: var(--surface, #F4F5F7);
    padding: 5rem 0;
}

.value-card {
    background: #fff;
    border-radius: 18px;
    padding: 2rem 1.75rem;
    border: 1px solid var(--border, #ECEEF4);
    height: 100%;
    transition: transform .3s, box-shadow .3s;
    position: relative;
    overflow: hidden;
}

.value-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: var(--primary, #6C3AFF);
    transform: scaleX(0);
    transition: transform .3s ease;
    transform-origin: left;
}

.value-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(108, 58, 255, .1);
}

.value-card:hover::before {
    transform: scaleX(1);
}

.value-icon {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    background: var(--primary-soft, #EDE8FF);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: var(--primary, #6C3AFF);
    margin-bottom: 1.25rem;
}

.value-title {
    font-size: .95rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: .5rem;
}

.value-text {
    font-size: .83rem;
    color: var(--text-muted);
    line-height: 1.65;
    margin: 0;
}

/* ── Timeline ── */
.timeline-section {
    padding: 5rem 0;
}

.timeline {
    position: relative;
    padding-left: 3rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, var(--primary, #6C3AFF), var(--primary-soft, #EDE8FF));
}

.timeline-item {
    position: relative;
    margin-bottom: 2.5rem;
}

.timeline-dot {
    position: absolute;
    left: -2.6rem;
    top: .25rem;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--primary, #6C3AFF);
    border: 3px solid #fff;
    box-shadow: 0 0 0 3px rgba(108, 58, 255, .2);
}

.timeline-year {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--primary, #6C3AFF);
    margin-bottom: .3rem;
}

.timeline-title {
    font-size: .95rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: .3rem;
}

.timeline-text {
    font-size: .83rem;
    color: var(--text-muted);
    line-height: 1.6;
    margin: 0;
}

/* ── Team section ── */
.team-section {
    background: #1A1A2E;
    padding: 5rem 0;
}

.team-title {
    color: #fff;
}

.team-sub {
    color: rgba(255, 255, 255, .55);
}

.team-card {
    background: rgba(255, 255, 255, .05);
    border: 1px solid rgba(255, 255, 255, .08);
    border-radius: 18px;
    overflow: hidden;
    transition: transform .3s, box-shadow .3s;
    text-align: center;
}

.team-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, .3);
}

.team-img {
    height: 200px;
    overflow: hidden;
}

.team-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s;
}

.team-card:hover .team-img img {
    transform: scale(1.06);
}

.team-body {
    padding: 1.25rem 1rem 1.5rem;
}

.team-name {
    font-size: .92rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: .2rem;
}

.team-role {
    font-size: .75rem;
    color: rgba(255, 255, 255, .45);
}

/* ── Awards ── */
.awards-section {
    padding: 5rem 0;
}

.award-item {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.5rem;
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--border);
    height: 100%;
    transition: transform .3s, box-shadow .3s;
}

.award-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(108, 58, 255, .08);
}

.award-icon {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.award-year {
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--primary);
    margin-bottom: .2rem;
}

.award-name {
    font-size: .88rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: .1rem;
}

.award-org {
    font-size: .75rem;
    color: var(--text-muted);
}

/* ── CTA ── */
.about-cta {
    background: linear-gradient(135deg, var(--primary, #6C3AFF), #4c1db8);
    padding: 5rem 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.about-cta::before {
    content: '';
    position: absolute;
    right: -80px;
    top: -80px;
    width: 350px;
    height: 350px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .06);
}

.about-cta .container {
    position: relative;
    z-index: 1;
}
</style>
@endpush

@section('content')

{{-- ── Hero ── --}}
<section class="about-hero">
    <div class="about-hero-bg"></div>
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="about-hero-eyebrow">
                    <i class="bi bi-buildings-fill"></i> Notre histoire
                </span>
                <h1 class="about-hero-title">
                    L'Immobilier <em>Réinventé</em><br>Pour Vous
                </h1>
                <p class="about-hero-text">
                    Depuis 2009, EstateVista accompagne des milliers de familles et d'investisseurs
                    à trouver la propriété de leurs rêves avec expertise, transparence et passion.
                </p>
                <div class="about-hero-actions">
                    <a href="{{ route('properties.index') }}" class="btn-hero-primary">
                        <i class="bi bi-search"></i> Voir nos biens
                    </a>
                    <a href="{{ route('contact') }}" class="btn-hero-ghost">
                        <i class="bi bi-telephone"></i> Nous appeler
                    </a>
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1">
                <div class="about-hero-card">
                    <p
                        style="font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.4);margin-bottom:1rem">
                        Nos chiffres clés
                    </p>
                    <div class="metric-row">
                        <div class="metric-item">
                            <div class="metric-icon"><i class="bi bi-buildings"></i></div>
                            <div>
                                <div class="metric-num counter" data-target="1250">0</div>
                                <div class="metric-lbl">Propriétés vendues</div>
                            </div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-icon"><i class="bi bi-people-fill"></i></div>
                            <div>
                                <div class="metric-num counter" data-target="850">0</div>
                                <div class="metric-lbl">Clients satisfaits</div>
                            </div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-icon"><i class="bi bi-person-badge-fill"></i></div>
                            <div>
                                <div class="metric-num counter" data-target="45">0</div>
                                <div class="metric-lbl">Agents experts</div>
                            </div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-icon"><i class="bi bi-award-fill"></i></div>
                            <div>
                                <div class="metric-num counter" data-target="15">0</div>
                                <div class="metric-lbl">Années d'expérience</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Story ── --}}
<section class="story-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="story-img-stack">
                    <div class="story-badge">
                        <div class="story-badge-num">15</div>
                        <div class="story-badge-lbl">ans d'expérience</div>
                    </div>
                    <div class="story-img-main">
                        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=800&q=85"
                            alt="Notre bureau">
                    </div>
                    <div class="story-img-accent">
                        <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=400&q=80"
                            alt="Notre équipe">
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="story-content">
                    <p class="section-eyebrow"><i class="bi bi-bookmark-heart me-1"></i>Notre histoire</p>
                    <h2 class="section-title mb-3">Nés d'une Passion<br>pour l'Immobilier</h2>
                    <p class="text-muted mb-4" style="line-height:1.75;font-size:.95rem">
                        Fondée en 2009 à Paris, EstateVista est née d'une vision simple : rendre l'immobilier
                        accessible, transparent et humain. Nous avons commencé avec 3 agents et aujourd'hui
                        nous comptons plus de 45 experts dédiés à votre satisfaction.
                    </p>

                    <div class="story-feature">
                        <div class="story-feature-icon"><i class="bi bi-shield-check"></i></div>
                        <div>
                            <div class="story-feature-title">Transparence totale</div>
                            <p class="story-feature-text">
                                Chaque transaction est documentée et vérifiée. Nous ne cachons rien
                                à nos clients — frais, commissions, historique du bien.
                            </p>
                        </div>
                    </div>

                    <div class="story-feature">
                        <div class="story-feature-icon"><i class="bi bi-headset"></i></div>
                        <div>
                            <div class="story-feature-title">Accompagnement personnalisé</div>
                            <p class="story-feature-text">
                                Un agent dédié pour chaque projet, disponible 7j/7 pour répondre à
                                toutes vos questions et vous guider pas à pas.
                            </p>
                        </div>
                    </div>

                    <div class="story-feature">
                        <div class="story-feature-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <div>
                            <div class="story-feature-title">Expertise du marché</div>
                            <p class="story-feature-text">
                                15 ans d'analyse du marché immobilier nous permettent d'offrir
                                des estimations précises et des conseils d'investissement avisés.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Values ── --}}
<section class="values-section">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-eyebrow"><i class="bi bi-heart me-1"></i>Ce qui nous anime</p>
            <h2 class="section-title">Nos Valeurs Fondamentales</h2>
            <p class="section-sub mx-auto mt-2">Les principes qui guident chacune de nos actions depuis 15 ans</p>
        </div>
        <div class="row g-4">
            @php
            $values = [
            ['icon'=>'bi-shield-check','title'=>'Intégrité','text'=>"Nous agissons avec honnêteté et transparence dans
            chaque interaction, chaque transaction, chaque conseil."],
            ['icon'=>'bi-stars','title'=>'Excellence','text'=>"Nous visons l'exceptionnel dans chaque détail : qualité
            des biens, qualité du service, qualité des conseils."],
            ['icon'=>'bi-people','title'=>'Engagement client','text'=>"Votre satisfaction est notre priorité absolue.
            Chaque décision est prise en pensant à votre bien-être."],
            ['icon'=>'bi-lightbulb','title'=>'Innovation','text'=>"Nous adoptons les meilleures technologies pour vous
            offrir une expérience immobilière moderne et fluide."],
            ['icon'=>'bi-globe','title'=>'Durabilité','text'=>"Nous promouvons des pratiques immobilières responsables
            et respectueuses de l'environnement."],
            ['icon'=>'bi-people','title'=>'Partenariat','text'=>"Nous bâtissons des relations durables basées sur la
            confiance mutuelle et le respect professionnel."],
            ];
            @endphp
            @foreach($values as $v)
            <div class="col-lg-4 col-md-6 value-item">
                <div class="value-card">
                    <div class="value-icon"><i class="bi {{ $v['icon'] }}"></i></div>
                    <div class="value-title">{{ $v['title'] }}</div>
                    <p class="value-text">{{ $v['text'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Timeline ── --}}
<section class="timeline-section">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-4">
                <div class="sticky-top" style="top:100px">
                    <p class="section-eyebrow"><i class="bi bi-clock-history me-1"></i>Notre parcours</p>
                    <h2 class="section-title mb-3">15 Ans d'Histoire</h2>
                    <p class="section-sub">
                        De notre premier bureau à Paris à notre réseau national,
                        découvrez les étapes clés qui ont forgé EstateVista.
                    </p>
                </div>
            </div>
            <div class="col-lg-7 offset-lg-1">
                <div class="timeline">
                    @php
                    $events = [
                    ['year'=>'2009','title'=>'Création d\'EstateVista','text'=>"Fondation à Paris avec 3 agents
                    passionnés et une vision : humaniser l'immobilier."],
                    ['year'=>'2012','title'=>'100ème transaction','text'=>"Une étape symbolique : notre 100ème vente
                    réalisée, signe de la confiance croissante de nos clients."],
                    ['year'=>'2015','title'=>'Expansion nationale','text'=>"Ouverture de 5 nouvelles agences en France,
                    doublant notre capacité d'accompagnement."],
                    ['year'=>'2018','title'=>'Lancement de la plateforme digitale','text'=>"Mise en ligne
                    d'EstateVista.com pour permettre la recherche de biens en ligne 24h/24."],
                    ['year'=>'2021','title'=>'Prix de l\'innovation immobilière','text'=>"Récompensés pour notre
                    approche technologique et notre service client d'exception."],
                    ['year'=>'2024','title'=>'1250 propriétés vendues','text'=>"Un bilan remarquable : plus de 1250
                    familles et investisseurs accompagnés avec succès."],
                    ];
                    @endphp
                    @foreach($events as $e)
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-year">{{ $e['year'] }}</div>
                        <div class="timeline-title">{{ $e['title'] }}</div>
                        <p class="timeline-text">{{ $e['text'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Awards ── --}}
<section class="awards-section" style="background:var(--surface)">
    <div class="container">
        <div class="text-center mb-5">
            <p class="section-eyebrow"><i class="bi bi-trophy me-1"></i>Reconnaissances</p>
            <h2 class="section-title">Nos Prix & Distinctions</h2>
        </div>
        <div class="row g-4">
            @php
            $awards = [
            ['icon'=>'🏆','year'=>'2024','name'=>'Meilleure Agence Digitale','org'=>'Fédération Nationale Immobilière'],
            ['icon'=>'🥇','year'=>'2023','name'=>'Prix de l\'Innovation','org'=>'PropTech Summit Paris'],
            ['icon'=>'⭐','year'=>'2022','name'=>'Top Agent Network','org'=>'Immobilier Excellence Awards'],
            ['icon'=>'🎯','year'=>'2021','name'=>'Meilleur Service Client','org'=>'Real Estate Awards FR'],
            ];
            @endphp
            @foreach($awards as $a)
            <div class="col-lg-3 col-md-6 award-item-wrap">
                <div class="award-item">
                    <div class="award-icon">{{ $a['icon'] }}</div>
                    <div>
                        <div class="award-year">{{ $a['year'] }}</div>
                        <div class="award-name">{{ $a['name'] }}</div>
                        <div class="award-org">{{ $a['org'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA ── --}}
<section class="about-cta">
    <div class="container">
        <h2
            style="font-size:clamp(1.8rem,3.5vw,2.5rem);font-weight:800;color:#fff;margin-bottom:.75rem;letter-spacing:-.02em">
            Prêt à Commencer Votre Projet ?
        </h2>
        <p style="color:rgba(255,255,255,.7);font-size:.95rem;max-width:440px;margin:0 auto 2rem;line-height:1.7">
            Nos agents sont disponibles maintenant pour vous accompagner dans votre recherche immobilière.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="{{ route('properties.index') }}" class="btn btn-light fw-700 px-5 py-3 rounded-3"
                style="color:var(--primary);font-size:.92rem">
                <i class="bi bi-search me-2"></i>Parcourir les biens
            </a>
            <a href="{{ route('contact') }}"
                style="height:50px;padding:0 2rem;border:1.5px solid rgba(255,255,255,.35);border-radius:12px;color:#fff;font-weight:600;font-size:.92rem;display:inline-flex;align-items:center;gap:.5rem;text-decoration:none;transition:all .2s"
                onmouseover="this.style.borderColor='#fff';this.style.background='rgba(255,255,255,.1)'"
                onmouseout="this.style.borderColor='rgba(255,255,255,.35)';this.style.background='transparent'">
                <i class="bi bi-envelope"></i>Nous contacter
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    /* Counters */
    const counters = document.querySelectorAll('.counter');
    const obs = new window.IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const target = parseInt(el.dataset.target);
            let cur = 0;
            const step = target / (1800 / 16);
            const tick = () => {
                cur = Math.min(cur + step, target);
                el.textContent = Math.floor(cur).toLocaleString('fr-FR');
                if (cur < target) requestAnimationFrame(tick);
            };
            tick();
            obs.unobserve(el);
        });
    }, {
        threshold: 0.5
    });
    counters.forEach(c => obs.observe(c));

    /* GSAP */
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        gsap.from('.about-hero-eyebrow', {
            opacity: 0,
            y: 16,
            duration: .6,
            ease: 'power3.out'
        });
        gsap.from('.about-hero-title', {
            opacity: 0,
            y: 28,
            duration: .8,
            delay: .15,
            ease: 'power3.out'
        });
        gsap.from('.about-hero-text', {
            opacity: 0,
            y: 18,
            duration: .6,
            delay: .3,
            ease: 'power2.out'
        });
        gsap.from('.about-hero-card', {
            opacity: 0,
            x: 30,
            duration: .8,
            delay: .2,
            ease: 'power3.out'
        });

        gsap.utils.toArray('.value-item, .award-item-wrap, .timeline-item').forEach((el, i) => {
            gsap.from(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top bottom-=70',
                    toggleActions: 'play none none reverse'
                },
                opacity: 0,
                y: 24,
                duration: .5,
                delay: (i % 3) * .07,
                ease: 'power2.out'
            });
        });

        gsap.from('.story-img-stack', {
            scrollTrigger: {
                trigger: '.story-img-stack',
                start: 'top bottom-=80'
            },
            opacity: 0,
            x: -30,
            duration: .8,
            ease: 'power2.out'
        });
    }
});
</script>
@endpush