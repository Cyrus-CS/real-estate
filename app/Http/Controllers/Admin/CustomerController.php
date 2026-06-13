<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::latest()->get();
        
        return view('admin.customers.index', [
            'customers' => $customers,
            'totalCustomers' => $customers->count(),
            'activeCustomers' => $customers->where('email_verified_at', '!=', null)->count(),
            'verifiedCustomers' => $customers->where('email_verified_at', '!=', null)->count(),
            'newCustomersThisMonth' => $customers->where('created_at', '>=', now()->startOfMonth())->count(),
        ]);
    }

    public function update(Request $request, User $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:buyer,agent,admin',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Client mis à jour avec succès');
    }

    public function destroy(User $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Client supprimé avec succès');
    }
}