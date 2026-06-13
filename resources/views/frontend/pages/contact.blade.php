@extends('base')

@section('title', 'Contact - EstateVista')

@push('styles')
<style>
/* ── Page Header ── */
.contact-header {
    background: linear-gradient(135deg, #1A1A2E 0%, #2d1b69 55%, #1A1A2E 100%);
    position: relative;
    overflow: hidden;
    padding: 5rem 0 4rem;
}

.contact-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 25% 60%, rgba(108, 58, 255, .28) 0%, transparent 55%),
        radial-gradient(ellipse at 80% 20%, rgba(167, 139, 250, .14) 0%, transparent 50%);
}

.contact-header::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 60px;
    background: var(--surface, #F4F5F7);
    clip-path: ellipse(55% 100% at 50% 100%);
}

.contact-header .container {
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

/* ── Layout ── */
.contact-layout {
    display: grid;
    grid-template-columns: 1fr 440px;
    gap: 2rem;
    align-items: start;
}

@media(max-width:1024px) {
    .contact-layout {
        grid-template-columns: 1fr;
    }
}

/* ── Contact Form Card ── */
.contact-form-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid var(--border, #ECEEF4);
    padding: 2.5rem;
    box-shadow: 0 4px 24px rgba(108, 58, 255, .06);
}

.form-section-title {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--text-muted, #8A8FA8);
    margin-bottom: 1.25rem;
    padding-bottom: .5rem;
    border-bottom: 1px solid var(--border);
}

.cf-group {
    margin-bottom: 1.25rem;
}

.cf-label {
    display: block;
    font-size: .78rem;
    font-weight: 600;
    color: var(--text-main, #1A1A2E);
    margin-bottom: .4rem;
}

.cf-label span {
    color: #E84545;
    margin-left: .2rem;
}

.cf-input,
.cf-select,
.cf-textarea {
    width: 100%;
    border: 1.5px solid var(--border, #ECEEF4);
    border-radius: 11px;
    padding: .7rem 1rem;
    font-size: .88rem;
    color: var(--text-main);
    background: var(--surface, #F4F5F7);
    transition: all .2s;
    font-family: inherit;
}

.cf-input:focus,
.cf-select:focus,
.cf-textarea:focus {
    outline: none;
    border-color: var(--primary, #6C3AFF);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(108, 58, 255, .1);
}

.cf-input::placeholder,
.cf-textarea::placeholder {
    color: var(--text-light, #B4B9CC);
}

.cf-input.error,
.cf-select.error,
.cf-textarea.error {
    border-color: #E84545;
    box-shadow: 0 0 0 4px rgba(232, 69, 69, .08);
}

.cf-textarea {
    resize: vertical;
    min-height: 130px;
}

.cf-select {
    appearance: none;
    cursor: pointer;
}

.input-with-icon {
    position: relative;
}

.input-with-icon i {
    position: absolute;
    left: .9rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: .9rem;
    pointer-events: none;
}

.input-with-icon .cf-input {
    padding-left: 2.5rem;
}

/* Subject pills */
.subject-pills {
    display: flex;
    flex-wrap: wrap;
    gap: .4rem;
    margin-bottom: 1.25rem;
}

.subject-pill {
    padding: .35rem .9rem;
    border-radius: 100px;
    border: 1.5px solid var(--border);
    font-size: .78rem;
    font-weight: 600;
    color: var(--text-muted);
    cursor: pointer;
    transition: all .2s;
    background: transparent;
}

.subject-pill:hover,
.subject-pill.active {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-soft, #EDE8FF);
}

input[type="hidden"]#subjectHidden {
    display: none;
}

/* Rating stars */
.rating-wrap {
    display: flex;
    gap: .4rem;
}

.rating-star {
    font-size: 1.4rem;
    cursor: pointer;
    color: var(--border);
    transition: color .15s;
}

.rating-star.active,
.rating-star:hover {
    color: #F5A623;
}

/* Submit btn */
.btn-submit {
    width: 100%;
    height: 52px;
    background: var(--primary, #6C3AFF);
    border: none;
    border-radius: 12px;
    color: #fff;
    font-size: .95rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .6rem;
    cursor: pointer;
    transition: all .25s;
    position: relative;
    overflow: hidden;
}

.btn-submit:hover {
    background: #5628E8;
    box-shadow: 0 8px 24px rgba(108, 58, 255, .4);
    transform: translateY(-2px);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-submit .spinner {
    display: none;
    width: 18px;
    height: 18px;
    border: 2.5px solid rgba(255, 255, 255, .3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin .7s linear infinite;
}

.btn-submit.loading .spinner {
    display: block;
}

.btn-submit.loading .btn-text {
    display: none;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Alert */
.form-alert {
    padding: 1rem 1.25rem;
    border-radius: 12px;
    font-size: .85rem;
    font-weight: 500;
    display: none;
    align-items: flex-start;
    gap: .75rem;
    margin-bottom: 1.25rem;
}

.form-alert.show {
    display: flex;
}

.form-alert.success {
    background: #E6F9F0;
    color: #1DB97A;
    border: 1px solid #b7e8d5;
}

.form-alert.error {
    background: #FEEAEA;
    color: #E84545;
    border: 1px solid #f5c6c6;
}

.form-alert i {
    font-size: 1.1rem;
    flex-shrink: 0;
    margin-top: .05rem;
}

/* ── Sidebar info ── */
.contact-info-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid var(--border);
    padding: 2rem;
    box-shadow: 0 4px 24px rgba(108, 58, 255, .06);
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border);
}

.info-item:last-of-type {
    border-bottom: none;
}

.info-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--primary-soft, #EDE8FF);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.05rem;
    color: var(--primary, #6C3AFF);
    flex-shrink: 0;
}

.info-label {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .08em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: .25rem;
}

.info-value {
    font-size: .9rem;
    font-weight: 600;
    color: var(--text-main);
    line-height: 1.5;
    text-decoration: none;
}

.info-value:hover {
    color: var(--primary);
}

a.info-value {
    transition: color .2s;
}

.info-note {
    font-size: .75rem;
    color: var(--text-muted);
    margin-top: .1rem;
}

/* Office hours */
.hours-grid {
    display: flex;
    flex-direction: column;
    gap: .35rem;
}

.hours-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: .8rem;
}

.hours-day {
    color: var(--text-muted);
}

.hours-time {
    font-weight: 600;
    color: var(--text-main);
}

.hours-badge {
    display: inline-flex;
    align-items: center;
    gap: .3rem;
    background: #E6F9F0;
    color: #1DB97A;
    font-size: .68rem;
    font-weight: 700;
    padding: .2rem .6rem;
    border-radius: 100px;
}

.hours-badge::before {
    content: '';
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: #1DB97A;
    animation: pulse 1.5s infinite;
}

/* Social links */
.social-links {
    display: flex;
    gap: .6rem;
    margin-top: 1rem;
}

.social-link {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1.5px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: .95rem;
    text-decoration: none;
    transition: all .2s;
}

.social-link:hover {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
}

/* Map section */
.map-section {
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--border);
    margin-top: 1.5rem;
    height: 200px;
    background: var(--surface);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.map-placeholder {
    text-align: center;
    color: var(--text-muted);
}

.map-placeholder i {
    font-size: 2rem;
    color: var(--primary);
    display: block;
    margin-bottom: .5rem;
}

/* ── FAQ ── */
.faq-section {
    padding: 5rem 0;
    background: var(--surface);
}

.faq-item {
    background: #fff;
    border-radius: 14px;
    border: 1px solid var(--border);
    margin-bottom: .75rem;
    overflow: hidden;
    transition: box-shadow .2s;
}

.faq-item:hover {
    box-shadow: 0 4px 16px rgba(108, 58, 255, .07);
}

.faq-question {
    padding: 1.1rem 1.4rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    user-select: none;
    font-size: .9rem;
    font-weight: 600;
    color: var(--text-main);
    gap: 1rem;
}

.faq-question i {
    color: var(--primary);
    font-size: 1rem;
    flex-shrink: 0;
    transition: transform .3s;
}

.faq-item.open .faq-question i {
    transform: rotate(45deg);
}

.faq-answer {
    padding: 0 1.4rem;
    font-size: .85rem;
    color: var(--text-muted);
    line-height: 1.7;
    max-height: 0;
    overflow: hidden;
    transition: max-height .35s ease, padding .3s ease;
}

.faq-item.open .faq-answer {
    max-height: 200px;
    padding-bottom: 1.25rem;
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
</style>
@endpush

@section('content')

<div class="contact-header">
    <div class="container">
        <div class="breadcrumb-custom">
            <a href="{{ route('home') }}">Accueil</a>
            <span><i class="bi bi-chevron-right"></i></span>
            <span>Contact</span>
        </div>
        <p class="page-eyebrow"><i class="bi bi-envelope-heart me-1"></i>Parlons de votre projet</p>
        <h1 class="page-title">Contactez Notre Équipe</h1>
        <p class="page-sub">Nous répondons à toutes vos demandes sous 24h ouvrées</p>
    </div>
</div>

<div style="background:var(--surface,#F4F5F7);padding:3rem 0 5rem">
    <div class="container">
        <div class="contact-layout">

            {{-- ════════════════════════
                 FORM
                 ════════════════════════ --}}
            <div class="contact-form-card">

                {{-- Alert --}}
                @if(session('success'))
                <div class="form-alert success show">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <strong>Message envoyé !</strong><br>
                        <span style="font-weight:400">{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="form-alert error show">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>
                        <strong>Veuillez corriger les erreurs ci-dessous.</strong>
                    </div>
                </div>
                @endif

                <div id="formAlert" class="form-alert"></div>

                <div class="form-section-title">Votre sujet</div>

                {{-- Subject pills --}}
                <div class="subject-pills" id="subjectPills">
                    @php
                    $subjects = [
                    'achat' => 'Achat de bien',
                    'location' => 'Location',
                    'estimation' => 'Estimation',
                    'investissement' => 'Investissement',
                    'partenariat' => 'Partenariat',
                    'autre' => 'Autre',
                    ];
                    @endphp
                    @foreach($subjects as $val => $lbl)
                    <button type="button" class="subject-pill {{ old('subject') === $val ? 'active' : '' }}"
                        data-val="{{ $val }}">{{ $lbl }}</button>
                    @endforeach
                </div>

                <form action="{{ route('contact.send') }}" method="POST" id="contactForm" novalidate>
                    @csrf
                    <input type="hidden" name="subject" id="subjectHidden" value="{{ old('subject') }}">

                    <div class="form-section-title mt-2">Vos coordonnées</div>

                    <div class="row g-3 mb-0">
                        <div class="col-sm-6">
                            <div class="cf-group">
                                <label class="cf-label">Prénom <span>*</span></label>
                                <div class="input-with-icon">
                                    <i class="bi bi-person"></i>
                                    <input type="text" name="first_name"
                                        class="cf-input {{ $errors->has('first_name') ? 'error' : '' }}"
                                        placeholder="Jean" value="{{ old('first_name') }}" required>
                                </div>
                                @error('first_name')
                                <small style="color:#E84545;font-size:.75rem">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="cf-group">
                                <label class="cf-label">Nom <span>*</span></label>
                                <div class="input-with-icon">
                                    <i class="bi bi-person"></i>
                                    <input type="text" name="last_name"
                                        class="cf-input {{ $errors->has('last_name') ? 'error' : '' }}"
                                        placeholder="Dupont" value="{{ old('last_name') }}" required>
                                </div>
                                @error('last_name')
                                <small style="color:#E84545;font-size:.75rem">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-0">
                        <div class="col-sm-6">
                            <div class="cf-group">
                                <label class="cf-label">Email <span>*</span></label>
                                <div class="input-with-icon">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" name="email"
                                        class="cf-input {{ $errors->has('email') ? 'error' : '' }}"
                                        placeholder="jean@exemple.fr" value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                <small style="color:#E84545;font-size:.75rem">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="cf-group">
                                <label class="cf-label">Téléphone</label>
                                <div class="input-with-icon">
                                    <i class="bi bi-telephone"></i>
                                    <input type="tel" name="phone" class="cf-input" placeholder="+33 6 00 00 00 00"
                                        value="{{ old('phone') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section-title mt-1">Votre message</div>

                    <div class="cf-group">
                        <label class="cf-label">Message <span>*</span></label>
                        <textarea name="message" class="cf-textarea {{ $errors->has('message') ? 'error' : '' }}"
                            placeholder="Décrivez votre projet immobilier, vos besoins et vos questions…"
                            required>{{ old('message') }}</textarea>
                        @error('message')
                        <small style="color:#E84545;font-size:.75rem">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="cf-group">
                        <label class="cf-label">Budget estimé</label>
                        <select name="budget" class="cf-select">
                            <option value="">Sélectionner une fourchette</option>
                            <option value="<100k" {{ old('budget') === '<100k' ? 'selected' : '' }}>Moins de 100 000 $
                            </option>
                            <option value="100-250k" {{ old('budget') === '100-250k' ? 'selected' : '' }}>100 000 $ –
                                250 000 $</option>
                            <option value="250-500k" {{ old('budget') === '250-500k' ? 'selected' : '' }}>250 000 $ –
                                500 000 $</option>
                            <option value="500k-1m" {{ old('budget') === '500k-1m' ? 'selected' : '' }}>500 000 $ – 1
                                000 000 $</option>
                            <option value=">1m" {{ old('budget') === '>1m' ? 'selected' : '' }}>Plus de 1 000 000 $
                            </option>
                        </select>
                    </div>

                    <div class="cf-group">
                        <label class="cf-label d-flex align-items-center gap-2">
                            <input type="checkbox" name="newsletter" value="1" {{ old('newsletter') ? 'checked' : '' }}
                                style="width:16px;height:16px;accent-color:var(--primary);cursor:pointer">
                            <span>Recevoir nos alertes et nouveautés immobilières</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <div class="spinner"></div>
                        <span class="btn-text">
                            <i class="bi bi-send-fill me-1"></i> Envoyer le message
                        </span>
                    </button>

                    <p
                        style="text-align:center;font-size:.72rem;color:var(--text-muted);margin-top:.85rem;margin-bottom:0">
                        <i class="bi bi-lock me-1"></i>
                        Vos données sont protégées et ne seront jamais partagées.
                    </p>
                </form>
            </div>

            {{-- ════════════════════════
                 SIDEBAR
                 ════════════════════════ --}}
            <div>
                <div class="contact-info-card">
                    <p
                        style="font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--text-muted);margin-bottom:1rem">
                        Nos coordonnées
                    </p>

                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div>
                            <div class="info-label">Adresse</div>
                            <div class="info-value">12 Avenue de l'Immobilier<br>75008 Paris, France</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div>
                            <div class="info-label">Téléphone</div>
                            <a href="tel:+33140000000" class="info-value">+33 1 40 00 00 00</a>
                            <div class="info-note">Lun–Ven, 9h–18h</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div>
                            <div class="info-label">Email</div>
                            <a href="mailto:contact@estatevista.fr" class="info-value">contact@estatevista.fr</a>
                            <div class="info-note">Réponse sous 24h ouvrées</div>
                        </div>
                    </div>

                    <div class="info-item" style="border-bottom:none">
                        <div class="info-icon"><i class="bi bi-clock-fill"></i></div>
                        <div style="flex:1">
                            <div class="info-label" style="margin-bottom:.6rem">
                                Horaires
                                <span class="hours-badge ms-2">Ouvert maintenant</span>
                            </div>
                            <div class="hours-grid">
                                <div class="hours-row">
                                    <span class="hours-day">Lundi – Vendredi</span>
                                    <span class="hours-time">9h00 – 18h00</span>
                                </div>
                                <div class="hours-row">
                                    <span class="hours-day">Samedi</span>
                                    <span class="hours-time">10h00 – 16h00</span>
                                </div>
                                <div class="hours-row">
                                    <span class="hours-day">Dimanche</span>
                                    <span class="hours-time" style="color:var(--text-muted)">Fermé</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="social-links">
                        <a href="#" class="social-link" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-link" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="social-link" title="X / Twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-link" title="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                {{-- Map placeholder ── remplace par une vraie map si tu as une API key --}}
                <div class="map-section">
                    <div class="map-placeholder">
                        <i class="bi bi-map"></i>
                        <p style="font-size:.82rem;margin:0">12 Avenue de l'Immobilier, Paris</p>
                        <a href="https://maps.google.com" target="_blank"
                            style="font-size:.75rem;color:var(--primary);text-decoration:none;font-weight:600">
                            Voir sur Google Maps <i class="bi bi-box-arrow-up-right ms-1"></i>
                        </a>
                    </div>
                </div>

                {{-- Quick contact agents --}}
                <div class="contact-info-card mt-4">
                    <p
                        style="font-size:.72rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--text-muted);margin-bottom:1rem">
                        Contact direct
                    </p>
                    <a href="{{ route('agents.index') }}"
                        style="display:flex;align-items:center;gap:.85rem;padding:.85rem;background:var(--primary-soft);border-radius:12px;text-decoration:none;transition:background .2s"
                        onmouseover="this.style.background='#DDD6FE'"
                        onmouseout="this.style.background='var(--primary-soft)'">
                        <div
                            style="width:42px;height:42px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.1rem;flex-shrink:0">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <div style="font-size:.85rem;font-weight:700;color:var(--text-main)">Parler à un agent</div>
                            <div style="font-size:.75rem;color:var(--text-muted)">Consultez nos {{ $agentsCount ?? 45 }}
                                experts disponibles</div>
                        </div>
                        <i class="bi bi-arrow-right ms-auto" style="color:var(--primary)"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── FAQ ── --}}
<section class="faq-section">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-4">
                <div class="sticky-top" style="top:100px">
                    <p
                        style="font-size:.72rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--primary);margin-bottom:.6rem">
                        <i class="bi bi-question-circle me-1"></i>FAQ
                    </p>
                    <h2
                        style="font-size:clamp(1.6rem,3vw,2.2rem);font-weight:800;color:var(--text-main);letter-spacing:-.02em;margin-bottom:.75rem">
                        Questions Fréquentes
                    </h2>
                    <p style="font-size:.9rem;color:var(--text-muted);line-height:1.7">
                        Vous ne trouvez pas la réponse ? Contactez-nous directement via le formulaire.
                    </p>
                </div>
            </div>
            <div class="col-lg-8">
                @php
                $faqs = [
                [
                'q' => "Comment fonctionne l'estimation de mon bien ?",
                'a' => "Notre service d'estimation gratuite analyse les données du marché local, les caractéristiques de
                votre bien et les transactions récentes pour vous fournir une valeur précise sous 48h."
                ],
                [
                'q' => "Quels sont vos frais de commission ?",
                'a' => "Notre commission standard est de 5%, incluant la mise en valeur du bien, la gestion des visites,
                la négociation et l'accompagnement jusqu'à la signature."
                ],
                [
                'q' => "Combien de temps prend une transaction immobilière ?",
                'a' => "En moyenne, une vente prend 3 à 4 mois de la mise en marché à la signature définitive. Nous
                optimisons chaque étape pour aller aussi vite que possible."
                ],
                [
                'q' => "Puis-je vendre et acheter simultanément ?",
                'a' => "Oui, c'est même ce que nous recommandons. Nos agents coordonnent les deux opérations pour éviter
                tout flottement et optimiser votre fiscalité."
                ],
                [
                'q' => "Proposez-vous un service de location saisonnière ?",
                'a' => "Nous nous concentrons sur les locations longue durée et les ventes. Pour la location
                saisonnière, nous pouvons vous orienter vers nos partenaires spécialisés."
                ],
                [
                'q' => "Comment sont sélectionnés vos agents ?",
                'a' => "Chaque agent suit une formation approfondie de 3 mois et doit obtenir une licence
                professionnelle. Nous imposons des standards d'excellence et de service client très élevés."
                ],
                ];
                @endphp
                @foreach($faqs as $i => $faq)
                <div class="faq-item" id="faq-{{ $i }}">
                    <div class="faq-question" onclick="toggleFaq('{{ $i }}')">
                        <span>{{ $faq['q'] }}</span>
                        <i class="bi bi-plus-lg"></i>
                    </div>
                    <div class="faq-answer">{{ $faq['a'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ── Subject pills ── */
    document.querySelectorAll('.subject-pill').forEach(pill => {
        pill.addEventListener('click', () => {
            document.querySelectorAll('.subject-pill').forEach(p => p.classList.remove(
                'active'));
            pill.classList.add('active');
            document.getElementById('subjectHidden').value = pill.dataset.val;
        });
    });

    /* ── Form submit with spinner ── */
    const form = document.getElementById('contactForm');
    const btn = document.getElementById('submitBtn');

    form?.addEventListener('submit', function() {
        btn.classList.add('loading');
    });

    /* ── FAQ ── */
    window.toggleFaq = function(index) {
        const item = document.getElementById('faq-' + index);
        const isOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
        if (!isOpen) item.classList.add('open');
    };

    /* ── GSAP ── */
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        gsap.from('.page-title', {
            opacity: 0,
            y: 20,
            duration: .7,
            ease: 'power3.out'
        });
        gsap.from('.page-sub', {
            opacity: 0,
            y: 14,
            duration: .6,
            delay: .15,
            ease: 'power2.out'
        });
        gsap.from('.contact-form-card', {
            opacity: 0,
            y: 24,
            duration: .7,
            delay: .1,
            ease: 'power2.out'
        });
        gsap.from('.contact-info-card', {
            opacity: 0,
            x: 20,
            duration: .7,
            delay: .2,
            ease: 'power2.out'
        });

        document.querySelectorAll('.faq-item, .award-item, .value-card').forEach((el, i) => {
            gsap.from(el, {
                scrollTrigger: {
                    trigger: el,
                    start: 'top bottom-=60',
                    toggleActions: 'play none none reverse'
                },
                opacity: 0,
                y: 20,
                duration: .45,
                delay: i * .05,
                ease: 'power2.out'
            });
        });
    }
});
</script>
@endpush