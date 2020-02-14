<template>
    <div>
        <el-row :gutter="30"> 
            <el-col :xs="30" :sm="30" :md="30" :lg="25" :xl="12" v-for="(index,x) in categorias" v-bind:key="x">
                <el-card >
                    <div slot="header" class="clearfix">
                        <span>{{ index.categoria }}</span> 
                    </div>
                    <table class="table table-striped table-bordered table-hover table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th >Código</th>
                                <th>Producto</th>
                                <th>Medida</th>
                                <th>Precio</th>
                                <th class="title_header">Operación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row_data, r) in Getdata" :key="r" class="tr">
                                <td v-if="row_data.code_category === index.code">{{ row_data.code }}</td>
                                <td v-if="row_data.code_category === index.code">{{ row_data.name_product }}</td>
                                <td v-if="row_data.code_category === index.code">{{ row_data.name_measure }}</td>
                                <td v-if="row_data.code_category === index.code">{{ row_data.price_product }}</td>
                                <td v-if="row_data.code_category === index.code">
                                    <el-button-group>
                                        <el-button
                                            type="primary" icon="el-icon-edit" circle
                                            
                                            @click="showDialogEdit(row_data.code)">
                                        </el-button>
                                    </el-button-group>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </el-card>
            </el-col>
        </el-row>
       <el-dialog
            
            :visible.sync="dialogFormVisible"
            width="50%"
            top="2vh"
            show-close
            destroy-on-close
            
            lock-scroll>
                <el-form :model="form">
                    <table class="table table-striped table-bordered table-hover table-responsive" id="out-table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Medida</th>
                                <th>Precio</th>
                                <th style="width:20%">Nuevo Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row_data_handle, r) in price_filter" :key="r" class="tr">
                                <td >{{ row_data_handle.code }}</td>
                                <td >{{ row_data_handle.name_product }}</td>
                                <td >{{ row_data_handle.name_measure }}</td>
                                <td >{{ row_data_handle.price_product }}</td>
                                <td><el-input 
                                            placeholder="Nuevo Precio" 
                                            v-model="new_price"
                                             
                                            >
                                    </el-input>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </el-form> 
                <span slot="footer" class="dialog-footer">
                    <el-button @click="dialogFormVisible = false">Cancelar</el-button>
                    <el-button type="primary" @click="onSubmit()">Guardar</el-button>
                </span>
        </el-dialog>
        <el-button class="my-5" type="success" @click="envio" v-loading.fullscreen.lock="fullscreenTerminar">Enviar</el-button>
    </div>
</template>
<style lang="css" scoped>
    .tr{
        border: 1px solid #000 !important;
    }

    .tr td{
        border: 1px solid #000 !important;
        text-align: center
    }

    .thead-dark tr th{
        text-align: center;
    }

    .title_header{
        width: 11%;
    }

    
