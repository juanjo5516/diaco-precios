<template>
    <div>
        <div
            class="card bg-light mb-3"
            v-for="(index, x) in getCategoria"
            v-bind:key="x"
        >
            <div class="card-header"></div>
            <div class="card-body">
                <table class="table" id="out-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Medida</th>
                            <!-- v-for="(prices, p) in getPriceData" v-bind:key="p"  -->
                            <th
                                v-for="(correlativo, c) in getColumnaCount"
                                v-bind:key="c"
                            >
                                Precio
                            </th>
                            <th>Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- v-if="(item.categoria == index.categoria)" -->
                        <tr
                            v-for="(item, i) in Getdata"
                            v-bind:key="i"
                            :id="'id_' + item.code"
                        >
                            <td>{{ item.producto }}</td>
                            <td>{{ item.medida }}</td>
                            <td
                                v-for="(prices, p) in getPriceData"
                                v-bind:key="p"
                                v-if="
                                    item.medida == prices.medida &&
                                        item.producto == prices.producto
                                "
                                :id="prices.codigo"
                            >
                                {{ prices.price }}
                            </td>
                            <td>
                                <el-button-group>
                                    <el-button
                                        size="mini"
                                        @click="showDialogEdit(item.code)"
                                        >Editar
                                    </el-button>
                                </el-button-group>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <el-dialog
                    title="Vaciado de Información"
                    :visible.sync="dialogFormVisible"
                    width="60%"
                    top="1vh">
                    <el-form :model="form">
                        <table class="table" id="out-table">
                                          <thead>
                                                <tr>
                                                      <th>Producto</th>
                                                      <th>Medida</th>
                                                      <th
                                                            v-for="(correlativo, c) in getColumnaCount"
                                                            v-bind:key="c">
                                                            
                                                            Precio
                                                      </th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                <tr
                                                v-for="(item, i) in Getdata"
                                                v-bind:key="i"
                                                v-if="(item.code == itemData)"
                                                >
                                                <td>{{ item.producto }}</td>
                                                <td>{{ item.medida }}</td>
                                                <td
                                                      v-for="(prices, p) in getPriceData"
                                                      v-bind:key="p"
                                                      v-if="
                                                            item.medida == prices.medida &&
                                                            item.producto == prices.producto
                                                      "
                                                      :id="prices.codigo"
                                                >
                                                      
                                                            <el-input size="medium" placeholder="precio"  v-model="form.precios['precio' + prices.codigo]" :id="1"></el-input>
                                                            
                                                     
                                                      {{ prices.price }}
                                                </td>
                                                
                                                </tr>
                                          </tbody>
                                    </table>

                        
                        <!-- <table class="table table-bordered head" width="100%">
                            <thead>
                                <tr>
                                    <th style="width:200px">Producto</th>
                                    <th style="width:200px">Medida</th>
                                    <th
                                        v-for="(index, x) in nColumna"
                                        v-bind:key="x"
                                    >
                                        {{ index.index }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(index, ix) of Productos"
                                    v-bind:key="ix"
                                >
                                    <td>{{ index.produto }}</td>
                                    <td class="ReferencesName">
                                        {{ index.medida }}
                                    </td>
                                    <td
                                        v-for="(n, x) in nColumna"
                                        v-bind:key="x"
                                    >
                                        <el-input-number
                                            v-model="index['valor' + n.index]"
                                            size="mini"
                                            :precision="2"
                                            :min="0"
                                            :max="1000"
                                        ></el-input-number>
                                    </td>
                                </tr>
                            </tbody>
                        </table> -->
                    </el-form>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="dialogFormVisible = false"
                            >Cancelar</el-button
                        >
                        <el-button type="primary" @click="onSubmit()"
                            >Guardar</el-button
                        >
                    </span>
                </el-dialog>
            </div>
        </div>
        <el-button class="my-5" type="success" @click="exportExcel"
            >Enviar</el-button
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
            dataIndexPrice: [],
            dialogFormVisible: false,
            form: {
                name: "",
                producto: "",
                medida: "",
                seleccionMercado: [],
                precios:[]
            },
            itemData:0,
            input:"",
            inicio:0
            
        };
    },
    
    mounted() {
        this.getPreciosVaciado();
        // console.log(this.categorias);
        this.getExportCategoria();
        this.getPrice();
        this.getColumn();
    },
    methods: {
        onSubmit () {
              console.log(this.form.precios)
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
              this.dialogFormVisible = true;
              this.itemData = data;
            // var customerId;
            // var i = 0;
            // $("#out-table " + "#id_" + data).each(function() {
            //     $(this)
            //         .find("td")
            //         .each(function() {
            //             alert(i++);
            //             alert(
            //                 $(this)
            //                     .eq()
            //                     .attr("id")
            //             );
            //         });
            // });
            // f;

            // console.log(customerId);
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
                    console.log(this.getPriceData);
            });
        },
        getColumn() {
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
