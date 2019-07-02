<template>
<div class="container" id="DataPrinter">
  <el-card class="box-card">
    <div slot="header" class="clearfix">
      <span>Impresión</span>
    </div>
  <table class="table" >
                        <tr >
                            <td colspan="12" class="fecha">
                                Fecha: <span>12-25-25</span>
                                12-25-25
                                    <input type="hidden" name="fechaVaciado" value="12-25-25">
                            </td>
                        </tr>
                        <tr >
                            <td  class="column-title">
                                Sede:
                            </td>
                           
                            <td colspan="5" class="column-data" >
                               2
                            </td>
                            <td  class="column-title">
                                Categoria:
                            </td>
                            
                            <td colspan="5" class="column-data-select" >
                                3
                            </td>
                        </tr>

                        <tr >
                            <td  class="column-title">
                                Verificador:
                            </td>
                            
                            <td colspan="5" class="column-data" >
                                4
                            </td>
                           
                        </tr>

                    </table>
  </el-card>
</div> 
</template>

<style>
  .has-gutter{
    text-align: center;
  }

</style>


<script>
    export default {
        data() {
            return {
                DataResult:[]
            }
          },
          mounted(){
            // invocar los métodos
            this.getData();
           // this.pollData();
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
          //     var url = 'http://128.5.101.19:8000/aLista';
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

