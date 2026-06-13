@extends('admin.admin')

@section('title', 'Customers')

@section('content')
<div class="content-wrapper">

    <!-- PAGE HEADER -->
    <div class="page-header mb-4">
        <div>
            <h2 class="page-title mb-1">Customers</h2>
            <p class="page-subtitle text-muted mb-0">Gérez vos clients et prospects</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
            <i class="bi bi-person-plus me-2"></i>
            Ajouter un client
        </button>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $totalCustomers }}</h3>
                    <p class="stat-label">Total Clients</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-person-check"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $activeCustomers }}</h3>
                    <p class="stat-label">Clients Actifs</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="bi bi-envelope-check"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $verifiedCustomers }}</h3>
                    <p class="stat-label">Vérifiés</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $newCustomersThisMonth }}</h3>
                    <p class="stat-label">Nouveaux ce mois</p>
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
                        <input type="text" class="form-control ps-5" placeholder="Rechercher un client..."
                            id="searchCustomer">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterRole">
                        <option value="">Tous les rôles</option>
                        <option value="buyer">Acheteur</option>
                        <option value="agent">Agent</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">Tous les statuts</option>
                        <option value="verified">Vérifié</option>
                        <option value="pending">En attente</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary active" id="viewTable">
                            <i class="bi bi-list-ul"></i>
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="viewGrid">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE VIEW (Default) -->
    <div id="tableView">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                </th>
                                <th class="border-0 py-3">Client</th>
                                <th class="border-0 py-3">Rôle</th>
                                <th class="border-0 py-3">Contact</th>
                                <th class="border-0 py-3">Date d'inscription</th>
                                <th class="border-0 py-3">Statut</th>
                                <th class="border-0 py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr class="customer-row" data-role="{{ $customer->role }}"
                                data-status="{{ $customer->email_verified_at ? 'verified' : 'pending' }}"
                                data-search="{{ strtolower($customer->name . ' ' . $customer->last_name . ' ' . $customer->email) }}">
                                <td class="px-4">
                                    <input type="checkbox" class="form-check-input customer-checkbox"
                                        value="{{ $customer->id }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="avatar-circle me-3 {{ $customer->role === 'admin' ? 'bg-danger bg-opacity-10 text-danger' : ($customer->role === 'agent' ? 'bg-primary-soft text-primary' : 'bg-success bg-opacity-10 text-success') }}">
                                            {{ substr($customer->name, 0, 1) }}{{ substr($customer->last_name ?? '', 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $customer->name }} {{ $customer->last_name }}
                                            </h6>
                                            <small class="text-muted">{{ $customer->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge rounded-pill {{ $customer->role === 'admin' ? 'bg-danger' : ($customer->role === 'agent' ? 'bg-primary' : 'bg-success') }}">
                                        {{ ucfirst($customer->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($customer->phone)
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-telephone text-muted"></i>
                                        <span class="small">{{ $customer->phone }}</span>
                                    </div>
                                    @else
                                    <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $customer->created_at->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    @if($customer->email_verified_at)
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="bi bi-check-circle me-1"></i>Vérifié
                                    </span>
                                    @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning">
                                        <i class="bi bi-clock me-1"></i>En attente
                                    </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewCustomerModal{{ $customer->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editCustomerModal{{ $customer->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-id="{{ $customer->id }}" onclick="deleteCustomer(this.dataset.id)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal View Customer -->
                            <div class="modal fade" id="viewCustomerModal{{ $customer->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Détails du client</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center mb-4">
                                                <div class="avatar-circle mx-auto mb-3"
                                                    style="width: 80px; height: 80px; font-size: 28px;">
                                                    {{ substr($customer->name, 0, 1) }}{{ substr($customer->last_name ?? '', 0, 1) }}
                                                </div>
                                                <h5 class="mb-1">{{ $customer->name }} {{ $customer->last_name }}</h5>
                                                <span class="badge bg-primary">{{ ucfirst($customer->role) }}</span>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="text-muted small mb-1">Email</label>
                                                    <p class="mb-0 fw-semibold">{{ $customer->email }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <label class="text-muted small mb-1">Téléphone</label>
                                                    <p class="mb-0 fw-semibold">
                                                        {{ $customer->phone ?? 'Non renseigné' }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <label class="text-muted small mb-1">Inscrit le</label>
                                                    <p class="mb-0 fw-semibold">
                                                        {{ $customer->created_at->format('d/m/Y') }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <label class="text-muted small mb-1">Statut</label>
                                                    <p class="mb-0">
                                                        @if($customer->email_verified_at)
                                                        <span class="badge bg-success">Vérifié</span>
                                                        @else
                                                        <span class="badge bg-warning">En attente</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit Customer -->
                            <div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title fw-bold">Modifier le client</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Prénom</label>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ $customer->name }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nom</label>
                                                        <input type="text" class="form-control" name="last_name"
                                                            value="{{ $customer->last_name }}" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email"
                                                            value="{{ $customer->email }}" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Téléphone</label>
                                                        <input type="tel" class="form-control" name="phone"
                                                            value="{{ $customer->phone }}">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Rôle</label>
                                                        <select class="form-select" name="role">
                                                            <option value="buyer"
                                                                {{ $customer->role === 'buyer' ? 'selected' : '' }}>
                                                                Acheteur</option>
                                                            <option value="agent"
                                                                {{ $customer->role === 'agent' ? 'selected' : '' }}>
                                                                Agent</option>
                                                            <option value="admin"
                                                                {{ $customer->role === 'admin' ? 'selected' : '' }}>
                                                                Admin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                                    <p class="mt-3 text-muted">Aucun client trouvé</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- GRID VIEW (Hidden by default) -->
    <div id="gridView" class="d-none">
        <div class="row g-4">
            @forelse($customers as $customer)
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 customer-card" data-role="{{ $customer->role }}"
                data-status="{{ $customer->email_verified_at ? 'verified' : 'pending' }}"
                data-search="{{ strtolower($customer->name . ' ' . $customer->last_name . ' ' . $customer->email) }}">
                <div class="card border-0 shadow-sm h-100 customer-item">
                    <div class="card-body text-center">
                        <div class="position-relative d-inline-block mb-3">
                            <div class="avatar-circle mx-auto bg-primary-soft text-primary"
                                style="width: 70px; height: 70px; font-size: 24px;">
                                {{ substr($customer->name, 0, 1) }}{{ substr($customer->last_name ?? '', 0, 1) }}
                            </div>
                            @if($customer->email_verified_at)
                            <span
                                class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle"
                                style="width: 18px; height: 18px;"></span>
                            @endif
                        </div>

                        <h6 class="fw-bold mb-1">{{ $customer->name }} {{ $customer->last_name }}</h6>
                        <p class="text-muted small mb-2">{{ $customer->email }}</p>

                        <span
                            class="badge rounded-pill mb-3 {{ $customer->role === 'admin' ? 'bg-danger' : ($customer->role === 'agent' ? 'bg-primary' : 'bg-success') }}">
                            {{ ucfirst($customer->role) }}
                        </span>

                        @if($customer->phone)
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                            <i class="bi bi-telephone text-muted small"></i>
                            <span class="text-muted small">{{ $customer->phone }}</span>
                        </div>
                        @endif

                        <div class="d-flex gap-2 justify-content-center mt-3">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#viewCustomerModal{{ $customer->id }}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#editCustomerModal{{ $customer->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="deleteCustomer('{{ $customer->id }}');">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3">Aucun client</h5>
                    <p class="text-muted">Aucun client n'a été trouvé</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal Add Customer -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Ajouter un client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Rôle</label>
                            <select class="form-select">
                                <option value="buyer">Acheteur</option>
                                <option value="agent">Agent</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Toggle View
document.getElementById('viewTable').addEventListener('click', function() {
    document.getElementById('tableView').classList.remove('d-none');
    document.getElementById('gridView').classList.add('d-none');
    this.classList.add('active');
    document.getElementById('viewGrid').classList.remove('active');
});

document.getElementById('viewGrid').addEventListener('click', function() {
    document.getElementById('gridView').classList.remove('d-none');
    document.getElementById('tableView').classList.add('d-none');
    this.classList.add('active');
    document.getElementById('viewTable').classList.remove('active');
});

// Search & Filters
function filterCustomers() {
    const search = document.getElementById('searchCustomer').value.toLowerCase();
    const role = document.getElementById('filterRole').value;
    const status = document.getElementById('filterStatus').value;

    document.querySelectorAll('.customer-row, .customer-card').forEach(item => {
        const searchText = item.dataset.search;
        const itemRole = item.dataset.role;
        const itemStatus = item.dataset.status;

        const matchSearch = searchText.includes(search);
        const matchRole = !role || itemRole === role;
        const matchStatus = !status || itemStatus === status;

        item.style.display = (matchSearch && matchRole && matchStatus) ? '' : 'none';
    });
}

document.getElementById('searchCustomer').addEventListener('keyup', filterCustomers);
document.getElementById('filterRole').addEventListener('change', filterCustomers);
document.getElementById('filterStatus').addEventListener('change', filterCustomers);

// Select All
document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.customer-checkbox').forEach(cb => cb.checked = this.checked);
});

// Delete Customer
function deleteCustomer(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce client ?')) {
        // Ajoutez votre logique de suppression ici
        //La methode exacte dépendra de votre implémentation (ex: requête AJAX, redirection vers une route de suppression, etc.)
        // La methode Laravel du controller pour la suppression est destoy public function destroy(Property $property)
        console.log('Supprimer le client avec ID :', id);
    }
}
</script>
@endpush

@push('styles')
<style>
.customer-item {
    transition: var(--transition);
}

.customer-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(108, 58, 255, .15) !important;
}

.avatar-circle {
    background-color: var(--primary-soft);
    color: var(--primary);
}
</style>
@endpush
@endsection