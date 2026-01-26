<div>
    <li class="nav-item dropdown header-profile">
        <a class="nav-link" href="#" role="button" data-toggle="dropdown"><small>{{ Auth::user()->name }}</small>
            <i class="mdi mdi-account"></i>
            <span class="badge {{ Auth::user()->IsOnline == 0  ?'badge-danger' :'badge-success' }}  badge-pill" style="height: 20px; position: absolute;top:20px; "> </span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            @livewire('auth.logout')
        </div>
    </li>
</div>
