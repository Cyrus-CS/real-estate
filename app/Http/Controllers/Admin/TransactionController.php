<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(){
        $user  = Auth::user();
        $query = Transaction::with(['property.images', 'buyer', 'agent.user']);

        // Admin voit tout, agent voit seulement ses transactions
        if ($user->role === 'agent') {
            $query->where('agent_id', $user->agent->id);
        }

        $transactions = $query->latest()->paginate(15);
        
        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'totalTransactions' => Transaction::count(),
            'completedTransactions' => Transaction::where('status', 'completed')->count(),
            'pendingTransactions' => Transaction::where('status', 'pending')->count(),
            'totalRevenue' => Transaction::where('status', 'completed')->sum('amount_cents') / 100,
        ]);
    }
}