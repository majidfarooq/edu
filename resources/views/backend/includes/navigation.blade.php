<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin.home')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">CMS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('admin.home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Menus Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMenus" aria-expanded="true" aria-controls="collapseMenus">
            <i class="fas fa-fw fa-cog"></i>
            <span>Menus</span>
        </a>
        <div id="collapseMenus" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                @isset($menus)
                    @foreach($menus as $menu)
                        <a class="collapse-item text-capitalize" href="{{ route('menu.show',$menu->slug) }}">{{ $menu->title.' Menu' }}</a>
                    @endforeach
                @endisset
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true" aria-controls="collapsePage">
            <i class="fa fa-fw fa-clipboard"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePage" class="collapse" aria-labelledby="headingPost" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('pages.index')}}">Pages</a>
                <a class="collapse-item" href="{{route('elements.index')}}">Elements</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
            <i class="fa fa-fw fa-clipboard"></i>
            <span>Users</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingPost" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('users.student')}}">Student</a>
                <a class="collapse-item" href="{{route('users.university')}}">University</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseApplications" aria-expanded="true" aria-controls="collapseApplications">
            <i class="fa fa-fw fa-clipboard"></i>
            <span>Applications</span>
        </a>
        <div id="collapseApplications" class="collapse" aria-labelledby="headingPost" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('admin.applications')}}">Index</a>
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
