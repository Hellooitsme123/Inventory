<!-- Admin -->
@if (Auth::check())
    <ul class="navbar-nav bg-gradient-blue-800 sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <div class="sidebar-brand-text">Inventory System</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Items
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ Route::is('food.index') || Route::is('food.create') || Route::is('food.edit') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFood" aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-table"></i>
                <span>Food</span>
            </a>
            <div id="collapseFood" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('food.index') }}">List</a>
                    <a class="collapse-item" href="{{ route('food.create') }}">Create</a>
                </div>
            </div>
        </li>

        <li class="nav-item {{ Route::is('recipes.index') || Route::is('recipes.create') || Route::is('recipes.edit') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRecipes" aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-table"></i>
                <span>Recipes</span>
            </a>
            <div id="collapseRecipes" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('recipes.index') }}">List</a>
                    <a class="collapse-item" href="{{ route('recipes.create') }}">Create</a>
                </div>
            </div>
        </li>

        <li class="nav-item {{ Route::is('tags.index') || Route::is('tags.create') || Route::is('tags.edit') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTags" aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-table"></i>
                <span>Tags</span>
            </a>
            <div id="collapseTags" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('tags.index') }}">List</a>
                    <a class="collapse-item" href="{{ route('tags.create') }}">Create</a>
                </div>
            </div>
        </li>

        

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            User
        </div>

        <li class="nav-item {{ Route::is('tags.index') || Route::is('tags.create') || Route::is('tags.edit') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTags" aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-table"></i>
                <span>Users</span>
            </a>
            <div id="collapseTags" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('tags.index') }}">List</a>
                    <a class="collapse-item" href="{{ route('tags.create') }}">Create</a>
                </div>
            </div>
        </li>

        

        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Other
        </div>

        <li class="nav-item {{ Route::is('tags.index') || Route::is('tags.create') || Route::is('tags.edit') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTags" aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-table"></i>
                <span>Settings</span>
            </a>
            <div id="collapseTags" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('tags.index') }}">List</a>
                    <a class="collapse-item" href="{{ route('tags.create') }}">Create</a>
                </div>
            </div>
        </li>

        

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
<!-- Staff -->
@else
    <ul class="navbar-nav bg-gradient-blue-800 sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <div class="sidebar-brand-text">Inventory System</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading 
        <div class="sidebar-heading">
            News
        </div>

        

        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Other
        </div>

        

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
@endif
