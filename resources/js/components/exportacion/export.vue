<template>
      <div>
            <div class="card bg-light mb-3" v-for="(index, x) in getCategoria" v-bind:key="x">
                  <div class="card-header">
                       
                        <!-- {{ index.categoria}} -->
                  </div> 
                  <div class="card-body">
                        <table class="table" id="out-table">
                              <thead>
                                    <tr>
                                          <th>Producto</th>
                                          <th>Medida</th>
                                          <th v-for="(correlativo, c) in getColumnaCount" v-bind:key="c">Precio</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    <!-- v-if="(item.categoria == index.categoria)" -->
                                    <tr v-for="(item, i) in Getdata" v-bind:key="i" >
                                          <td>{{ item.producto}}</td>
                                          <td>{{ item.medida}}</td>
                                          <td v-for="(prices, p) in getPriceData" v-bind:key="p" v-if="(item.medida == prices.medida && item.producto == prices.producto)">
                                                {{ prices.price }}
                                          </td>
                                    </tr>
                              </tbody>
                        </table>
                  </div>
            </div>
            <el-button  class="my-5" type="success"  @click="exportExcel" >Exportar</el-button>
      </div>
</template>
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
                  getColumnaCount:[]
            }
      },
      mounted(){
            this.getPreciosVaciado();
            // console.log(this.categorias);
            this.getExportCategoria();
            this.getPrice();
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

                         console.log(this.getColumnaCount);
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

            
      }
}
</script>