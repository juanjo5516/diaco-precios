<template>
  <div>
    <el-form :inline="false" :model="formInline" ref="formInline" class="form" :rules="rules">
      <el-form-item label="Nombre: " prop="name">
        <el-input v-model="formInline.name"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button
          @click="onSubmit('formInline')"
          type="primary"
          class="btn btn-success"
          v-loading.fullscreen.lock="fullscreenLoading"
        >Guardar</el-button>
      </el-form-item>
    </el-form>
    <el-table
      :data="plantillasall.slice((currentPage-1)*pagesize,currentPage*pagesize).filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))"
      style="width: 100%"
      border
    >
      <el-table-column prop="code" label="#" width="50"></el-table-column>
      <el-table-column prop="name" label="Nombre"></el-table-column>
      <el-table-column label="Operaciones" width="200">
        <template slot="header" slot-scope="scope">
          <el-input
            v-model="search"
            size="mini"
            placeholder="Buscar"/>
        </template>
        <template slot-scope="scope">
          <el-button size="mini"  @click="handleEdit(scope.row.code)">Editar</el-button>
          <el-button
            size="mini"
            type="danger"
            @click="handleDelete(scope.row.code)"
          >Eliminar</el-button>
        </template>
      </el-table-column>
    </el-table>
    <div style="text-align: left;margin-top: 30px;">
      <el-pagination
        background
        layout="total,prev, pager, next"
        :total="total"
        @current-change="current_change"
      ></el-pagination>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      plantillasall: [],
      total: 0,
      currentPage: 1,
      pagesize: 10,
      formInline: {
        name: ""
      },

      names: "",
      fullscreenLoading: false,
      loading: false,
      rules: {
        name: [
          {
            required: true,
            message: "Ingrese Nombre de Producto",
            trigger: "blur"
          }
        ]
      },
      search: ''
    };
  },
  mounted() {
    this.getPlantillasData();
  },
  methods: {
    getPlantillasData: function() {
      var url = "/findAllProducto";
      axios.get(url).then(response => {
        this.plantillasall = response.data;
        this.total = response.data.length;
      });
    },
    onSubmit(formName) {
        const h = this.$createElement;
        this.$refs[formName].validate(valid => {
        if (valid) {
          this.fullscreenLoading = true;
          var url = "/addProducto";
          axios
            .post(url, {
              names: this.formInline.name
            })
            .then(response => {
              const status = JSON.parse(response.status);
              if (status == "200") {
                this.$message({
                  message: h("p", null, [
                    h("i", { style: "color: teal" }, "Producto Agregado!")
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
        } else {
            this.$message.error({
                message: h("p", null, [
                h("i", { style: "color: red" }, 'Ingrese un Nombre de Producto')
                ])
            });
          return false;
        }
      });
    },
    current_change: function(currentPage) {
      console.log(currentPage);
      this.currentPage = currentPage;
    },
    handleSizeChange(val) {
      console.log(`${val} items per page`);
    },
    handleDelete(row) {
        const config = { headers: {'Content-Type': 'application/json'} };
        const h = this.$createElement;
          this.fullscreenLoading = true;
          var url = "/deleteProducto";
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
                    h("i", { style: "color: teal" }, "Producto Eliminado!")
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
            this.getPlantillasData();
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
    }
  }
};
</script>

<style lang="scss" scoped>
</style>