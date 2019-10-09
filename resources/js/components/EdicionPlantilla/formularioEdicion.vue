<template>
<div>
    <form id="vue-vaciado">
        <el-card class="box-card">
                <table class="table" >
                    <tr>
                        <td colspan="3" class="fecha">
                            Fecha: <span> {{ fecha }}   </span> 
                            <input type="hidden" name="fechaVaciado" :value=" fecha ">  
                        </td>
                    </tr>
                </table>
                <el-container>
                    <el-main>
                        <el-row :gutter="15">
                            <el-col :span="6">
                                <div class="sub-title">Nombre de la Plantilla:</div>
                                <el-input
                                    placeholder="Ingrese Nombre"
                                    v-model="input"
                                    clearable
                                    name="Nplantilla">
                                </el-input>
                            </el-col>
                            <el-col :span="6">
                                <div class="sub-title">Tipo de Plantilla:</div>
                                <select   name="TipoVisita" id="TipoVisita" class="form-control">
                                    <option >Seleccione una Opción</option>
                                    <option v-for="(item, idx) in DataResult" :key="idx" :value="item.id_TipoVerificacion">{{ item.nombreVerificacion}}</option>  
                                </select>
                            </el-col>
                            <el-col :span="6">
                                <div class="sub-title">Categoria:</div>
                                <select   name="categoriaVaciado" id="categoriaVaciado" class="form-control">
                                    <option >Seleccione una Opción</option>
                                    <option v-for="(item, idx) in coleccion" :key="idx" :value="item.id">{{ item.nombre }}</option>  
                                </select>
                            </el-col>
                            <el-col :span="6">
                                <div class="sub-title"># de Columnas:</div>
                                <!-- <el-input
                                    placeholder="# columna"
                                    v-model="input2"
                                    clearable
                                    class="NColumna"
                                    name="NColumna">
                                </el-input> -->
                                <input type="text" class="NColumna form-control" name="NColumna" placeholder="# Columna"  >
                            </el-col>
                        </el-row>
                    </el-main>
                </el-container>
                <button type="button" class="btn btn-primary" id="addLinea">Ingresar Producto</button>
                <table class="table" id="vue-table-productos">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Medida</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                    
                    <div class="fecha">
                            <button type="submit" class="btn btn-success" id="almacenar">Almacenar Boleta</button>
                    </div>
                
                <div id="snoAlertBox" class="alert alert-warning" data-alert="alert">Plantilla Almacenada.</div>
                <div id="snoAlertBoxE" class="alert alert-danger" data-alert="alert">Error al ingresar la Boleta.</div>
        </el-card>
    </form> 
</div>
</template>

<style>
    .table td{
        border:0;

    }

    .select{
        height: 85% !important;
    }
    .column-title-vue{
        text-align: right;
        font-weight: bold;
        width:20%;
    }
    .btn-vue{
        text-align: right;
    }
</style>

<script>
    export default {
        props: ['fecha','coleccion'],
        data() {
            return {
            input: '',
            input2: '',
            input3: '',
            DataResult:[],
            Tipo:"Seleccione una Opción",
            tableData: [{
            date: '2016-05-03'
          }],
          TipoVisita:"",
          categoriaVaciado:""
            
            }
        },
         mounted() {
            this.getData();
        },methods: {
            getData: function(){
              axios.get('/getTipo')
                .then(response => {
                  this.DataResult = response.data;

                })
                .catch(function (error) {
                  console.log(error);
                })
                .finally(function () {
                });
            }
        }
    }
    
</script>



