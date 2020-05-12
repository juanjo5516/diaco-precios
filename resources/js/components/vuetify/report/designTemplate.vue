<template>
  <div>
    <form id="vue-vaciado">
      <el-card class="box-card">

        <el-row :gutter="10">
          <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="12">
            <div class="sub-title">
              Tipo de Visita:
              <strong>*</strong>
            </div>
            <el-select
              v-model="model_response.model_type"
              placeholder="Tipo Visita"
              filterable>
              <el-option
                v-for="item in response_list.response_type"
                :key="item.code"
                :label="item.name"
                :value="item.code"
              ></el-option>
            </el-select>
          </el-col>
          <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="12">
            <div class="sub-title">
              Categoria:
              <strong>*</strong>
            </div>
            <el-select v-model="model_response.model_category" placeholder="Categoria" filterable >
              <el-option
                v-for="item in response_list.response_category"
                :key="item.id_Categoria"
                :label="item.nombre"
                :value="item.id_Categoria"
              ></el-option>
            </el-select>
          </el-col>
        </el-row>

        <el-row :gutter="20" class="my-3 mb-3">
          <el-col :xs="25" :sm="12" :md="8" :lg="9" :xl="12">
            <div>
              Producto:
              <strong>*</strong>
            </div>
            <el-select v-model="model_response.model_product" placeholder="Nuevo Producto" filterable>
              <el-option
                v-for="item in response_list.response_product"
                :key="item.code"
                :label="item.name"
                :value="item.code"
              ></el-option>
            </el-select>
          </el-col>
          <el-col :xs="25" :sm="12" :md="8" :lg="9" :xl="12">
            <div>
              Medida:
              <strong>*</strong>
            </div>
            <el-select v-model="model_response.model_measure" placeholder="Nueva Medida" filterable>
              <el-option
                v-for="item in response_list.response_measure"
                :key="item.code"
                :label="item.name"
                :value="item.code"
              ></el-option>
            </el-select>
          </el-col>
          <el-col :xs="25" :sm="8" :md="8" :lg="6" :xl="10">
            <div>Accion:</div>
            <el-button @click="guardar" type="success" size="medium" :loading="handle_load.load_all">Añadir</el-button>
          </el-col>
        </el-row>

        <el-table :data="response_list.response_data" style="width: 100%" border>
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
          v-loading.fullscreen.lock="handle_load.fullscreenLoading"
        >Guardar</el-button>

        <el-button
          @click="newData"
          type="primary"
          class="my-4"
          v-loading.fullscreen.lock="handle_load.fullscreenLoading2"
        >Nueva</el-button>
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
  data() {
    return {
        handle_load: {
            load_all : false,
            fullscreenLoading: false,
            fullscreenLoading2: false,
        },
        urlRequest: 
          {
              getInfor: '/findAllVisita',
              getAllProduct: '/findAllProducto',
              getAllmeasure: '/findAllmeasure',
              postProductandMeasure: '/getProductoAndMeasure',
              postTemplate: '/addDesignTemplate',
              getCategory: 'getCategory',
          },
        response_list: {
            response_category: [],
            response_type: [],
            response_product: [],
            response_measure: [],
            response_data: [],
        },
        model_response: {
            model_category: "",
            model_type: "",
            model_product: "",
            model_measure: "",
        }
      
    };
  },
  mounted() {
    this.getData();
    this.getAllProduct();
    this.getAllmeasure();
    this.getCategory();
  },
  methods: {
    getCategory(){
          axios.get(this.urlRequest.getCategory).then(response =>{
              this.response_list.response_category = response.data;
          })
      },
    getData() {
      axios
        .get(this.urlRequest.getInfor)
            .then(response => {
            this.response_list.response_type = response.data;
            })
    },
    getAllProduct: function() {
      axios
        .get(this.urlRequest.getAllProduct)
            .then(res => {
            this.response_list.response_product = res.data;
            })
    },
    getAllmeasure: function() {
      axios
        .get(this.urlRequest.getAllmeasure)
        .then(res => {
          this.response_list.response_measure = res.data;
        })
    },

    guardar: function() {
      if (this.model_response.model_measure === "" || this.model_response.model_product === "") {
        this.$notify.error({
          title: "Datos Vacios",
          message: "Por favor complete los campos requeridos",
          duration: 2000
        });
      } else {
        this.handle_load.load_all = true;
        const h = this.$createElement;
        axios
          .post(this.urlRequest.postProductandMeasure, {
            producto: this.model_response.model_product,
            medida: this.model_response.model_measure
          })
          .then(res => {
            this.response_list.response_data.push({
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
              this.handle_load.load_all = false;
              this.model_response.model_product = "";
              this.model_response.model_measure = "";
     
            }
          });
      }
    },
    handleDelete(row) {
      this.response_list.response_data.splice(row, 1);
      this.$notify({
        title: "Eliminación",
        message: "Registro Eliminado, con exito!",
        position: "bottom-right"
      });
    },
    submit() {
      if (
        this.model_response.model_type === "" || 
        this.model_response.model_category === "" ||
        this.response_list.response_data === ""
      ) {
        this.$message({
          showClose: true,
          message: "Por favor complete los campos requeridos.",
          type: "error",
          center: true
        });
      } else {
        const h = this.$createElement;
        this.handle_load.fullscreenLoading = true;
        
        axios
          .post(this.urlRequest.postTemplate, {
            type: this.model_response.model_type,
            category: this.model_response.model_category,
            Dproducto: this.response_list.response_data
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
              this.handle_load.fullscreenLoading = false;
              this.clear();
            }
          });
      }
    },
    clear() {
      this.response_list.response_data = [];
      this.model_response.model_category = "";
      this.model_response.model_type = "";

    },
    newData() {
      this.response_list.response_data = [];
      this.model_response.model_category = "";
      this.model_response.model_type = "";
      this.$notify({
        title: "Nuevo",
        message: "Nueva Plantilla",
        type: "success"
      });
    }
  }
};
</script>