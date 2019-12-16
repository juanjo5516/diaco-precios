
<nav class="sidebar-nav">
    <ul class="nav">
        @if (Auth()->user()->nombre == 'Juan José Jolón Granados'  || Auth()->user()->nombre == 'Herberth Ordoñez' || Auth()->user()->nombre == 'Jose Gudiel' || Auth()->user()->nombre == 'Carlos Paxtor' || Auth()->user()->nombre == 'Oliver Salvador' || Auth()->user()->nombre == 'Javier Pineda')
            <li class="nav-title">Catálogos</li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-star"></i> Catálogos</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href=/Producto>
                                <i class="nav-icon fas fa-angle-right"></i> Producto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Categoria">
                                <i class="nav-icon fas fa-angle-right"></i> Categoría</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/Medida">
                                        <i class="nav-icon fas fa-angle-right"></i> Medida</a>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link" href="/Mercados">
                                        <i class="nav-icon fas fa-angle-right"></i> Lugares de Visita</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/Establecimiento">
                                        <i class="nav-icon fas fa-angle-right"></i> Establecimiento</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/viewVisita">
                                        <i class="nav-icon fas fa-angle-right"></i> Tipo Visita</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/viewUsuariosSistema">
                                        <i class="nav-icon fas fa-angle-right"></i> Usuarios Sistema</a>
                            </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=/Producto>
                        <i class="nav-icon fas fa-angle-right"></i> Producto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Categoria">
                        <i class="nav-icon fas fa-angle-right"></i> Categoría</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Medida">
                        <i class="nav-icon fas fa-angle-right"></i> Medida</a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="/Mercados">
                        <i class="nav-icon fas fa-angle-right"></i> Lugares de Visita</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Establecimiento">
                        <i class="nav-icon fas fa-angle-right"></i> Establecimiento</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/viewVisita">
                        <i class="nav-icon fas fa-angle-right"></i> Tipo Visita</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/viewUsuariosSistema">
                        <i class="nav-icon fas fa-angle-right"></i> Usuarios Sistema</a>
            </li>

            <li class="nav-title">Plantillas</li>
            <li class="nav-item">
                <a class="nav-link" href=/Edicion>
                    <i class="nav-icon fas fa-angle-right"></i> Editor
                </a>
                <a class="nav-link" href=/AsignarSede>
                    <i class="nav-icon fas fa-angle-right"></i> Asignación
                </a>
                <a class="nav-link" href=/clonar>
                    <i class="nav-icon fas fa-angle-right"></i> Clonar plantillas
                </a>
            </li>
            <li class="nav-title">Reporte</li>
            <li class="nav-item nav-dropdown">
            </li>
        @endif
        <li class="nav-title">Vaciado</li>
        <li class="nav-item nav-dropdown">
            <li class="nav-item">
                <a class="nav-link" href=/Bandeja>
                    <i class="nav-icon fas fa-angle-right"></i> Bandeja</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=/enviados>
                    <i class="nav-icon fas fa-angle-right"></i> Enviados</a>
            </li>
        </li>
    </ul>
</nav>
