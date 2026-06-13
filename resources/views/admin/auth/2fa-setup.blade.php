<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification à deux facteurs - EstateVista</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    :root {
        --primary: #6C3AFF;
        --primary-soft: #EDE8FF;
        --primary-hover: #5628E8;
        --surface: #F4F5F7;
        --white: #FFFFFF;
        --text-main: #1A1A2E;
        --text-muted: #8A8FA8;
        --border: #ECEEF4;
        --shadow-card: 0 2px 12px rgba(108, 58, 255, .08);
        --shadow-lg: 0 20px 60px rgba(108, 58, 255, .15);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: linear-gradient(135deg, var(--primary) 0%, #8B5CFF 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .auth-container {
        width: 100%;
        max-width: 480px;
        animation: slideUp 0.5s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .auth-card {
        background: var(--white);
        border-radius: 24px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .auth-header {
        text-align: center;
        padding: 3rem 2rem 2rem;
        background: linear-gradient(135deg, var(--primary-soft) 0%, #f8f6ff 100%);
    }

    .auth-icon {
        width: 80px;
        height: 80px;
        background: var(--primary);
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 20px rgba(108, 58, 255, .3);
    }

    .auth-icon i {
        font-size: 2.5rem;
        color: white;
    }

    .auth-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .auth-subtitle {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .auth-body {
        padding: 2rem;
    }

    .code-input-wrapper {
        margin: 2rem 0;
    }

    .code-input {
        width: 100%;
        text-align: center;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: 1rem;
        padding: 1rem;
        border: 2px solid var(--border);
        border-radius: 16px;
        transition: all 0.3s ease;
        font-family: 'Courier New', monospace;
    }

    .code-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(108, 58, 255, .1);
        background: var(--primary-soft);
    }

    .recovery-input {
        font-family: 'Courier New', monospace;
        font-size: 1rem;
        letter-spacing: 0.2rem;
        text-align: center;
    }

    .recovery-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(108, 58, 255, .1);
    }

    .btn-primary {
        background: var(--primary);
        border: none;
        border-radius: 12px;
        padding: 0.875rem 1.5rem;
        font-weight: 600;
        font-size: 1rem;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(108, 58, 255, .2);
    }

    .btn-primary:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(108, 58, 255, .3);
    }

    .btn-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .btn-link:hover {
        color: var(--primary-hover);
        text-decoration: underline;
    }

    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 1.5rem 0;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid var(--border);
    }

    .divider span {
        padding: 0 1rem;
    }

    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.25rem;
    }

    .alert-danger {
        background: #FEE;
        color: #C33;
    }

    .info-box {
        background: var(--surface);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1.5rem;
        display: flex;
        align-items: start;
        gap: 0.75rem;
    }

    .info-box i {
        color: var(--primary);
        font-size: 1.25rem;
        margin-top: 0.25rem;
    }

    .info-box p {
        margin: 0;
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .back-link {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border);
    }

    .back-link a {
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.2s ease;
    }

    .back-link a:hover {
        color: var(--primary);
    }

    .spinner-border {
        width: 1.5rem;
        height: 1.5rem;
        border-width: 2px;
    }

    @media (max-width: 576px) {
        .auth-header {
            padding: 2rem 1.5rem 1.5rem;
        }

        .auth-title {
            font-size: 1.5rem;
        }

        .code-input {
            font-size: 1.5rem;
            letter-spacing: 0.75rem;
        }

        .auth-body {
            padding: 1.5rem;
        }
    }
    </style>
</head>

