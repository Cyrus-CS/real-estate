@php
use Illuminate\Support\Str;
@endphp
@extends('admin.admin')

@section('title', 'Transactions')

@section('content')
<div class="content-wrapper">

    <!-- PAGE HEADER -->
    <div class="page-header mb-4">
        <div>
            <h2 class="page-title mb-1">Transactions</h2>
            <p class="page-subtitle text-muted mb-0">Suivez toutes les transactions immobilières</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="bi bi-printer me-2"></i>
                Imprimer
            </button>
            <button class="btn btn-primary">
                <i class="bi bi-download me-2"></i>
                Exporter
            </button>
        </div>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-receipt"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $totalTransactions }}</h3>
                    <p class="stat-label">Total Transactions</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $completedTransactions }}</h3>
                    <p class="stat-label">Complétées</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $pendingTransactions }}</h3>
                    <p class="stat-label">En Attente</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div>
                    <h3 class="stat-value">${{ number_format($totalRevenue, 0) }}</h3>
                    <p class="stat-label">Revenu Total</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTERS & SEARCH -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" class="form-control ps-5" placeholder="Rechercher une transaction..."
                            id="searchTransaction">
                    </div>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="filterType">
                        <option value="">Tous les types</option>
                        <option value="sale">Vente</option>
                        <option value="rent">Location</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="filterStatus">
                        <option value="">Tous les statuts</option>
                        <option value="completed">Complétée</option>
                        <option value="pending">En attente</option>
                        <option value="processing">En cours</option>
                        <option value="cancelled">Annulée</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="filterPayment">
                        <option value="">Tous les paiements</option>
                        <option value="bank_transfer">Virement</option>
                        <option value="stripe">Stripe</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-select" id="filterDate">
                </div>
            </div>
        </div>
    </div>

    <!-- TRANSACTIONS TABLE -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3">Référence</th>
                            <th class="border-0 py-3">Propriété</th>
                            <th class="border-0 py-3">Client</th>
                            <th class="border-0 py-3">Agent</th>
                            <th class="border-0 py-3">Type</th>
                            <th class="border-0 py-3">Montant</th>
                            <th class="border-0 py-3">Commission</th>
                            <th class="border-0 py-3">Paiement</th>
                            <th class="border-0 py-3">Statut</th>
                            <th class="border-0 py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr class="transaction-row" data-type="{{ $transaction->transaction_type }}"
                            data-status="{{ $transaction->status }}" data-payment="{{ $transaction->payment_method }}"
                            data-search="{{ strtolower($transaction->reference . ' ' . $transaction->property->title . ' ' . $transaction->buyer->name) }}">
                            <td class="px-4">
                                <div>
                                    <span
                                        class="badge bg-light text-dark border fw-semibold">{{ $transaction->reference }}</span>
                                    <div class="text-muted small mt-1">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $transaction->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <h6 class="mb-0 fw-semibold">{{ Str::limit($transaction->property->title, 30) }}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $transaction->property->city }}
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2 bg-success bg-opacity-10 text-success"
                                        style="width: 32px; height: 32px; font-size: 12px;">
                                        {{ substr($transaction->buyer->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">{{ $transaction->buyer->name }}</div>
                                        <small class="text-muted">{{ $transaction->buyer->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2 bg-primary-soft text-primary"
                                        style="width: 32px; height: 32px; font-size: 12px;">
                                        {{ substr($transaction->agent->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">{{ $transaction->agent->user->name }}</div>
                                        <small class="text-muted">{{ $transaction->agent->agency_name }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="badge {{ $transaction->transaction_type === 'sale' ? 'bg-primary' : 'bg-info' }}">
                                    {{ $transaction->transaction_type === 'sale' ? 'Vente' : 'Location' }}
                                </span>
                            </td>
                            <td>
                                <div>
                                    <span
                                        class="fw-bold text-dark">${{ number_format($transaction->amount_cents / 100, 2) }}</span>
                                    <div class="text-muted small">{{ $transaction->currency }}</div>
                                </div>
                            </td>
                            <td>
                                <span
                                    class="fw-semibold text-success">${{ number_format($transaction->commission_cents / 100, 2) }}</span>
                            </td>
                            <td>
                                <div>
                                    @php
                                    $paymentIcons = [
                                    'bank_transfer' => 'bank',
                                    'stripe' => 'credit-card',
                                    'paypal' => 'paypal',
                                    ];
                                    $icon = $paymentIcons[$transaction->payment_method] ?? 'wallet2';
                                    @endphp
                                    <i class="bi bi-{{ $icon }} me-1 text-muted"></i>
                                    <span
                                        class="small">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</span>
                                </div>
                            </td>
                            <td>
                                @php
                                $statusConfig = [
                                'completed' => ['class' => 'bg-success bg-opacity-10 text-success', 'icon' =>
                                'check-circle', 'label' => 'Complétée'],
                                'pending' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'icon' => 'clock',
                                'label' => 'En attente'],
                                'processing' => ['class' => 'bg-info bg-opacity-10 text-info', 'icon' => 'arrow-repeat',
                                'label' => 'En cours'],
                                'cancelled' => ['class' => 'bg-danger bg-opacity-10 text-danger', 'icon' => 'x-circle',
                                'label' => 'Annulée'],
                                ];
                                $status = $statusConfig[$transaction->status] ?? $statusConfig['pending'];
                                @endphp
                                <span class="badge {{ $status['class'] }}">
                                    <i class="bi bi-{{ $status['icon'] }} me-1"></i>{{ $status['label'] }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#viewTransactionModal{{ $transaction->id }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal View Transaction -->
                        <div class="modal fade" id="viewTransactionModal{{ $transaction->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0 bg-light">
                                        <div>
                                            <h5 class="modal-title fw-bold mb-1">Transaction
                                                {{ $transaction->reference }}</h5>
                                            <small
                                                class="text-muted">{{ $transaction->created_at->format('d/m/Y à H:i') }}</small>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <!-- Transaction Summary -->
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <div class="card bg-light border-0">
                                                    <div class="card-body">
                                                        <h6 class="fw-bold mb-3">Informations de la transaction</h6>
                                                        <div class="mb-2">
                                                            <label class="text-muted small">Référence</label>
                                                            <p class="mb-0 fw-semibold">{{ $transaction->reference }}
                                                            </p>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="text-muted small">Type</label>
                                                            <p class="mb-0">
                                                                <span
                                                                    class="badge {{ $transaction->transaction_type === 'sale' ? 'bg-primary' : 'bg-info' }}">
                                                                    {{ $transaction->transaction_type === 'sale' ? 'Vente' : 'Location' }}
                                                                </span>
                                                            </p>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="text-muted small">Statut</label>
                                                            <p class="mb-0">
                                                                <span class="badge {{ $status['class'] }}">
                                                                    {{ $status['label'] }}
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card bg-primary bg-opacity-10 border-0">
                                                    <div class="card-body">
                                                        <h6 class="fw-bold mb-3">Détails financiers</h6>
                                                        <div class="mb-2">
                                                            <label class="text-muted small">Montant</label>
                                                            <h4 class="mb-0 text-primary">
                                                                ${{ number_format($transaction->amount_cents / 100, 2) }}
                                                            </h4>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="text-muted small">Commission</label>
                                                            <p class="mb-0 fw-semibold text-success">
                                                                ${{ number_format($transaction->commission_cents / 100, 2) }}
                                                            </p>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="text-muted small">Méthode de paiement</label>
                                                            <p class="mb-0">
                                                                {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
                                                            </p>
                                                        </div>
                                                        @if($transaction->payment_reference)
                                                        <div>
                                                            <label class="text-muted small">Référence de
                                                                paiement</label>
                                                            <p class="mb-0">
                                                                <code>{{ $transaction->payment_reference }}</code>
                                                            </p>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Property Info -->
                                        <div class="mb-4">
                                            <h6 class="fw-bold mb-3">Propriété</h6>
                                            <div class="d-flex gap-3">
                                                @if($transaction->property->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $transaction->property->images->first()->image_path) }}"
                                                    class="rounded"
                                                    style="width: 100px; height: 80px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <h6 class="mb-1">{{ $transaction->property->title }}</h6>
                                                    <p class="text-muted small mb-1">
                                                        <i
                                                            class="bi bi-geo-alt me-1"></i>{{ $transaction->property->address }},
                                                        {{ $transaction->property->city }}
                                                    </p>
                                                    <p class="text-muted small mb-0">
                                                        {{ $transaction->property->bedrooms }} ch. •
                                                        {{ $transaction->property->bathrooms }} sdb •
                                                        {{ $transaction->property->surface }} m²</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Parties -->
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <h6 class="fw-bold mb-3">Acheteur / Locataire</h6>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-circle me-3 bg-success bg-opacity-10 text-success">
                                                        {{ substr($transaction->buyer->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $transaction->buyer->name }}
                                                            {{ $transaction->buyer->last_name }}</div>
                                                        <div class="text-muted small">{{ $transaction->buyer->email }}
                                                        </div>
                                                        @if($transaction->buyer->phone)
                                                        <div class="text-muted small">
                                                            <i
                                                                class="bi bi-telephone me-1"></i>{{ $transaction->buyer->phone }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <h6 class="fw-bold mb-3">Agent</h6>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-3 bg-primary-soft text-primary">
                                                        {{ substr($transaction->agent->user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold">{{ $transaction->agent->user->name }}
                                                            {{ $transaction->agent->user->last_name }}</div>
                                                        <div class="text-muted small">
                                                            {{ $transaction->agent->agency_name }}</div>
                                                        <div class="text-muted small">
                                                            {{ $transaction->agent->user->email }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($transaction->notes)
                                        <div class="mt-3">
                                            <h6 class="fw-bold mb-2">Notes</h6>
                                            <p class="text-muted mb-0">{{ $transaction->notes }}</p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Fermer</button>
                                        <button type="button" class="btn btn-primary" onclick="window.print()">
                                            <i class="bi bi-printer me-2"></i>Imprimer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="bi bi-receipt text-muted" style="font-size: 3rem;"></i>
                                <p class="mt-3 text-muted">Aucune transaction trouvée</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($transactions->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $transactions->links() }}
    </div>
    @endif

</div>

@push('scripts')
<script>
// Search & Filters
function filterTransactions() {
    const search = document.getElementById('searchTransaction').value.toLowerCase();
    const type = document.getElementById('filterType').value;
    const status = document.getElementById('filterStatus').value;
    const payment = document.getElementById('filterPayment').value;

    document.querySelectorAll('.transaction-row').forEach(row => {
        const searchText = row.dataset.search;
        const rowType = row.dataset.type;
        const rowStatus = row.dataset.status;
        const rowPayment = row.dataset.payment;

        const matchSearch = searchText.includes(search);
        const matchType = !type || rowType === type;
        const matchStatus = !status || rowStatus === status;
        const matchPayment = !payment || rowPayment === payment;

        row.style.display = (matchSearch && matchType && matchStatus && matchPayment) ? '' : 'none';
    });
}

document.getElementById('searchTransaction').addEventListener('keyup', filterTransactions);
document.getElementById('filterType').addEventListener('change', filterTransactions);
document.getElementById('filterStatus').addEventListener('change', filterTransactions);
document.getElementById('filterPayment').addEventListener('change', filterTransactions);
</script>
@endpush
@endsection