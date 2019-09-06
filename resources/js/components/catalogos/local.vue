<template>
  <div>
    <el-form :inline="false" :model="formInline" ref="formInline" class="form" :rules="rules">
      <el-form-item label="Nombre: " prop="name">
        <el-input v-model="formInline.name"></el-input>
      </el-form-item>
      <el-form-item label="Direcciòn: " prop="address">
        <el-input v-model="formInline.address"></el-input>
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
      <el-table-column prop="address" label="Dirección"></el-table-column>
      <el-table-column label="Operaciones" width="200">
        <template slot="header" slot-scope="scope">
          <el-input
            v-model="search"
            size="mini"
            placeholder="Buscar"/>
        </template>
        <template slot-scope="scope">
          <el-button size="mini"  @click="showDialogEdit(scope.row.code,scope.row.name,scope.row.address)">Editar</el-button>
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

    <el-dialog title="Edición de Mercado" :visible.sync="dialogFormVisible">
      <el-form :model="form">
        <el-form-item label="Nombre" :label-width="formLabelWidth">
          <el-input v-model="form.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="Direccion" :label-width="formLabelWidth">
          <el-input v-model="form.address" autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">Cancelar</el-button>
        <el-button type="primary" @click="handleEdit()">Actualizar</el-button>
      </span>
    </el-dialog>
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
        name: "",
        address:""
      },

      names: "",
      fullscreenLoading: false,
      loading: false,
      rules: {
        name: [
          {
            required: true,
            message: "Ingrese Nombre",
            trigger: "blur"
          }
        ],
        address: [
          {
            required: true,
            message: "Ingrese una Dirección",
            trigger: "blur"
          }
        ]
      },
      search: '',
      address:'',
      dialogFormVisible: false,
      form: {
          name: '',
          address: '',
        },
        formLabelWidth: '120px',
        codeEdit:0
    };
  },
  mounted() {
    this.getPlantillasData();
  },
  methods: {
    getPlantillasData: function() {
      var url = "/findAllLocal";
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
          var url = "/addLocal";
          axios
            .post(url, {
              names: this.formInline.name,
              address: this.formInline.address,
              status: 'A'
            })
            .then(response => {
              const status = JSON.parse(response.status);
              if (status == "200") {
                this.$message({
                  message: h("p", null, [
                    h("i", { style: "color: teal" }, "Establecimiento Agregado!")
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
                h("i", { style: "color: red" }, 'No se permiten datos nulos')
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
          var url = "/deleteByIdLocal";
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
                    h("i", { style: "color: teal" }, "Dato Eliminado!")
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
    showDialogEdit(row,namef,addressf){
      this.dialogFormVisible = true;
      this.codeEdit = row;

      this.form.name = namef;
      this.form.address = addressf;
    },
    handleEdit(row){
        
        const config = { headers: {'Content-Type': 'application/json'} };
        const h = this.$createElement;
        var url = "/updateByIdLocal";
        axios
        .put(url, {
            id: this.codeEdit,
            name: this.form.name,
            address: this.form.address
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
            this.dialogFormVisible = false;
            this.form.name= "";
            this.form.address ="";
            }
        })
        .catch(error => {
            this.$message.error({
                message: h("p", null, [
                h("i", { style: "color: red" }, 'Error, servidor no encontrado')
                ])
            });
        });
        

        
    }
  }
};
</script>

<style lang="scss" scoped>
</style>