<body>

    <div class="auth-container">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="auth-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <h1 class="auth-title">Authentification requise</h1>
                <p class="auth-subtitle">
                    Veuillez entrer le code à 6 chiffres généré par votre application d'authentification
                </p>
            </div>

            <!-- Body -->
            <div class="auth-body">
                <!-- Errors -->
                @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                        {{ $error }}
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Code Form -->
                <div id="codeForm">
                    <form method="POST" action="{{ route('two-factor.login') }}">
                        @csrf

                        <div class="code-input-wrapper">
                            <input type="text" class="form-control code-input" id="code" name="code"
                                placeholder="000000" maxlength="6" pattern="[0-9]{6}" inputmode="numeric"
                                autocomplete="one-time-code" autofocus required>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <span id="btnText">
                                <i class="bi bi-check-circle me-2"></i>
                                Vérifier le code
                            </span>
                            <span id="btnSpinner" class="d-none">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Vérification...
                            </span>
                        </button>
                    </form>

                    <div class="divider">
                        <span>Vous n'avez pas accès à votre appareil ?</span>
                    </div>

                    <button class="btn btn-link w-100" onclick="toggleRecovery()">
                        <i class="bi bi-key me-2"></i>
                        Utiliser un code de récupération
                    </button>
                </div>

                <!-- Recovery Form (Hidden by default) -->
                <div id="recoveryForm" class="d-none">
                    <form method="POST" action="{{ route('two-factor.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="recovery_code" class="form-label fw-semibold">Code de récupération</label>
                            <input type="text" class="form-control recovery-input" id="recovery_code"
                                name="recovery_code" placeholder="xxxx-xxxx-xxxx-xxxx" maxlength="19" required>
                            <small class="text-muted">Entrez l'un de vos codes de récupération</small>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>
                            Utiliser le code de récupération
                        </button>
                    </form>

                    <div class="divider">
                        <span>ou</span>
                    </div>

                    <button class="btn btn-link w-100" onclick="toggleRecovery()">
                        <i class="bi bi-arrow-left me-2"></i>
                        Retour à l'authentification
                    </button>
                </div>

                <!-- Info Box -->
                <div class="info-box">
                    <i class="bi bi-info-circle"></i>
                    <p>
                        <strong>Conseil de sécurité :</strong> Ne partagez jamais vos codes d'authentification.
                        Si vous pensez que votre compte a été compromis, contactez immédiatement le support.
                    </p>
                </div>

                <!-- Back Link -->
                <div class="back-link">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 border-0">
                            <i class="bi bi-arrow-left me-1"></i>
                            Retour à la connexion
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-4">
            <p class="text-white small mb-0">
                <i class="bi bi-shield-check me-1"></i>
                Votre connexion est sécurisée et cryptée
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Auto-focus et auto-submit quand 6 chiffres sont entrés
    const codeInput = document.getElementById('code');

    codeInput.addEventListener('input', function(e) {
        // Garder seulement les chiffres
        this.value = this.value.replace(/[^0-9]/g, '');

        // Auto-submit quand 6 chiffres sont entrés
        if (this.value.length === 6) {
            showLoading();
            setTimeout(() => {
                this.form.submit();
            }, 300);
        }
    });

    // Formater le code de récupération avec tirets
    const recoveryInput = document.getElementById('recovery_code');

    recoveryInput?.addEventListener('input', function(e) {
        let value = this.value.replace(/[^a-zA-Z0-9]/g, '');
        let formatted = value.match(/.{1,4}/g)?.join('-') || value;
        this.value = formatted.substring(0, 19);
    });

    // Toggle entre code et récupération
    function toggleRecovery() {
        const codeForm = document.getElementById('codeForm');
        const recoveryForm = document.getElementById('recoveryForm');

        codeForm.classList.toggle('d-none');
        recoveryForm.classList.toggle('d-none');

        // Focus sur le bon input
        if (recoveryForm.classList.contains('d-none')) {
            codeInput.focus();
        } else {
            recoveryInput.focus();
        }
    }

    // Loading state
    function showLoading() {
        const btnText = document.getElementById('btnText');
        const btnSpinner = document.getElementById('btnSpinner');
        const submitBtn = document.getElementById('submitBtn');

        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');
        submitBtn.disabled = true;
    }

    // Empêcher les espaces
    codeInput.addEventListener('keydown', function(e) {
        if (e.key === ' ') {
            e.preventDefault();
        }
    });

    // Animation au focus
    codeInput.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.02)';
        this.parentElement.style.transition = 'transform 0.2s ease';
    });

    codeInput.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });
    </script>

</body>

</html>