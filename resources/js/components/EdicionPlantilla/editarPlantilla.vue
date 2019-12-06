<template>
  <div>
    <el-form :inline="false" v-model="formInline" class="form" ref="formInline"  id="vue-Asignacion">
            <el-table :data="Productos"
              style="width: 100%"
              border>
              <el-table-column prop="produto" label="Producto"></el-table-column>
              <el-table-column prop="medida" label="Medida"></el-table-column>
              <el-table-column prop="categoria" label="categoria"></el-table-column>
              <!-- <el-table-column prop="template" label="categoria"></el-table-column>  -->
              <el-table-column label="Operaciones" width="200">
               
                <template slot-scope="scope">
                  <!-- <el-button size="mini"  @click="handleEdit(scope.row.code)">Editar</el-button> -->
                  <el-button-group>
                    <el-button size="mini"  @click="showDialogEdit(scope.row.produto,scope.row.medida,scope.row.idPlantilla)">Editar</el-button>
                  </el-button-group>
                </template>
              </el-table-column>
            </el-table>

    <el-dialog title="Edición de Plantilla" :visible.sync="dialogFormVisible">
      <el-form :model="form">
        <el-form-item label="ID" :label-width="formLabelWidth">
          <el-input v-model="form.name" autocomplete="off" :disabled="true"></el-input>
        </el-form-item>
        <el-form-item label="Producto" :label-width="formLabelWidth">
            <el-select v-model="form.producto" placeholder="Producto" filterable >
                  <el-option
                    v-for="(item,index) in ListadoProducto"
                    :key="index"
                    :label="item.name"
                    :value="item.code">
                  </el-option>
              </el-select>
        </el-form-item>
        <el-form-item label="Medida" :label-width="formLabelWidth">
            <el-select v-model="form.medida" placeholder="Municipio" filterable >
                    <el-option
                      v-for="(item,index) in ListadoMedidas"
                      :key="index"
                      :label="item.name"
                      :value="item.code">
                    </el-option>
                </el-select>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">Cancelar</el-button>
        <el-button type="primary" @click="handleEdit()">Actualizar</el-button>
      </span>
    </el-dialog>

        <!-- <el-card clas="box-card categoria" v-for="(item, it) in categoria" :key="it">
          <div slot="header" class="clearfix">
            <span>{{ item.categoria }}</span>
          </div>
            <table class="table table-bordered head" id="vue">
              <thead>
                <tr>
                  <th class="productoName">Producto</th>
                  <th class="medidaName">Medida</th>
                 <th v-for="n in nColumna" :key="n">{{ n }}</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(index, ix) of Productos "
                  :key="ix"
                  v-if="index.categoria == item.categoria">
                  <td>{{ index.produto }}</td>
                  <td class="ReferencesName">{{ index.medida }}</td>
                   <td v-for="n in nColumna" :key="n">
                        <el-input-number  v-model="index['valor' + n ]"  :precision="2" :min="0" :max="1000"></el-input-number>
                   </td>
                 </tr>
              </tbody> 
            </table> 
        </el-card> -->
        <!-- <el-button @click="onSubmit" type="success" icon="el-icon-folder-add" v-loading.fullscreen.lock="fullscreenLoading" plain>Almacenar</el-button>  -->
    </el-form>
  </div>
</template>

<style>
.titulo {
  width: 300px;
}

.selectMercado{
  width: 80% !important;
}

.date {
  margin-top: -30px;
  text-align: right !important;
}

.date span {
  color: red !important;
  font-weight: bold;
}

.date .el-input {
  width: 150px;
}

.establecimiento {
  width: 80%;
}

.head {
  margin-top: 20px;
}

.head th {
  text-align: center !important;
}
.productoName {
  width: 20%;
}

.medidaName {
  width: 60%;
  text-align: center !important;
}

.ReferencesName {
  widows: 10%;
  text-align: center !important;
}

.precioName {
  width: 150px !important;
}

.precioName input {
  margin: 0 auto !important;
  padding: 0 auto !important;
}

.paso{
  background-color: green;
  width: 23px;
  height: 22px;
  border-radius: 10px;
  margin-top:10px;
}

