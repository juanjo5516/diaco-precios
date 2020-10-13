<template>
  <div>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header text-white bg-primary">
              Información Pública
            </div>
            <div class="card-body">
              <el-row :gutter="10">
                <el-col :xs="25" :sm="6" :md="8" :lg="20" :xl="14">
                  <el-form :model="form" :rules="rules" ref="form">
                    <el-form-item label="Departamento: " prop="departamento">
                      <el-select
                        v-model="form.departamento"
                        placeholder="Departamentos"
                        filterable
                        clearable
                        @change="sedes"
                        v-loading.fullscreen.lock="loader.loaderDepto.status"
                        :element-loading-text="loader.loaderDepto.text"
                        :element-loading-spinner="loader.loaderDepto.spinner"
                        :element-loading-background="loader.loaderDepto.color"
                      >
                        <el-option
                          v-for="(item, i) in responseList.listDepartamento"
                          v-bind:key="i"
                          :label="item.name"
                          :value="item.code"
                        ></el-option>
                      </el-select>
                    </el-form-item>
                    <el-form-item label="Sede:" prop="sede">
                      <el-select
                        :disabled="handlerSelect.selectSede"
                        v-model="form.sede"
                        placeholder="Sedes"
                        filterable
                        clearable
                        @change="producto"
                        v-loading.fullscreen.lock="loader.loaderSede.status"
                        :element-loading-text="loader.loaderSede.text"
                        :element-loading-spinner="loader.loaderSede.spinner"
                        :element-loading-background="loader.loaderSede.color"
                      >
                        <el-option
                          v-for="(item, i) in responseList.listSedes"
                          v-bind:key="i"
                          :label="item.name"
                          :value="item.code"
                        ></el-option>
                      </el-select>
                    </el-form-item>
                    <el-form-item label="categoria:" prop="producto">
                      <el-select
                        :disabled="handlerSelect.selectProducto"
                        v-model="form.producto"
                        placeholder="Categoria"
                        filterable
                        clearable
                        @change="productos"
                      >
                      <!-- @change="precios" -->
                        <el-option
                          v-for="(item, i) in responseList.listPrecios"
                          v-bind:key="i"
                          :label="item.name"
                          :value="item.code"
                        ></el-option>
                      </el-select>
                    </el-form-item>
                    <el-form-item label="Producto:" prop="pro">
                      <el-select
                        :disabled="handlerSelect.selectMedida"
                        v-model="form.pro"
                        placeholder="Producto"
                        filterable
                        clearable
                        @change="precios"
                      >
                        <el-option
                          v-for="(item, i) in responseList.listPro"
                          v-bind:key="i"
                          :label="item.articulo"
                          :value='item.code'
                        ></el-option>
                      </el-select>
                    </el-form-item>
                    <el-form-item label="Medida:" prop="medida">
                      <el-select
                        :disabled="handlerSelect.selectMedida"
                        v-model="form.medida"
                        placeholder="Medida"
                        filterable
                        clearable
                        @change="char_Price"
                      >
                        <el-option
                          v-for="(item, i) in responseList.listMedida"
                          v-bind:key="i"
                          :label="item.medida"
                          :value='item.code'
                        ></el-option>
                      </el-select>
                    </el-form-item>
                  </el-form>
                </el-col>
                <el-col :xs="25" :sm="6" :md="8" :lg="20" :xl="10">
                  <el-table
                    height="250"
                    v-if="visible"
                    v-loading="loading"
                    :data="responseList.listPreciosPublic"
                  >
                    <el-table-column
                      prop="articulo"
                      label="Articulo"
                      width="300"
                    ></el-table-column>
                    <el-table-column
                      prop="medida"
                      label="Medida"
                      width="100"
                    ></el-table-column>
                    <el-table-column label="Precio">
                      <template slot-scope="scope">
                        Q {{ scope.row.precio }}
                      </template>
                    </el-table-column>
                  </el-table>
                </el-col>
              </el-row>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div ref="leyends"></div>
      <div>
        <canvas ref="grafica"></canvas>
      </div>
    </div>
  </div>
</template>
<style lang="css">
.cuadro {
  width: 13px;
  height: 13px;
  border-radius: 0.1em;
  border: 1px solid gray;
  display: inline-block;
  margin: 0.1em;
}
.card {
  border: none;
  margin-bottom: 0 auto;
  border-radius: 0.5em;
  padding: 0;
  background: #fff;
  color: #000;
  transition: all 400ms ease-out;
}

