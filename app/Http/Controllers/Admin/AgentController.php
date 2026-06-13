<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

// use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::with(['user', 'properties'])->latest()->get();
        
        return view('admin.agents.index', [
            'agents' => $agents,
            'totalAgents' => $agents->count(),
            'activeAgents' => $agents->where('is_active', true)->count(),
            'totalProperties' => Property::whereIn('agent_id', $agents->pluck('id'))->count(),
            'totalCommissions' => $agents->sum('commission_rate') * 1000, // Exemple
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'agency_name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:agents',
            'commission_rate' => 'required|numeric|min:0|max:100',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => 'Agent@2026',
            'role' => 'agent',
        ]);

        Agent::create([
            'user_id' => $user->id,
            'agency_name' => $validated['agency_name'],
            'license_number' => $validated['license_number'],
            'commission_rate' => $validated['commission_rate'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.agents.index')->with('success', 'Agent créé avec succès');
    }

    public function update(Request $request, Agent $agent)
{
        $validated = $request->validate([
            'agency_name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:agents,license_number,' . $agent->id,
            'commission_rate' => 'required|numeric|min:0|max:100',
            'bio' => 'nullable|string',
            'is_active' => 'nullable', // Pas boolean ici car checkbox
        ]);

        //  Important : Gérer le checkbox correctement
        $agent->update([
            'agency_name' => $validated['agency_name'],
            'license_number' => $validated['license_number'],
            'commission_rate' => $validated['commission_rate'],
            'bio' => $validated['bio'],
            'is_active' => $request->has('is_active'), //  True si checkbox cochée, false sinon
        ]);

        return redirect()->route('admin.agents.index')->with('success', 'Agent mis à jour avec succès');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        return redirect()->route('admin.agents.index')->with('success', 'Agent supprimé avec succès');
    }
}