<template>
  <div>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header text-white bg-primary">Información Pública</div>
            <div class="card-body">
                <el-row :gutter="10">
                    <el-col :xs="25" :sm="6" :md="8" :lg="20" :xl="14">
                        <el-form :model="form" :rules="rules" ref="form">
                            <el-form-item label="Departamento: " prop="departamento">
                            <el-select
                                v-model="form.departamento"
                                placeholder="Departamentos"
                                filterable
                                clearable
                                @change="sedes"
                                v-loading.fullscreen.lock="loader.loaderDepto.status"
                                :element-loading-text="loader.loaderDepto.text"
                                :element-loading-spinner="loader.loaderDepto.spinner"
                                :element-loading-background="loader.loaderDepto.color"
                            >
                                <el-option
                                v-for="(item,i) in responseList.listDepartamento"
                                v-bind:key="i"
                                :label="item.name"
                                :value="item.code"
                                ></el-option>
                            </el-select>
                            </el-form-item>
                            <el-form-item label="Sede:" prop="sede">
                            <el-select
                                :disabled="handlerSelect.selectSede"
                                v-model="form.sede"
                                placeholder="Sedes"
                                filterable
                                clearable
                                @change="producto"
                                v-loading.fullscreen.lock="loader.loaderSede.status"
                                :element-loading-text="loader.loaderSede.text"
                                :element-loading-spinner="loader.loaderSede.spinner"
                                :element-loading-background="loader.loaderSede.color"
                            >
                                <el-option
                                v-for="(item,i) in responseList.listSedes"
                                v-bind:key="i"
                                :label="item.name"
                                :value="item.code"
                                ></el-option>
                            </el-select>
                            </el-form-item>
                            <el-form-item label="Producto:" prop="producto">
                            <el-select
                                :disabled="handlerSelect.selectProducto"
                                v-model="form.producto"
                                placeholder="Producto"
                                filterable
                                clearable
                                @change="precios"
                            >
                                <el-option
                                v-for="(item,i) in responseList.listPrecios"
                                v-bind:key="i"
                                :label="item.name"
                                :value="item.code"
                                ></el-option>
                            </el-select>
                            </el-form-item>
                        </el-form>
                    </el-col>
                    <el-col :xs="25" :sm="6" :md="8" :lg="20" :xl="10">
                        <el-table :data="responseList.listPreciosPublic">
                            <el-table-column prop="name" width="180"></el-table-column>
                            <el-table-column prop="uom" width="180">
                                <template slot-scope="scope"  >
                                    <div v-for="item in scope.row.uom" :key="item.code">

                                    <span>
                                        {{ item.name}}

                                    </span>
                                    </div>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-col>
                </el-row>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="css">
.cuadro {
  width: 13px;
  height: 13px;
  border-radius: 0.1em;
  border: 1px solid gray;
  display: inline-block;
  margin: 0.1em;
}
.card {
  border: none;
  margin-bottom: 0 auto;
  border-radius: 0.5em;
  padding: 0;
  background: #fff;
  color: #000;
  transition: all 400ms ease-out;
}

.el-table th{
    background: none !important;
}
</style>
<script>
export default {
  data() {
    return {
      loader: {
        loaderDepto: {
          status: true,
          text: "Cargando Información",
          spinner: "el-icon-loading",
          color: "rgba(0, 0, 0, 0.8)",
        },
        loaderSede: {
          status: false,
          text: "Cargando Información",
          spinner: "el-icon-loading",
          color: "rgba(0, 0, 0, 0.8)",
        },
      },
      handlerSelect: {
        selectSede: true,
        selectProducto: true,
      },
      form: {
        departamento: "",
        sede: "",
        producto: "",
      },
      url: {
        Departamentos: "api/categoriasPublicas",
        precios: "api/preciosPublicos/",
      },
      responseList: {
        listDepartamento: [],
        listSedes: [],
        listPrecios: [],
        listPreciosPublic: [],
      },
      rules: {
        departamento: [
          {
            required: true,
            message: "Seleccione un Departamento",
            trigger: "blur",
          },
        ],
      },
    };
  },
  methods: {
    getDepartamentos() {
      axios.get(this.url.Departamentos).then((response) => {
        this.responseList.listDepartamento = response.data;
        this.responseList.listDepartamento.length;
        this.loader.loaderDepto.status = false;
        // console.log(this.responseList.listDepartamento);
      });
    },
    sedes(idDepto) {
      this.loader.loaderSede.status = true;
      this.form.sede = "";
      for (
        let index = 0;
        index < this.responseList.listDepartamento.length;
        index++
      ) {
        if (this.responseList.listDepartamento[index].code === idDepto) {
          this.responseList.listSedes = this.responseList.listDepartamento[
            index
          ].branches;
        }
      }
      this.loader.loaderSede.status = false;
      this.handlerSelect.selectSede = false;
    },
    producto(idsede) {
        this.handlerSelect.selectProducto = false;
      this.form.producto = "";
      for (let index = 0; index < this.responseList.listSedes.length; index++) {
        if (this.responseList.listSedes[index].code === idsede) {
          this.responseList.listPrecios = this.responseList.listSedes[
            index
          ].categories;
        }
      }
      // console.log(this.responseList.listPrecios);
    },
    precios() {
      axios
        .get(this.url.precios + this.form.sede + "/" + this.form.producto)
        .then((response) => {
          this.responseList.listPreciosPublic = response.data;
          console.log(this.responseList.listPreciosPublic);
        });
    },
  },
  mounted() {
    this.getDepartamentos();
  },
};
</script>