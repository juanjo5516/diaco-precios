<template>
  <div>
    <form id="vue-vaciado">
      <el-card class="box-card">
        <table class="table">
          <tr>
            <td colspan="3" class="fecha">
              Fecha:
              <span>{{ fecha }}</span>
              <input type="hidden" name="fechaVaciado" :value=" fecha " />
            </td>
          </tr>
        </table>
        <el-row :gutter="10">
          <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="10">
            <div>
              Plantilla:
              <strong>*</strong>
            </div>
            <el-input
              placeholder="Ingrese Nombre"
              v-model="input"
              clearable
              :autofocus="focus"
              name="Nplantilla"
            ></el-input>
          </el-col>

          <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="10">
            <div class="sub-title">
              Tipo de Plantilla:
              <strong>*</strong>
            </div>
            <el-select
              v-model="selectTPlantilla"
              placeholder="Tipo Plantilla"
              filterable
             
            >
              <el-option
                v-for="item in DataResult"
                :key="item.code"
                :label="item.name"
                :value="item.code"
              ></el-option>
            </el-select>
          </el-col>

          <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="10">
            <div class="sub-title">
              Categoria:
              <strong>*</strong>
            </div>
            <el-select v-model="selectCategoria" placeholder="Categoria" filterable >
              <el-option
                v-for="item in coleccion"
                :key="item.id"
                :label="item.nombre"
                :value="item.id"
              ></el-option>
            </el-select>
          </el-col>

          <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="10">
            <div class="sub-title">
              # de Columnas (Cantidad de Establecimientos a visitar):
              <strong>*</strong>
            </div>
            <el-input
              placeholder="# Columna"
              v-model="nColumnas"
              clearable
              :disabled="activado"
              name="NColumna"
            ></el-input>
          </el-col>
        </el-row>
      </el-card>

      <el-card class="box-card">
        <el-row :gutter="20" class="my-3">
          <el-col :xs="25" :sm="12" :md="8" :lg="9" :xl="10">
            <div>
              Producto:
              <strong>*</strong>
            </div>
            <el-select v-model="NewProducto" placeholder="Nuevo Producto" filterable>
              <el-option
                v-for="item in ListadoProducto"
                :key="item.code"
                :label="item.name"
                :value="item.code"
              ></el-option>
            </el-select>
          </el-col>
          <el-col :xs="25" :sm="12" :md="8" :lg="9" :xl="10">
            <div>
              Medida:
              <strong>*</strong>
            </div>
            <el-select v-model="NewMeasure" placeholder="Nueva Medida" filterable>
              <el-option
                v-for="item in ListadoMedidas"
                :key="item.code"
                :label="item.name"
                :value="item.code"
              ></el-option>
            </el-select>
          </el-col>
          <el-col :xs="25" :sm="8" :md="8" :lg="6" :xl="10">
            <div>Accion:</div>
            <el-button @click="guardar" type="success" size="medium" :loading="load">Añadir</el-button>
          </el-col>
        </el-row>

        <el-table :data="respuestaMedida" style="width: 100%" border>
          <el-table-column type="index" width="50"></el-table-column>
          <el-table-column prop="nameProducto" label="Producto"></el-table-column>
          <el-table-column prop="nameMedida" label="Medida"></el-table-column>
          <el-table-column width="150" label="Operaciones">
            <template slot-scope="scope">
              <el-button
                size="mini"
                type="danger"
                @click="handleDelete(scope.$index, scope.row)"
              >Eliminar</el-button>
            </template>
          </el-table-column>
        </el-table>
        <!-- <button type="submit" class="btn btn-success" id="almacenar"  v-loading.fullscreen.lock="fullscreenLoading">Almacenar Boleta</button> -->
        <el-button
          @click="submit"
          type="primary"
          class="my-4"
          v-loading.fullscreen.lock="fullscreenLoading"
        >Almacenar Boleta</el-button>
        

        <el-button
          @click="newData"
          type="primary"
          class="my-4"
          v-loading.fullscreen.lock="fullscreenLoading2"
        >Nueva Boleta</el-button>
      </el-card>
    </form>
  </div>
</template>

<style lang="css" scoped>
strong {
  color: red;
}
</style>

