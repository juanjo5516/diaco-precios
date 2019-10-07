<template>
  <div>
    <el-form :inline="false" :model="formInline" ref="formInline" class="form" :rules="rules">
      <el-form-item label="Nombre: " prop="name">
        <el-input v-model="formInline.name"></el-input>
      </el-form-item>
      <el-form-item label="Dirección: " prop="address">
        <el-input v-model="formInline.address"></el-input>
      </el-form-item>

         <el-row :gutter="30">
        <el-col :span="12">
            <el-form-item label="Departamento: " prop="departamento_value">
              <el-select v-model="formInline.departamento_value" placeholder="Departamento" filterable @change="municipios">
                  <el-option
                    v-for="(item,index) in departamento"
                    :key="index"
                    :label="item.nombre_departamento"
                    :value="item.codigo_departamento">
                  </el-option>
              </el-select>

              <!-- <el-input v-model="formInline.address"></el-input> -->
            </el-form-item>
        </el-col>
        <el-col :span="12">
            <el-form-item label="Municipio: " prop="municipio_value">
                <el-select v-model="formInline.municipio_value" placeholder="Municipio" filterable >
                    <el-option
                      v-for="(item,index) in municipio"
                      :key="index"
                      :label="item.nombre_municipio"
                      :value="item.codigo_municipio">
                    </el-option>
                </el-select>
              <!-- <el-input v-model="formInline.address"></el-input> -->
            </el-form-item>
        </el-col>
      </el-row>

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
      <el-table-column prop="departamento" label="Departamento"></el-table-column>
      <el-table-column prop="municipio" label="Municipio"></el-table-column>
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
        <el-form-item label="Departamento" :label-width="formLabelWidth">
            <el-select v-model="form.departamento" placeholder="Departamento" filterable @change="municipios">
                  <el-option
                    v-for="(item,index) in departamento"
                    :key="index"
                    :label="item.nombre_departamento"
                    :value="item.codigo_departamento">
                  </el-option>
              </el-select>
        </el-form-item>
        <el-form-item label="Departamento" :label-width="formLabelWidth">
            <el-select v-model="form.municipio" placeholder="Municipio" filterable >
                    <el-option
                      v-for="(item,index) in municipio"
                      :key="index"
                      :label="item.nombre_municipio"
                      :value="item.codigo_municipio">
                    </el-option>
                </el-select>
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
      departamento:[],
      municipio:[],
      total: 0,
      currentPage: 1,
      pagesize: 10,
      formInline: {
        name: "",
        address:"",
        departamento_value:'',
        municipio_value: "",
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
        ],
        departamento_value: [
          {
            required: true,
            message: "Seleccione un Departamento",
            trigger: "blur"
          }
        
        ],
        municipio_value: [
          {
            required: true,
            message: "Seleccione un Municipio",
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
          departamento:"",
          municipio:""
        },
        formLabelWidth: '120px',
        codeEdit:0
    };
  },
  mounted() {
    this.getPlantillasData();
    this.dataDepartamento();
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
              departamento_id: this.formInline.departamento_value,
              municipio_id: this.formInline.municipio_value,
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
                this.formInline.address = "";
                this.municipio_value = "";
                this.departamento_value = "";
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
            address: this.form.address,
            departamento: this.form.departamento,
            municipio: this.form.municipio,
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
    },
     dataDepartamento(){
      var url = '/getDepartamento';
      axios.get(url).then(response => {
        this.departamento = response.data;
        // console.log(this.departamento);
        // this.total = response.data.length;
      });
    },
    dataMunicipio(dato){
      this.municipio = dato;
    },
    municipios(dato){
      var url = '/getMunicipio';
      this.municipio_value = "";
      axios.post(url,{
              id: dato
            }).then(response =>{
              this.dataMunicipio(response.data);
            })
    }
  }
};
</script>

<style lang="scss" scoped>
</style>