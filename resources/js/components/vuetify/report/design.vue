<template>
  <div>
    <el-container style="height: 700px; ">
      <el-aside width="300px">
        <el-card class="box-card">
          <el-row :gutter="10">
            <el-col :span="10" class="mb-2">Departamento:</el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col>
              <el-select
                v-model="model_request.model_departament"
                placeholder="Departamento"
                @change="municipios"
              >
                <el-option
                  v-for="(item, i) in list_response.list_departament"
                  v-bind:key="i"
                  :label="item.nombre_departamento"
                  :value="item.codigo_departamento"
                ></el-option>
              </el-select>
            </el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col :span="10" class="mt-3 mb-2">Municipio:</el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col>
              <el-select v-model="model_request.model_municipio" placeholder="Municipio">
                <el-option
                  v-for="(item, i) in list_response.list_municipios"
                  v-bind:key="i"
                  :label="item.nombre_municipio"
                  :value="item.codigo_municipio"
                ></el-option>
              </el-select>
            </el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col :span="10" class="mt-3 mb-2">Tipo:</el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col>
              <el-select v-model="model_request.model_type_category" placeholder="Categoría">
                <el-option
                  v-for="(item, i) in list_response.list_type_category"
                  v-bind:key="i"
                  :label="item.name"
                  :value="item.code" 
                ></el-option>
              </el-select>
            </el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col :span="10" class="mt-3 mb-2">Categoría:</el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col>
              <el-select v-model="model_request.model_category" placeholder="Categoría">
                <el-option
                  v-for="(item, i) in list_response.list_category"
                  v-bind:key="i"
                  :label="item.nombre"
                  :value="item.id_Categoria" 
                ></el-option>
              </el-select>
            </el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col :span="15">
              <div class="mt-3 ">
                <span class="mb-3">Fecha Inicial:</span>
                <el-date-picker
                  v-model="model_request.model_range_initial"
                  type="date"
                  size="large"
                  clearable
                  placeholder="Inicio">
                </el-date-picker>
              </div>
            </el-col>
          </el-row>
          <el-row :gutter="10">
            <el-col :span="15">
              <div class="mt-3 ">
                <span class="mb-3">Fecha Final:</span>
                <el-date-picker
                  v-model="model_request.model_range_final"
                  type="date"
                  size="large"
                  clearable
                  placeholder="Fin">
                </el-date-picker>
              </div>
            </el-col>
          </el-row>
          <el-row >
            <div class="mt-3">
              <el-button type="primary">Generar</el-button>
            </div>
          </el-row>
        </el-card>
      </el-aside>
      <el-container>
        <el-main>
          <div class="d-flex justify-content-center" v-if="loading_true">
            <div class="spinner-grow  text-primary" style="width: 4rem; height: 4rem; margin-top: 200px;" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
        </el-main>
      </el-container>
    </el-container>
  </div>
</template>

<style lang="css">

</style>
<script>
export default {
  data() {
    return {
      url_response: {
        departament: "departamentos",
        municipios: "getMunicipio",
        type: "findAllVisita",
        category: "getCategory",
      },
      list_response: {
        list_departament: [],
        list_municipios: [],
        list_category: [],
        list_type_category: [],
      },
      model_request: {
        model_departament: "",
        model_municipio: "",
        model_category: "",
        model__type_category: "",
        model_range_initial:"",
        model_range_final:"",
      },
      loading_true:false
    };
  },
  mounted() {
    this.getDepartament();
    this.getTypeCategory();
    this.getCategory();
  },
  methods: {
    getDepartament() {
      axios.get(this.url_response.departament).then(response => {
        this.list_response.list_departament = response.data;
      });
    },
    municipios(dato) {
      this.model_request.model_municipio = "";
      axios
        .post(this.url_response.municipios, {
          id: dato
        })
        .then(response => {
          this.list_response.list_municipios = response.data; 
        });
    },
    getTypeCategory() {
      axios.get(this.url_response.type).then(response => {
        this.list_response.list_type_category = response.data;
      });
    },
    getCategory() {
      axios.get(this.url_response.category).then(response => {
        this.list_response.list_category = response.data;
      });
    }
  }
};
</script>