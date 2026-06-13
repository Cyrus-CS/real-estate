<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;

class SettingsController extends Controller
{
    /**
     * Résoudre l'utilisateur authentifié avec le bon type.
     * Évite la répétition et corrige les erreurs d'inférence de type.
     */
    private function resolveUser()
    {
        /** @var User $user */
        $user = Auth::user();

        abort_if($user === null, 401);

        return $user;
    }

    /**
     * Afficher la page des paramètres
     */
    public function index()
    {
        return view('admin.settings', [
            'user' => $this->resolveUser()
        ]);
    }

    /**
     * Mettre à jour le profil de l'utilisateur
     */
    public function updateProfile(Request $request)
    {
        $user = $this->resolveUser();

        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'     => ['nullable', 'string', 'max:20'],
            'bio'       => ['nullable', 'string', 'max:1000'],
            'avatar'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Upload de l'avatar
        if ($request->hasFile('avatar')) {
            // Supprimer l'ancien avatar
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Stocker le nouveau
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        $user->update($validated);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $user = $this->resolveUser();

        $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'new_password'     => ['required', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()
            ],
        ], [
            'current_password.required' => 'Le mot de passe actuel est obligatoire.',
            'new_password.required'     => 'Le nouveau mot de passe est obligatoire.',
            'new_password.confirmed'    => 'Les mots de passe ne correspondent pas.',
        ]);

