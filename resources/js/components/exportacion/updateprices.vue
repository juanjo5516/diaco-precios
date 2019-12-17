<template>
      <div>
            <div class="card bg-light mb-3" v-for="(index, x) in getCategoria" v-bind:key="x">
                  <div class="card-header">
                  </div> 
                  <div class="card-body">
                        <el-table :data="getPriceData" border >
                              <el-table-column label="#" type="index"></el-table-column>
                              <el-table-column label="Codigo" prop="codigo"></el-table-column>
                              <el-table-column label="Producto" prop="producto"></el-table-column>
                              <el-table-column label="Medida" prop="medida"></el-table-column>
                              <el-table-column label="Precio" prop="price"></el-table-column>
                              <el-table-column label="Repetido" >
                                    <template  slot-scope="scope">
                                          <div v-for="(precio, n) in getPriceDataCount" v-bind:key="n" v-if="(scope.row.producto == precio.producto && scope.row.medida == precio.medida)">
                                                {{ precio.repetidos }}
                                          </div>
                                    </template>
                              </el-table-column>
                              <el-table-column label="Operación" >
                                    <template slot-scope="scope">
                                          <el-button
                                                size="mini"
                                                type="danger"
                                                @click="handleDelete(scope.row.codigo)"
                                          >Eliminar</el-button>
                                    </template>
                              </el-table-column>
                        </el-table>
                        <!-- <el-table :data="getPriceDataCount">
                              <el-table-column label="repetidos" prop="repetidos"></el-table-column>

                        </el-table> -->
                        <!-- <table class="table" id="out-table">
                              <thead>
                                    <tr>
                                          <th>Producto</th>
                                          <th>Medida</th>
                                          <th>Precio</th>
                                          <th>Operación</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    <tr v-for="(item, i) in getPriceData" v-bind:key="i" >
                                          <td>{{ item.producto}}</td>
                                          <td>{{ item.medida}}</td>
                                          <td>{{ item.price }}</td>
  

                                    </tr>
                              </tbody>
                        </table> -->
                  </div>
            </div>
            <el-button  class="my-5" type="primary"  @click="exportExcel" >Autorizar</el-button>
            <el-button  class="my-5" type="danger"  @click="exportExcel" >Rechazar</el-button>
            <el-button  class="my-5" type="success"  @click="exportExcel" >Exportar</el-button>
      </div>
</template>
<style>
  .el-table .warning-row {
    background: oldlace;
  }

  .el-table .success-row {
    background: #f0f9eb;
  }
</style>
<script>
      import FileSaver from 'file-saver'
      import XLSX from 'xlsx'
export default {
      name: 'exportacion',
      props: ['categorias','producto','correlativo','id','user'],
      data(){
            return{
                  Getdata:[],
                  getCategoria:[],
                  getPriceData:[],
                  getPriceDataCount:[],
                  getColumnaCount:[],
                  fullscreenLoading : false,
                  RowData:[]
            }
      },
      mounted(){
            this.getPreciosVaciado();
            // console.log(this.categorias);
            this.getExportCategoria();
            this.getPrice();
            this.getPriceCount();
            this.getColumn();
           
            
            
      },
      methods:{
            getPreciosVaciado (){
                  var url = '/getExportData/'+this.id+'/'+this.user+'/'+this.correlativo;
                  axios.get(url)
                  .then(response => {
                        this.Getdata = response.data;
                        // console.log(this.Getdata);
                  })
            },
            
            changeRowTable(){
                  
                  
                  // for (let index = 0; index <= this.getPriceData.length; index++) {

                  //       for (let fila = 0; fila < this.getPriceDataCount.length; fila++) {
                  //             if(this.getPriceData[index].producto != this.getPriceDataCount[fila].producto){
                  //                   this.RowData.push({
                  //                         codigo: this.getPriceData[index].codigo
                  //                   })
                  //             }
                  //       }
                  // }
                  // console.log(this.RowData);
            },
            getExportCategoria () {
                  var url = '/getExportDataCategory/'+this.id+'/'+this.user+'/'+this.correlativo;
                  axios.get(url)
                  .then(response => {
                        this.getCategoria = response.data; 
                  })
            },
            getPrice () { 
                  var url = '/getPriceExport/'+this.id+'/'+this.user+'/'+this.correlativo;
                  axios.get(url)
                  .then(response => {
                        this.getPriceData = response.data;
                         
                        
                        
                  })
            },
            getPriceCount () { 
                  var url = '/getExportDataPriceRepeat';
                  axios.post(url,{
                        id: this.id,
                        user: this.user,
                        correlativo: this.correlativo,
                        // producto: producto,
                        // medida: medida
                  })
                  .then(response => {
                        this.getPriceDataCount = response.data;
                        // console.log(this.getPriceDataCount);
                        
                        
                  })

            },
            getColumn () {
                  var url = '/getCountColumn'; 
                  axios.post(url,{
                        id: this.id
                  })
                  .then(response => {
                        // this.getColumnaCount = response.data;
                        var cantidad = 1;
                        for(let i=0; i < response.data[0].Columna; i++){
                              this.getColumnaCount.push({
                                    index: cantidad
                              })
                              cantidad ++;
                         };
                  })
            },
            exportExcel () {
                  var table = 'out-table';
                  var name = 'Worksheet';
                  var DocumentName = this.getCategoria[0].categoria;

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
            handleDelete(row) {
                  console.log(row)
                  const config = { headers: {'Content-Type': 'application/json'} };
                  const h = this.$createElement;
                  this.fullscreenLoading = true;
                  var url = "/deletePricesSubmit";
                  axios
                        .put(url, {
                        code: row
                        },config
                        )
                        .then(response => {
                              const status = JSON.parse(response.status);
                              if (status == "200") {
                              this.$message({
                                    message: h("p", null, [
                                    h("i", { style: "color: teal" }, "Precio Eliminado")
                                    ]),
                                    type: 'success'
                              });
                              // this.formInline.name = "";
                              this.fullscreenLoading = false;
                              this.getPrice();
                              this.getPriceCount();
                              }
                        })
                        .catch(error => {
                        this.$message.error({
                              message: h("p", null, [
                              h("i", { style: "color: red" }, 'Error, servidor no encontrado')
                              ])
                        });
                        this.fullscreenLoading = false;
                        });

    },

            
      }
}
</script>