.aumento{
  background-color: red;
  width: 23px;
  height: 22px;
  border-radius: 10px;
  margin-top:10px;
}

.inputAumento{
  background-color: red !important;
}

.inputPaso{
  background-color: green !important;
}
.el-select{
  width: 100%;
}
</style>

<script>
export default {
  name: "vaciado",
  props: ["fecha", "usuario", "coleccion", "categoria", "id"],
  
  data() {
    return {
      Fecha: "fecha",
      sedes:{
        select1: "Seleccione una Opción",
        select2: "Seleccione una Opción",
        select3: "Seleccione una Opción",
        select4: "Seleccione una Opción",
        select5: "Seleccione una Opción",
        mLugar: "Seleccione una Opción",
      },
      input1: "",
      input2: "",
      input3: "",
      input4: "",
      input5: "",
      linea: 1,
      n:"",
      tipo:'',
      IdTipo:{},
     

      formInline: {
        idplantilla:'',
        id_usuario:'',
        sede1:'',
        sede2:'',
        sede3:'',
        categoria:{},
        
        Productos:{},
        coleccion:{}
        
        
      },
      Productos:[],
      dataProductos:[],
      formData:'asdf',
      idVerificador:'',
      Data1:{},
      valor1:'',
      inputs1:{},
      sede:{},
      inputMercados:{
        mercado1:'',
        mercado2:'',
        mercado3:'',
        mercado4:'',
        mercado5:'',
      },
      // DataAdd:[],
      Data:[],
      idP:'',
      Mercados:[],
      Propano:[],
      idTt:'',
      SMercado: [],
      fullscreenLoading: false,
      nColumna:0,
      dialogFormVisible: false,
      form: {
          name: '',
          producto:"",
          medida:""
        },
        formLabelWidth: '120px',
        ListadoProducto:[],
        ListadoMedidas:[],
        codeEdit:0
      // usuario:{
      //   sede:'',
      //   nombre:'',
      //   id_usuario:''
      // }
    };
  },
  mounted() {
    this.DataProductos();
    // this.getTipo();
    // this.getPropano();
    // console.log(this.usuario);
    // this.getSMercado();
    // this.getColumnas();
    
    this.getAllProduct();
    this.getAllmeasure();
  },
  methods: {
    showDialogEdit(producto,medida,idplantilla){
      this.dialogFormVisible = true;

      this.form.name = idplantilla;
      // this.form.producto = producto;
      // this.form.medida = medida;
    },
    handleEdit(row){
        if(this.form.producto === "" ){
            this.form.producto = 0;
            
            const config = { headers: {'Content-Type': 'application/json'} };
            const h = this.$createElement;
            var url = "/updatePlantillaById"; 
            axios
            .put(url, {
                id: this.form.name,
                producto: this.form.producto,
                medida: this.form.medida,
            },config
            )
            .then(response => {   
              
                const status = JSON.parse(response.status);
                if (status == "200") {    
                this.$message({
                    message: h("p", null, [
                    h("i", { style: "color: teal" }, "Datos Actualizados!")
                    ]),
                    type: 'success'
                });
                this.DataProductos();
                this.dialogFormVisible = false;
                this.form.name= "";
                // this.form.address ="";
                this.form.producto = "";
                this.form.medida = "";
                }
            })
            .catch(error => {
                this.$message.error({
                    message: h("p", null, [
                    h("i", { style: "color: red" }, 'Error, servidor no encontrado')
                    ])
                });
            });  
        }else if(this.form.medida === ""){
            this.form.medida = 0;
            
            const config = { headers: {'Content-Type': 'application/json'} };
            const h = this.$createElement;
            var url = "/updatePlantillaById"; 
            axios
            .put(url, {
                id: this.form.name,
                producto: this.form.producto,
                medida: this.form.medida,
            },config
            )
            .then(response => {   
              
                const status = JSON.parse(response.status);
                if (status == "200") {    
                this.$message({
                    message: h("p", null, [
                    h("i", { style: "color: teal" }, "Datos Actualizados!")
                    ]),
                    type: 'success'
                });
                this.DataProductos();
                this.dialogFormVisible = false;
                this.form.name= "";
                // this.form.address ="";
                this.form.producto = "";
                this.form.medida = "";
                }
            })
            .catch(error => {
                this.$message.error({
                    message: h("p", null, [
                    h("i", { style: "color: red" }, 'Error, servidor no encontrado')
                    ])
                });
            });
        }else{
          const config = { headers: {'Content-Type': 'application/json'} };
            const h = this.$createElement;
            var url = "/updatePlantillaById"; 
            axios
            .put(url, {
                id: this.form.name,
                producto: this.form.producto,
                medida: this.form.medida,
            },config
            )
            .then(response => {   
              
                const status = JSON.parse(response.status);
                if (status == "200") {    
                this.$message({
                    message: h("p", null, [
                    h("i", { style: "color: teal" }, "Datos Actualizados!")
                    ]),
                    type: 'success'
                });
                this.DataProductos();
                this.dialogFormVisible = false;
                this.form.name= "";
                // this.form.address ="";
                this.form.producto = "";
                this.form.medida = "";
                }
            })
            .catch(error => {
                this.$message.error({
                    message: h("p", null, [
                    h("i", { style: "color: red" }, 'Error, servidor no encontrado')
                    ])
                });
            });
        }
    },
     getAllProduct: function() {
                axios.get("/findAllProducto")
                .then(res => {
                    this.ListadoProducto = res.data;
                })
                .catch(function(err){
                    console.log(err)
                })
            },
            getAllmeasure: function(){
                axios.get("/findAllmeasure")
                .then(res => {
                    this.ListadoMedidas = res.data;
                })
                .catch(function(err){
                    console.log(err)
                })
            },
    DataProductos: function(){
          // this.Productos = [];

          var url = "/getProductoEdicionPlantilla";
          axios.post(url,{
            id: this.id
          }).then(response => {
            this.Productos = response.data;
          })
    },
      
      getTipo: function(){
        const tipos = this.idplantilla;
          axios.get('/visitas/'+tipos)
            .then(response => {
              // handle success
              //this.DataResult = response.data;
              this.IdTipo = response.data;
              // console.log(this.IdTipo);
            })
            .catch(function (error) {
              // handle error
              console.log(error);
            })
            .finally(function () {
              // always executed
            });
        },
      getSMercado: function(){
          axios.get('/findAllSmarket')
            .then(response => {
              this.SMercado = response.data;
            })
            .catch(function (error) {
              console.log(error);
            })
            .finally(function () {
            });
        },
      getColumnas: function(){
          axios.post('/getCountColumn',{id: this.idplantilla})
            .then(response => {
              this.nColumna = response.data;
              // console.log(this.nColumna);
              // console.log(response.data);
            })
            .catch(function (error) {
              console.log(error);
            })
            .finally(function () {
            });
        },
      getPropano: function(){
              axios.get('/getPropano')
                .then(response => {
                  this.Propano = response.data;
                 
                })
                .catch(function (error) {
                  console.log(error);
                });
                
      },    
    onSubmit() {
      this.fullscreenLoading = true;
        for(let a = 0; a <= this.coleccion.length-1; a++){
            this.dataProductos.push({
                idDataProducto: this.coleccion[a].producto,
                idDataMedida: this.coleccion[a].idmedida
            })
        }

        var url = '/mercadoCBA';
        const bandeja = '/Bandeja';
        
        axios.post(url, {
            idP: this.idplantilla,
            Mercados: this.inputMercados,
            Sedes:this.sedes,
            Usuarios: this.usuario[0].id_usuario,
            Data: this.Productos,
            idSede:this.usuario[0].id,
            idTipo: this.IdTipo
        }).then(response =>{
          const status = 
            JSON.parse(response.status);

          //redirect logic
          if (status == '200') {
            window.location = bandeja;
            this.fullscreenLoading = false;
            //this.$router.push('/Bandeja');
          }
            //console.log("respuesta"+response.data)
        }).catch(error => {
          this.fullscreenLoading = false;
				  console.log(error.message)
        });
      
        
      }
  }
};
</script>