        $user->forceFill([
            'password' => Hash::make($request->new_password),
        ])->save();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Mot de passe mis à jour avec succès.');
    }

    /**
     * Mettre à jour les préférences de notifications
     */
    public function updateNotifications(Request $request)
    {
        $user = $this->resolveUser();

        $validated = $request->validate([
            'email_rent_applications' => ['nullable', 'boolean'],
            'email_transactions'      => ['nullable', 'boolean'],
            'email_messages'          => ['nullable', 'boolean'],
            'email_newsletter'        => ['nullable', 'boolean'],
            'push_important'          => ['nullable', 'boolean'],
            'push_reminders'          => ['nullable', 'boolean'],
        ]);

        // Normaliser les valeurs null en false
        $notifications = array_map(fn($value) => (bool) $value, $validated);

        $user->update([
            'notification_preferences' => $notifications // cast 'json' dans le modèle, pas besoin de json_encode
        ]);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Préférences de notifications mises à jour.');
    }

    /**
     * Mettre à jour les préférences générales
     */
    public function updatePreferences(Request $request)
    {
        $user = $this->resolveUser();

        $validated = $request->validate([
            'language'    => ['required', 'string', 'in:fr,en,es'],
            'timezone'    => ['required', 'string'],
            'currency'    => ['required', 'string', 'in:USD,EUR,GBP'],
            'date_format' => ['required', 'string', 'in:d/m/Y,m/d/Y,Y-m-d'],
            'dark_mode'   => ['nullable', 'boolean'],
            'compact_view'=> ['nullable', 'boolean'],
        ]);

        $preferences = [
            'language'     => $validated['language'],
            'timezone'     => $validated['timezone'],
            'currency'     => $validated['currency'],
            'date_format'  => $validated['date_format'],
            'dark_mode'    => $request->boolean('dark_mode'),
            'compact_view' => $request->boolean('compact_view'),
        ];

        $user->update([
            'preferences' => $preferences // cast 'json' gère la sérialisation
        ]);

        app()->setLocale($preferences['language']);
        session(['locale' => $preferences['language']]);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Préférences mises à jour avec succès.');
    }

    /**
     * Supprimer l'avatar
     */
    public function deleteAvatar()
    {
        $user = $this->resolveUser();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);

            return redirect()
                ->route('admin.settings.index')
                ->with('success', 'Avatar supprimé avec succès.');
        }

        return back()->with('error', 'Aucun avatar à supprimer.');
    }

    /**
     * Activer l'authentification à deux facteurs
     */
    public function enable2FA(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->two_factor_secret) {
            return back()->with('error', '2FA est déjà activée.');
        }

        app(EnableTwoFactorAuthentication::class)($user);

        // Session persistante au lieu de flash
        session([
            'two_factor_qr_code'      => $user->twoFactorQrCodeSvg(),
            'two_factor_setup_codes'  => json_decode(
                decrypt($user->two_factor_recovery_codes), true
            ),
        ]);

        return redirect()->route('admin.settings.2fa.setup');
    }

    public function show2FASetup()
    {
        // Rediriger si pas de session setup (accès direct à l'URL)
        if (!session('two_factor_qr_code')) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Session expirée, réactivez la 2FA.');
        }

        return view('admin.auth.2fa-setup', [
            'qrCode'        => session('two_factor_qr_code'),
            'recoveryCodes' => session('two_factor_setup_codes'),
        ]);
    }

    /**
     * Confirmer l'activation de 2FA avec code OTP
     */
    public function confirm2FA(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!$user->two_factor_secret) {
            return back()->withErrors(['code' => '2FA n\'est pas activée.']);
        }

        try {
            app(\Laravel\Fortify\Actions\ConfirmTwoFactorAuthentication::class)($user, $request->code);
        } catch (\Exception $e) {
            return back()->withErrors(['code' => 'Code invalide. Vérifiez l\'heure de votre appareil.']);
        }

        // Vider la session setup
        session()->forget(['two_factor_qr_code', 'two_factor_setup_codes']);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', '2FA activée et confirmée avec succès. ');
    }

    /**
     * Désactiver l'authentification à deux facteurs
     */
    public function disable2FA(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->two_factor_secret) {
            return back()->with('error', '2FA n\'est pas activée.');
        }

        app(DisableTwoFactorAuthentication::class)($user);

        return back()->with('success', '2FA désactivée avec succès.');
    }

    /**
     * Régénérer les codes de récupération
     */
    public function regenerateRecoveryCodes(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->two_factor_secret) {
            return back()->with('error', '2FA n\'est pas activée.');
        }

        // Régénérer les codes
        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode(
                \Laravel\Fortify\RecoveryCode::generate()
            )),
        ])->save();

        // Recharger le user depuis la DB
        $user->refresh();

        // Décoder correctement les codes
        $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);

        return back()->with([
            'success' => 'Codes de récupération régénérés.',
            'recoveryCodes' => $recoveryCodes,
        ]);
    }
    

    /**
     * Déconnecter toutes les autres sessions
     */
    public function logoutOtherSessions(Request $request)
    {
        $request->validateWithBag('logoutSessions', [
            'password' => ['required', 'current_password'],
        ]);

        Auth::logoutOtherDevices($request->password);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Toutes les autres sessions ont été déconnectées.');
    }

    /**
     * Vider le cache, Admin uniquement
     */
    public function clearCache()
    {
        abort_unless($this->resolveUser()->isAdmin(), 403, 'Accès non autorisé.');

        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return response()->json([
            'success' => true,
            'message' => 'Cache vidé avec succès.'
        ]);
    }

    /**
     * Optimiser l'application — Admin uniquement
     * CORRECTION : db:seed retiré (dangereux en production)
     */
    public function optimizeDatabase()
    {
        abort_unless($this->resolveUser()->isAdmin(), 403, 'Accès non autorisé.');

        Artisan::call('optimize');

        return response()->json([
            'success' => true,
            'message' => 'Application optimisée.'
        ]);
    }

    /**
     * Créer une sauvegarde — Admin uniquement
     */
    public function createBackup()
    {
        abort_unless($this->resolveUser()->isAdmin(), 403, 'Accès non autorisé.');

        // Décommenter après avoir installé spatie/laravel-backup : composer require spatie/laravel-backup
        Artisan::call('backup:run');

        return response()->json([
            'success' => true,
            'message' => 'Sauvegarde créée avec succès.'
        ]);
    }

    /**
     * Exporter les données utilisateur (RGPD)
     */
    public function exportData()
    {
        $user = $this->resolveUser();

        $data = [
            'profile'    => $user->toArray(),
            'properties' => $user->properties()->get()->toArray(),
        ];

        $fileName = 'user_data_' . $user->id . '_' . now()->format('Y-m-d') . '.json';

        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    /**
     * Supprimer le compte utilisateur
     */
    public function deleteAccount(Request $request)
    {
        $request->validateWithBag('deleteAccount', [
            'password'     => ['required', 'current_password'],
            'confirmation' => ['required', 'string', 'in:DELETE'],
        ]);

        $user = $this->resolveUser();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();
        $user->delete();

        return redirect()
            ->route('home')
            ->with('success', 'Votre compte a été supprimé avec succès.');
    }

}