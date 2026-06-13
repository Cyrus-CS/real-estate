<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\FrontendPropertyRequest;
use App\Models\Property;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function index(FrontendPropertyRequest $request)
    {
        $query = Property::where('is_published', true)->with(['images', 'agent.user', 'amenities']);

        // Filtres
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('surface')) {
            $query->where('surface', '>=', $request->surface);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        if ($request->filled('bathdrooms')) {
            $query->where('bathdrooms', '>=', $request->bedrooms);
        }

        // ── Tri ─────────
        match ($request->input('sort', 'latest')) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest(),
        };

        $properties = $query->paginate(12)->withQueryString();
        // withQueryString() conserve tous les paramètres GET dans les liens de pagination

        return view('frontend.properties.index', compact('properties'));
    }

    // Soft delete check + published
    public function show(Property $property): View
    {   
        abort_if($property->deleted_at || !$property->is_published, 404);

        $property->load([
            'images',
            'amenities',
            'agent.user',
        ]);
    // ...
        $hasActiveRent = false;

        if (Auth::check() && Auth::user()->isBuyer()) {
            $hasActiveRent = \App\Models\Rent::where('property_id', $property->id)
                ->where('applicant_id', Auth::id())
                ->whereIn('status', ['pending', 'under_review', 'approved'])
                ->exists();
        }

        // Renommer $similarProperties (pas $similar) pour correspondre au Blade
        $similarProperties = Property::where('is_published', true)
            ->where('id', '!=', $property->id)
            ->where(function ($q) use ($property) {
                $q->where('type', $property->type)
                ->orWhere('city', $property->city);
            })
            ->with('images')
            ->take(4)
            ->get();

        return view('frontend.properties.show', compact('property', 'similarProperties', 'hasActiveRent'));
    }

    public function featured()
    {
        $properties = Property::where('is_published', true)
            ->where('is_featured', true)
            ->with(['images', 'agent.user'])
            ->latest()
            ->paginate(12);

        return view('frontend.properties.featured', compact('properties'));
    }

    public function favorites()
    {
        /** @var User|null $user */
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }
        
        $properties = $user->favoriteProperties()
            ->where('is_published', true)
            ->with('images')
            ->paginate(12);

        return view('frontend.properties.favorites', compact('properties'));
    }

    public function toggleFavorite(Property $property)
    {
        // À implémenter avec une table pivot user_favorites
        /**
         * @var User|null $user
         */
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        if ($user->favoriteProperties()->where('property_id', $property->id)->exists()) {
            $user->favoriteProperties()->detach($property->id);
            return response()->json(['favorited' => false]);
        } else {
            $user->favoriteProperties()->attach($property->id);
            return response()->json(['favorited' => true]);
        }
    }
}