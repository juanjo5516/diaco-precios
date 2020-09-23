<template>
    <div>
        <el-container style="height: 720px; ">
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
                                filterable
                                @change="municipios"
                            >
                                <el-option
                                    v-for="(item,
                                    i) in list_response.list_departament"
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
                            <el-select
                                v-model="model_request.model_municipio" 
                                placeholder="Municipio"
                                filterable
                            >
                                <el-option
                                    v-for="(item,
                                    i) in list_response.list_municipios"
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
                            <el-select
                                v-model="model_request.model_type_category"
                                placeholder="Categoría"
                                filterable
                            >
                                <el-option
                                    v-for="(item,
                                    i) in list_response.list_type_category"
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
                            <el-select
                                v-model="model_request.model_category"
                                placeholder="Categoría"
                                filterable
                            >
                                <el-option
                                    v-for="(item,
                                    i) in list_response.list_category"
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
                                    format="dd-MM-yyyy"
                                    value-format="dd-MM-yyyy"
                                    type="date"
                                    size="large"
                                    clearable
                                    placeholder="Inicio"
                                >
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
                                    format="dd-MM-yyyy"
                                    value-format="dd-MM-yyyy"
                                    type="date"
                                    size="large"
                                    clearable
                                    placeholder="Fin"
                                >
                                </el-date-picker>
                            </div>
                        </el-col>
                    </el-row>
                    <el-row :gutter="15" class="mb-3 mt-3">
                        <el-col :span="25">
                            <div>
                                <span>Tipo de Busqueda:</span>
                                <el-radio-group
                                    v-model="model_request.radio_select_db"
                                    size="small"
                                >
                                    <el-radio label="Actual" border></el-radio>
                                    <el-radio
                                        label="Anterior"
                                        border
                                    ></el-radio>
                                </el-radio-group>
                            </div>
                        </el-col>
                    </el-row>
                    <el-row>
                        <div class="mt-3">
                            <el-button type="primary" @click="submit"
                                >Generar</el-button
                            >
                            <el-button  type="success" icon="el-icon-printer" @click="exportExcel" ></el-button>
                        </div>


                    </el-row>
                </el-card>
            </el-aside>
            <el-container>
                <el-main>
                    <div
                        class="d-flex justify-content-center"
                        v-if="loading_true"
                    >
                        <div
                            class="spinner-grow  text-primary"
                            style="width: 4rem; height: 4rem; margin-top: 200px;"
                            role="status"
                        >
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <el-alert v-show="catch_error.show"
                        :title="catch_error.title_error"
                        :type="catch_error.type_error"
                        :description="catch_error.description_error"
                        :closable="false"
                        :effect = "catch_error.effect_error" 
                        show-icon>
                    </el-alert>
                    <table class="table" id="exportData">
                        <tbody>
                            <tr
                                v-for="(index, i) in list_response.list_Local"
                                :key="i">
                                <td>
                                  <div class="empresa">
                                    <div >
                                      {{ index.name }}
                                    </div>
                                  </div>
                                </td>
                                <!-- <td colspan="3" v-for="(data,k) in list_response.list_Local_filter" :key="k"> -->
                                <td>
                                  <!-- <div v-if="data.mercado === index.mercado"> -->
                                  <div >
                                      
                                      <el-table
                                          :data="index.items.data"
                                          stripe
                                          :border="value_border"
                                          size="small" 
                                          :empty-text="message_table.mensajeData"
                                          
                                          >
                                          <el-table-column type="index" width="100">
                                          </el-table-column>
                                          <el-table-column
                                              label="Producto"
                                              prop="product"
                                              
                                          ></el-table-column>
                                          <el-table-column
                                              label="Medida"
                                              prop="measure"
                                              width="150"
                                          ></el-table-column>
                                          <el-table-column
                                              label="Precio"
                                              prop="price"
                                              width="150"
                                          ></el-table-column>
                                      </el-table>
                                  </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <table class="table" id="exportData">
                        <tbody>
                            <tr
                                v-for="(index, i) in list_response.list_Local"
                                :key="i">
                                <td>
                                  <div class="empresa">
                                    <div >
                                      {{ index.mercado }}
                                    </div>
                                  </div>
                                </td>
                                <td colspan="3">
                                  <div
                                      v-for="(data,k) in list_response.list_Local_filter" :key="k">
                                      <el-table
                                          :data="data.data"
                                          stripe
                                          :border="value_border"
                                          size="small" 
                                          :empty-text="message_table.mensajeData"
                                          v-if="
                                              data.type ===
                                                  index.nombreMercado">
                                          <el-table-column type="index" width="100">
                                          </el-table-column>
                                          <el-table-column
                                              label="Producto"
                                              prop="producto"
                                              
                                          ></el-table-column>
                                          <el-table-column
                                              label="Medida"
                                              prop="medida"
                                              width="150"
                                          ></el-table-column>
                                          <el-table-column
                                              label="Precio"
                                              prop="precio"
                                              width="150"
                                          ></el-table-column>
                                      </el-table>
                                  </div>
                                </td>
                            </tr>
                        </tbody>
                    </table> -->
                                <!-- <template>
                  <div v-for="(data,k) in list_response.list_Local_filter" :key="k">
                      <td v-if="data.type === index.nombreMercado">{{data.data[k].producto}}</td>
                  </div>
                  <div v-for="(data,k) in list_response.list_Local_filter" :key="k">
                      <td v-if="data.type === index.nombreMercado">{{data.data[k].medida}}</td>
                  </div>
                </template>
                <template>
                  <div v-for="(data,k) in list_response.list_Local_filter" :key="k">
                      <td v-if="data.type === index.nombreMercado">{{data.data[k].precio}}</td>
                  </div>
                </template> -->
                                <!-- <td v-for="(data,k) in list_response.list_Local_filter" :key="k">
                  <span  v-if="data.type === index.nombreMercado">{{data}}</span>
                </td> -->
                        
                        

                    <!-- <el-card v-for="(index,i) in list_response.list_Local" :key="i">
            <div slot="header">
              <span>{{ index.nombreMercado }}</span>
            </div>
            <div v-for="(data,k) in list_response.list_Local_filter" :key="k">
           
              <el-table :data="data.data" v-if="data.type === index.nombreMercado">
                <el-table-column label="Producto" prop="producto"></el-table-column>
                <el-table-column label="Medida" prop="medida"></el-table-column>
                <el-table-column label="Precio" prop="precio"></el-table-column>
              </el-table>
            </div>
          </el-card> -->
                </el-main>
            </el-container>
        </el-container>
    </div>
