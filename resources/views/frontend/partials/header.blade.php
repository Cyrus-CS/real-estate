@php
use Illuminate\Support\Facades\Auth;
@endphp
<header class="main-header">
    <!-- Top Bar (optionnel) -->
    <div class="top-bar d-none d-lg-block">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-2">
                <div class="top-bar-left">
                    <a href="tel:+12120000001" class="text-decoration-none me-4">
                        <i class="bi bi-telephone me-2"></i>
                        +1 (212) 000-0001
                    </a>
                    <a href="mailto:contact@estatevista.com" class="text-decoration-none">
                        <i class="bi bi-envelope me-2"></i>
                        contact@estatevista.com
                    </a>
                </div>
                <div class="top-bar-right">
                    <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="social-link"><i class="bi bi-twitter-x"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand logo" href="{{ route('home') }}">
                <i class="bi bi-building brand-icon"></i>
                <span class="brand-text">Estate Vista</span>
            </a>

            <!-- Mobile Menu Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Desktop Menu -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Propriétés
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('properties.index') }}">Toutes les
                                    propriétés</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('properties.index', ['status' => 'for_sale']) }}">À vendre</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('properties.index', ['status' => 'for_rent']) }}">À louer</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('properties.featured') }}">Propriétés
                                    vedettes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agents.index') }}">Nos agents</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>

                <!-- CTA Buttons -->
                <div class="d-flex align-items-center gap-3">
                    @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'agent')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                    @endif

                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-2"></i>
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @auth
                            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'agent')
                            <a href="{{ route('admin.settings.index') }}" class="dropdown-item">
                                Mon profil
                            </a>
                            @endif
                            @endauth
                            <li><a class="dropdown-item" href="{{ route('favorites') }}">Mes favoris</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Connexion
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="bi bi-person-plus me-2"></i>Inscription
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Offcanvas Menu -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <i class="bi bi-building me-2 text-primary"></i>
                EstateVista
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('properties.index') }}">Propriétés</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('agents.index') }}">Nos agents</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>

            <hr>

            @auth
            <div class="d-grid gap-2">
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'agent')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                @endif
                <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">Mon profil</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100">Déconnexion</button>
                </form>
            </div>
            @else
            <div class="d-grid gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Connexion</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
            </div>
            @endauth
        </div>
    </div>
</header>