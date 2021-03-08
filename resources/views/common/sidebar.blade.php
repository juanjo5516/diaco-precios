<nav class="sidebar-nav">  
    <ul class="nav">
        @if (Auth()->user()->nombre == 'Juan José Jolón Granados'  || Auth()->user()->nombre == 'Herberth Ordoñez' || Auth()->user()->nombre == 'Jorge Carballo' || Auth()->user()->nombre == 'Oliver Salvador' || Auth()->user()->nombre == 'Sergio Eduardo Golón Díaz')
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" >Catálogos</a>
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
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" >Plantillas</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href=/Edicion>
                            <i class="nav-icon fas fa-angle-right"></i> Editor
                        </a>
                        <a class="nav-link" href=/AsignarSede>
                            <i class="nav-icon fas fa-angle-right"></i> Asignación
                        </a>
                        <a class="nav-link" href=/design_template>
                            <i class="nav-icon fas fa-angle-right"></i> Diseñar Plantilla
                        </a>
                        <a class="nav-link" href=/clonar>
                            <i class="nav-icon fas fa-angle-right"></i> Clonar plantillas
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" >Reporte</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href=/revisarEnvio>
                            <i class="nav-icon fas fa-angle-right"></i> Revisar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=/envio_sede>
                            <i class="nav-icon fas fa-angle-right"></i> Enviados por Sedes</a> 
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=/reportDesign>
                            <i class="nav-icon fas fa-angle-right"></i> Reporte General</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href=/Edicion>
                            <i class="nav-icon fas fa-angle-right"></i> Editor
                        </a>
                        <a class="nav-link" href=/AsignarSede>
                            <i class="nav-icon fas fa-angle-right"></i> Asignación
                        </a>
                        <a class="nav-link" href=/clonar>
                            <i class="nav-icon fas fa-angle-right"></i> Clonar plantillas
                        </a>
                    </li> --}}
                </ul>
            </li>
            <!-- <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" >Reportes</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href=/reportDesign>
                            <i class="nav-icon fas fa-angle-right"></i> Reporte General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=/envio_sede>
                            <i class="nav-icon fas fa-angle-right"></i> Enviados por Sedes</a> 
                    </li>

                </ul>
            </li> -->
            <!-- <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">Api</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href=/verify2>
                            <i class="nav-icon fas fa-angle-right"></i> Api</a>
                    </li>
                </ul>
            </li> -->
            @endif
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" >Vaciado</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link" href=/Bandeja>
                            <i class="nav-icon fas fa-angle-right"></i> Bandeja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=/enviados>
                            <i class="nav-icon fas fa-angle-right"></i> Enviados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=/asignacionUsuario>
                            <i class="nav-icon fas fa-angle-right"></i> Asignar</a>
                    </li>
                    
                </ul>
            </li>
    </ul>
</nav>