</style>
<script>
import FileSaver from "file-saver";
import XLSX from "xlsx";
export default {
    name: "exportacion",
    props: ["categorias", "producto", "correlativo", "id", "user"],
    data() {
        return {
            Getdata: [],
            price_filter:[],
            new_price: "",
            getCategoria: [],
            getPriceData: [],
            getColumnaCount: [],
            dataIndexPrice: [],
            dialogFormVisible: false,
            form: {
                name: "",
                producto: "",
                medida: "",
                seleccionMercado: [],
                precios:[],
                preciosP:[]
            },
            itemData:0,
            input:"",
            inicio:0,
            x:1,
            pricesUpdate:[],
            fullscreenTerminar: false,
            
        };
    },
    
    mounted() {
        this.getPreciosVaciado();
        this.getExportCategoria();
        this.getPrice();
        this.getColumn();

    },
    methods: {
        
        onSubmit () {
            const h = this.$createElement;
            this.pricesUpdate= [];
            this.pricesUpdate.push({
                code: this.itemData,
                new_price_data: this.new_price
            })
            
            var url = '/change_prices_data';
            
            axios.post(url,{
                  data:this.pricesUpdate
            }).then(response => {
                  
                  const status = JSON.parse(response.status);
                  if(status == '200'){
                        this.dialogFormVisible = false;
                        this.$message({
                              message: h("p", null, [
                              h("i", { style: "color: teal" }, "Cambio Exitoso!")
                              ]),
                              type: 'success'
                        });
                        this.getPreciosVaciado();
                        this.getExportCategoria();
                        this.getPrice();
                        this.getColumn();
                  }

            })           
            
        },
        getPreciosVaciado() {
            var url =
                "/getExportData/" +
                this.id +
                "/" +
                this.user +
                "/" +
                this.correlativo;
            axios.get(url).then(response => {
                this.Getdata = response.data;
            //     console.log(this.Getdata);
            });
        },
        dataPrices(codigo, prices) {
            this.dataIndexPrice.push({
                index: codigo,
                precio: prices
            });
            // console.log(this.dataIndexPrice);
        },
        showDialogEdit(data) {
              this.new_price = ""
              this.inicio = 0;
              this.price_filter = []
              this.dialogFormVisible = true;
              this.itemData = data;
            for (let index = 0; index < this.Getdata.length; index++) {
                  if (this.Getdata[index].code == this.itemData) {
                        this.price_filter.push({
                            code: this.Getdata[index].code,
                            code_product: this.Getdata[index].code_product,
                            name_product: this.Getdata[index].name_product,
                            code_measure: this.Getdata[index].code_measure,
                            name_measure: this.Getdata[index].name_measure,
                            price_product: this.Getdata[index].price_product,
                            count_column: this.Getdata[index].count_column,
                            code_category: this.Getdata[index].code_category,
                        })
                  }
            }
            
        },
        getExportCategoria() {
            var url =
                "/getExportDataCategory/" +
                this.id +
                "/" +
                this.user +
                "/" +
                this.correlativo;
            axios.get(url).then(response => {
                this.getCategoria = response.data;
            });
        },
        getPrice() {
            var url =
                "/getPriceExport/" +
                this.id +
                "/" +
                this.user +
                "/" +
                this.correlativo;
            axios.get(url).then(response => {
                this.getPriceData = response.data;
                  //   console.log(this.getPriceData);
            });
        },
        getColumn() {
            this.getColumnaCount = []
            var url = "/getCountColumn";
            axios
                .post(url, {
                    id: this.id
                })
                .then(response => {
                    // this.getColumnaCount = response.data;
                    var cantidad = 1;
                    var nombre = 'precio_';
                    for (let i = 0; i < response.data[0].Columna; i++) {
                        this.getColumnaCount.push({
                            index: cantidad
                        });
                        // nombre = nombre + cantidad;
                        // this.precios.push({
                        //       precio:cantidad
                        // })
                        cantidad++;
                    }
                });
        },
        envio() {
    
            this.fullscreenTerminar = true;
            var url = "/changeStatusPlantilla";
            const bandeja = "/Bandeja";
            axios
                .post(url, {
                    correlativo: this.correlativo
                })
                .then(response => {
                    const status = JSON.parse(response.status);
                    if (status == "200") {
                        this.fullscreenTerminar = false;
                        window.location = bandeja;
                    }
                })
                .catch(error => {});
        },
        exportExcel() {
            var table = "out-table";
            var name = "Worksheet";
            var DocumentName = this.getCategoria[0].categoria;

            var link = document.createElement("a");
            link.download = DocumentName + ".xls";
            var uri = "data:application/vnd.ms-excel;base64,",
                template =
                    '<html  xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
                base64 = function(s) {
                    return window.btoa(unescape(encodeURIComponent(s)));
                },
                format = function(s, c) {
                    return s.replace(/{(\w+)}/g, function(m, p) {
                        return c[p];
                    });
                };
            if (!table.nodeType) table = document.getElementById(table);
            var ctx = {
                worksheet: name || "Worksheet",
                table: table.innerHTML
            };
            // window.location.href = uri + base64(format(template, ctx))
            link.href = uri + base64(format(template, ctx));
            link.click();
        }
    }
};
</script>
