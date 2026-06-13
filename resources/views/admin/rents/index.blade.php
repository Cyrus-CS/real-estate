@php
use Illuminate\Support\Str;
@endphp
@extends('admin.admin')

@section('title', 'Demandes de Location')

@section('content')
<div class="content-wrapper">

    <!-- PAGE HEADER -->
    <div class="page-header mb-4">
        <div>
            <h2 class="page-title mb-1">Demandes de Location</h2>
            <p class="page-subtitle text-muted mb-0">Gérez les demandes de location de vos propriétés</p>
        </div>
    </div>

    <!-- STATS -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $totalApplications }}</h3>
                    <p class="stat-label">Total Demandes</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $pendingApplications }}</h3>
                    <p class="stat-label">En Attente</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $approvedApplications }}</h3>
                    <p class="stat-label">Approuvées</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-eye"></i>
                </div>
                <div>
                    <h3 class="stat-value">{{ $underReviewApplications }}</h3>
                    <p class="stat-label">En Révision</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTERS -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" class="form-control ps-5" placeholder="Rechercher par nom ou propriété..."
                            id="searchApplication">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="filterStatus">
                        <option value="">Tous les statuts</option>
                        <option value="pending">En attente</option>
                        <option value="under_review">En révision</option>
                        <option value="approved">Approuvée</option>
                        <option value="rejected">Rejetée</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="filterProperty">
                        <option value="">Toutes les propriétés</option>
                        @foreach($properties as $property)
                        <option value="{{ $property->id }}">{{ $property->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- APPLICATIONS LIST -->
    <div class="row g-4">
        @forelse($applications as $application)
        <div class="col-12 application-item" data-status="{{ $application->status }}"
            data-property="{{ $application->property_id }}"
            data-search="{{ strtolower($application->applicant->name . ' ' . $application->property->title) }}">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Applicant Info -->
                        <div class="col-lg-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3 bg-primary-soft text-primary">
                                    {{ substr($application->applicant->name, 0, 1) }}{{ substr($application->applicant->last_name ?? '', 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">{{ $application->applicant->name }}
                                        {{ $application->applicant->last_name }}</h6>
                                    <small class="text-muted">{{ $application->applicant->email }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Property Info -->
                        <div class="col-lg-3">
                            <div>
                                <small class="text-muted d-block mb-1">Propriété</small>
                                <h6 class="mb-0 fw-semibold">{{ Str::limit($application->property->title, 30) }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $application->property->city }}
                                </small>
                            </div>
                        </div>

                        <!-- Application Details -->
                        <div class="col-lg-2">
                            <div>
                                <small class="text-muted d-block mb-1">Durée du bail</small>
                                <span class="fw-semibold">{{ $application->lease_duration_months }} mois</span>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted d-block mb-1">Emménagement</small>
                                <span
                                    class="fw-semibold">{{ \Carbon\Carbon::parse($application->desired_move_in)->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-lg-2">
                            @php
                            $statusConfig = [
                            'pending' => ['class' => 'bg-warning bg-opacity-10 text-warning', 'icon' => 'clock', 'label'
                            => 'En attente'],
                            'under_review' => ['class' => 'bg-info bg-opacity-10 text-info', 'icon' => 'eye', 'label' =>
                            'En révision'],
                            'approved' => ['class' => 'bg-success bg-opacity-10 text-success', 'icon' => 'check-circle',
                            'label' => 'Approuvée'],
                            'rejected' => ['class' => 'bg-danger bg-opacity-10 text-danger', 'icon' => 'x-circle',
                            'label' => 'Rejetée'],
                            ];
                            $status = $statusConfig[$application->status] ?? $statusConfig['pending'];
                            @endphp
                            <span class="badge {{ $status['class'] }} w-100 py-2">
                                <i class="bi bi-{{ $status['icon'] }} me-1"></i>{{ $status['label'] }}
                            </span>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-calendar3 me-1"></i>{{ $application->created_at->format('d/m/Y') }}
                            </small>
                        </div>

                        <!-- Actions -->
                        <div class="col-lg-1 text-end">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#viewApplicationModal{{ $application->id }}">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal View Application -->
            <div class="modal fade" id="viewApplicationModal{{ $application->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bold">Détails de la demande</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Applicant Section -->
                                <div class="col-md-6 mb-4">
                                    <h6 class="fw-bold mb-3">Informations du demandeur</h6>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-circle me-3 bg-primary-soft text-primary"
                                            style="width: 60px; height: 60px; font-size: 20px;">
                                            {{ substr($application->applicant->name, 0, 1) }}{{ substr($application->applicant->last_name ?? '', 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $application->applicant->name }}
                                                {{ $application->applicant->last_name }}</h6>
                                            <small class="text-muted">{{ $application->applicant->email }}</small>
                                        </div>
                                    </div>
                                    @if($application->applicant->phone)
                                    <div class="mb-2">
                                        <i class="bi bi-telephone me-2 text-muted"></i>
                                        <span>{{ $application->applicant->phone }}</span>
                                    </div>
                                    @endif
                                </div>

                                <!-- Property Section -->
                                <div class="col-md-6 mb-4">
                                    <h6 class="fw-bold mb-3">Propriété concernée</h6>
                                    <div class="mb-2">
                                        <strong>{{ $application->property->title }}</strong>
                                    </div>
                                    <div class="text-muted mb-2">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $application->property->address }},
                                        {{ $application->property->city }}
                                    </div>
                                    <div class="fw-bold text-primary">
                                        ${{ number_format($application->property->price, 0) }}/mois
                                    </div>
                                </div>

                                <!-- Application Details -->
                                <div class="col-12 mb-4">
                                    <h6 class="fw-bold mb-3">Détails de la demande</h6>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="text-muted small mb-1">Date d'emménagement souhaitée</label>
                                            <p class="mb-0 fw-semibold">
                                                {{ \Carbon\Carbon::parse($application->desired_move_in)->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <label class="text-muted small mb-1">Durée du bail</label>
                                            <p class="mb-0 fw-semibold">{{ $application->lease_duration_months }} mois
                                            </p>
                                        </div>
                                        <div class="col-12">
                                            <label class="text-muted small mb-1">Message du demandeur</label>
                                            <p class="mb-0">{{ $application->message ?? 'Aucun message fourni' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Review Info -->
                                @if($application->reviewed_at)
                                <div class="col-12">
                                    <div class="bg-light rounded p-3">
                                        <h6 class="fw-bold mb-2">Informations de révision</h6>
                                        <div class="text-muted small">
                                            Révisé le
                                            {{ \Carbon\Carbon::parse($application->reviewed_at)->format('d/m/Y à H:i') }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            @if($application->status === 'pending' || $application->status === 'under_review')
                            <form action="{{ route('admin.applications.update', $application) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-2"></i>Approuver
                                </button>
                            </form>
                            <form action="{{ route('admin.applications.update', $application) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-x-circle me-2"></i>Rejeter
                                </button>
                            </form>
                            @endif
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3">Aucune demande de location</h5>
                    <p class="text-muted">Aucune demande n'a été soumise pour le moment</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

</div>

@push('scripts')
<script>
// Search & Filters
function filterApplications() {
    const search = document.getElementById('searchApplication').value.toLowerCase();
    const status = document.getElementById('filterStatus').value;
    const property = document.getElementById('filterProperty').value;

    document.querySelectorAll('.application-item').forEach(item => {
        const searchText = item.dataset.search;
        const itemStatus = item.dataset.status;
        const itemProperty = item.dataset.property;

        const matchSearch = searchText.includes(search);
        const matchStatus = !status || itemStatus === status;
        const matchProperty = !property || itemProperty === property;

        item.style.display = (matchSearch && matchStatus && matchProperty) ? '' : 'none';
    });
}

document.getElementById('searchApplication').addEventListener('keyup', filterApplications);
document.getElementById('filterStatus').addEventListener('change', filterApplications);
document.getElementById('filterProperty').addEventListener('change', filterApplications);
</script>
@endpush
@endsection