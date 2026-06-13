<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — EstateVista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/style.css'])
    <style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: #0e0c1e;
        min-height: 100vh;
        display: flex;
        align-items: stretch;
        color: #1A1A2E;
    }

    /* ── Split layout ── */
    .auth-layout {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    /* Left panel */
    .auth-panel-left {
        flex: 0 0 42%;
        background:
            linear-gradient(160deg, rgba(10, 8, 30, .88) 0%, rgba(40, 15, 90, .8) 50%, rgba(10, 8, 30, .92) 100%),
            url('https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=85') center/cover no-repeat;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .auth-panel-left::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 30% 60%, rgba(108, 58, 255, .3) 0%, transparent 60%);
    }

    .auth-panel-left .content {
        position: relative;
        z-index: 1;
    }

    .auth-logo {
        display: inline-flex;
        align-items: center;
        gap: .6rem;
        text-decoration: none;
    }

    .auth-logo-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(108, 58, 255, .3);
        border: 1px solid rgba(108, 58, 255, .5);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #a78bfa;
    }

    .auth-logo-text {
        font-size: 1.2rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -.02em;
    }

    .auth-panel-quote {
        background: rgba(255, 255, 255, .06);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: auto;
    }

    .auth-panel-quote p {
        font-size: .92rem;
        color: rgba(255, 255, 255, .75);
        line-height: 1.7;
        font-style: italic;
        margin-bottom: 1rem;
    }

    .auth-panel-quote-author {
        display: flex;
        align-items: center;
        gap: .75rem;
    }

    .auth-panel-quote-author img {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(108, 58, 255, .5);
    }

    .auth-panel-quote-name {
        font-size: .82rem;
        font-weight: 700;
        color: #fff;
    }

    .auth-panel-quote-role {
        font-size: .72rem;
        color: rgba(255, 255, 255, .45);
    }

    .auth-panel-left-features {
        display: flex;
        flex-direction: column;
        gap: .75rem;
        margin-top: 2rem;
    }

    .auth-feature-item {
        display: flex;
        align-items: center;
        gap: .75rem;
        font-size: .82rem;
        color: rgba(255, 255, 255, .7);
    }

    .auth-feature-item i {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(108, 58, 255, .25);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a78bfa;
        font-size: .85rem;
        flex-shrink: 0;
    }

    /* Right panel */
    .auth-panel-right {
        flex: 1;
        background: #F4F5F7;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1.5rem;
        overflow-y: auto;
    }

    .auth-form-container {
        width: 100%;
        max-width: 520px;
    }

    /* ── Role selector ── */
    .role-selector {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .75rem;
        margin-bottom: 2rem;
    }

    .role-card {
        background: #fff;
        border: 2px solid #ECEEF4;
        border-radius: 14px;
        padding: 1.25rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all .25s;
        position: relative;
        overflow: hidden;
    }

    .role-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(108, 58, 255, .05), transparent);
        opacity: 0;
        transition: opacity .25s;
    }

    .role-card:hover {
        border-color: #c4b5fd;
        transform: translateY(-2px);
    }

    .role-card:hover::before {
        opacity: 1;
    }

    .role-card.active {
        border-color: #6C3AFF;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(108, 58, 255, .12), 0 8px 24px rgba(108, 58, 255, .1);
    }

    .role-card.active::before {
        opacity: 1;
    }

    .role-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin: 0 auto .75rem;
        transition: all .25s;
    }

    .role-card-buyer .role-card-icon {
        background: #E6F9F0;
        color: #1DB97A;
    }

    .role-card-agent .role-card-icon {
        background: #EDE8FF;
        color: #6C3AFF;
    }

    .role-card.active.role-card-buyer .role-card-icon {
        background: #1DB97A;
        color: #fff;
    }

    .role-card.active.role-card-agent .role-card-icon {
        background: #6C3AFF;
        color: #fff;
    }

    .role-card-title {
        font-size: .88rem;
        font-weight: 700;
        color: #1A1A2E;
        margin-bottom: .2rem;
    }

    .role-card-sub {
        font-size: .72rem;
        color: #8A8FA8;
        line-height: 1.4;
    }

    .role-card-check {
        position: absolute;
        top: .6rem;
        right: .6rem;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #6C3AFF;
        color: #fff;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: .65rem;
    }

    .role-card.active .role-card-check {
        display: flex;
    }

    /* ── Form panels ── */
    .form-panel {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #ECEEF4;
        padding: 2rem;
        box-shadow: 0 4px 24px rgba(108, 58, 255, .06);
        display: none;
    }

    .form-panel.active {
        display: block;
    }

    .form-panel-header {
        margin-bottom: 1.5rem;
    }

    .form-panel-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        padding: .3rem .75rem;
        border-radius: 100px;
        margin-bottom: .65rem;
    }

    .badge-buyer {
        background: #E6F9F0;
        color: #1DB97A;
    }

    .badge-agent {
        background: #EDE8FF;
        color: #6C3AFF;
    }

    .form-panel-title {
        font-size: 1.2rem;
        font-weight: 800;
        color: #1A1A2E;
        margin-bottom: .3rem;
        letter-spacing: -.02em;
    }

    .form-panel-sub {
        font-size: .8rem;
        color: #8A8FA8;
    }

    /* Form fields */
    .field-group {
        margin-bottom: 1rem;
    }

    .field-label {
        display: block;
        font-size: .75rem;
        font-weight: 600;
        color: #1A1A2E;
        margin-bottom: .4rem;
    }

    .field-label span {
        color: #E84545;
        margin-left: .15rem;
    }

    .field-wrap {
        position: relative;
    }

    .field-wrap i {
        position: absolute;
        left: .9rem;
        top: 50%;
        transform: translateY(-50%);
        color: #8A8FA8;
        font-size: .9rem;
        pointer-events: none;
        z-index: 1;
    }

    .field-input {
        width: 100%;
        height: 46px;
        border: 1.5px solid #ECEEF4;
        border-radius: 11px;
        padding: 0 1rem 0 2.6rem;
        font-size: .85rem;
        color: #1A1A2E;
        background: #F4F5F7;
        font-family: 'Inter', sans-serif;
        transition: all .2s;
    }

    .field-input:focus {
        outline: none;
        border-color: #6C3AFF;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(108, 58, 255, .1);
    }

    .field-input::placeholder {
        color: #B4B9CC;
    }

    .field-input.is-invalid {
        border-color: #E84545;
        box-shadow: 0 0 0 4px rgba(232, 69, 69, .08);
    }

    .field-error {
        font-size: .72rem;
        color: #E84545;
        margin-top: .3rem;
        display: block;
    }

    /* Password toggle */
    .field-eye {
        position: absolute;
        right: .9rem;
        top: 50%;
        transform: translateY(-50%);
        color: #8A8FA8;
        cursor: pointer;
        font-size: .95rem;
        transition: color .2s;
        z-index: 1;
    }

    .field-eye:hover {
        color: #6C3AFF;
    }

    .field-input.has-eye {
        padding-right: 2.8rem;
    }

    /* Password strength */
    .pwd-strength {
        margin-top: .4rem;
    }

    .pwd-strength-bar {
        height: 3px;
        border-radius: 100px;
        background: #ECEEF4;
        overflow: hidden;
    }

    .pwd-strength-fill {
        height: 100%;
        border-radius: 100px;
        width: 0;
        transition: width .3s, background .3s;
    }

    .pwd-strength-label {
        font-size: .68rem;
        color: #8A8FA8;
        margin-top: .25rem;
    }

    /* Separator */
    .fields-sep {
        display: flex;
        align-items: center;
        gap: .6rem;
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #B4B9CC;
        margin: 1.1rem 0 1rem;
    }

    .fields-sep::before,
    .fields-sep::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #ECEEF4;
    }

    /* Agent notice */
    .agent-notice {
        background: #FFF8E7;
        border: 1px solid #FDE68A;
        border-radius: 10px;
        padding: .75rem 1rem;
        font-size: .78rem;
        color: #92400E;
        display: flex;
        align-items: flex-start;
        gap: .6rem;
        margin-bottom: 1rem;
    }

    .agent-notice i {
        color: #F5A623;
        font-size: 1rem;
        flex-shrink: 0;
        margin-top: .05rem;
    }

    /* Submit btn */
    .btn-submit {
        width: 100%;
        height: 50px;
        border: none;
        border-radius: 12px;
        font-size: .92rem;
        font-weight: 700;
        cursor: pointer;
        transition: all .25s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        margin-top: 1.25rem;
    }

    .btn-submit-buyer {
        background: linear-gradient(135deg, #1DB97A, #15a367);
        color: #fff;
        box-shadow: 0 6px 20px rgba(29, 185, 122, .3);
    }

    .btn-submit-buyer:hover {
        background: linear-gradient(135deg, #18a36c, #12916d);
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(29, 185, 122, .4);
    }

    .btn-submit-agent {
        background: linear-gradient(135deg, #6C3AFF, #4c1db8);
        color: #fff;
        box-shadow: 0 6px 20px rgba(108, 58, 255, .35);
    }

    .btn-submit-agent:hover {
        background: linear-gradient(135deg, #5628E8, #3d14a0);
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(108, 58, 255, .45);
    }

    /* Bottom links */
    .auth-bottom {
        text-align: center;
        margin-top: 1.25rem;
        font-size: .78rem;
        color: #8A8FA8;
    }

    .auth-bottom a {
        color: #6C3AFF;
        font-weight: 600;
        text-decoration: none;
        transition: color .2s;
    }

    .auth-bottom a:hover {
        color: #5628E8;
    }

    /* ── Header above form ── */
    .auth-form-top {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .auth-form-top h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1A1A2E;
        letter-spacing: -.025em;
        margin-bottom: .3rem;
    }

    .auth-form-top p {
        font-size: .83rem;
        color: #8A8FA8;
    }

    .step-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        margin-bottom: 1.5rem;
    }

    .step-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ECEEF4;
        transition: all .3s;
    }

    .step-dot.active {
        background: #6C3AFF;
        width: 20px;
        border-radius: 100px;
    }

    .step-dot.done {
        background: #1DB97A;
    }

    /* Responsive */
    @media(max-width: 900px) {
        .auth-panel-left {
            display: none;
        }
    }
    </style>
</head>

<body>

    <div class="auth-layout">

        {{-- ── Left panel ── --}}
        <div class="auth-panel-left">
            <div class="content">
                <a href="{{ route('home') }}" class="auth-logo">
                    <div class="auth-logo-icon"><i class="bi bi-buildings-fill"></i></div>
                    <span class="auth-logo-text">EstateVista</span>
                </a>

                <div style="margin-top: 3rem;">
                    <p
                        style="font-size:.72rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#a78bfa;margin-bottom:.6rem">
                        Rejoignez-nous
                    </p>
                    <h2
                        style="font-size:2rem;font-weight:800;color:#fff;line-height:1.2;letter-spacing:-.025em;margin-bottom:1rem">
                        L'immobilier de confiance,<br>à portée de main
                    </h2>
                    <p style="font-size:.9rem;color:rgba(255,255,255,.6);line-height:1.7;max-width:340px">
                        Créez votre compte gratuitement et accédez à des milliers de propriétés d'exception.
                    </p>
                </div>

                <div class="auth-panel-left-features">
                    <div class="auth-feature-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Transactions 100% sécurisées</span>
                    </div>
                    <div class="auth-feature-item">
                        <i class="bi bi-search"></i>
                        <span>+1250 propriétés disponibles</span>
                    </div>
                    <div class="auth-feature-item">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>45 agents experts dédiés</span>
                    </div>
                    <div class="auth-feature-item">
                        <i class="bi bi-heart-fill"></i>
                        <span>Sauvegardez vos favoris</span>
                    </div>
                </div>
            </div>

            <div class="auth-panel-quote">
                <p>"J'ai trouvé mon appartement de rêve en 3 semaines grâce à EstateVista. Un service incroyable !"</p>
                <div class="auth-panel-quote-author">
                    <img src="https://i.pravatar.cc/80?img=5" alt="Marie Laurent">
                    <div>
                        <div class="auth-panel-quote-name">Marie Laurent</div>
                        <div class="auth-panel-quote-role">Acheteuse | Bordeaux</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Right panel ── --}}
        <div class="auth-panel-right">
            <div class="auth-form-container">

                <div class="auth-form-top">
                    <h1>Créer un compte</h1>
                    <p>Choisissez votre type de compte pour commencer</p>
                </div>

                {{-- Global errors --}}
                @if($errors->any() && !$errors->has('name') && !$errors->has('email'))
                <div
                    style="background:#FEEAEA;border:1px solid #f5c6c6;border-radius:10px;padding:.75rem 1rem;font-size:.8rem;color:#E84545;margin-bottom:1rem;display:flex;gap:.5rem;align-items:center">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    Veuillez corriger les erreurs ci-dessous.
                </div>
                @endif

                {{-- ── Role selector ── --}}
                <div class="role-selector" id="roleSelector">
                    <div class="role-card role-card-buyer {{ old('_form') !== 'agent' ? 'active' : '' }}" id="roleBuyer"
                        onclick="selectRole('buyer')">
                        <div class="role-card-check"><i class="bi bi-check-lg"></i></div>
                        <div class="role-card-icon"><i class="bi bi-person-fill"></i></div>
                        <div class="role-card-title">Acheteur</div>
                        <div class="role-card-sub">Je recherche une propriété à acheter ou louer</div>
                    </div>
                    <div class="role-card role-card-agent {{ old('_form') === 'agent' ? 'active' : '' }}" id="roleAgent"
                        onclick="selectRole('agent')">
                        <div class="role-card-check"><i class="bi bi-check-lg"></i></div>
                        <div class="role-card-icon"><i class="bi bi-briefcase-fill"></i></div>
                        <div class="role-card-title">Agent</div>
                        <div class="role-card-sub">Je suis agent immobilier professionnel</div>
                    </div>
                </div>

                <div class="step-indicator">
                    <div class="step-dot active" id="step1"></div>
                    <div class="step-dot" id="step2"></div>
                </div>

                {{-- ════════════════════════
                 FORM BUYER
                 ════════════════════════ --}}
                <div class="form-panel {{ old('_form') !== 'agent' ? 'active' : '' }}" id="formBuyer">
                    <div class="form-panel-header">
                        <span class="form-panel-badge badge-buyer">
                            <i class="bi bi-person-fill"></i> Acheteur
                        </span>
                        <div class="form-panel-title">Inscription acheteur</div>
                        <div class="form-panel-sub">Accédez à toutes nos propriétés gratuitement</div>
                    </div>

                    <form method="POST" action="{{ route('register.buyer') }}" id="buyerForm" novalidate>
                        @csrf
                        <input type="hidden" name="_form" value="buyer">

                        <div class="row g-2">
                            <div class="col-6">
                                <div class="field-group">
                                    <label class="field-label">Prénom <span>*</span></label>
                                    <div class="field-wrap">
                                        <i class="bi bi-person"></i>
                                        <input type="text" name="name"
                                            class="field-input {{ $errors->has('name') && old('_form') !== 'agent' ? 'is-invalid' : '' }}"
                                            placeholder="Jean" value="{{ old('name') }}" required>
                                    </div>
                                    @if($errors->has('name') && old('_form') !== 'agent')
                                    <span class="field-error">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="field-group">
                                    <label class="field-label">Nom <span>*</span></label>
                                    <div class="field-wrap">
                                        <i class="bi bi-person"></i>
                                        <input type="text" name="last_name"
                                            class="field-input {{ $errors->has('last_name') && old('_form') !== 'agent' ? 'is-invalid' : '' }}"
                                            placeholder="Dupont" value="{{ old('last_name') }}" required>
                                    </div>
                                    @if($errors->has('last_name') && old('_form') !== 'agent')
                                    <span class="field-error">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Email <span>*</span></label>
                            <div class="field-wrap">
                                <i class="bi bi-envelope"></i>
                                <input type="email" name="email"
                                    class="field-input {{ $errors->has('email') && old('_form') !== 'agent' ? 'is-invalid' : '' }}"
                                    placeholder="jean@exemple.fr" value="{{ old('email') }}" required>
                            </div>
                            @if($errors->has('email') && old('_form') !== 'agent')
                            <span class="field-error">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="field-group">
                            <label class="field-label">Téléphone <span>*</span></label>
                            <div class="field-wrap">
                                <i class="bi bi-telephone"></i>
                                <input type="tel" name="phone" class="field-input" placeholder="+33 6 00 00 00 00"
                                    value="{{ old('phone') }}" required>
                            </div>
                            @error('phone') <span class="field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label">Mot de passe <span>*</span></label>
                            <div class="field-wrap">
                                <i class="bi bi-lock"></i>
                                <input type="password" name="password" id="buyerPwd"
                                    class="field-input has-eye {{ $errors->has('password') && old('_form') !== 'agent' ? 'is-invalid' : '' }}"
                                    placeholder="Min. 8 caractères" required
                                    oninput="checkStrength(this, 'buyerStrengthFill', 'buyerStrengthLabel')">
                                <i class="bi bi-eye field-eye" onclick="togglePwd('buyerPwd', this)"></i>
                            </div>
                            @if($errors->has('password') && old('_form') !== 'agent')
                            <span class="field-error">{{ $errors->first('password') }}</span>
                            @endif
                            <div class="pwd-strength">
                                <div class="pwd-strength-bar">
                                    <div class="pwd-strength-fill" id="buyerStrengthFill"></div>
                                </div>
                                <span class="pwd-strength-label" id="buyerStrengthLabel"></span>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Confirmer le mot de passe <span>*</span></label>
                            <div class="field-wrap">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" name="password_confirmation" id="buyerPwdConf"
                                    class="field-input has-eye" placeholder="Répéter le mot de passe" required>
                                <i class="bi bi-eye field-eye" onclick="togglePwd('buyerPwdConf', this)"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit btn-submit-buyer">
                            <i class="bi bi-person-check-fill"></i>
                            Créer mon compte acheteur
                        </button>
                    </form>
                </div>

                {{-- ════════════════════════
                 FORM AGENT
                 ════════════════════════ --}}
                <div class="form-panel {{ old('_form') === 'agent' ? 'active' : '' }}" id="formAgent">
                    <div class="form-panel-header">
                        <span class="form-panel-badge badge-agent">
                            <i class="bi bi-briefcase-fill"></i> Agent
                        </span>
                        <div class="form-panel-title">Inscription agent</div>
                        <div class="form-panel-sub">Rejoignez notre réseau d'experts immobiliers</div>
                    </div>

                    <div class="agent-notice">
                        <i class="bi bi-info-circle-fill"></i>
                        <div>
                            Votre compte sera <strong>en attente de validation</strong> par nos administrateurs.
                            Vous devrez également <strong>vérifier votre email</strong> pour accéder au dashboard.
                        </div>
                    </div>

                    <form method="POST" action="{{ route('register.agent') }}" id="agentForm" novalidate>
                        @csrf
                        <input type="hidden" name="_form" value="agent">

                        <div class="fields-sep">Informations personnelles</div>

                        <div class="row g-2">
                            <div class="col-6">
                                <div class="field-group">
                                    <label class="field-label">Prénom <span>*</span></label>
                                    <div class="field-wrap">
                                        <i class="bi bi-person"></i>
                                        <input type="text" name="name"
                                            class="field-input {{ $errors->has('name') && old('_form') === 'agent' ? 'is-invalid' : '' }}"
                                            placeholder="Jean" value="{{ old('name') }}" required>
                                    </div>
                                    @if($errors->has('name') && old('_form') === 'agent')
                                    <span class="field-error">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="field-group">
                                    <label class="field-label">Nom <span>*</span></label>
                                    <div class="field-wrap">
                                        <i class="bi bi-person"></i>
                                        <input type="text" name="last_name"
                                            class="field-input {{ $errors->has('last_name') && old('_form') === 'agent' ? 'is-invalid' : '' }}"
                                            placeholder="Dupont" value="{{ old('last_name') }}" required>
                                    </div>
                                    @if($errors->has('last_name') && old('_form') === 'agent')
                                    <span class="field-error">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Email professionnel <span>*</span></label>
                            <div class="field-wrap">
                                <i class="bi bi-envelope"></i>
                                <input type="email" name="email"
                                    class="field-input {{ $errors->has('email') && old('_form') === 'agent' ? 'is-invalid' : '' }}"
                                    placeholder="agent@agence.fr" value="{{ old('email') }}" required>
                            </div>
                            @if($errors->has('email') && old('_form') === 'agent')
                            <span class="field-error">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="field-group">
                            <label class="field-label">Téléphone <span>*</span></label>
                            <div class="field-wrap">
                                <i class="bi bi-telephone"></i>
                                <input type="tel" name="phone" class="field-input" placeholder="+33 6 00 00 00 00"
                                    value="{{ old('phone') }}" required>
                            </div>
                            @error('phone') <span class="field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="fields-sep">Informations professionnelles</div>

                        <div class="field-group">
                            <label class="field-label">Nom de l'agence <span>*</span></label>
                            <div class="field-wrap">
                                <i class="bi bi-building"></i>
                                <input type="text" name="agency_name"
                                    class="field-input {{ $errors->has('agency_name') ? 'is-invalid' : '' }}"
                                    placeholder="Ex : Immo Paris Nord" value="{{ old('agency_name') }}" required>
                            </div>
                            @error('agency_name') <span class="field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label">Numéro de licence <span>*</span></label>
                            <div class="field-wrap">
                                <i class="bi bi-shield-check"></i>
                                <input type="text" name="license_number"
                                    class="field-input {{ $errors->has('license_number') ? 'is-invalid' : '' }}"
                                    placeholder="Ex : CPI-75-2024-XXXXX" value="{{ old('license_number') }}" required>
                            </div>
                            @error('license_number') <span class="field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="fields-sep">Sécurité</div>

                        <div class="field-group">
                            <label class="field-label">Mot de passe <span>*</span></label>
                            <div class="field-wrap">
                                <i class="bi bi-lock"></i>
                                <input type="password" name="password" id="agentPwd"
                                    class="field-input has-eye {{ $errors->has('password') && old('_form') === 'agent' ? 'is-invalid' : '' }}"
                                    placeholder="Min. 8 caractères" required
                                    oninput="checkStrength(this, 'agentStrengthFill', 'agentStrengthLabel')">
                                <i class="bi bi-eye field-eye" onclick="togglePwd('agentPwd', this)"></i>
                            </div>
                            @if($errors->has('password') && old('_form') === 'agent')
                            <span class="field-error">{{ $errors->first('password') }}</span>
                            @endif
                            <div class="pwd-strength">
                                <div class="pwd-strength-bar">
                                    <div class="pwd-strength-fill" id="agentStrengthFill"></div>
                                </div>
                                <span class="pwd-strength-label" id="agentStrengthLabel"></span>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Confirmer le mot de passe <span>*</span></label>
                            <div class="field-wrap">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" name="password_confirmation" id="agentPwdConf"
                                    class="field-input has-eye" placeholder="Répéter le mot de passe" required>
                                <i class="bi bi-eye field-eye" onclick="togglePwd('agentPwdConf', this)"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn-submit btn-submit-agent">
                            <i class="bi bi-briefcase-fill"></i>
                            Créer mon compte agent
                        </button>
                    </form>
                </div>

                <div class="auth-bottom">
                    Déjà inscrit ?
                    <a href="{{ route('login') }}">Se connecter</a>
                    &nbsp;·&nbsp;
                    <a href="{{ route('home') }}">Retour à l'accueil</a>
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    /* ── Role toggle ── */
    function selectRole(role) {
        const buyer = document.getElementById('roleBuyer');
        const agent = document.getElementById('roleAgent');
        const fBuyer = document.getElementById('formBuyer');
        const fAgent = document.getElementById('formAgent');
        const s1 = document.getElementById('step1');
        const s2 = document.getElementById('step2');

        if (role === 'buyer') {
            buyer.classList.add('active');
            agent.classList.remove('active');
            fBuyer.classList.add('active');
            fAgent.classList.remove('active');
            s1.classList.add('active');
            s2.classList.remove('active');
        } else {
            agent.classList.add('active');
            buyer.classList.remove('active');
            fAgent.classList.add('active');
            fBuyer.classList.remove('active');
            s2.classList.add('active');
            s1.classList.remove('active');
        }
    }

    /* ── Toggle password visibility ── */
    function togglePwd(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }

    /* ── Password strength ── */
    function checkStrength(input, fillId, labelId) {
        const val = input.value;
        const fill = document.getElementById(fillId);
        const lbl = document.getElementById(labelId);
        let score = 0;

        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        const levels = [{
                pct: '0%',
                color: '',
                text: ''
            },
            {
                pct: '25%',
                color: '#E84545',
                text: 'Faible'
            },
            {
                pct: '50%',
                color: '#F5A623',
                text: 'Moyen'
            },
            {
                pct: '75%',
                color: '#6C3AFF',
                text: 'Bon'
            },
            {
                pct: '100%',
                color: '#1DB97A',
                text: 'Excellent'
            },
        ];

        fill.style.width = levels[score].pct;
        fill.style.background = levels[score].color;
        lbl.textContent = levels[score].text;
        lbl.style.color = levels[score].color;
    }

    /* ── Restore form on validation error ── */
    document.addEventListener('DOMContentLoaded', function() {
        const savedForm = <?php echo json_encode(old('_form')); ?>;
        if (savedForm === 'agent') {
            selectRole('agent');
        }
    });
    </script>
</body>

</html>