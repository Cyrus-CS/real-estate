# 🏠 EstateVista | Plateforme Immobilière Full-Stack

> Application web immobilière complète développée avec **Laravel 12** et **PHP 8.3**,
> permettant la gestion de biens immobiliers, d'agents, de demandes de location
> et de transactions financières.

---

## 🎯 Objectif

EstateVista est une plateforme **SaaS immobilière** qui connecte acheteurs,
locataires et agents professionnels autour d'un catalogue de biens d'exception.
Elle automatise le cycle complet d'une transaction immobilière : de la recherche
du bien jusqu'à la signature du bail ou de la vente.

---

## ✨ Fonctionnalités principales

### Frontend public
- 🔍 Recherche avancée avec filtres (type, statut, prix, ville, pays, surface)
- 🏡 Catalogue de propriétés paginé avec vue grille/liste
- ⭐ Système de favoris persistants par utilisateur
- 📋 Page détail d'un bien avec galerie, équipements, carte et formulaire de demande
- 👤 Pages agents avec portefeuille et contact direct
- 📬 Formulaire de contact avec envoi de mail (Laravel Mailable)

### Espace acheteur
- 📝 Inscription en tant qu'acheteur avec redirection vers l'accueil
- 💌 Demande de location en ligne avec message et date d'emménagement
- ❤️ Gestion des favoris

### Dashboard agent
- 🏘️ Gestion de ses propriétés (CRUD)
- 📋 Traitement des demandes de location (approbation / rejet)
- 💳 Consultation de ses transactions

### Dashboard administrateur
- 👥 Gestion complète des utilisateurs et agents
- 🏢 Gestion de toutes les propriétés
- 💰 Suivi de toutes les transactions
- ⚙️ Paramètres système et notifications

---

## 🛠️ Stack technique

| Couche | Technologie |
|--------|-------------|
| Backend | Laravel 12, PHP 8.3 |
| Auth | Laravel Breeze + Fortify (2FA) |
| Base de données | MySQL 8 |
| Frontend | Bootstrap 5.3, Bootstrap Icons |
| Animations | GSAP 3 + ScrollTrigger |
| Build | Vite + Laravel Mix |
| Mail | Laravel Mailable (Markdown) |

---

## 🗃️ Architecture de la base de données
