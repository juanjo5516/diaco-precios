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
                        </td>
                    </tr>
                    <tr >
                        <td  class="column-title">
                            Sede:
                        </td>
                        <td colspan="5" class="column-data">
                            Sede central
                        </td>
                        <td  class="column-title">
                            Categoria:
                        </td>
                        <td colspan="5" class="column-data-select">
                            <select name="" id="" class="form-control">
                                <option value="">1</option>
                                <option value="">2</option>
                                <option value="">3</option>
                            </select>
                        </td>
                    </tr>

                    <tr >
                        <td  class="column-title">
                            Verificador:
                        </td>
                        <td colspan="5" class="column-data">
                            Juan José Jolón Granados
                        </td>
                        <td  class="column-title">
                            Establecimiento:
                        </td>
                        <td colspan="5" class="column-data-select">
                            <select name="" id="" class="form-control">
                                <option value="">Frutas 1</option>
                                <option value="">Mercado 2</option>
                                <option value="">Carniceria </option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td  class="column-title">
                            Mercado:
                        </td>
                        <td colspan="5" class="column-data">
                            <select name="" id="" class="form-control">
                                <option value="">Mercado 1</option>
                                <option value="">Mercado 2</option>
                                <option value="">Mercado 3 </option>
                            </select>
                        </td>
                        <td  class="column-title">
                            Dirección:
                        </td>
                        <td colspan="5" class="column-data-select">
                            <input  class="form-control" type="text" name="" id="" value="2 calle 1-25 zona 1" disabled>
                        </td>
                    </tr>
                    <tr>
                        <form id="DproductoT">
                            <td  class="column-title">
                                Producto:
                            </td>
                            <td colspan="3" class="column-data">
                                <select name="Dproducto" id="Dproducto" class="form-control">
                                    <option value="">Producto 1</option>
                                    <option value="">Producto 2</option>
                                    <option value="">Producto 3 </option>
                                </select>
                            </td>
                            <td  class="column-title">
                                Medida:
                            </td>
                            <td colspan="3" class="column-data-select">
                                <select name="Dmedida" id="Dmedida" class="form-control">
                                    <option value="">Libra</option>
                                    <option value="">Manojo</option>
                                    <option value="">Mercado 3 </option>
                                </select>
                            </td>
                            <td  class="column-title">
                                    Precio:
                            </td>
                            <td colspan="3" class="column-data-select">
                                <input  class="form-control" type="text" name="Dprecio" id="Dprecio" value="Q 25.65"  required>
                            </td>
                        
                        </tr>
                        <tr >
                            <td colspan="12" class="fecha">
                                    <button type="submit" class="btn btn-primary" >Ingresar Producto</button>
                            </td>
                        </tr>
                    </form>
                    <tr>
                        <table class="table" id="TDProductos">
                            <thead class="table-dark">
                                <tr>
                                    <th>Producto</th>
                                    <th>Medida</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                        </table>
                    </tr>
                    <td colspan="12" class="fecha">
                            <button type="submit" class="btn btn-success" >Almacenar Boleta</button>
                    </td>
                </table>
            </div>
    </div>
</div>


