<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PropertyStatus;
use App\Enums\PropertyType;
use App\Http\Controllers\Controller;
use App\Models\Agent;

use App\Models\Property;
use App\Models\Rent;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAgent = $user->role === 'agent';
        $agent = null;

        if ($isAgent) {
            $agent = Agent::where('user_id', $user->id)->firstOrFail();
            
            // Données filtrées pour l'agent
            $properties = Property::with('images')
                ->where('agent_id', $agent->id)
                ->latest()
                ->get();
            
            $totalProperties = $properties->count();
            $soldProperties = $properties->where('status', PropertyStatus::SOLD)->count();
            $rentRequests = Rent::whereHas('property', function($q) use ($agent) {
                $q->where('agent_id', $agent->id);
            })->count();
            
            $totalRevenue = Transaction::whereHas('property', function($q) use ($agent) {
                $q->where('agent_id', $agent->id);
            })->where('status', 'completed')->sum('amount_cents') / 100;
            
        } else {
            // Données globales pour l'admin
            $properties = Property::with('images')->latest()->get();
            
            $totalProperties = $properties->count();
            $soldProperties = $properties->where('status', PropertyStatus::SOLD)->count();
            $rentRequests = Rent::count();
            $totalRevenue = Transaction::where('status', 'completed')->sum('amount_cents') / 100;
        }

        return view('admin.dashboard', [
            'properties' => $properties,
            'totalProperties' => $totalProperties,
            'soldProperties' => $soldProperties,
            'rents' => $rentRequests,
            'totalRevenue' => $totalRevenue,
            'cities' => $properties->pluck('city')->unique()->sort()->values(),
            'types' => PropertyType::toArray(),
            'statuses' => PropertyStatus::toArray(),
            'isAgent' => $isAgent,
            'agent' => $agent,
        ]);
    }
}