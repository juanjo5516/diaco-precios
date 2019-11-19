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
                
                <!-- <el-container>  -->
                    <!-- <el-main> -->
                        <el-row :gutter="10">
                            <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="10">
                                <div >Plantilla:</div>
                                <el-input
                                    placeholder="Ingrese Nombre"
                                    v-model="input"
                                    clearable
                                    name="Nplantilla">
                                </el-input>
                            </el-col>

                            <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="10">
                                <div class="sub-title">Tipo de Plantilla:</div>
                                <select   name="TipoVisita" id="TipoVisita" class="form-control">
                                    <option >Seleccione una Opción</option>
                                    <option v-for="(item, idx) in DataResult" :key="idx" :value="item.id_TipoVerificacion">{{ item.nombreVerificacion}}</option>  
                                </select>
                            </el-col>
                           

                            <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="10">
                                <div class="sub-title">Categoria:</div>
                                <select   name="categoriaVaciado" id="categoriaVaciado" class="form-control">
                                    <option >Seleccione una Opción</option>
                                    <option v-for="(item, idx) in coleccion" :key="idx" :value="item.id">{{ item.nombre }}</option>  
                                </select>
                            </el-col>


                            <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="10">
                                <div class="sub-title"># de Columnas:</div>
                                <el-input
                                    placeholder="# Columna"
                                    v-model="nColumnas"
                                    clearable
                                    name="NColumna">
                                </el-input>
                                <!-- <input type="text" class="NColumna form-control" name="NColumna" placeholder="# Columna"  > -->
                            </el-col> 
                        </el-row>
                    <!-- </el-main> -->
                <!-- </el-container>  -->

                <!-- <button type="button" class="btn btn-primary my-3"  id="addLinea" >Ingresar Producto</button> -->
                <!-- <el-button
                    type="success"
                    class="my-3">Ingresar Producto
                </el-button> -->
            </el-card>
            <el-card class="box-card">
            <el-row :gutter="20" class="my-3">
                <el-col :xs="25" :sm="6" :md="8" :lg="9" :xl="10">
                    <div>Producto:</div>
                    <el-select v-model="NewProducto" placeholder="Nuevo Producto">
                        <el-option
                        v-for="item in ListadoProducto"
                        :key="item.code"
                        :label="item.name"
                        :value="item.code">
                        </el-option>
                    </el-select>
                </el-col>
                <el-col :xs="25" :sm="6" :md="8" :lg="9" :xl="10">
                    <div>Medida:</div>
                    <el-select v-model="NewMeasure" placeholder="Nueva Medida">
                        <el-option
                        v-for="item in ListadoMedidas"
                        :key="item.code"
                        :label="item.name"
                        :value="item.code">
                        </el-option>
                    </el-select>
                </el-col>
                <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="10">
                    <div>Accion:</div>
                    <el-button
                    @click="guardar"
                    type="success"
                    size="medium"
                    :loading=load
                    >Añadir</el-button>
                </el-col>
                    <!-- v-loading.fullscreen.lock="fullscreenLoading"  -->
            </el-row>


            <el-table
            :data="respuestaMedida"
            style="width: 100%"
            border>
                <el-table-column  type="index" width="50"></el-table-column>
                <!-- <el-table-column  prop="codeProducto"  label="Código Producto" ></el-table-column> -->
                <el-table-column  prop="nameProducto"  label="Producto" ></el-table-column>
                <!-- <el-table-column  prop="codeMedida"  label="Código Medida" ></el-table-column> -->
                <el-table-column  prop="nameMedida"  label="Medida" ></el-table-column>
                <el-table-column
                    width="150"
                    label="Operaciones">
                    <template slot-scope="scope">
                        <el-button
                        size="mini"
                        type="danger"
                        @click="handleDelete(scope.$index, scope.row)">Eliminar</el-button>
                    </template>
                    </el-table-column>
            </el-table>
                <!-- <div class="table-responsive-sm">   
                    <table class="table "   id="vue-table-productos">
                        <thead class="thead-dark" >
                            <tr>
                                <th >#</th>
                                <th >Producto</th>
                                <th >Medida</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div> -->

               
                    
                    
                            <!-- <button type="submit" class="btn btn-success" id="almacenar"  v-loading.fullscreen.lock="fullscreenLoading">Almacenar Boleta</button> -->
                            <el-button
                            type="primary"
                            class="my-4" 
                            v-loading.fullscreen.lock="fullscreenLoading"
                            >Almacenar Boleta</el-button>
                    
                
                <!-- <div id="snoAlertBox" class="alert alert-warning" data-alert="alert">Plantilla Almacenada.</div>
                <div id="snoAlertBoxE" class="alert alert-danger" data-alert="alert">Error al ingresar la Boleta.</div> -->
        </el-card>
    </form> 
</div>
</template>

<style>

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
            ListadoProducto:[],
            ListadoMedidas:[],
            DataProducto:[],
            NewProducto:"",
            NewMeasure:"",
            respuestaMedida:[],
            respuestaProducto:[],
            load:false,
            respuesta:"",
            medida:"",
            input: '',
            input2: '',
            input3: '',
            nColumnas:"",
            DataResult:[],
            Tipo:"Seleccione una Opción",
            fullscreenLoading: false,
            tableData: [{
            date: '2016-05-03'
          }],
          TipoVisita:"",
          categoriaVaciado:""
            
            }
        },
         mounted() {
            this.getData();
            this.getAllProduct();
            this.getAllmeasure();
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
            },
            getAllProduct: function() {
                axios.get("/findAllProducto")
                .then(res => {
                    this.ListadoProducto = res.data;
                })
                .catch(function(err){
                    console.log(err)
                })
            },
            getAllmeasure: function(){
                axios.get("/findAllmeasure")
                .then(res => {
                    this.ListadoMedidas = res.data;
                })
                .catch(function(err){
                    console.log(err)
                })
            },
            guardar: function() {
                this.load = true;
                const h = this.$createElement;
                axios.post('/getProductoAndMeasure',{producto: this.NewProducto, medida: this.NewMeasure})
                .then(res => {
                        this.respuestaMedida.push({
                            codeProducto:res.data[0].codeProducto,
                            nameProducto:res.data[0].nameProducto,
                            codeMedida:res.data[0].codeMedida,
                            nameMedida:res.data[0].nameMedida,
                        });

                        const status = JSON.parse(res.status);
                        if (status == "200") {
                            
                            this.$notify({
                                title: 'Success',
                                message: 'This is a success message',
                                type: 'success',
                                duration: 2000
                            });
                            this.load = false;
                        }
                });    
            }
        }
    }
    
</script>



