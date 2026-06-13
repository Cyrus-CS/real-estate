<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\PropertyType;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Agent;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProperties = Property::where('is_featured', true)
            ->where('is_published', true)
            ->with('images')
            ->latest()
            ->take(6)
            ->get();

        $latestProperties = Property::where('is_published', true)
            ->with('images')
            ->latest()
            ->take(8)
            ->get();

        $topAgents = Agent::where('is_active', true)
            ->with('user')
            ->withCount('properties')
            ->take(4)
            ->get();

        $types = PropertyType::cases();

        return view('frontend.home', compact('featuredProperties', 'latestProperties', 'topAgents', 'types'));
    }
}