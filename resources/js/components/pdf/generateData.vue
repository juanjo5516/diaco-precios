<template>
    <div >
        <el-container>
            <el-main>
                <!-- <el-row :gutter="20"> -->
            <pdf ref="myPdfComponent">
            
        
                <table class="tables" width="100%">
                    <tr>
                        <td>a</td>
                        <td>s</td>
                        <td>d</td>
                    </tr>
                </table>
            </pdf>
                <!-- <el-button @click="download" type="success" icon="el-icon-folder-add" >PDF</el-button>  -->
                <button @click="logContent">print</button>
                
            </el-main>
        </el-container>
    </div>
</template>

<style >

    .tables{
        border:1px solid #000;
    }

    .tables td{

        border:1px solid #000;
    }
    .info{
        text-align: center;
        font-size: 1em;
        height: 200px;
        
    }
    .img{
        text-align: center;
    }
</style>

<script>

import jsPDF from "jspdf";
import html2canvas from "html2canvas";

import pdf from 'vue-pdf';

  export default {
       name: "prueba",
      props: ['id'],
    data() {
      return {
        src: 'https://cube.elemecdn.com/6/94/4d3ea53c084bad6931a56d5158a48jpeg.jpeg',
        imgDiaco: 'https://www.diaco.gob.gt/site/images/2018/LOGO/2018/Ndiaco.jpg',
        imgMineco: 'https://w2019.cancham.org.gt/wp-content/uploads/2016/11/min-economia-guatemala.png',
        resultUser:[],
        resultCategoria:[],
        resultProducto:[],
        currentPage: 0,
        pageCount: 0,
        
      }
    },
    components: {
        pdf
    },
    mounted(){
            this.getData();
            this.getCategoria();
            this.getProducto();
    },
    methods: {
        getData: function(){
              axios.get('/getInfoUser')
                .then(response => {
                  this.resultUser = response.data;
                  console.log(response.data);
                })
                .catch(function (error) {
                  console.log(error);
                })
            },
        getCategoria: function(){
              axios.post('/getCategoriaPdf',{id: this.id})
                .then(response => {
                this.resultCategoria = response.data;
                //  console.log(response.data);
                })
                .catch(function (error) {
                  console.log(error);
                })
            },
        getProducto: function(){
              axios.post('/getProductosPdf',{id: this.id})
                .then(response => {
                this.resultProducto = response.data;
                //  console.log(response.data);
                })
                .catch(function (error) {
                  console.log(error);
                })
            },
        // download() {
         
    //   const doc = new jsPDF();
    //   /** WITH CSS */
    //   var canvasElement = document.createElement('canvas');
    //   html2canvas(this.$refs.content, { canvas: canvasElement }).then(function (canvas) {
    // //   html2canvas(html, { canvas: canvasElement }).then(function (canvas) {
    //     // const img = canvas.toDataURL("image/jpeg", 0.8);
    //     // doc.addImage(img,'JPEG',20,20);
    //     doc.save("sample.pdf");
    //   });
    // },
    download() {
      const doc = new jsPDF();
      
      /** WITHOUT CSS */
      const contentHtml = '<h1>asf</h1>'
    //   const contentHtml = this.$refs.content.innerHTML;
      doc.fromHTML(contentHtml, 15, 15, {
          width: 170
        });
      doc.save("sample.pdf");
    },
    logContent() {

            this.$refs.myPdfComponent.pdf.forEachPage(function(page) {

                return page.getTextContent()
                .then(function(content) {

                    var text = content.items.map(item => item.str);
                    console.log(text);
                })
            });
        }
    }
  }
</script>