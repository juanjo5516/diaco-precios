<template>
     <el-card class="box-card">
    <div slot="header" class="clearfix">
      <span>Bandeja de Salida</span>
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
          label="Fecha de Envio">
          <template slot-scope="scope">
                <i class="el-icon-time"></i>
                <span style="margin-left: 10px">{{ scope.row.created_at }}</span>
            </template>
        </el-table-column>
      <el-table-column
        width="220"
        label="Operaciones">
        <template slot-scope="scope">
          <el-link :underline=false v-bind:href="'/Printer/'+scope.row.id" :id=scope.row.id_Asignacion>
            <el-button
              size="small"
              type="warning"
              icon="el-icon-printer"
              plain
              >Imprimir 
            </el-button>
          </el-link>
        </template>
      </el-table-column>
    </el-table>
  </el-card> 
</template>

<style>

</style>


<script>
 export default {
        data() {
            return {
                DataResult:[]
            }
          },
          mounted(){
            this.getData();
          },
            methods: {
              getData: function(){
                axios.get('/getEnviados')
                    .then(response => {
                    this.DataResult = response.data;
                    console.log(this.DataResult);
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

