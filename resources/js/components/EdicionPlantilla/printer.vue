<template>
<div class="container" id="DataPrinter">
  <el-card class="box-card">
    <div slot="header" class="clearfix">
      <span>Impresión</span>
    </div>
        <table class="table" >
            <tr >
                <td colspan="12">
                    Fecha: <span>{{ fecha }}</span>
                        <input type="hidden" name="fechaVaciado" value="12-25-25">
                </td>
            </tr>
            <tr v-for="(index , ex) in usuario" :key="ex">
                <td>
                    Sede:
                </td>
                <td colspan="5"  >
                    {{ index.sede }}
                </td>
                <td >
                    Verificador:
                </td>
                <td colspan="5"  >
                    {{ index.nombre }} 
                    
                </td>
            </tr>
        </table>
  
  <br>
    <el-card clas="box-card categoria" v-for="(item, it) in categoria" :key="it">
        <div slot="header" class="clearfix">
            <span >
                {{ item.categoria }}
            </span>
        </div>
        <div>
            <el-table
                :data="tableData"
                style="width: 100%;"
                border="true">
                <el-table-column
                    prop="id"
                    label="Numero"
                    width="80"
                    align="center">
                </el-table-column>
                <el-table-column
                    prop="Establecimiento"
                    label="Nombre del Establecimiento"
                    align="center"
                    
                    >
                </el-table-column>
                <el-table-column
                    prop="local"
                    label="Numero de Local"
                    align="center"
                    width="100">
                </el-table-column>
            </el-table>
        </div>
        <table class="table table-bordered descripcion" >
                    <thead>
                        <tr>
                            <th>
                                Producto
                            </th>
                            <th>
                                Medida
                            </th>
                            <th>
                                1
                            </th>
                            <th>
                                2
                            </th>
                            <th>
                                3
                            </th>
                            <th>
                                4
                            </th>
                            <th>
                                5
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(index, ix) of coleccion " :key="ix" v-if="index.categoria == item.categoria">
                                <td >
                                    {{ index.produto }}
                                </td>
                                <td >
                                    {{ index.medida }}
                                </td>
                                <td >
                                    &nbsp;
                                </td>
                                <td >
                                    &nbsp;
                                </td>
                                <td >
                                    &nbsp;
                                </td>
                                <td >
                                    &nbsp;
                                </td>
                                <td >
                                    &nbsp;
                                </td>
                        </tr>
                    </tbody>
                </table>
    </el-card>


  </el-card>
</div> 
</template>

<style>
    .has-gutter{
        text-align: center!important;
    }

    .el-card{
        margin-bottom:25px !important;
    }

    .descripcion{
        margin-top:20px;
    
    }
  
    .descripcion td{
        border: 1px solid #dbdbdb !important;
        
    }

    .descripcion th{
        text-align: center !important;
    }

</style>


<script>
    export default {
        props: ['fecha','usuario','coleccion','categoria'],
        data() {
            return {
                DataResult:[],
                tableData: [{
                    id: '1',
                    Establecimiento: '',
                    local: ''
                }, {
                    id: '2',
                    Establecimiento: '',
                    local: ''
                }, {
                    id: '3',
                    Establecimiento: '',
                    local: ''
                }, {
                    id: '4',
                    Establecimiento: '',
                    local: ''
                },{
                    id: '5',
                    Establecimiento: '',
                    local: ''
                }]
                
            }
          },
          mounted(){
            // invocar los métodos
            this.getData();
            
          },
          methods: {
            viewPrinter: function(){
              axios.get('/Printer').
              then(response => {
                console.log("s");
              })
            },
              getData: function(){
              axios.get('/getinbox')
                .then(response => {
                  // handle success
                  this.DataResult = response.data;
                  console.log(this.DataResult);
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                })
                .finally(function () {
                  // always executed
                });
            },
            handleEdit(index, row) {
                console.log(index,row);
                //return view('Ediciones.printer')
            },
            pollData () {
             setInterval(() => {
                console.log('RETRIEVE_DATA_FROM_BACKEND')
              }, 3000)
            }
          //   onSubmit: function(){
          //     var url = '/aLista';
          //     axios.post(url, {
          //         SPlantilla: this.select1,
          //         SSede: this.select2,
          //         created_at_new: new Date(),
          //     }).then(response =>{
          //         $('#table-vue-asede').DataTable().ajax.reload();
          //         $("#snoAlertBox").fadeIn();
          //         closeSnoAlertBox("#snoAlertBox");
          //     }).catch(error => {
          //     console.log(error.message)
          //     });
          //   }
            }
    }
</script>

