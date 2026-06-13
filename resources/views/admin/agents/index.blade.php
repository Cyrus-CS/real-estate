@extends('admin.admin')

@section('title', 'Agents')

@section('content')
<div class="content-wrapper">

    <!-- PAGE HEADER -->
    <div class="page-header mb-4">
        <div>
            <h2 class="page-title mb-1">Agents Immobiliers</h2>
            <p class="page-subtitle text-muted mb-0">Gérez vos agents et leurs performances</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAgentModal">
            <i class="bi bi-person-plus me-2"></i>
            Ajouter un agent
        </button>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $totalAgents }}</h3>
                    <p class="stat-label">Total Agents</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $activeAgents }}</h3>
                    <p class="stat-label">Agents Actifs</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="bi bi-building"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $totalProperties }}</h3>
                    <p class="stat-label">Propriétés Gérées</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div>
                    <h3 class="stat-value">${{ number_format($totalCommissions, 0) }}</h3>
                    <p class="stat-label">Commissions Totales</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTERS & SEARCH -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" class="form-control ps-5" placeholder="Rechercher par nom ou agence..."
                            id="searchAgent">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">Tous les statuts</option>
                        <option value="active">Actif</option>
                        <option value="inactive">Inactif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="sortBy">
                        <option value="name">Nom</option>
                        <option value="properties">Propriétés</option>
                        <option value="commission">Commission</option>
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
                                <th class="border-0 px-4 py-3">Agent</th>
                                <th class="border-0 py-3">Agence</th>
                                <th class="border-0 py-3">Licence</th>
                                <th class="border-0 py-3">Commission</th>
                                <th class="border-0 py-3">Propriétés</th>
                                <th class="border-0 py-3">Statut</th>
                                <th class="border-0 py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agents as $agent)
                            <tr class="agent-row" data-status="{{ $agent->is_active ? 'active' : 'inactive' }}"
                                data-search="{{ strtolower($agent->user->name . ' ' . $agent->user->last_name . ' ' . $agent->agency_name) }}">
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-3 bg-primary-soft text-primary">
                                            {{ substr($agent->user->name, 0, 1) }}{{ substr($agent->user->last_name ?? '', 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $agent->user->name }}
                                                {{ $agent->user->last_name }}</h6>
                                            <small class="text-muted">{{ $agent->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-semibold">{{ $agent->agency_name }}</div>
                                        @if($agent->user->phone)
                                        <small class="text-muted">
                                            <i class="bi bi-telephone me-1"></i>{{ $agent->user->phone }}
                                        </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $agent->license_number }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $agent->commission_rate }}%</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary-soft text-primary">
                                        {{ $agent->properties->count() }} biens
                                    </span>
                                </td>
                                <td>
                                    @if($agent->is_active)
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        <i class="bi bi-check-circle me-1"></i>Actif
                                    </span>
                                    @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger">
                                        <i class="bi bi-x-circle me-1"></i>Inactif
                                    </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal" data-bs-target="#viewAgentModal{{ $agent->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            data-bs-toggle="modal" data-bs-target="#editAgentModal{{ $agent->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            data-id="{{$agent->id}}" onclick="deleteAgent(this.dataset.id)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal View Agent -->
                            <div class="modal fade" id="viewAgentModal{{ $agent->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Profil de l'agent</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 text-center border-end">
                                                    <div class="avatar-circle mx-auto mb-3 bg-primary-soft text-primary"
                                                        style="width: 100px; height: 100px; font-size: 36px;">
                                                        {{ substr($agent->user->name, 0, 1) }}{{ substr($agent->user->last_name ?? '', 0, 1) }}
                                                    </div>
                                                    <h5 class="mb-1">{{ $agent->user->name }}
                                                        {{ $agent->user->last_name }}</h5>
                                                    <p class="text-muted small">{{ $agent->agency_name }}</p>
                                                    @if($agent->is_active)
                                                    <span class="badge bg-success">Agent Actif</span>
                                                    @else
                                                    <span class="badge bg-danger">Inactif</span>
                                                    @endif
                                                </div>
                                                <div class="col-md-8">
                                                    <h6 class="fw-bold mb-3">Informations de contact</h6>
                                                    <div class="row g-3 mb-4">
                                                        <div class="col-12">
                                                            <label class="text-muted small mb-1">Email</label>
                                                            <p class="mb-0">{{ $agent->user->email }}</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="text-muted small mb-1">Téléphone</label>
                                                            <p class="mb-0">{{ $agent->user->phone ?? 'Non renseigné' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="text-muted small mb-1">Licence N°</label>
                                                            <p class="mb-0">{{ $agent->license_number }}</p>
                                                        </div>
                                                    </div>

                                                    <h6 class="fw-bold mb-3">Statistiques</h6>
                                                    <div class="row g-3">
                                                        <div class="col-6">
                                                            <label class="text-muted small mb-1">Taux de
                                                                commission</label>
                                                            <p class="mb-0 fw-bold text-primary">
                                                                {{ $agent->commission_rate }}%</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="text-muted small mb-1">Propriétés
                                                                gérées</label>
                                                            <p class="mb-0 fw-bold">{{ $agent->properties->count() }}
                                                            </p>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="text-muted small mb-1">Biographie</label>
                                                            <p class="mb-0">
                                                                {{ $agent->bio ?? 'Aucune biographie renseignée' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Fermer</button>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#editAgentModal{{ $agent->id }}"
                                                data-bs-dismiss="modal">
                                                <i class="bi bi-pencil me-2"></i>Modifier
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit Agent -->
                            <div class="modal fade" id="editAgentModal{{ $agent->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.agents.update', $agent) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title fw-bold">Modifier l'agent</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label class="form-label">Nom de l'agence</label>
                                                        <input type="text" class="form-control" name="agency_name"
                                                            value="{{ $agent->agency_name }}" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Numéro de licence</label>
                                                        <input type="text" class="form-control" name="license_number"
                                                            value="{{ $agent->license_number }}" required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Taux de commission (%)</label>
                                                        <input type="number" step="0.01" class="form-control"
                                                            name="commission_rate" value="{{ $agent->commission_rate }}"
                                                            required>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Biographie</label>
                                                        <textarea class="form-control" name="bio"
                                                            rows="3">{{ $agent->bio }}</textarea>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="is_active" id="is_active{{ $agent->id }}"
                                                                value="1" {{-- value="1" --}}
                                                                {{ $agent->is_active ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="is_active{{ $agent->id }}">
                                                                Agent actif
                                                            </label>
                                                        </div>
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
                                    <i class="bi bi-person-badge text-muted" style="font-size: 3rem;"></i>
                                    <p class="mt-3 text-muted">Aucun agent trouvé</p>
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
            @forelse($agents as $agent)
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 agent-card"
                data-status="{{ $agent->is_active ? 'active' : 'inactive' }}"
                data-search="{{ strtolower($agent->user->name . ' ' . $agent->user->last_name . ' ' . $agent->agency_name) }}">
                <div class="card border-0 shadow-sm h-100 agent-item">
                    <div class="card-body text-center">
                        <div class="position-relative d-inline-block mb-3">
                            <div class="avatar-circle mx-auto bg-primary-soft text-primary"
                                style="width: 80px; height: 80px; font-size: 28px;">
                                {{ substr($agent->user->name, 0, 1) }}{{ substr($agent->user->last_name ?? '', 0, 1) }}
                            </div>
                            @if($agent->is_active)
                            <span
                                class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle"
                                style="width: 20px; height: 20px;"></span>
                            @endif
                        </div>

                        <h6 class="fw-bold mb-1">{{ $agent->user->name }} {{ $agent->user->last_name }}</h6>
                        <p class="text-muted small mb-2">{{ $agent->agency_name }}</p>

                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <div>
                                <div class="fw-bold text-primary">{{ $agent->commission_rate }}%</div>
                                <small class="text-muted">Commission</small>
                            </div>
                            <div class="vr"></div>
                            <div>
                                <div class="fw-bold">{{ $agent->properties->count() }}</div>
                                <small class="text-muted">Biens</small>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-center mt-3">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#viewAgentModal{{ $agent->id }}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#editAgentModal{{ $agent->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" data-id="{{ $agent->id }}"
                                onclick="deleteAgent(this.dataset.id)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-person-badge text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3">Aucun agent</h5>
                    <p class="text-muted">Aucun agent n'a été trouvé</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

</div>

<!-- Modal Add Agent -->
<div class="modal fade" id="addAgentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.agents.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Ajouter un agent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Prénom</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" name="phone">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nom de l'agence</label>
                            <input type="text" class="form-control" name="agency_name" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Numéro de licence</label>
                            <input type="text" class="form-control" name="license_number" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Taux de commission (%)</label>
                            <input type="number" step="0.01" class="form-control" name="commission_rate" value="5.00"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
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
function filterAgents() {
    const search = document.getElementById('searchAgent').value.toLowerCase();
    const status = document.getElementById('filterStatus').value;

    document.querySelectorAll('.agent-row, .agent-card').forEach(item => {
        const searchText = item.dataset.search;
        const itemStatus = item.dataset.status;

        const matchSearch = searchText.includes(search);
        const matchStatus = !status || itemStatus === status;

        item.style.display = (matchSearch && matchStatus) ? '' : 'none';
    });
}

document.getElementById('searchAgent').addEventListener('keyup', filterAgents);
document.getElementById('filterStatus').addEventListener('change', filterAgents);

// Delete Agent
function deleteAgent(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet agent ? Toutes ses propriétés seront également supprimées.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/agents/${id}`;
        form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush

@push('styles')
<style>
.agent-item {
    transition: var(--transition);
}

.agent-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(108, 58, 255, .15) !important;
}
</style>
@endpush
@endsection