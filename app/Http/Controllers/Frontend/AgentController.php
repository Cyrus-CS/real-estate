<?php

// ══════════════════════════════════════════════════════════
// AgentController.php  (Frontend)
// ══════════════════════════════════════════════════════════

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $query = Agent::where('is_active', true)
            ->with('user')
            ->withCount(['properties', 'transactions']);

        // Recherche nom / agence
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%");
            })->orWhere('agency_name', 'like', "%$search%");
        }

        // Ville (via user ou propriétés liées — à adapter selon votre modèle)
        if ($request->filled('city')) {
            $city = $request->city;
            $query->whereHas('properties', function ($q) use ($city) {
                $q->where('city', 'like', "%$city%");
            });
        }

        // Tri
        match ($request->input('sort', 'latest')) {
            'properties'  => $query->orderByDesc('properties_count'),
            'commission'  => $query->orderBy('commission_rate'),
            default       => $query->latest(),
        };

        $agents = $query->paginate(12)->withQueryString();

        return view('frontend.agents.index', compact('agents'));
    }

    public function show(Agent $agent, Request $request)
    {
        // Charger l'agent avec ses relations
        $agent->load('user')
            ->loadCount(['properties', 'transactions']);
    
        // Query des propriétés de l'agent avec filtre optionnel
        $query = $agent->properties()
                    ->where('is_published', true)
                    ->with('images');
    
        // Filtre par status depuis l'URL (?status=for_sale)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        $properties = $query->latest()->paginate(6)->withQueryString();
    
        return view('frontend.agents.show', compact('agent', 'properties'));
    }
}