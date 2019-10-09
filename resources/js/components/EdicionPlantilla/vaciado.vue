<template>
  <div>
    
    <el-form :inline="false" v-model="formInline" class="form" ref="formInline"  id="vue-Asignacion">
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Vaciado de Información</span>
          <span class="d"></span>
        </div>
        <div slot="header" class="date">
          Fecha:
          <span>{{ fecha }}</span>
          
          <input type="hidden" :value="formInline.idplantilla" name="idPlantilla">
          
          
        </div>
        <div>

      

          <table class="table">
            <tbody v-for="(index , ex1) in usuario" :key="ex1">
              <tr >
                  <td  class="titulo">Sede:</td>
                  <td  colspan="8">{{ index.sede }}</td>

                   
              <span  v-for="(tipos, tp) of IdTipo" :key="tp" >
                  <span v-if="tipos.tipoVerificacion === '1'">
                    <td  class="titulo">Mercado:</td> 
                    <td v-if="tipos.tipoVerificacion === '1'" class="selectMercado">
                        <el-select :name="'LugarMercado'" v-model="sedes['mLugar']"  filterable  >
                            <el-option
                              v-for="(sede,index) in mercados"
                              v-bind:key=" index "
                              :label=" sede.nombre  " 
                              :value=" sede.idMercado "
                            ></el-option>
                        </el-select>
                    </td>
                  </span>
                  <span v-if="tipos.tipoVerificacion === '2'">
                    <td  class="titulo">Super Mercado:</td> 
                    <td v-if="tipos.tipoVerificacion === '2'" class="selectMercado">
                        <el-select :name="'LugarMercado'" v-model="sedes['mLugar']" filterable>
                            <el-option
                              v-for="(sede,index) in mercados"
                              v-bind:key=" index "
                              :label=" sede.nombre  " 
                              :value=" sede.idMercado "
                            ></el-option>
                        </el-select>
                    </td>
                  </span>
                  <span v-if="tipos.tipoVerificacion === '3'">
                    <td  class="titulo">Tienda de Barrio:</td> 
                    <td v-if="tipos.tipoVerificacion === '3'" class="selectMercado">
                        <el-select :name="'LugarMercado'" v-model="sedes['mLugar']" filterable>
                            <el-option
                              v-for="(sede,index) in mercados"
                              v-bind:key=" index "
                              :label=" sede.nombre  " 
                              :value=" sede.idMercado "
                            ></el-option>
                        </el-select>
                    </td>
                  </span>
                  <span v-if="tipos.tipoVerificacion === '4'">
                    <td  class="titulo">Canasta Básica Alimentaria:</td> 
                    <td v-if="tipos.tipoVerificacion === '4'" class="selectMercado">
                        <el-select :name="'LugarMercado'" v-model="sedes['mLugar']" filterable>
                            <el-option
                              v-for="(sede,index) in mercados"
                              v-bind:key=" index "
                              :label=" sede.nombre  " 
                              :value=" sede.idMercado "
                            ></el-option>
                        </el-select>
                    </td>
                  </span>
                  <span v-if="tipos.tipoVerificacion === '5'">
                    <td class="titulo">Gas Propano:</td> 
                    <td v-if="tipos.tipoVerificacion === '5'" class="selectMercado">
                      <el-select :name="'LugarMercado'" v-model="sedes['mLugar']" filterable>
                          <el-option
                            v-for="(sede,index) in mercados"
                            v-bind:key=" index "
                            :label=" sede.nombre  " 
                            :value=" sede.idMercado "
                          ></el-option>
                      </el-select>
                    </td>
                  </span>
              </span>    
              </tr>
              <tr>
                <td class="titulo">Verificador:</td>
                <td colspan="11">{{ index.nombre }}</td>
                <input type="hidden"  :value="index.id_usuario"  id="idVerificador" name="idVerificador" >
              </tr>
            </tbody>
          </table>
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>Lugares de visitas</span>
            </div>
            <div >
              <table class="table table-bordered head">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th class="establecimiento">Establecimiento</th>
                    <th>No. Local</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="n in 5" :key="n">
                    <td>{{ n }}</td>
                    <td >
                      <el-select :name="'visita['  + n  + ']'" v-model="sedes['select' + n ]" filterable>
                          <el-option
                            v-for="(sede,index) in establecimientos"
                            v-bind:key=" index "
                            :label=" sede.nombre  " 
                            :value=" sede.idEstablecimiento "
                          ></el-option>
                      </el-select>
                    </td>
                    <td >
                        
                      <input type="text" class="form-control" :name="'inputMercado['  + n  + ']'" v-model="inputMercados['mercado' + n ]">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </el-card>
        </div>
        
      </el-card>
    
