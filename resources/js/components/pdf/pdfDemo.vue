<template>
  <div>
    
    <div class="sheet">
      <table class="table tableData" witdh="80%"> 
        <tr>
            <td><img src="img/Ndiaco.jpg" alt="diaco"  ></td>
            
            <td>
                <p>
                    Dirección de Atención y Asistencia al Consumidor -DIACO-
                </p> <br>
                <p>Ministerio de Economia</p>
            </td>
            <td><img src="img/Ndiaco.jpg" alt="diaco" ></td>
           
        </tr>
    </table>
    </div>
  </div>
</template>

<style >
  
  .table {
            font-family: verdana !important;
            font-size: 12px;
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            border: 1px solid #ccc;
            margin-bottom: none !important;
        }


          .tableData{
                padding-bottom: 10px;
                /* border:1px solid $000; */
            }
    
            /* .tableData td{
                border:1px solid #000;
            } */

            .tableData img{
                padding: 0 auto;
                margin:0 auto;
                width:200px;
                
            }
            .tableData td p{
                width: 250;
                font-size: 12px;
                text-align: center;
            }
</style>

<script>

export default {


        data() {
            return {
               n:0
            
            }
          },
};
</script>