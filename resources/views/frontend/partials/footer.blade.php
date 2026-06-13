<footer class="main-footer">
    <!-- Main Footer Content -->
    <div class="footer-main">
        <div class="container">
            <div class="row g-4">
                <!-- About Column -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand mb-4">
                        <i class="bi bi-building brand-icon"></i>
                        <span class="brand-text">EstateVista</span>
                    </div>
                    <p class="footer-desc">
                        Votre partenaire de confiance pour trouver la propriété de vos rêves.
                        Nous offrons des services immobiliers premium avec une expertise locale inégalée.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Navigation</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                        <li><a href="{{ route('properties.index') }}">Propriétés</a></li>
                        <li><a href="{{ route('about') }}">À propos</a></li>
                        <li><a href="{{ route('agents.index') }}">Nos agents</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Services</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('properties.index', ['status' => 'for_sale']) }}">Vente</a></li>
                        <li><a href="{{ route('properties.index', ['status' => 'for_rent']) }}">Location</a></li>
                        <li><a href="{{ route('properties.featured') }}">Propriétés vedettes</a></li>
                        <li><a href="{{ route('valuation') }}">Estimation gratuite</a></li>
                        <li><a href="{{ route('mortgage') }}">Calculateur hypothécaire</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-title">Contactez-nous</h5>
                    <ul class="contact-info">
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <span>157 West 57th Street<br>New York, NY 10019</span>
                        </li>
                        <li>
                            <i class="bi bi-telephone"></i>
                            <a href="tel:+12120000001">+1 (212) 000-0001</a>
                        </li>
                        <li>
                            <i class="bi bi-envelope"></i>
                            <a href="mailto:contact@estatevista.com">contact@estatevista.com</a>
                        </li>
                        <li>
                            <i class="bi bi-clock"></i>
                            <span>Lun - Ven: 9h - 18h<br>Sam: 10h - 16h</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="footer-newsletter">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <h4 class="newsletter-title">Restez informé</h4>
                    <p class="newsletter-desc mb-0">Recevez nos dernières propriétés directement dans votre boîte mail
                    </p>
                </div>
                <div class="col-lg-6">
                    <form class="newsletter-form" id="newsletterForm">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Votre adresse email" required>
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-send me-2"></i>
                                S'abonner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <p class="mb-0">&copy; {{ date('Y') }} EstateVista. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="footer-legal">Confidentialité</a>
                    <span class="mx-2">•</span>
                    <a href="#" class="footer-legal">Conditions d'utilisation</a>
                    <span class="mx-2">•</span>
                    <a href="#" class="footer-legal">Cookies</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
        <i class="bi bi-arrow-up"></i>
    </button>
</footer>