<!-- <el-form :inline="false" :model="formInline" class="form" id="vue-Asignacion"> -->
      <!-- Vaciado -->
    <!-- <el-container  > -->
      <el-card class="box-card">
        <el-card clas="box-card categoria" v-for="(item, it) in categoria" :key="it">
          <div slot="header" class="clearfix">
            <span>{{ item.categoria }}</span>
          </div>
          <!-- <el-main> -->

            <!-- Table ElementUI -->

            <!-- <el-table :data="Productos" style="width: 100%;">
              <el-table-column prop="produto" label="Producto" width="180">
              </el-table-column>
              <el-table-column prop="medida" label="Medida" width="180">
              </el-table-column>
              <el-table-column v-for="n in 5" :key="n" :label="''  + n  + ''">
              <template slot-scope="scope">
                       <el-input type="text" size="small"  :name="'inputs['  + n  + ']'"  :v-model="scope['valor' + n ]"></el-input> 
                        <input type="text" class="form-control" :name="'inputs['  + n  + ']'" v-model="scope['valor' + n ]">
              </template>

              </el-table-column>
            </el-table> -->

            <!-- <table class="table table-bordered head" id="vue">
              <thead>
                <tr>
                  <th class="productoName">Producto</th>
                  <th class="medidaName">Medida</th>
                  <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>4</th>
                  <th>5</th>
                  <th></th>
                  
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(index, ix) of Productos "
                  :key="ix"
                  v-if="index.categoria == item.categoria">
                  <td>{{ index.produto }}</td>
                  <td class="ReferencesName">{{ index.medida }}</td>
                    <td v-for="n in 5" :key="n">
                      <el-input size="small"  :name="'inputs['  + n  + ']'" ></el-input>
                    </td>
                </tr>
              </tbody>
             </table>  -->

            <!-- Tabla normal -->
            
            <table class="table table-bordered head" id="vue">
              <thead>
                <tr>
                  <th class="productoName">Producto</th>
                  <th class="medidaName">Medida</th>
                  <!-- <th class="ReferencesName" >Ref. 1</th> -->
                  <!-- <th class="ReferencesName">Ref. 2</th> -->
                 <th>1</th>
                  <th>2</th>
                  <th>3</th>
                  <th>4</th>
                  <th>5</th>
                  <th>Obs.</th>
                  
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(index, ix) of Productos "
                  :key="ix"
                  v-if="index.categoria == item.categoria">
                  <td>{{ index.produto }}</td>
                  <td class="ReferencesName">{{ index.medida }}</td>
                  <!-- <td class="ReferencesName">{{ index.precio2 }}</td> -->
                   <td v-for="n in 5" :key="n">
                        <el-input type="text" size="small"  :name="'inputs['  + n  + ']'" v-model="index['valor' + n ]"></el-input>
                      <!-- <input type="text" class="form-control" :name="'inputs['  + n  + ']'" v-model="index['valor' + n ]"> -->
                   </td>
                   <td >
                        <el-input type="text" size="small"  :name="'inputs['  + n  + ']'" v-model="index['valor' + n ]"></el-input>
                   </td>
                 </tr>
              </tbody> 
            </table> 
          <!-- </el-main> -->
        </el-card>
        <el-button @click="onSubmit" type="success" icon="el-icon-folder-add" v-loading.fullscreen.lock="fullscreenLoading" plain>Almacenar</el-button> 
        <!-- <button  type="submit" class="btn btn-outline-success">Almacenar</button> -->
        
      </el-card>
    <!-- </el-container> -->
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
  width: 10%;
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
  props: ["fecha", "usuario", "coleccion", "categoria", "establecimientos", "idplantilla", "mercados"],
  
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
      // usuario:{
      //   sede:'',
      //   nombre:'',
      //   id_usuario:''
      // }
    };
  },
  mounted() {
    this.DataProductos();
    this.getTipo();
    this.getPropano();
    // console.log(this.usuario);
    this.getSMercado();
  },
  methods: {
    DataProductos: function(){
          for (let i = 0; i <= this.coleccion.length-1; i++) {
            this.Productos.push({
              // NombrePlantilla: this.coleccion[i].NombrePlantilla,
              categoria: this.coleccion[i].categoria,
              created_at: this.coleccion[i].created_at,
              medida: this.coleccion[i].medida,
              producto: this.coleccion[i].producto,
              produto: this.coleccion[i].produto,
              precio1: this.coleccion[i].Anterior1,
              precio2: this.coleccion[i].Anterior1,
              medidaId: this.coleccion[i].idmedida,
              valor1:'',
              valor2:'',
              valor3:'',
              valor4:'',
              valor5:''
            })
            console.log(this.Productos);
        }
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
      getPropano: function(){
              axios.get('/getPropano')
                .then(response => {
                  this.Propano = response.data;
                 
                })
                .catch(function (error) {
                  console.log(error);
                });
                
      },    

    // for (let i = 0; i <= this.coleccion.length-1; i++) {
    //         this.Productos.push({
    //           NombrePlantilla: this.coleccion[i].NombrePlantilla,
    //           categoria: this.coleccion[i].categoria,
    //           created_at: this.coleccion[i].created_at,
    //           medida: this.coleccion[i].medida,
    //           producto: this.coleccion[i].producto,
    //           produto: this.coleccion[i].produto,
    //           precio1: this.coleccion[i].Anterior1,
    //           precio2: this.coleccion[i].Anterior2,
    //           inputColumn1: `<input v-model=campo type=text onblur="mensaje(this.id,${this.coleccion[i].Anterior1},${this.coleccion[i].Anterior2},this.value)" class="form-control" maxlength=10 id=inputColumn1_${ i } name=inputColumn[${ i }] />`,
    //           inputColumn2: `<input type=text onblur="mensaje(this.id,${this.coleccion[i].Anterior1},${this.coleccion[i].Anterior2},this.value)" class="form-control" maxlength=10 id=inputColumn2_${ i } name=inputColumn[2][${ i }] />`,
    //           inputColumn3: `<input type=text onblur="mensaje(this.id,${this.coleccion[i].Anterior1},${this.coleccion[i].Anterior2},this.value)" class="form-control" maxlength=10 id=inputColumn3_${ i } name=inputColumn[3][${ i }] />`,
    //           inputColumn4: `<input type=text onblur="mensaje(this.id,${this.coleccion[i].Anterior1},${this.coleccion[i].Anterior2},this.value)" class="form-control" maxlength=10 id=inputColumn4_${ i } name=inputColumn[4][${ i }] />`,
    //           inputColumn5: `<input type=text onblur="mensaje(this.id,${this.coleccion[i].Anterior1},${this.coleccion[i].Anterior2},this.value)" class="form-control" maxlength=10 id=inputColumn5_${ i } name=inputColumn[5][${ i }] />`,
    //           productoId: `<input type=text class="form-control" :model:"dataProducto" id=idProducto_${ i } name=idProducto[${ i }]  value= ${this.coleccion[i].producto} />`,
    //           medidaId: `<input type=hidden class="form-control" id=idMedida${ i } name=idMedida[${ i }]  value= ${this.coleccion[i].idmedida} />`,
    //           valor1:'',
    //           valor2:'',
    //           valor3:'',
    //           valor4:'',
    //           valor5:''
    //         })
    //         // console.log(this.Productos);
    //     }
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
