<nav class="sidebar-nav">
    <ul class="nav">
        {{-- Menu y submenu --}}
        @if (Auth()->user()->nombre == 'Juan José Jolón Granados' )
            <li class="nav-title">Catálogos</li>
            <li class="nav-item">
                <a class="nav-link" href=../Producto>
                        <i class="nav-icon fas fa-angle-right"></i> Producto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Categoria">
                        <i class="nav-icon fas fa-angle-right"></i> Categoría</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../SubCategorias">
                        <i class="nav-icon fas fa-angle-right"></i> Sub-Categoría</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Medida">
                        <i class="nav-icon fas fa-angle-right"></i> Medida</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Mercados">
                        <i class="nav-icon fas fa-angle-right"></i> Lugares de Visita</a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link" href="../SMercados">
                        <i class="nav-icon fas fa-angle-right"></i>Super Mercado</a>
            </li> --}}
            {{-- <li class="nav-item">
                    <a class="nav-link" href="../GasPropano">
                            <i class="nav-icon fas fa-angle-right"></i> Gas Propano</a>
                </li> --}}
            <li class="nav-item">
                <a class="nav-link" href="../Establecimiento">
                        <i class="nav-icon fas fa-angle-right"></i> Establecimiento</a>
            </li>

       

            <li class="nav-title">Plantillas</li>
            <li class="nav-item">
                <a class="nav-link" href=../Edicion>
                    <i class="nav-icon fas fa-angle-right"></i> Editor
                </a>
                <a class="nav-link" href=../AsignarSede>
                    <i class="nav-icon fas fa-angle-right"></i> Asignación
                </a>
                <a class="nav-link" href=../clonar>
                    <i class="nav-icon fas fa-angle-right"></i> Clonar plantillas
                </a>
            </li>
        @endif
        <li class="nav-title">Vaciado</li>
        <li class="nav-item nav-dropdown">
            <li class="nav-item">
                <a class="nav-link" href=../Bandeja>
                    <i class="nav-icon fas fa-angle-right"></i> Bandeja</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=../enviados>
                    <i class="nav-icon fas fa-angle-right"></i> Enviados</a>
            </li>
        </li>

        {{-- <li class="nav-title">Vaciado</li>
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon fas fa-angle-double-right"></i> Ingreso</a>
            <ul class="nav-dropdown-items">
                <li class="nav-item">
                    <a class="nav-link" href=../Mercado>
                        <i class="nav-icon fas fa-angle-right"></i> Mercado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="base/breadcrumb.html">
                        <i class="nav-icon fas fa-angle-right"></i> Super Mercado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="base/cards.html">
                        <i class="nav-icon fas fa-angle-right"></i> Tiendas de Barrio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="base/carousel.html">
                        <i class="nav-icon fas fa-angle-right"></i> Gasolineras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="base/collapse.html">
                        <i class="nav-icon fas fa-angle-right"></i> Reporte CBA</a>
                </li>
            </ul>
        </li> --}}
        
    </ul>
</nav>
