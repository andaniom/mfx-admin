<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
       href="{{ route('home.index') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ url('/') }}/img/favicon.ico" style="width: 5rem;">
        </div>
        <div class="sidebar-brand-text mx-3">MFX Admin <sup>Billionaire</sup></div>
    </a>

    <div class="sidebar-items d-flex flex-col">
    @foreach ($menuItems as $item)
        @if ($item->children->isEmpty())
            @can($item->route)
                <hr class="sidebar-divider my-0">
                <li class="nav-item {{ (request()->is($item->url != '/' ? ltrim($item->url, '/') : '/')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url($item->url) }}">
                        {{--                <i class="fas fa-fw fa-tachometer-alt"></i>--}}
                        <span>{{$item->name}}</span></a>
                </li>
            @endcan
        @elseif ($item->children->isNotEmpty())
            @hasanyrole('admin|superadmin')
                <hr class="sidebar-divider my-0">
                <li class="nav-item ">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                       aria-expanded="true" aria-controls="collapsePages">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Admin</span>
                    </a>
                    <div id="collapsePages" class="collapse {{ (request()->is('admin/*')) ? 'show' : '' }}"
                         aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @foreach ($item->children as $child)
                                @can($child->route)
                                    <a class="collapse-item {{ (request()->is(ltrim($item->url, '/').$child->url."*")) ? 'active' : '' }}"
                                       href="{{ url($item->url.$child->url) }}">{{$child->name}}</a>
                                @endcan
                            @endforeach
                        </div>
                    </div>
                </li>
            @endrole
        @endif
    @endforeach

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    </div>
</ul>
