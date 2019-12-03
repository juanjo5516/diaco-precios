<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src=" {{ asset('images/diaco/logo.webp') }}"  width="119" height="45" alt="Diaco">
        <img class="navbar-brand-minimized" src=" {{ asset('images/diaco/logo.webp') }} " width="30" height="30" alt="Diaco">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <ul class="nav navbar-nav ml-auto" >
        <li>
                <a class="btn" href="/Bandeja">
                    <i class="fas fa-mail-bulk"></i> &nbsp;Bandeja</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                aria-expanded="false">
                <img class="img-avatar" src="{{ asset('images/diaco/user.png') }}" alt="admin@bootstrapmaster.com">
                <span>{{ auth()->user()->login!=null ? auth()->user()->login : "Administrator" }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header text-center">
                    <strong>Herramientas</strong>
                </div>
                <a class="dropdown-item" href="../logout">
                    <i class="fa fa-lock"></i> Cerrar Sesión</a>
                <a class="dropdown-item" href="../changePasswordUser">
                    <i class="fa fa-lock"></i> Cambiar Clave</a>
            </div>
        </li>
    </ul>
</header>
