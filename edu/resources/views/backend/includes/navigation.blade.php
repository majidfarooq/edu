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

{{--
    <!-- Nav Item - Pages -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('pages.index')}}">
            <i class="far fa-fw fa-file"></i>
            <span>Pages</span>
        </a>
    </li>--}}

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('users.index')}}">
            <i class="fas fa-fw fa-user"></i>
            <span>Users</span>
        </a>
    </li>

    <!-- Nav Item - Posts Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePost" aria-expanded="true" aria-controls="collapsePost">
            <i class="fa fa-fw fa-clipboard"></i>
            <span>Posts</span>
        </a>
        <div id="collapsePost" class="collapse" aria-labelledby="headingPost" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('admin.posts.index')}}">All Posts</a>
                <a class="collapse-item" href="{{route('admin.post.create')}}">Create Posts</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Categories -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.categories.index')}}">
            <i class="fa fa-fw fa-clipboard"></i>
            <span>Categories</span>
        </a>
    </li>


    <!-- Nav Item - Tags -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('admin.tags.index')}}">
            <i class="fas fa-fw fa-tags"></i>
            <span>Tags</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
