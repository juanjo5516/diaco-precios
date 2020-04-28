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
        :data="plantillasall.slice((currentPage - 1) * pagesize,currentPage * pagesize)"
        :empty-text="mensajeData"
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
        <!-- <el-table-column
      label="Operaciones"
      width="200">
      <template slot-scope="scope">
        <el-button
          size="mini"
          @click="handleEdit(scope.$index, scope.row)">Editar</el-button>
        <el-button
          size="mini"
          type="danger"
          @click="handleDelete(scope.row)">Eliminar</el-button>
      </template>
    </el-table-column> -->
    </el-table>
    <div style="text-align: left;margin-top: 30px;" v-if="vista">
        <el-pagination
            background
            :page-size="5"
            layout="total,sizes,prev, pager, next"
            :total="total"
            @current-change="current_change"
            @size-change="handleSizeChange"
            :current-page.sync="currentPage"
            :page-sizes="[5, 10, 20, 100, 200]"
        ></el-pagination>
    </div>
    </div>
</div>
</template>

<style>
</style>

<script>
export default {
    // props: ['plantillasall'],
    data() {
      return {

        getPlantilla: 'Seleccione una Opción',
        currentPage: 1,
        pagesize: 5,
        currentPage2: 5,
        vista: true,
        total: 0,
        mensajeData: "Cargando datos...",
        input:'',
        // select2: 'Seleccione una Opción',
        formInline: {
        },
        // Data:[],
        // search: '',
        SPlantilla:'',
        dataResponse:'',
        plantillasall:[]
        // SSede:'',
        // created_at_new:''
      }
    },
    mounted() {
            this.getPlantillasData();
    },
     methods: {
       clear_input(){
         this.input = "";
         this.getPlantilla = "";
       },
        verPlantilla: function(){
            const h = this.$createElement;
            var url = '/getPlantillaClone';
            axios.post(url,{
                SPlantilla: this.getPlantilla,
                dataResponse: this.input
            }).then(response => {
              console.log("true")
                const status = JSON.parse(response.status);
                if (status == '200') {
                    this.getPlantillasData(); 
                    this.$message({
                      message: h("p", null, [
                      h("i", { style: "color: teal" }, "Plantilla copiada!")
                      ]),
                      type: 'success'
                    });
                    this.clear_input();
                }
            })
        },
      getPlantillasData: function(){
          var url = '/getPlantillaClon';
          axios.get(url)
            .then(response => {
                this.plantillasall = response.data;
                this.total = response.data.length;
                if (this.DataResult.length == 0) {
                    this.mensajeData =
                        "No se ingresaron datos para esta sede";
                }
            })
      },
      handleEdit(index, row) {
        console.log(index, row);
      },
      handleDelete(row) {

        const config = { headers: {'Content-Type': 'application/json'} };
        const h = this.$createElement;
          this.fullscreenLoading = true;
          var url = "/deleteCategory";
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
                    h("i", { style: "color: teal" }, "Categoria Eliminada!")
                  ]),
                  type: 'success'
                });
                this.formInline.name = "";
                this.fullscreenLoading = false;
                this.getPlantillasData();
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
        console.log(index, row);
      },

      current_change: function(currentPage) {
            this.currentPage = currentPage;
        },
        handleSizeChange(val) {
            this.pagesize = val;
        }
      
    }
  }
</script>