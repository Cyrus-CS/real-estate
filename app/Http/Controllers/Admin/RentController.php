<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Property;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAgent = $user->role === 'agent';

        if ($isAgent) {
            $agent = Agent::where('user_id', $user->id)->firstOrFail();
            
            $applications = Rent::with(['applicant', 'property'])
                ->whereHas('property', function($q) use ($agent) {
                    $q->where('agent_id', $agent->id);
                })
                ->latest()
                ->get();
        } else {
            $applications = Rent::with(['applicant', 'property'])->latest()->get();
        }
        
        return view('admin.rents.index', [
            'applications' => $applications,
            'totalApplications' => $applications->count(),
            'pendingApplications' => $applications->where('status', 'pending')->count(),
            'approvedApplications' => $applications->where('status', 'approved')->count(),
            'underReviewApplications' => $applications->where('status', 'under_review')->count(),
            'properties' => Property::all(),
        ]);
    }

    public function update(Request $request, Rent $application)
    {
         // Admin OU l'agent propriétaire du bien peuvent approuver
        /**
         * @var User $user
         */
        $user = Auth::user();

        $isAdmin  = $user->role === 'admin';
        $isOwnerAgent  = $user->role === 'agent'
                        && $application->property->agent->user_id === $user->id;

        if (!$isAdmin && !$isOwnerAgent) {
            abort(403, 'Action non autorisée.');
        }
        
        $validated = $request->validate([
            'status'           => 'required|in:pending,under_review,approved,rejected,cancelled',
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $application->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['rejection_reason'] ?? null,
            'reviewed_at'      => now(),
            'reviewed_by'      => $user->id,
        ]);

         // Si approuvé → créer automatiquement la transaction
        if ($validated['status'] === 'approved') {
            \App\Models\Transaction::create([
                'reference'        => 'TXN-'.strtoupper(uniqid()),
                'property_id'      => $application->property_id,
                'buyer_id'         => $application->applicant_id,
                'agent_id'         => $application->property->agent->id,
                'rent_id'          => $application->id,
                'transaction_type' => 'rent',
                'status'           => 'pending',
                'amount_cents'     => $application->property->price * 100,
                'currency'         => 'USD',
            ]);

            // Mettre le bien en "rented"
            $application->property->update(['status' => 'rented']);
        }

        return redirect()->route('admin.applications.index')
            ->with('success', 'Demande mise à jour avec succès');
    }
}