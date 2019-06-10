<div class="row wow fadeIn">
        <div class="col-md-12 mb-12">
            <div class="card mb-12 border-shadow">
                <div class="card-header text-left">
                    Catálogo de Mercados
                </div>
                <div class="card-body">
                    <!-- <canvas id="pieChart"></canvas> -->
                    <form id="addMercados" class="Fdata">
                        <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <label for="nombreP">Nombre: </label>
                            <input type="text" class="form-control" name="nombreM" id="nombreM">
                        </div>
                        <div class="form-group col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <label for="nombreP">Dirección: </label>
                                <input type="text" class="form-control" name="direccionM" id="direccionM">
                            </div>
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </form>
                    <div id="snoAlertBox" class="alert alert-warning" data-alert="alert">Mercado Almacenada.</div>
                    <div id="snoAlertBoxE" class="alert alert-danger" data-alert="alert">Error al ingresar el Mercado.</div>
                
                    <div class="container">
                        <table class="table table-striped display table-bordered tData" id="tMercados" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>