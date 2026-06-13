@component('mail::message')

{{-- Header visuel --}}
<div style="text-align:center;margin-bottom:2rem">
    <div style="display:inline-flex;align-items:center;gap:.5rem;margin-bottom:.5rem">
        <span style="font-size:1.4rem">🏠</span>
        <span style="font-size:1.2rem;font-weight:800;color:#1A1A2E;letter-spacing:-.02em">EstateVista</span>
    </div>
    <p style="font-size:.78rem;color:#8A8FA8;margin:0;text-transform:uppercase;letter-spacing:.1em">
        Nouveau message de contact
    </p>
</div>

{{-- Badge sujet --}}
@if(!empty($data['subject']))
<div style="text-align:center;margin-bottom:1.5rem">
    <span
        style="display:inline-block;background:#EDE8FF;color:#6C3AFF;font-size:.75rem;font-weight:700;padding:.3rem .9rem;border-radius:100px;letter-spacing:.06em;text-transform:uppercase">
        📋 {{ ucfirst($data['subject']) }}
    </span>
</div>
@endif

{{-- Intro --}}
Bonjour,

Vous avez reçu un nouveau message via le formulaire de contact d'**EstateVista**. Voici les détails :

---

{{-- Infos expéditeur --}}
@component('mail::panel')
**👤 Informations de l'expéditeur**

| Champ | Valeur |
|-------|--------|
| **Prénom** | {{ $data['first_name'] }} |
| **Nom** | {{ $data['last_name'] }} |
| **Email** | {{ $data['email'] }} |
@if(!empty($data['phone']))
| **Téléphone** | {{ $data['phone'] }} |
@endif
@if(!empty($data['budget']))
| **Budget estimé** | {{ $data['budget'] }} |
@endif
@if(!empty($data['subject']))
| **Sujet** | {{ ucfirst($data['subject']) }} |
@endif
@endcomponent

---

**💬 Message :**

{{ $data['message'] }}

---

@if(!empty($data['newsletter']) && $data['newsletter'])
> 📧 Cette personne souhaite recevoir vos alertes et nouveautés immobilières.
@endif

{{-- CTA répondre --}}
@component('mail::button', ['url' => 'mailto:' . $data['email'], 'color' => 'primary'])
Répondre à {{ $data['first_name'] }}
@endcomponent

---

<div style="font-size:.75rem;color:#B4B9CC;text-align:center;margin-top:1rem">
    Ce message a été envoyé depuis le formulaire de contact d'EstateVista.<br>
    Reçu le {{ now()->format('d/m/Y à H\hi') }}
</div>

@endcomponent