<template>
<div class="">
    <el-form 
        :inline="false" 
        :model="formInline" 
        class="form"
        id="vue-Asignacion"
        
    >
        <el-form-item label="Plantillas: "> 
          <el-select  name="idSede" class="vue-select" v-model="select1" placeholder="Plantillas">
                <el-option v-for="(item,idx) in coleccion" :key="idx" :label=" item.NombreTemplate " :value=" item.id "></el-option>
            </el-select>
        </el-form-item>
        
        <el-form-item label="Sedes: ">
            <el-select  name="idSede" class="vue-select" v-model="select2" placeholder="Sedes">
                <el-option v-for="(item,idx) in Sedes" :key="idx" :label=" item.nombre_sede " :value=" item.id_diaco_sede "></el-option>
            </el-select>
        </el-form-item>

        <el-form-item>
            <button @click="onSubmit" type="submit" class="btn btn-success" id="btnAsignar">Asignar</button>
        </el-form-item>
    </el-form>
    <div id="snoAlertBox" class="alert alert-warning" data-alert="alert">Asignación Exitosa.</div>
    <div id="snoAlertBoxE" class="alert alert-danger" data-alert="alert">Error al asignar.</div>
    <div class="container-fluid">
      <table class="table table-responsive" id="table-vue-asede">
        <thead>
          <tr>
            <th>Plantilla</th>
            <th>Sede</th>
            <th>Estado</th>
            <th>Controles</th>
          </tr>
        </thead>
      </table>
    </div>
</div>

</template>


<style>
    .vue-select{
        width: 100%;
        font-weight: bold;
    }
    .el-form-item__label{
        font-weight: bold;
        font-size: 1em;
    }


</style>


<script>
  export default {
    props: ['coleccion','Sedes'],
    data() {
      return {

        select1: 'Seleccione una Opción',
        select2: 'Seleccione una Opción',
        formInline: {
        },
        Data:[],
        search: '',
        SPlantilla:'',
        SSede:'',
        created_at_new:''
      }
    },
    
     methods: {
      onSubmit: function(){
        var url = 'http://128.5.101.19:8000/aLista';
        axios.post(url, {
            SPlantilla: this.select1,
            SSede: this.select2,
            created_at_new: new Date(),
        }).then(response =>{
            $('#table-vue-asede').DataTable().ajax.reload();
            $("#snoAlertBox").fadeIn();
            closeSnoAlertBox("#snoAlertBox");
        }).catch(error => {
				console.log(error.message)
        });
      },
      // resetDateFilter() {
      //   this.$refs.filterTable.clearFilter('date');
      // },
      // clearFilter() {
      //   this.$refs.filterTable.clearFilter();
      // },
      //  formatter(row, column) {
      //   return row.address;
      // },
      // filterTag(value, row) {
      //   return row.tag === value;
      // },
      // filterHandler(value, row, column) {
      //   const property = column['property'];
      //   return row[property] === value;
      // },
      handleEdit(index, row) {
        console.log(index, row);
      },
      handleDelete(index, row) {
        console.log(index, row);
      }
    }
  }
</script>