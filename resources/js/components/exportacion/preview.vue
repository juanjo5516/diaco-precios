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
                                                            v-bind:key="c" style="width:16%">
                                                            
                                                            Precio
                                                      </th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                <tr
                                                v-for="(item, i) in Getdata" v-bind:key="i" v-if="(item.code == itemData)"
                                                >
                                                      <td>{{ item.producto }}</td>
                                                      <td>{{ item.medida }}</td>
                                                      <td v-for="(prices, p) in getPriceData" v-bind:key="p"  v-if="item.medida == prices.medida && item.producto == prices.producto">
                                                            
                                                            <el-input v-for="(id,ix) in form.precios" v-bind:key="ix"  v-if="(id.id == x)" size="medium"   v-model="form.preciosP['valor_' + id.id]" :id="'inputs['  + id.id  + ']'"></el-input>
                                                            <span v-show="false">{{ x++}}</span>
                                                            <!-- {{ prices.price }} -->
                                                  
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
        <el-button class="my-5" type="success" @click="envio" v-loading.fullscreen.lock="fullscreenTerminar"
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
            for (let index = 0; index < this.form.precios.length; index++) {
                  this.pricesUpdate.push({
                        code: this.form.precios[index].codePrice,
                        current: this.form.preciosP['valor_' + index],
                        previous:this.form.precios[index].priceValue
                  })
            }
            var url = '/updatePrice';
            // const bandeja = "/Bandeja";

            axios.post(url,{
                  data:this.pricesUpdate
            }).then(response => {
                  console.log(response.data)
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

            for (let cambio = 0; cambio < this.form.precios.length; cambio++) {
                        this.form.preciosP['valor_' + cambio] = "";
            }
           
            
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
              this.inicio = 0;
              this.form.precios = [];
              this.dialogFormVisible = true;
              this.itemData = data;
            //   console.log(this.getPriceData)
            for (let index = 0; index < this.Getdata.length; index++) {
                  if (this.Getdata[index].code == this.itemData) {
                        for (let Fproducto = 0; Fproducto < this.getPriceData.length; Fproducto++) {
                             if ((this.getPriceData[Fproducto].medida == this.Getdata[index].medida) && (this.getPriceData[Fproducto].producto == this.Getdata[index].producto) ) {
                              //      console.log(this.getPriceData[Fproducto])
                                   this.form.precios.push({
                                         id: this.inicio,
                                         codePrice: this.getPriceData[Fproducto].codigo,
                                         priceValue: this.getPriceData[Fproducto].price,
                                         nameProduct: this.Getdata[index].producto,
                                          nameMedida: this.Getdata[index].medida,
                                         updateP:0
                                   })
                                    this.inicio ++;
                             }
                        }
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