</template>

<style lang="css">
.table{
  border:none !important;
}

.empresa{
  font-size: 16px;
  width: 150px;
  display: flex;
  align-items: center;
  
}

.row_handle{
  padding-top: 300px !important;
  height: 80px;
  background: #fea;
  border:1px solid #000;
}


.hijo {
   line-height: 150px;
}
</style>
<script>
    import FileSaver from 'file-saver'
    import XLSX from 'xlsx'
    import jsPDF from 'jspdf' 
    import html2canvas from "html2canvas"
    // import domtoimage from "dom-to-image";
    // import 'jspdf-autotable' 
export default {
    data() {
        return {
            size_list: 0,
            value_border:true,
            message_table:{
              mensajeData: "Cargando datos...", 
            },
            catch_error: {
                title_error: "Consulta sin registros",
                type_error: "warning",
                description_error: "No se encontro registros para estos parametros",
                effect_error: "dark",
                show: false
            },
            url_response: {
                departament: "departamentos",
                municipios: "getMunicipio",
                type: "findAllVisita",
                category: "getCategory",
                show_table: "show_table",
                getNameLocal: "getNameLocal",
                getNameLocalFilter: "getNameLocalFilter",
                
            },
            list_response: {
                list_departament: [],
                list_municipios: [],
                list_category: [],
                list_type_category: [],
                list_response_data: [],
                list_Local: [],
                list_Local_filter: [],
                setNameFilter: []
            },
            model_request: {
                model_departament: "",
                model_municipio: "",
                model_category: "",
                model_type_category: "",
                model_range_initial: "",
                model_range_final: "",
                radio_select_db: ""
            },
            loading_true: false
        };
    },
    mounted() {
        this.getDepartament();
        this.getTypeCategory();
        this.getCategory();
    },
    methods: {
        exportExcel() {
        var table = 'exportData';
        var name = 'exportData';
        var DocumentName = "exportData";
        var link = document.createElement('a');
        link.download = DocumentName + '.xls';
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html  xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
        , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            // window.location.href = uri + base64(format(template, ctx))
            link.href = uri + base64(format(template, ctx));
            link.click();
        
        },
        export2(){
            // let data = XLSX.utils.json_to_sheet(this.bien)
            const tbl = document.getElementById('exportData')
            let data = XLSX.utils.table_to_book(tbl)
            const workbook = XLSX.utils.book_new()
            const filename = 'devschile-admins'
            XLSX.utils.book_append_sheet(workbook, data, filename)
            XLSX.writeFile(workbook, `${filename}.xlsx`)
        },
        clear() {
            this.model_request.model_departament = "todo";
            this.model_request.model_municipio = "todo";
            this.model_request.model_category = "todo";
            this.model_request.model_type_category = "todo";
        },
        submit() {
            this.catch_error.show = false;
            this.loading_true = true;
            this.list_response.list_Local = [];
            axios
                .post(this.url_response.getNameLocal, {
                    departament: this.model_request.model_departament,
                    municipio: this.model_request.model_municipio,
                    type: this.model_request.model_type_category,
                    category: this.model_request.model_category,
                    fInitial: this.model_request.model_range_initial,
                    fFinal: this.model_request.model_range_final,
                    db: this.model_request.radio_select_db
                })
                .then(response => {
                    
                    const status = JSON.parse(response.status);
                    const length = response.data.data.length; 
                    if (status == "200" && length > 0 ) {
                        console.log(response.data)
                        this.list_response.list_Local = response.data;
                        console.log(response.data);
                        this.loading_true = false;
                    }else{
                        this.message_table.mensajeData =
                        "sin precios de referencia";
                        this.value_border = false;
                        this.loading_true = false;
                        this.catch_error.show = true;
                    }
                });
        },

        getNameLocal() {
            axios
                .post(this.url_response.getNameLocal, {
                    departament: this.model_request.model_departament,
                    municipio: this.model_request.model_municipio,
                    type: this.model_request.model_type_category,
                    category: this.model_request.model_category,
                    fInitial: this.model_request.model_range_initial,
                    fFinal: this.model_request.model_range_final,
                    db: this.model_request.radio_select_db
                })
                .then(response => {
                    this.list_response.list_Local = response.data;

                    for (let index = 0; index < response.data.length; index++) {
                        this.getNameLocalFilter(
                            response.data[index].nombreMercado
                        );
                    }
                });
        },
        getNameLocalFilter(id) {
            
            this.list_response.list_Local_filter = [];
            this.list_response.list_Local = [];
            axios
                .post(this.url_response.getNameLocalFilter, {
                    departament: this.model_request.model_departament,
                    municipio: this.model_request.model_municipio,
                    type: this.model_request.model_type_category,
                    category: this.model_request.model_category,
                    fInitial: this.model_request.model_range_initial,
                    fFinal: this.model_request.model_range_final,
                    filter: id,
                    db: this.model_request.radio_select_db
                })
                .then(response => {
                    if (response.data.length == 0) { 
                        this.message_table.mensajeData =
                        "sin precios de referencia";
                        this.value_border = false;
                        this.loading_true = false;
                        // this.catch_error.show = true;
                       
                    }else{
                        this.catch_error.show = false;
                        this.list_response.list_Local.push({
                            nombreMercado: id
                        })
                        this.list_response.list_Local_filter.push({
                            type: id,
                            data: response.data
                        });
                        this.loading_true = false;
                    }
                    
                });
            
        },
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
