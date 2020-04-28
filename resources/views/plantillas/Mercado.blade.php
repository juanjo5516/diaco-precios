<form id="addVaciados">
    <div class="border-shadow" >
        <div class="row card">
                <div class="card-header">
                    Vaciado de Mercado
                </div>
                <div class="card-body Linea">
                    <table class="table" >
                        <tr >
                            <td colspan="12" class="fecha">
                                Fecha: <span>{{ $fecha }}</span>
                                {{-- fecha --}}
                                    <input type="hidden" name="fechaVaciado" value="{{ $fecha }}">
                            </td>
                        </tr>
                        <tr >
                            <td  class="column-title">
                                Sede:
                            </td>
                            {{-- sede --}}
                            <td colspan="5" class="column-data" >
                                @foreach($Nsede as $key)
                                <input type="hidden" name="sedeVaciado" id="sedeVaciado" value="{{ $key->id }}">
                                    {{ $key->sede }}
                                @endforeach
                            </td>
                            <td  class="column-title">
                                Categoria:
                            </td>
                            {{-- categoria --}}
                            <td colspan="5" class="column-data-select" >
                                <select name="categoriaVaciado" id="categoriaVaciado" class="form-control">
                                    <option value="-1">Seleccione una Opción</option>
                                    @foreach ($collection as $item)
                                        <option  value="{{ $item->id }}">{{ $item->nombre }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        <tr >
                            <td  class="column-title">
                                Verificador:
                            </td>
                            {{-- verificador --}}
                            <td colspan="5" class="column-data" >
                                @foreach($Nsede as $key)
                                <input type="hidden" name="verificadorVaciado" id="verificadorVaciado" value="{{ $key->id_usuario }}">
                                {{ $key->nombre }}
                                @endforeach
                            </td>
                           
                        </tr>

                        <tr>
                            <td  class="column-title">
                                Mercado:
                            </td>
                            {{-- Mercado --}}
                            <td colspan="5" class="column-data">
                                <select name="mercadoVaciado" id="mercadoVaciado" class="form-control">
                                    <option value="-1">Seleccione una Opción</option>
                                    @foreach ($mercado as $mercados)
                                        <option value="{{ $mercados->id }}">{{ $mercados->nombre }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td  class="column-title">
                                Dirección:
                            </td>
                            {{-- Direccion Mercado --}}
                            <td colspan="5" class="column-data-select">
                                    <input  class="form-control" type="text" name="direccionMercadoVaciado" id="direccionMercadoVaciado"  >
                            </td>
                        </tr>
                        <tr>
                            <td  class="column-title">
                                Establecimiento:
                            </td>
                            {{-- Establecimiento --}}
                            <td colspan="5" class="column-data-select">
                                <select name="establecimientoVaciado" id="establecimientoVaciado" class="form-control">
                                    <option value="-1">Seleccione una Opción</option>
                                    @foreach ($establecimiento as $Establecimiento)
                                        <option value="{{ $Establecimiento->id }}">{{ $Establecimiento->nombre }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td  class="column-title">
                                Dirección:
                            </td>
                            {{-- Direccion Establecimiento --}}
                            <td colspan="5" class="column-data-select">
                                <input  class="form-control" type="text" name="direccionEstablecimientoVaciado" id="direccionEstablecimientoVaciado"  >
                            </td>
                        </tr>
                        <tr>
                            <td colspan="12" class="fecha">
                                    <button type="button" class="btn btn-primary" id="addLinea">Ingresar Producto</button>
                            </td>
                        </tr>
                        
                        <tr>
                            <table class="table" id="TDProductos">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th>Medida</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                            </table>
                        </tr>
                        <td colspan="12" class="fecha">
                                <button type="submit" class="btn btn-success" id="almacenar">Almacenar Boleta</button>
                        </td>
                    </table>
                    <div id="snoAlertBox" class="alert alert-warning" data-alert="alert">Boleta Almacenada.</div>
                    <div id="snoAlertBoxE" class="alert alert-danger" data-alert="alert">Error al ingresar la Boleta.</div>
                </div>
        </div>
    </div>
</form>

