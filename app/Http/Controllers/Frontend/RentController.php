<?php
// app/Http/Controllers/Frontend/RentController.php

namespace App\Http\Controllers\Frontend;

use App\Enums\PropertyStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRentRequest;
use App\Models\Property;
use App\Models\Rent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RentController extends Controller
{
    public function store(StoreRentRequest $request, Property $property): RedirectResponse
    {
        // Vérifier que la propriété est bien for_rent
        if ($property->status->value !== PropertyStatus::FOR_RENT->value) {
            return back()->with('error', 'Ce bien n\'est pas disponible à la location.');
        }

        // Vérifier qu'il n'y a pas déjà une demande pending/under_review/approved
        $existing = Rent::where('property_id', $property->id)
            ->where('applicant_id', Auth::id())
            ->whereIn('status', ['pending', 'under_review', 'approved'])
            ->exists();

        if ($existing) {
            return back()->with('error', 'Vous avez déjà une demande en cours pour ce bien.');
        }

        Rent::create([
            'property_id'           => $property->id,
            'applicant_id'          => Auth::id(),
            'status'                => 'pending',
            'message'               => $request->message,
            'desired_move_in'       => $request->desired_move_in,
            'lease_duration_months' => $request->lease_duration_months,
        ]);

        return redirect()
            ->route('properties.show', $property)
            ->with('success', 'Votre demande de location a bien été envoyée. Un agent vous contactera bientôt.');
    }
}