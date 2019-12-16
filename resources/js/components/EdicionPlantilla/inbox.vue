<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span>Bandeja de Entrada</span>
        </div>
        <el-table :data="DataResult" border stripe style="width: 100%">
            <el-table-column prop="correlativo" label="Correlativo">
            </el-table-column>
            <el-table-column prop="NombreTemplate" label="Nombre">
            </el-table-column>
            <el-table-column prop="nombre_sede" label="Sede"> </el-table-column>
            <el-table-column prop="estatus" label="Estatus"> </el-table-column>
            <el-table-column width="270" label="Operaciones">
                <template slot-scope="scope">
                    <el-link
                        :underline="false"
                        v-bind:href="
                            '/vaciado/' +
                                scope.row.id +
                                '/' +
                                scope.row.correlativo
                        "
                        :id="scope.row.id_Asignacion"
                    >
                        <el-button
                            size="small"
                            type="success"
                            icon="el-icon-s-order"
                            plain
                        >
                            Vaciar
                        </el-button>
                    </el-link>
                    <el-link
                        :underline="false"
                        target="_blank"
                        v-bind:href="
                            '/Printer/' +
                                scope.row.id +
                                '/' +
                                scope.row.correlativo
                        "
                        :id="scope.row.id_Asignacion"
                    >
                        <!-- <el-link :underline=false @click="PrinterData(scope.row.id,scope.row.correlativo)" :id=scope.row.id_Asignacion> -->
                        <el-button
                            size="small"
                            type="warning"
                            icon="el-icon-printer"
                            plain
                            >Imprimir
                        </el-button>
                    </el-link>
                    <el-link
                        v-if="scope.row.filtro == 2"
                        :underline="false"
                        v-bind:href="
                            '/preview/' +
                                scope.row.id +
                                '/' +
                                scope.row.correlativo +
                                '/' +
                                idUser
                        "
                        :id="scope.row.id_Asignacion"
                    >
                        <!-- <el-link :underline=false @click="PrinterData(scope.row.id,scope.row.correlativo)" :id=scope.row.id_Asignacion> -->
                        <el-button size="small" icon="el-icon-search" plain>
                        </el-button>
                    </el-link>
                    <!-- <button @click="download">print</button> -->
                    <!-- <el-link :underline=false v-bind:href="'/get-pdf/'+scope.row.id" :id=scope.row.id_Asignacion>
            <el-button
              size="small"
              type="warning"
              icon="el-icon-printer"
              plain
              >Imprimir 2
            </el-button>
          </el-link> -->

                    <!-- <el-button
            size="small"
            type="warning"
            icon="el-icon-printer"
            plain
            href="/Printer"
            @click="handleEdit(scope.$index, scope.row)">Imprimir
          </el-button> -->
                </template>
            </el-table-column>
        </el-table>
        <!-- <div id="print" class="letter">
          <div class="pageout"><PrintElement ref="print" /></div>
          <div class="preview"><PrintElement /></div>
        </div> -->
    </el-card>
</template>

<style>
.has-gutter {
    text-align: center;
}

/* #print {
position: absolute; 
opacity: 0.0;
} */
</style>

<script>
// import pdfData from "./components/pdf/pdfDemo.vue";
// import jsPDF from "jspdf";
// import html2canvas from "html2canvas";
import PrintElement from "../pdf/pdfDemo";
import { createPdfFromHtml } from "../logic.js";

export default {
    name: "app",
    components: {
        PrintElement
    },
    data() {
        return {
            DataResult: [],
            userInfo: [],
            idUser: 0
        };
    },
    mounted() { 
        // invocar los métodos
        this.getData();
        this.getUserAuth();

        // this.pollData();
    },
    methods: {
        viewPrinter: function() {
            axios.get("/Printer").then(response => {
                console.log("s");
            });
        },
        getUserAuth() {
            axios.get("/getInfoUser").then(response => {
                this.userInfo = response.data;
                this.idUser = this.userInfo[0].usuario_id;
            });
        },
        getData: function() {
            axios
                .get("/getinbox")
                .then(response => {
                    // handle success
                    this.DataResult = response.data;
                    // console.log(this.DataResult);
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                })
                .finally(function() {
                    // always executed
                });
        },

        download() {
            createPdfFromHtml(this.$refs.print.$el);
            //  const doc = new jsPDF();

            //   /** WITHOUT CSS */
            //   const contentHtml = '<h1>asf</h1>'
            //   // const contentHtml = this.$refs.print.innerHTML;
            //   doc.fromHTML(contentHtml, 15, 15, {
            //       width: 170
            //     });
            //   doc.save("sample.pdf");
        }

        // pollData () {
        //  setInterval(() => {
        //     console.log('RETRIEVE_DATA_FROM_BACKEND')
        //   }, 3000)
        // },

        //   onSubmit: function(){
        //     var url = '/aLista';
        //     axios.post(url, {
        //         SPlantilla: this.select1,
        //         SSede: this.select2,
        //         created_at_new: new Date(),
        //     }).then(response =>{
        //         $('#table-vue-asede').DataTable().ajax.reload();
        //         $("#snoAlertBox").fadeIn();
        //         closeSnoAlertBox("#snoAlertBox");
        //     }).catch(error => {
        //     console.log(error.message)
        //     });
        //   }
    }
};
</script>
