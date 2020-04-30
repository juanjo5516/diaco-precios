<template>
  <div>
    <el-container style="height: 500px; ">
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
        </el-card>
      </el-aside>
    </el-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      url_response: {
        departament: "departamentos",
        municipios: "getMunicipio",
      },
      list_response: {
        list_departament: [],
        list_municipios: [],
      },
      model_request: {
        model_departament: "",
        model_municipio: "",
      }
    };
  },
  mounted() {
    this.getDepartament();
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
    }
  }
};
</script>