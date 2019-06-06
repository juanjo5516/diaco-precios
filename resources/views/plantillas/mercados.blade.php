<div class="row wow fadeIn">
        <div class="col-md-12 mb-12">
            <div class="card mb-12">
                <div class="card-header text-left">
                    Vaciado de Mercados
                </div>
                <div class="card-body">
                    <div class="row">      
                        <div class="fecha col-12">Fecha: <span>{{ $fecha }}</span>
                                <input type="hidden" name="dFecha" id="dFecha" value={{ $fecha }}>
                        </div>
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr >
                                        <td class="CData">Sede Departamental:</td>
                                        @foreach($Nsede as $key)
                                            <td class="CResult">{{ $key->sede }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="CData">Verificador:</td>
                                        @foreach($Nsede as $key)
                                            <td class="CResult">{{ $key->nombre }}</td>
                                        @endforeach
                                    </tr>
                                    <tr class="CData">
                                        <td>Lugar de Visita:</td>
                                        <td>
                                          <input type="text" class="form-control" name="lvisita" id="lvisita"  placeholder="">
                                        </td>
                                    </tr>
                                    <tr class="CData">
                                        <td>Dirección de Visita:</td>
                                        <td>
                                            <input type="text" class="form-control" name="dvisita" id="dvistia" placeholder="">
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                    {{-- <form id="addProductos" class="Fdata ">
                        <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <label for="nombreP">Nombre: </label>
                            <input type="text" class="form-control" name="nombreP" id="nombreP">
                        </div>
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </form> --}}
                    <div id="snoAlertBox" class="alert alert-warning" data-alert="alert">Producto Almacenado.</div>
                    <div id="snoAlertBoxE" class="alert alert-danger" data-alert="alert">Error al ingresar un producto.</div>
            
                </div>
            </div>
        </div>
    </div>
<div class="Productos">
    <div class="row ">
            <div class="col-md-12 mb-12">
                <div class="card mb-12">
                    <div class="card-header text-left">
                        Establecimiento
                    </div>
                    <div class="card-body">
                        <div class="row">      
                            
                            <div class="col-12 Linea">
                                <table class="table ">
                                    <tbody>
                                        <tr>
                                            <td class="CData">Categoría:</td>
                                                <td class="CResult">
                                                    <select class="form-control" name="Dcategoria" id="Dcategoria">
                                                        @foreach ($collection as $item)
                                                            <option  value="{{ $item->id }}">{{ $item->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                        </tr>
                                        <tr>
                                            <td class="CData">Establecimiento:</td>
                                                <td class="CResult">
                                                        <input type="text" class="form-control" name="dEstablecimiento" id="dEstablecimiento" placeholder="">
                                                 </td>
                                        </tr>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    
    <div class="row ">
            <div class="col-md-12 mb-12">
                <div class="card mb-12">
                    <div class="card-header text-left">
                        Productos
                    </div>
                    <div class="card-body">
                        <div class="row">      
                            <div class="col-12 Linea">
                                <form id="DproductoT">
                                    <table class="table " >
                                        <tbody>
                                            <tr>
                                                <td  class="CData">Producto:</td>
                                                    <td colspan="3" class="CResult">
                                                        <select class="form-control" name="Dproducto" id="Dproducto">
                                                            @foreach ($producto as $item)
                                                                <option  value="{{ $item->id }}">{{ $item->Pnombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                            </tr>
                                            <tr>
                                                <td class="CData">Medida:</td>
                                                <td style="width:350px">
                                                    <select class="form-control" name="Dmedida" id="Dmedida">
                                                            @foreach ($medida as $medidas)
                                                                <option  value="{{ $medidas->id }}">{{ $medidas->nombre }}</option>
                                                            @endforeach
                                                    </select>
                                                </td>
                                                <td class="CDataS">Precio:</td>
                                                <td style="width:350px;">
                                                    <input type="text" class="form-control" name="Dprecio" id="Dprecio" placeholder="">                                                      
                                                </td>
                                            </tr>                                        
                                        </tbody>
                                    </table>
                                    <div class="Pagrega">
                                            <button type="submit" class="btn btn-primary" >Ingresar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="row ">
        <div class="col-md-12 mb-12">
            <div class="card mb-12">
                <div class="card-header text-left">
                    Detalle
                </div>
                <div class="card-body">
                    <div class="row">      
                        <div class="col-12 Linea">
                            <table class="table" id="TDProductos">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Medida</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>





