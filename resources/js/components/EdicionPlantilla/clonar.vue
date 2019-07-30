<template>
<div class="">
    <el-form 
        :inline="false" 
        :model="formInline" 
        ref="formInline"
        class="form"
        
        >
        <el-form-item label="Nombre: "> 
            <el-input placeholder="Please input" v-model="input"></el-input>
        </el-form-item>
        
        <el-form-item label="Plantillas: ">
            <el-select  name="idPlantilla" class="vue-select" v-model="getPlantilla" placeholder="Sedes">
                 <el-option v-for="(item,idx) in plantillasall" :key="idx" :label=" item.NombreTemplate " :value=" item.id "></el-option>
            </el-select>
        </el-form-item>

        <el-form-item>
            <el-button type="primary" @click="verPlantilla">Clonar</el-button>
            <!-- // <button @click="verPlantilla"  class="btn btn-success">Clonar</button> -->
        </el-form-item>
    </el-form>

    <div id="snoAlertBox" class="alert alert-warning" data-alert="alert">Asignación Exitosa.</div>
    <div id="snoAlertBoxE" class="alert alert-danger" data-alert="alert">Error al asignar.</div>

    <div class="container-fluid">

    <el-table
        :data="plantillasall"
        style="width: 100%"
        border>
        <el-table-column
        prop="id"
        label="Correlativo"
        width="180">
        </el-table-column>
        <el-table-column
        prop="NombreTemplate"
        label="Nombre"
    >
        </el-table-column>
        <el-table-column
      label="Operaciones"
      width="200">
      <template slot-scope="scope">
        <el-button
          size="mini"
          @click="handleEdit(scope.$index, scope.row)">Editar</el-button>
        <el-button
          size="mini"
          type="danger"
          @click="handleDelete(scope.$index, scope.row)">Eliminar</el-button>
      </template>
    </el-table-column>
    </el-table>
    </div>
</div>
</template>

<style>
</style>

<script>
export default {
    props: ['plantillasall'],
    data() {
      return {

        getPlantilla: 'Seleccione una Opción',
        input:'',
        // select2: 'Seleccione una Opción',
        formInline: {
        },
        // Data:[],
        // search: '',
        SPlantilla:'',
        dataResponse:'',
        // SSede:'',
        // created_at_new:''
      }
    },
    
     methods: {
        verPlantilla: function(){
            
            var url = '/getPlantillaClone';
            axios.post(url,{
                SPlantilla: this.getPlantilla,
                dataResponse: this.input
            }).then(response => {
                console.log(response.data);
            })
        }
        ,
      // onSubmit: function(){
      //   var url = '/aLista';
      //   axios.post(url, {
      //       SPlantilla: this.select1,
      //       SSede: this.select2,
      //       created_at_new: new Date(),
      //   }).then(response =>{
      //       $('#table-vue-asede').DataTable().ajax.reload();
      //       $("#snoAlertBox").fadeIn();
      //       closeSnoAlertBox("#snoAlertBox");
      //   }).catch(error => {
			// 	console.log(error.message)
      //   });
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