<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    // public function registerAsBuyer(Request $request): RedirectResponse
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'role' => 'buyer'
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirection vers l'accueil pour les buyers
        return redirect()->route('home.index')->with('success', 'Bienvenue ! Votre compte a été créé.');
    }

    public function registerAsAgent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'agency_name' => 'required|string|max:255',
            'license_number' => 'required|string|max:50|unique:agents',
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'role' => 'agent', // Rôle agent
        ]);

        // Créer le profil agent
        Agent::create([
            'user_id' => $user->id,
            'agency_name' => $validated['agency_name'],
            'license_number' => $validated['license_number'],
            'commission_rate' => 5.00, // Taux par défaut
            'is_active' => false, //  En attente de validation admin
            'bio' => null,
        ]);

        // Envoyer email de vérification
        event(new Registered($user));

        // Connexion automatique
        Auth::login($user);

        // Redirection vers le dashboard agent avec message
        return redirect()
            ->route('admin.dashboard')
            ->with('warning', 'Votre compte agent est en attente de validation. Veuillez vérifier votre email.');
    }
}