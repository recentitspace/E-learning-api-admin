<div class="position-sticky pt-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('module-manager.index') ? 'active' : '' }}" href="{{ route('module-manager.index') }}">
                <span data-feather="home"></span>
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('module-manager.installed') ? 'active' : '' }}" href="{{ route('module-manager.installed') }}">
                <span data-feather="package"></span>
                Installed Modules
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('module-manager.marketplace') ? 'active' : '' }}" href="{{ route('module-manager.marketplace') }}">
                <span data-feather="shopping-bag"></span>
                Marketplace
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('module-manager.envato') ? 'active' : '' }}" href="{{ route('module-manager.envato') }}">
                <span data-feather="shopping-cart"></span>
                Envato Market
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('module-manager.updates') ? 'active' : '' }}" href="{{ route('module-manager.updates') }}">
                <span data-feather="refresh-cw"></span>
                Updates
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('module-manager.settings') ? 'active' : '' }}" href="{{ route('module-manager.settings') }}">
                <span data-feather="settings"></span>
                Settings
            </a>
        </li>
    </ul>
</div>