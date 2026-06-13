@extends('admin.admin')

@section('title', 'Paramètres')
@php
use Illuminate\Support\Facades\Auth;
@endphp

@section('content')
<div class="content-wrapper">

    <!-- PAGE HEADER -->
    <div class="page-header mb-4">
        <div>
            <h2 class="page-title mb-1">Paramètres</h2>
            <p class="page-subtitle text-muted mb-0">Gérez vos préférences et paramètres du compte</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- SIDEBAR SETTINGS -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm sticky-top" style="top: 90px;">
                <div class="card-body p-3">
                    <nav class="nav flex-column settings-nav">
                        <a href="#profile" class="nav-link active" data-section="profile">
                            <i class="bi bi-person me-2"></i>
                            Profil
                        </a>
                        <a href="#account" class="nav-link" data-section="account">
                            <i class="bi bi-shield-lock me-2"></i>
                            Sécurité
                        </a>
                        <a href="#notifications" class="nav-link" data-section="notifications">
                            <i class="bi bi-bell me-2"></i>
                            Notifications
                        </a>
                        <a href="#preferences" class="nav-link" data-section="preferences">
                            <i class="bi bi-sliders me-2"></i>
                            Préférences
                        </a>
                        @if(Auth::user()->role === 'admin')
                        <a href="#system" class="nav-link" data-section="system">
                            <i class="bi bi-gear me-2"></i>
                            Système
                        </a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>

        <!-- MAIN SETTINGS CONTENT -->
        <div class="col-lg-9">

            <!-- SECTION: PROFILE -->
            <div class="settings-section active" id="profile">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Informations du profil</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.settings.profile.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Avatar -->
                            <div class="text-center mb-4">
                                <div class="position-relative d-inline-block">
                                    @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                        class="rounded-circle border"
                                        style="width: 120px; height: 120px; object-fit: cover;" id="avatarPreview">
                                    @else
                                    <div class="avatar-circle mx-auto bg-primary-soft text-primary"
                                        style="width: 120px; height: 120px; font-size: 48px;" id="avatarPlaceholder">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <img src="" class="rounded-circle border d-none"
                                        style="width: 120px; height: 120px; object-fit: cover;" id="avatarPreview">
                                    @endif
                                    <label for="avatarInput"
                                        class="position-absolute bottom-0 end-0 btn btn-primary btn-sm rounded-circle"
                                        style="width: 36px; height: 28px; padding: 0;">
                                        <i class="bi bi-camera"></i>
                                    </label>
                                    <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*">
                                </div>
                                <p class="text-muted small mt-2">JPG, PNG max 2MB</p>
                            </div>

                            <!-- Personal Info -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Prénom</label>
                                    <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nom</label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ Auth::user()->last_name }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ Auth::user()->email }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Téléphone</label>
                                    <input type="tel" class="form-control" name="phone"
                                        value="{{ Auth::user()->phone }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Biographie</label>
                                    <textarea class="form-control" name="bio" rows="4"
                                        placeholder="Parlez-nous de vous...">{{ Auth::user()->bio ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SECTION: ACCOUNT SECURITY -->
            <div class="settings-section" id="account">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Sécurité du compte</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Change Password -->
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Changer le mot de passe</h6>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Mot de passe actuel</label>
                                        <input type="password" class="form-control" name="current_password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nouveau mot de passe</label>
                                        <input type="password" class="form-control" name="new_password" required>
                                        <small class="text-muted">Min. 8 caractères</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Confirmer le mot de passe</label>
                                        <input type="password" class="form-control" name="new_password_confirmation"
                                            required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Mettre à jour le mot de passe
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <!-- Two-Factor Authentication -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Authentification à deux facteurs</h6>

                            @if(Auth::user()->two_factor_secret)
                            <!-- 2FA Activée -->
                            <div class="alert alert-success">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-check fs-4 me-3"></i>
                                    <div class="flex-grow-1">
                                        <strong>2FA activée</strong>
                                        <p class="mb-0 small">Votre compte est protégé par l'authentification à deux
                                            facteurs.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Codes de récupération après régénération -->
                            @if(session('recoveryCodes'))
                            <div class="alert alert-warning">
                                <h6 class="fw-bold">Codes de récupération</h6>
                                <p class="small mb-2">Conservez ces codes dans un endroit sûr.</p>
                                <div class="bg-white p-3 rounded" id="recoveryCodesContainer">
                                    @php
                                    $codes = is_array(session('recoveryCodes'))
                                    ? session('recoveryCodes')
                                    : json_decode(session('recoveryCodes'), true);
                                    @endphp
                                    @foreach($codes as $code)
                                    <code class="d-block mb-1">{{ $code }}</code>
                                    @endforeach
                                </div>
                                <button class="btn btn-sm btn-outline-primary mt-2" onclick="copyRecoveryCodes()">
                                    <i class="bi bi-clipboard me-1"></i>Copier
                                </button>
                            </div>
                            @endif

                            <!-- Actions -->
                            <div class="d-flex gap-2 mt-3">
                                <form action="{{ route('admin.settings.2fa.recovery') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-arrow-repeat me-1"></i>
                                        Régénérer codes
                                    </button>
                                </form>

                                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#disable2FAModal">
                                    <i class="bi bi-shield-x me-1"></i>
                                    Désactiver 2FA
                                </button>
                            </div>

                            @else
                            <!-- 2FA Désactivée -->
                            <div class="alert alert-warning">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-shield-exclamation fs-4 me-3"></i>
                                    <div class="flex-grow-1">
                                        <strong>2FA désactivée</strong>
                                        <p class="mb-0 small">Activez la double authentification pour renforcer la
                                            sécurité.</p>
                                    </div>
                                    <form action="{{ route('admin.settings.2fa.enable') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Activer</button>
                                    </form>
                                </div>
                            </div>

                            <!-- QR Code affiché après activation -->
                            @if(session('qrCode'))
                            <div class="alert alert-info mt-3">
                                <h6 class="fw-bold mb-3">Scannez ce QR code</h6>
                                <div class="text-center mb-3">
                                    <div class="p-3 bg-white d-inline-block rounded">
                                        {!! session('qrCode') !!}
                                    </div>
                                </div>

                                <form action="{{ route('admin.settings.2fa.confirm') }}" method="POST">
                                    @csrf
                                    <label class="form-label fw-semibold">Entrez le code à 6 chiffres pour confirmer
                                        :</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control text-center" name="code"
                                            placeholder="000000" maxlength="6" required
                                            style="font-size: 1.5rem; letter-spacing: 0.5rem;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle me-1"></i>Confirmer
                                        </button>
                                    </div>
                                </form>

                                <!-- Codes de récupération initiaux -->
                                @if(session('recoveryCodes'))
                                <div class="bg-light p-3 rounded mt-3">
                                    <h6 class="fw-bold small">Codes de récupération (à sauvegarder maintenant)</h6>
                                    <div id="recoveryCodesContainer">
                                        @php
                                        $codes = is_array(session('recoveryCodes'))
                                        ? session('recoveryCodes')
                                        : json_decode(session('recoveryCodes'), true);
                                        @endphp
                                        @foreach($codes as $code)
                                        <code class="d-block small">{{ $code }}</code>
                                        @endforeach
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary mt-2" onclick="copyRecoveryCodes()">
                                        <i class="bi bi-clipboard me-1"></i>Copier
                                    </button>
                                </div>
                                @endif
                            </div>
                            @endif
                            @endif
                        </div>

                        <!-- Modal Désactiver 2FA (reste inchangé) -->
                        <div class="modal fade" id="disable2FAModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    {{-- Dans le modal disable2FAModal --}}
                                    <form action="{{ route('admin.settings.2fa.disable') }}" method="POST">
                                        @csrf
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Désactiver 2FA</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-muted">Pour désactiver, confirmez votre mot de passe.</p>
                                            <input type="password"
                                                class="form-control @error('password', 'disable2FA') is-invalid @enderror"
                                                name="password" required>
                                            {{-- Afficher l'erreur du bon error bag --}}
                                            @error('password', 'disable2FA')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-danger">Désactiver</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Active Sessions -->
                        <div>
                            <h6 class="fw-bold mb-3">Sessions actives</h6>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-laptop fs-5 text-primary"></i>
                                            <div>
                                                <div class="fw-semibold">Windows • Chrome</div>
                                                <small class="text-muted">Paris, France • Actuelle</small>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="badge bg-success">Active</span>
                                </div>
                            </div>
                            <button class="btn btn-outline-danger btn-sm mt-3">
                                <i class="bi bi-x-circle me-2"></i>
                                Déconnecter toutes les autres sessions
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION: NOTIFICATIONS -->
            <div class="settings-section" id="notifications">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Préférences de notifications</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.settings.notifications.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Email Notifications -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Notifications par email</h6>
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-semibold">Nouvelles demandes de location</div>
                                                <small class="text-muted">Recevoir un email pour chaque nouvelle
                                                    demande</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    name="email_rent_applications" checked>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-semibold">Nouvelles transactions</div>
                                                <small class="text-muted">Notifications lors de nouvelles ventes ou
                                                    locations</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    name="email_transactions" checked>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-semibold">Messages clients</div>
                                                <small class="text-muted">Recevoir les messages de vos clients</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="email_messages"
                                                    checked>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-semibold">Newsletter</div>
                                                <small class="text-muted">Actualités et conseils immobiliers</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="email_newsletter">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Push Notifications -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Notifications push</h6>
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-semibold">Activités importantes</div>
                                                <small class="text-muted">Ventes, locations, demandes urgentes</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="push_important"
                                                    checked>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-semibold">Rappels</div>
                                                <small class="text-muted">Rendez-vous, tâches à faire</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="push_reminders"
                                                    checked>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Enregistrer les préférences
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SECTION: PREFERENCES -->
            <div class="settings-section" id="preferences">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Préférences générales</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.settings.preferences.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Language & Region -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Langue</label>
                                    <select class="form-select" name="language">
                                        <option value="fr" selected>Français</option>
                                        <option value="en">English</option>
                                        <option value="es">Español</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Fuseau horaire</label>
                                    <select class="form-select" name="timezone">
                                        <option value="Europe/Paris" selected>Paris (GMT+1)</option>
                                        <option value="America/New_York">New York (GMT-5)</option>
                                        <option value="Asia/Tokyo">Tokyo (GMT+9)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Devise</label>
                                    <select class="form-select" name="currency">
                                        <option value="USD" selected>USD ($)</option>
                                        <option value="EUR">EUR (€)</option>
                                        <option value="GBP">GBP (£)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Format de date</label>
                                    <select class="form-select" name="date_format">
                                        <option value="d/m/Y" selected>DD/MM/YYYY</option>
                                        <option value="m/d/Y">MM/DD/YYYY</option>
                                        <option value="Y-m-d">YYYY-MM-DD</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Display Preferences -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Affichage</h6>
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-semibold">Mode sombre</div>
                                                <small class="text-muted">Basculer vers un thème sombre</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="dark_mode">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-semibold">Vue compacte</div>
                                                <small class="text-muted">Réduire les espacements pour plus de
                                                    contenu</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="compact_view">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Enregistrer les préférences
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- SECTION: SYSTEM (Admin only) -->
            @if(Auth::user()->role === 'admin')
            <div class="settings-section" id="system">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">Paramètres système</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- System Info -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Informations système</h6>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted">Version de l'application</td>
                                            <td class="fw-semibold">1.0.0</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Laravel</td>
                                            <td class="fw-semibold">{{ app()->version() }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">PHP</td>
                                            <td class="fw-semibold">{{ phpversion() }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Base de données</td>
                                            <td class="fw-semibold">MySQL</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Maintenance -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Maintenance</h6>
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-outline-primary" onclick="clearCache()">
                                    <i class="bi bi-arrow-clockwise me-2"></i>
                                    Vider le cache
                                </button>
                                <button class="btn btn-outline-warning" onclick="optimizeDatabase()">
                                    <i class="bi bi-database me-2"></i>
                                    Optimiser la base
                                </button>
                                <button class="btn btn-outline-info">
                                    <i class="bi bi-download me-2"></i>
                                    Sauvegarde
                                </button>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Danger Zone -->
                        <div>
                            <h6 class="fw-bold text-danger mb-3">Zone de danger</h6>
                            <div class="alert alert-danger">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-semibold">Supprimer toutes les données</div>
                                        <small>Cette action est irréversible</small>
                                    </div>
                                    <button class="btn btn-danger btn-sm" onclick="confirmDeleteAll()">
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>

@push('styles')
<style>
.settings-nav .nav-link {
    color: var(--text-muted);
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    transition: var(--transition);
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.settings-nav .nav-link:hover {
    background-color: var(--primary-soft);
    color: var(--primary);
}

.settings-nav .nav-link.active {
    background-color: var(--primary-soft);
    color: var(--primary);
}

.settings-section {
    display: none;
}

.settings-section.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.list-group-item {
    border: 1px solid var(--border);
    margin-bottom: 0.5rem;
    border-radius: 0.5rem !important;
}

.form-switch .form-check-input {
    width: 3rem;
    height: 1.5rem;
    cursor: pointer;
}
</style>
@endpush

@push('scripts')
<script>
// Navigation between sections
document.querySelectorAll('.settings-nav .nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();

        // Remove active class from all links and sections
        document.querySelectorAll('.settings-nav .nav-link').forEach(l => l.classList.remove('active'));
        document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));

        // Add active class to clicked link
        this.classList.add('active');

        // Show corresponding section
        const section = this.dataset.section;
        document.getElementById(section).classList.add('active');

        // Update URL hash
        window.location.hash = section;
    });
});

// Handle page load with hash
window.addEventListener('load', function() {
    const hash = window.location.hash.replace('#', '');
    if (hash) {
        const link = document.querySelector(`.settings-nav .nav-link[data-section="${hash}"]`);
        if (link) link.click();
    }
});

// Avatar preview
document.getElementById('avatarInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new window.FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            const placeholder = document.getElementById('avatarPlaceholder');

            preview.src = e.target.result;
            preview.classList.remove('d-none');

            if (placeholder) {
                placeholder.classList.add('d-none');
            }
        };
        reader.readAsDataURL(file);
    }
});

// Copier les codes de récupération
function copyRecoveryCodes() {
    const container = document.getElementById('recoveryCodesContainer');
    const codes = Array.from(container.querySelectorAll('code'))
        .map(el => el.textContent)
        .join('\n');

    navigator.clipboard.writeText(codes).then(() => {
        alert('Codes copiés dans le presse-papiers !');
    });
}

// System functions
function clearCache() {
    if (confirm('Vider le cache de l\'application ?')) {
        // Implement cache clearing
        alert('Cache vidé avec succès !');
    }
}

function optimizeDatabase() {
    if (confirm('Optimiser la base de données ?')) {
        // Implement database optimization
        alert('Base de données optimisée !');
    }
}

function confirmDeleteAll() {
    if (confirm(' ATTENTION : Cette action supprimera TOUTES les données. Êtes-vous absolument sûr ?')) {
        if (prompt('Tapez "DELETE" pour confirmer') === 'DELETE') {
            // Implement deletion
            alert('Action annulée pour des raisons de sécurité');
        }
    }
}
</script>
@endpush
@endsection