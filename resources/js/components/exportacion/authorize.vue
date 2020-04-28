<template>
    <div>
        <div
            class="card bg-light mb-3"
            v-for="(index, x) in getCategoria" 
            v-bind:key="x"
        >
            <div class="card-header">
                <!-- {{ index.categoria}} -->
            </div>
            <div class="card-body">
                <el-table :data="Getdata" stripe>
                    <el-table-column label="Producto" prop="name_product" width="450"></el-table-column> 
                    <el-table-column label="Medida" prop="name_measure"></el-table-column>
                    <el-table-column label="precio" prop="price_product" width="80"></el-table-column>

                </el-table>
                <table class="table" id="out-table" v-show="showInfor">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Medida</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, i) in Getdata" v-bind:key="i">
                            <td>{{ item.name_product }}</td>
                            <td>{{ item.name_measure }}</td>
                            <td >
                                 {{item.price_product}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <el-button
            class="my-5"
            type="primary"
            @click="authorize"
            v-loading.fullscreen.lock="fullscreenLoading"
            >Autorizar</el-button
        >
        <!-- <el-button  class="my-5" type="danger"  @click="exportExcel" >Rechazar</el-button> -->
        <el-button class="my-5" type="success" @click="exportExcel"
            >Exportar</el-button
        >
    </div>
</template>
<script>
import FileSaver from "file-saver";
import XLSX from "xlsx";
export default {
    name: "exportacion",
    props: ["categorias", "producto", "correlativo", "id", "user"],
    data() {
        return {
            Getdata: [],
            getCategoria: [],
            getPriceData: [],
            getColumnaCount: [],
            column: 0,
            fullscreenLoading: false,
            urlRequest: {
                getname: "/getNameTemplate/",
                getPricesTemplate: "/getPricesTemplate/",
            },
            filter_name: [],
            response_data: [
                {
                     response_name:{}
                },
                {
                    filter_name: []
                },
                {
                    columns:[]
                },
                {
                    filter_name_result: []
                },
            ],
            showInfor:false
        };
    },
    mounted() {
        
        // this.getNameTempalte();
        this.getPreciosVaciado();
        // console.log(this.categorias);
        this.getExportCategoria();
        this.getPrice();
        this.getColumn();
    },
    methods: {
        authorize() {
            const h = this.$createElement;
            let url = "/authorizeChange";
            this.fullscreenLoading = true;
            var bandeja = "/revisarEnvio";
            axios
                .post(url, {
                    correlativo: this.correlativo
                })
                .then(response => {
                    const status = JSON.parse(response.status);
                    if (status == "200") {
                        this.$message({
                            message: h("p", null, [
                                h("i", { style: "color: teal" }, "Autorizado")
                            ]),
                            type: "success"
                        });
                        // this.formInline.name = "";
                        this.fullscreenLoading = false;
                        window.location = bandeja;
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
        getPreciosVaciado() {
            
            axios.get(this.urlRequest.getPricesTemplate+this.correlativo).then(response => {
                this.Getdata = response.data;
            });
        },

        getNameTempalte(){
            axios.get(this.urlRequest.getname+this.correlativo).then(response =>{
                this.response_data[0].response_name = response.data;
                for (let index = 0; index < this.response_data[0].response_name.length; index++) {
                    this.getPreciosVaciado(this.response_data[0].response_name,this.response_data[0].response_name[index].code_measure);
                }
            })
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
                
            });
        },
        getColumn() {
            var url = "/getCountColumn";
            axios
                .post(url, {
                    id: this.id
                })
                .then(response => {
                    //this.column = response.data;
                    var cantidad = 1;
                    for (let i = 0; i < response.data[0].Columna; i++) {
                        this.getColumnaCount.push({
                            index: cantidad
                        });
                        cantidad++;
                    }
                });
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
