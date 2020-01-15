<template>
<div class="">
    <el-form 
        :inline="false" 
        :model="formInline" 
        class="form"
        id="vue-Asignacion"
        
    >
        <el-form-item label="Usuarios: "> 
          <el-select  name="idSede" class="vue-select" v-model="select1" placeholder="Usuarios">
                <el-option v-for="(item,idx) in coleccion" :key="idx" :label=" item.name " :value=" item.code "></el-option>
            </el-select>
        </el-form-item>
        
        <el-form-item label="Sede: ">
            <el-select   name="idSede" class="vue-select" v-model="select2" placeholder="Sedes">
                <el-option v-for="(item,idx) in Sedes" :key="idx" :label=" item.nombre_sede " :value=" item.id_diaco_sede "></el-option>
            </el-select>
        </el-form-item>

        <el-form-item>
            <!-- <button @click="onSubmit" type="submit" class="btn btn-success" id="btnAsignar">Asignar</button> -->
            <el-button
              @click="onSubmit"
              type="success"
              size="medium"
              :loading=load
              >Asignar</el-button>
        </el-form-item>
    </el-form>
    <div id="snoAlertBox" class="alert alert-warning" data-alert="alert">Asignación Exitosa.</div>
    <div id="snoAlertBoxE" class="alert alert-danger" data-alert="alert">Error al asignar.</div>
    <div class="container-fluid">

      <el-table
      :data="plantillasall.slice((currentPage-1)*pagesize,currentPage*pagesize).filter(data => !search || data.nombre_sede.toLowerCase().includes(search.toLowerCase()))"
      style="width: 100%"
      border
    >
      <!-- <el-table-column prop="code" label="#" width="50"></el-table-column> -->
      <el-table-column prop="user" label="Nombre"></el-table-column>
      <el-table-column prop="sede" label="Sede"></el-table-column>
      <el-table-column label="Operaciones" width="200">
        <template slot="header" slot-scope="scope">
          <el-input
            v-model="search"
            size="mini"
            placeholder="Buscar"/>
        </template>
        <template slot-scope="scope">
          <!-- <el-button size="mini"  @click="handleEdit(scope.row.code)">Editar</el-button> -->
          <el-button-group>
            <el-button
             size="small"
              type="danger"
              @click="handleDelete(scope.row.code)" 
            >Inactivar</el-button>
          </el-button-group>
        </template>
      </el-table-column>
    </el-table>
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

        plantillasall: [],
        select1: 'Seleccione una Opción',
        select2: 'Seleccione una Opción',
        pagesize: 10,
        total: 0,
        currentPage: 1,
        formInline: {
        },
        Data:[],
        search: '',
        SPlantilla:'',
        SSede:'',
        created_at_new:'',
        fullscreenLoading: false,
        load:false,
      }
    },
     mounted() {
    this.getAsignaciones();
  },
     methods: {
      onSubmit: function(){
        // console.log(this.select2);
        this.load = true;
        const h = this.$createElement;
        var url = '/addUserSystem';
        axios.post(url, {
            usuario: this.select1,
            sede: this.select2
            
        }).then(response =>{
          
            const status = JSON.parse(response.status);
            if (status == "200") {
                
                this.$notify({
                    title: 'Exitoso',
                    message: 'Asignacion Completa',
                    type: 'success',
                    duration: 2000
                });
                this.load = false;
                this.select2 = "";
                this.select1 = "";
                // this.NewProducto = "";
                // this.NewMeasure = "";
                // console.log(this.respuestaMedida);
                this.getAsignaciones();
                
            }
            
        }).catch(error => {
				console.log(error.message)
        });

      },

      getAsignaciones: function() {
      var url = "/findAllUserSystem";
      axios.get(url).then(response => {
        this.plantillasall = response.data;
        // console.log(response);
        this.total = response.data.length;
      });
    },
      handleEdit(row){
        this.$prompt('Nombre Producto', 'Edición de Productos', {
          confirmButtonText: 'Actualizar',
          cancelButtonText: 'Cancel',
          
        }).then(({ value }) => {

        const config = { headers: {'Content-Type': 'application/json'} };
        const h = this.$createElement;
        var url = "/UpdateProduct";
        axios
        .put(url, {
            id: row,
            name: value
        },config
        )
        .then(response => {            
            const status = JSON.parse(response.status);
            if (status == "200") {
            this.$message({
                message: h("p", null, [
                h("i", { style: "color: teal" }, "Datos Actualizados!")
                ]),
                type: 'success'
            });
            this.getAsignaciones();
            }
        })
        .catch(error => {
            this.$message.error({
                message: h("p", null, [
                h("i", { style: "color: red" }, 'Error, servidor no encontrado')
                ])
            });
        });
        }).catch(() => {
          this.$message({
            type: 'info',
            message: 'Proceso Cancelado'
          });       
        });
    },
      handleDelete(row) {
        const config = { headers: {'Content-Type': 'application/json'} };
        const h = this.$createElement;
          this.fullscreenLoading = true;
          var url = "/deleteByIdUserSystem";
          axios
            .put(url, {
              id: row
            },config
            )
            .then(response => {
              
              const status = JSON.parse(response.status);
              if (status == "200") {
                this.$message({
                  message: h("p", null, [
                    h("i", { style: "color: teal" }, "Asignación inactivada!")
                  ]),
                  type: 'success'
                });
                // this.formInline.name = "";
                this.fullscreenLoading = false;
                this.getAsignaciones();
              }
            })
            .catch(error => {
                this.$message.error({
                  message: h("p", null, [
                    h("i", { style: "color: red" }, 'Error, servidor no encontrado')
                  ])
                });
                this.fullscreenLoading = false;
            });

    },
       current_change: function(currentPage) {
      // console.log(currentPage);
      this.currentPage = currentPage;
    },
    handleSizeChange(val) {
      console.log(`${val} items per page`);
    },
    }
  }
</script>