/* .el-table th{
    background: none !important;
} */
</style>
<script>
import Chart from "chart.js";
export default {
  data() {
    return {
      visible: false,
      loading: false,
      loader: {
        loaderDepto: {
          status: true,
          text: "Cargando Información",
          spinner: "el-icon-loading",
          color: "rgba(0, 0, 0, 0.8)",
        },
        loaderSede: {
          status: false,
          text: "Cargando Información",
          spinner: "el-icon-loading",
          color: "rgba(0, 0, 0, 0.8)",
        },
      },
      handlerSelect: {
        selectSede: true,
        selectProducto: true,
        selectMedida: true,
      },
      form: {
        departamento: "",
        sede: "",
        producto: "",
        medida:[],
        pro:""
      },
      url: {
        Departamentos: "api/categoriasPublicas",
        precios: "api/preciosPublicos/",
        precios_view: "api/price_view",
        chartPublic: "api/chartPublic",
        price_viewFilter: "api/price_viewFilter",
        price_view_Category: "api/price_view_Category",
      },
      responseList: {
        listDepartamento: [],
        listSedes: [],
        listPrecios: [],
        listPreciosPublic: [],
        listMedida: [],
        listPro:[]
        
      },
      rules: {
        departamento: [
          {
            required: true,
            message: "Seleccione un Departamento",
            trigger: "blur",
          },
        ],
      },
      data_chart: [],
      names: [],
      tableChart: [],
    };
  },
  methods: {
    getDepartamentos() {
      axios.get(this.url.Departamentos).then((response) => {
        this.responseList.listDepartamento = response.data;
        this.responseList.listDepartamento.length;
        this.loader.loaderDepto.status = false;
        // console.log(this.responseList.listDepartamento);
      });
    },
    sedes(idDepto) {
      this.loader.loaderSede.status = true;
      this.form.sede = "";
      for (
        let index = 0;
        index < this.responseList.listDepartamento.length;
        index++
      ) {
        if (this.responseList.listDepartamento[index].code === idDepto) {
          this.responseList.listSedes = this.responseList.listDepartamento[
            index
          ].branches;
        }
      }
      this.loader.loaderSede.status = false;
      this.handlerSelect.selectSede = false;
    },
    producto(idsede) {
      this.handlerSelect.selectProducto = false;
      this.form.producto = "";
      for (let index = 0; index < this.responseList.listSedes.length; index++) {
        if (this.responseList.listSedes[index].code === idsede) {
          this.responseList.listPrecios = this.responseList.listSedes[
            index
          ].categories;
        }
      }
      // console.log(this.responseList.listPrecios);
    },
    productos(){
      axios.post(this.url.price_view_Category,{
        sede: this.form.sede,
        categoria: this.form.producto,
      }).then(response => {
        this.responseList.listPro = response.data;
        this.handlerSelect.selectMedida = false;
      })
    },
    precios() {
      this.responseList.listMedida = []; 
      this.loading = true;
      axios
        .post(this.url.precios_view, {
          sede: this.form.sede,
          categoria: this.form.producto,
          code: this.form.pro
        })
        .then((response) => {
          // this.responseList.listPreciosPublic = response.data;
          // this.visible = true;
          this.loading = false;
          // console.log(response.data);
          for (let index = 0; index < response.data.length; index++) {
            this.responseList.listMedida.push({
              'medida' : response.data[index].medida,
              'code' : response.data[index].code,
              
            })
            // this.responseList.listMedida.push({
            //   'medida' : response.data[index].articulo + '-' + response.data[index].medida,
            //   'code' : response.data[index].medida,
            //   'articulo': response.data[index].articulo
            // })
          }
          this.handlerSelect.selectMedida = false;
          // console.log(response.data)
        });
    },
    char_Price() {

      axios.post(this.url.price_viewFilter,{
          sede: this.form.sede,
          categoria: this.form.producto,
          idMedida: this.form.medida,
          code: this.form.pro
      }).then(response =>  {
        this.visible = true;
        this.responseList.listPreciosPublic = response.data;

        axios.post(this.url.chartPublic,{
          sede: this.form.sede,
          categoria: this.form.producto,
          medida: this.form.medida,
          code: this.form.pro
        }).then(response => {
          this.chartDataShow("line", response.data);
        })
      })
    },
    chartDataShow(tipe, request) {
      const ctx = this.$refs.grafica;
      const legends = this.$refs.leyends;
      // console.log(request);

      ctx.height = "500";
      ctx.width = "800";

// console.log(request.map((item) => item.precio))
      const myChart = new Chart(ctx, {
        type: tipe,
        data: {
          labels: request.map((item) => item.mes),
          datasets: [
            {
              label: "Tendencia de Precios",
              data: request.map((item) => item.precio),
              lineTension: 0,
              fill: false,
              borderColor: 'red'
              // data: [0, 20, 40, 50],
              // backgroundColor: request.map(
              //     item => item.backgroundColor
              // ),
              // borderColor: request.map(item => item.borderColor),
              // borderWidth: 1,
              // fill: false
              // hoverBackgroundColor: request.map(item => item.backgroundColor)
            },
          ],
          // labels: ["January", "February", "March", "April"],
        },
        options: {
          // onClick: (e, legendItem) => {
          //     var index = legendItem.index;
          //     var chart = this.chart;
          //     var i, ilen, meta;
          //     this.showInfo(legendItem);
          // },

          legend: {
              display: true,
              // rtl: true,
              position: 'top',
              labels: {
                  fontColor: "rgb(255, 99, 132)",
                  boxWidth: 80,
                  // fontSize: 14,
                  // padding: 8,
                  // usePointStyle: false

                  //fin
              },
              align: "center"
          },
          // tooltips: {
          //     mode: "label",

          //     callbacks: {
          //         // label: function(tooltipItem, data) {
          //         //     console.log(data)
          //         //     var label = data.datasets[tooltipItem.datasetIndex].label || '';
          //         //     label = data.labels[tooltipItem[0]]

          //         //     return label;

          //         // },
          //         labelColor: function(tooltipItem, chart) {
          //             return {
          //                 borderColor: "rgb(255, 0, 0)",
          //                 backgroundColor: "rgb(255, 0, 0)"
          //             };
          //         },
          //         labelTextColor: function(tooltipItem, chart) {
          //             return "#fff";
          //         }
          //     },
          //     mode: "index",
          //     intersect: false
          // },
          // tooltips: {
          //     mode: "label"
          // },
          // onClick: (evt, item) => {
          //     // let index = item[0]["_index"];
          //     let fruit = item[0]["_chart"].data.labels[index];
          //     let votes = item[0]["_chart"].data.datasets[0].data[index];
          //     console.log(votes);
          // },
          // title: {
          //     display: false,
          //     text: "Datos envias desde las sedes"
          // },
          // legendCallback: function(chart) {
          //     var text = [];
          //     text.push('<ul >');
          //     var ds = chart.data.datasets[0];
          //     console.log(ds);
          //     var sum = ds.data.reduce(function add(a, b) {
          //         return a + b;
          //     }, 0);
          //     for (var i = 0; i < ds.data.length; i++) {
          //         text.push("<li class='lista'>");
          //         // var perc = Math.round((100 * ds.data[i]) / sum, 0);
          //         text.push(
          //             '<span class="cuadro" style="background-color:' +
          //                 ds.backgroundColor[i] +
          //                 '">' +
          //                 "</span>" +
          //                 chart.data.labels[i] +
          //                 " (" +
          //                 ds.data[i] +
          //                 ")"
          //         );
          //         text.push("</li>");
          //     }
          //     text.push("</ul>");

          //     return text.join("");
          // },

          scales: {
            // yAxes: [
            //   {
            //     ticks: {
            //       suggestedMin: 1,
            //       suggestedMax: 10,
            //     },
            //   },
            // ],
            // xAxes: [
            //     {
            //         display: true,
            //         scaleLabel: {
            //             display: true
            //             // labelString: 'Month'
            //         }
            //     }
            // ],
            // yAxes: [
            //     {
            //         display: true,
            //         scaleLabel: {
            //             display: true
            //             // labelString: 'Value'
            //         }
            //     }
            // ]
            yAxes: [
                {
                    // stacked: true
                    ticks: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return "Q" + value;
                        }
                    }
                }
            ]
          },
          // layout: {
          //     padding: {
          //         left: 50,
          //         right: 0,
          //         top: 0,
          //         bottom: 0
          //     }
          // },
          responsive: true,
          maintainAspectRatio: false,
        },
      });
      legends.innerHTML = myChart.generateLegend();
    },
  },
  mounted() {
    this.getDepartamentos();
    // this.getDataChart();
  },
};
</script>