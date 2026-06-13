@php
use App\Models\Agent;
use Illuminate\Support\Facades\Auth;
$user = Auth::user();
$isAdmin = $user->role === 'admin';
$isAgent = $user->role === 'agent';

// Récupérer l'agent si l'utilisateur est un agent
$agent = null;
if ($isAgent) {
$agent = Agent::where('user_id', $user->id)->first();
}
@endphp

<!-- SIDEBAR MOBILE -->
<div class="offcanvas offcanvas-start sidebar-mobile d-lg-none" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title fw-bold text-primary">
            <i class="bi bi-building me-2"></i>
            EstateVista
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body p-0">
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                Dashboard
            </a>

            <a href="{{ route('admin.properties.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
                <i class="bi bi-buildings"></i>
                {{ $isAgent ? 'Mes Propriétés' : 'Propriétés' }}
                @if($isAgent && $agent)
                <span class="badge bg-primary ms-auto">{{ $agent->properties->count() }}</span>
                @endif
            </a>

            @if($isAdmin)
            <a href="{{ route('admin.customers.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                Clients
            </a>

            <a href="{{ route('admin.agents.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i>
                Agents
            </a>
            @endif

            <a href="{{ route('admin.applications.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i>
                {{ $isAgent ? 'Mes Demandes' : 'Demandes de Location' }}
            </a>

            @if($isAdmin || $isAgent)
            <a href="{{ route('admin.transactions.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                <i class="bi bi-arrow-left-right"></i>
                Transactions
            </a>
            @endif

            <a href="{{ route('admin.settings.index') }}"
                class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                Paramètres
            </a>
        </nav>
    </div>
</div>

<!-- SIDEBAR DESKTOP -->
<aside class="sidebar d-none d-lg-block">
    <div class="sidebar-header">
        <h4 class="mb-0 fw-bold text-primary">
            <i class="bi bi-building me-2"></i>
            EstateVista
        </h4>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('admin.dashboard.*') ? 'active' : '' }}">
            <i class="bi bi-grid"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.properties.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
            <i class="bi bi-buildings"></i>
            {{ $isAgent ? 'Mes Propriétés' : 'Propriétés' }}
            @if($isAgent && $agent)
            <span class="badge bg-primary ms-auto">{{ $agent->properties->count() }}</span>
            @endif
        </a>

        @if($isAdmin)
        <a href="{{ route('admin.customers.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            Clients
        </a>

        <a href="{{ route('admin.agents.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i>
            Agents
        </a>
        @endif

        <a href="{{ route('admin.applications.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            {{ $isAgent ? 'Mes Demandes' : 'Demandes de Location' }}
        </a>

        @if($isAdmin || $isAgent)
        <a href="{{ route('admin.transactions.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i>
            Transactions
        </a>
        @endif

        <a href="{{ route('admin.settings.index') }}"
            class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear"></i>
            Paramètres
        </a>
    </nav>

    <!-- Footer Sidebar -->
    <div class="sidebar-footer">
        <div class="d-flex align-items-center">
            <div
                class="avatar-circle {{ $isAdmin ? 'bg-danger bg-opacity-10 text-danger' : 'bg-primary-soft text-primary' }}">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="ms-3 flex-grow-1">
                <div class="fw-semibold small">{{ $user->name }}</div>
                <div class="text-muted" style="font-size: 0.75rem;">
                    <span class="badge badge-sm bg-{{ $isAdmin ? 'danger' : 'primary' }}">
                        {{ $isAdmin ? 'Admin' : 'Agent' }}
                    </span>
                    @if($isAgent && $agent)
                    <div class="small mt-1">{{ $agent->agency_name }}</div>
                    @endif
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-link text-muted p-0" title="Déconnexion">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</aside>