<script>
export default {
  props: ["fecha", "coleccion"],
  data() {
    return {
      links: [],
      state: "",
      timeout: null,
      ListadoProducto: [],
      ListadoMedidas: [],
      DataProducto: [],
      selectTPlantilla: "",
      selectCategoria: "",
      NewProducto: "",
      NewMeasure: "",
      respuestaMedida: [],
      load: false,
      medida: "",
      input: "",
      input2: "",
      input3: "",
      nColumnas: "",
      DataResult: [],
      Tipo: "Seleccione una Opción",
      fullscreenLoading: false,
      fullscreenLoading2: false,
      TipoVisita: "",
      categoriaVaciado: "",

      datos: [],
      activado: false,
      focus: true,

      urlRequest: 
          {
              getInfor: '/findAllVisita',
              getAllProduct: '/findAllProducto',
              getAllmeasure: '/findAllmeasure',
              postProductandMeasure: '/getProductoAndMeasure',
              postTemplate: '/addPlantillas',
          }
      
    };
  },
  mounted() {
    this.getData();
    this.getAllProduct();
    this.getAllmeasure();
  },
  methods: {
      test(){
          axios.get('test/123').then(response =>{
              console.log(response.data);
          })
      },
    getData() {
      axios
        .get(this.urlRequest.getInfor)
            .then(response => {
            this.DataResult = response.data;
            })
    },
    getAllProduct: function() {
      axios
        .get(this.urlRequest.getAllProduct)
            .then(res => {
            this.ListadoProducto = res.data;
            })
    },
    getAllmeasure: function() {
      axios
        .get(this.urlRequest.getAllmeasure)
        .then(res => {
          this.ListadoMedidas = res.data;
        })
    },
    guardar: function() {
      if (this.NewMeasure === "" || this.NewProducto === "") {
        this.$notify.error({
          title: "Datos Vacios",
          message: "Por favor complete los campos requeridos",
          duration: 2000
        });
      } else {
        this.load = true;
        const h = this.$createElement;
        axios
          .post(this.urlRequest.postProductandMeasure, {
            producto: this.NewProducto,
            medida: this.NewMeasure
          })
          .then(res => {
            this.respuestaMedida.push({
              codeProducto: res.data[0].codeProducto,
              nameProducto: res.data[0].nameProducto,
              codeMedida: res.data[0].codeMedida,
              nameMedida: res.data[0].nameMedida
            });

            const status = JSON.parse(res.status);
            if (status == "200") {
              this.$notify({
                title: "Exitoso",
                message: "Producto Añadido",
                type: "success",
                duration: 2000
              });
              this.load = false;
              this.NewProducto = "";
              this.NewMeasure = "";
              // console.log(this.respuestaMedida);
            }
          });
      }
    },
    handleDelete(row) {
      this.respuestaMedida.splice(row, 1);
      this.$notify({
        title: "Eliminación",
        message: "Registro Eliminado, con exito!",
        position: "bottom-right"
      });
    },
    submit() {
      if (
        this.input === "" ||
        this.nColumnas === "" ||
        this.selectTPlantilla === "" ||
        this.selectCategoria === ""
      ) {
        this.$message({
          showClose: true,
          message: "Por favor complete los campos requeridos.",
          type: "error",
          center: true
        });
      } else {
        const h = this.$createElement;
        this.fullscreenLoading = true;
        var url = "/addPlantillas";
        axios
          .post(this.urlRequest.postTemplate, {
            Nplantilla: this.input,
            TipoVisita: this.selectTPlantilla,
            categoriaVaciado: this.selectCategoria,
            NColumna: this.nColumnas,
            Dproducto: this.respuestaMedida
          })
          .then(response => {
            const status = response.status;
            if (status == "200") {
              this.$message({
                message: h("p", null, [
                  h("i", { style: "color: teal" }, "Plantilla Almacenada!")
                ]),
                type: "success"
              });
              this.fullscreenLoading = false;
              this.clear();
            }
          });
      }
    },
    clear() {
      this.respuestaMedida = [];
      //  this.input = "",
      this.selectTPlantilla = "";
      this.selectCategoria = "";
      this.activado = true;
    },
    newData() {
      //  this.fullscreenLoading2 = true;
      this.respuestaMedida = [];
      this.input = "";
      this.selectTPlantilla = "";
      this.selectCategoria = "";
      this.nColumnas = "";
      this.$notify({
        title: "Nuevo",
        message: "Nueva Plantilla",
        type: "success"
      });
      //  this.fullscreenLoading2 = false;
    }
  }
};
</script>



