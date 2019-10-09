<template>
  <div>
    <button @click="downloadWithCSS">Download PDF WITH CSS</button>
    <br>
    <br>
    <button @click="download">Download PDF WITHOUT CSS</button>
    <div ref="content">
      <p style="background-color: red;">Hello Vue in CodeSandbox!</p>
      <h3>Installed CLI Plugins</h3>
      <ul>
        <li>
          <a
            href="https://github.com/vuejs/vue-cli/tree/dev/packages/%40vue/cli-plugin-babel"
            target="_blank"
            rel="noopener"
          >babel</a>
        </li>
        <li>
          <a
            href="https://github.com/vuejs/vue-cli/tree/dev/packages/%40vue/cli-plugin-eslint"
            target="_blank"
            rel="noopener"
          >eslint</a>
        </li>
      </ul>
      <h3>Essential Links</h3>
      <h3>Ecosystem</h3>
    </div>
  </div>
</template>

<script>
import jsPDF from "jspdf";
import html2canvas from "html2canvas"

export default {
   
  name: "prueba",
//   props: {
//     msg: String
//   },


        data() {
            return {
                html:`
                    <table class="tableData">
                        <tr>
                            <td>
                        asdf
                            </td>
                            <td>b</td>
                            <td>c</td>
                        </tr>
                    </table>
                `,
            
            }
          },

  methods: {
    downloadWithCSS() {
         var html = '<h1>hello</h1>';
      const doc = new jsPDF();
      /** WITH CSS */
      var canvasElement = document.createElement('canvas');
    //   html2canvas(this.$refs.content, { canvas: canvasElement }).then(function (canvas) {
      html2canvas(html, { canvas: canvasElement }).then(function (canvas) {
        // const img = canvas.toDataURL("image/jpeg", 0.8);
        // doc.addImage(img,'JPEG',20,20);
        doc.save("sample.pdf");
      });
    },
    download() {
      const doc = new jsPDF();
      
      /** WITHOUT CSS */
      const contentHtml = this.html2;
    //   const contentHtml = this.$refs.content.innerHTML;
      doc.fromHTML(contentHtml, 15, 15, {
          width: 170
        });
      doc.save("sample.pdf");
    }
  }
};
</script>