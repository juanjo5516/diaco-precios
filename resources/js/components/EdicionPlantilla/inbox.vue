<template>
  <el-card class="box-card">
    <div slot="header" class="clearfix">
      <span>Bandeja de Entrada</span>
    </div>
    <el-table
        :data="DataResult"
        border
        stripe
        style="width: 100%">

        <el-table-column
          prop="NombreTemplate"
          label="Nombre"
          >
        </el-table-column>
        <el-table-column
          prop="nombre_sede"
          label="Sede"
          >
        </el-table-column>
        <el-table-column
          prop="estatus"
          label="Estatus">
        </el-table-column>
      <el-table-column
        width="220"
        label="Operaciones">
        <template slot-scope="scope">
          <el-link :underline=false v-bind:href="'/vaciado/'+scope.row.id" :id=scope.row.id_Asignacion>  
            <el-button
              size="small"
              type="success"
              icon="el-icon-s-order"
              plain>
              Vaciar
            </el-button>
          </el-link>
          <el-link :underline=false v-bind:href="'/Printer/'+scope.row.id" :id=scope.row.id_Asignacion>
            <el-button
              size="small"
              type="warning"
              icon="el-icon-printer"
              plain
              >Imprimir 
            </el-button>
          </el-link>
          <!-- <el-link :underline=false v-bind:href="'/get-pdf/'+scope.row.id" :id=scope.row.id_Asignacion>
            <el-button
              size="small"
              type="warning"
              icon="el-icon-printer"
              plain
              >Imprimir 2
            </el-button>
          </el-link> -->
          
          <!-- <el-button
            size="small"
            type="warning"
            icon="el-icon-printer"
            plain
            href="/Printer"
            @click="handleEdit(scope.$index, scope.row)">Imprimir
          </el-button> -->
        </template>
      </el-table-column>
    </el-table>
  </el-card> 
</template>

<style>
  .has-gutter{
    text-align: center;
  }

</style>


<script>
// import pdfData from "./components/pdf/pdfDemo.vue";
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
                  //console.log(this.DataResult);
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                })
                .finally(function () {
                  // always executed
                });
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

