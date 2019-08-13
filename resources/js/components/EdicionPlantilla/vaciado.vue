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
          <input type="hidden" :value="formInline.valores" name="idValores">
          
        </div>
        <div>

      

          <table class="table">
            <tbody v-for="(index , ex1) in usuario" :key="ex1">
              <tr v-for="(tipos, tp) of IdTipo" :key="tp">
                  <td  class="titulo">Sede:</td>
                  <td  colspan="8">{{ index.sede }}</td>

                   
                  
                  <td v-if="tipos.tipoVerificacion === '5'" class="titulo">Mercado:</td>

                  <td v-if="tipos.tipoVerificacion === '5'" class="selectMercado">
                      <el-select :name="'LugarMercado'" v-model="sedes['mLugar']">
                          <el-option
                            v-for="(sede,index) in mercados"
                            v-bind:key=" index "
                            :label=" sede.nombre  " 
                            :value=" sede.idMercado "
                          ></el-option>
                      </el-select>
                  </td>
              </tr>
              <tr >
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
            
            <div>
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
                      <el-select :name="'visita['  + n  + ']'" v-model="sedes['select' + n ]">
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
                  <!-- <tr>
                    <td>1</td>
                    <td>
                      <el-select name="Visita[1]" class="vue-select" v-model="sede1"  >
                        <el-option
                          v-for="(sede,index) in establecimientos"
                          v-bind:key=" index "
                          :label=" sede.nombre  " 
                          :value=" sede.idMercado "
                        ></el-option>
                      </el-select>
                    </td>
                    <td>
                       <el-input v-model="input1" name="iputMercado[1]" maxlength="3"></el-input> 
                    </td>
                  </tr>
                  
                   <tr>
                    <td>2</td>
                    <td>
                      <el-select
                        name="Visita[2]"
                        class="vue-select"
                        v-model="select2"
                        placeholder="Plantillas"
                      >
                        <el-option
                          v-for="(item0,idx2) in establecimientos"
                          :key="idx2"
                          :label=" item0.nombre "
                          :value=" item0.idMecado "
                        ></el-option>
                      </el-select>
                    </td>
                    <td>
                      <el-input v-model="input2" name="iputMercado[2]" maxlength="3"></el-input>
                    </td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>
                      <el-select
                        name="Visita[3]"
                        class="vue-select"
                        v-model="select3"
                        placeholder="Plantillas"
                      >
                        <el-option
                          v-for="(item1,idx3) in establecimientos"
                          :key="idx3"
                          :label=" item1.nombre "
                          :value=" item1.idMecado "
                        ></el-option>
                      </el-select>
                    </td>
                    <td>
                      <el-input v-model="input3" name="iputMercado[3]" maxlength="3"></el-input>
                    </td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>
                      <el-select
                        name="Visita[4]"
                        class="vue-select"
                        v-model="select4"
                        placeholder="Plantillas"
                      >
                        <el-option
                          v-for="(item2,idx4) in establecimientos"
                          :key="idx4"
                          :label=" item2.nombre "
                          :value=" item2.idMercado "
                        ></el-option>
                      </el-select>
                    </td>
                    <td>
                      <el-input v-model="input4" name="iputMercado[4]" maxlength="3"></el-input>
                    </td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>
                      <el-select
                        name="Visita[5]"
                        class="vue-select"
                        v-model="select5"
                        placeholder="Plantillas"
                      >
                        <el-option
                          v-for="(item3,idx5) in establecimientos"
                          :key="idx5"
                          :label=" item3.nombre "
                          :value=" item3.idMercado "
                        ></el-option>
                      </el-select>
                    </td>
                    <td>
                      <el-input v-model="input5" name="iputMercado[5]" maxlength="3"></el-input>
                    </td>
                  </tr> -->
                </tbody>
              </table>
            </div>
          </el-card>
        </div>
        
      </el-card>
    
<!-- <el-form :inline="false" :model="formInline" class="form" id="vue-Asignacion"> -->
      <!-- Vaciado -->
      <el-card class="box-card">
        <el-card clas="box-card categoria" v-for="(item, it) in categoria" :key="it">
          <div slot="header" class="clearfix">
            <span>{{ item.categoria }}</span>
          </div>
          <table class="table table-bordered head" id="vue">
            <thead>
              <tr>
                <th class="productoName">Producto</th>
                <th class="medidaName">Medida</th>
                <th class="ReferencesName" >Ref. 1</th>
                <!-- <th class="ReferencesName">Ref. 2</th> -->
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
                <td class="ReferencesName">{{ index.precio2 }}</td>
                  <td v-for="n in 5" :key="n">
                    <input type="text" class="form-control" :name="'inputs['  + n  + ']'" v-model="index['valor' + n ]">
                  </td>
                <!-- <td v-html="index.producto" ></td> -->
                <!-- <td class="precioName" v-html="index.productoId"></td> -->

                <!-- <tr v-for="item in items" :key="item.id"> -->
                <!-- </tr> -->

                <!-- <td v-for="(it,ti) in 5" :key="ti"> -->
                  <!-- <input  type=text class="form-control" maxlength=10  /> -->
                  <!-- <input type="text" :name="'input['  + it  + ']'" v-model="item['valor' + it ]"> -->
                <!-- </td> -->
                <!-- <td class="precioName" v-html="index.inputColumn1"></td> -->
                <!-- <td class="precioName" v-html="index.inputColumn2"></td>
                <td class="precioName" v-html="index.inputColumn3"></td>
                <td class="precioName" v-html="index.inputColumn4"></td>
                <td class="precioName" v-html="index.inputColumn5"></td> -->
                <!-- <td v-html="index.productoId" ></td> -->
                
              </tr>
            </tbody>
          </table>
          
        </el-card>
        <el-button @click="onSubmit" type="success" icon="el-icon-folder-add" plain>Almacenar</el-button>
        <!-- <button  type="submit" class="btn btn-outline-success">Almacenar</button> -->
        
      </el-card>
    </el-form>
  </div>
</template>

<style>
.titulo {
  width: 300px;
}

.selectMercado{
  width: 40% !important;
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
      IdTipo:[],
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
      Mercados:[]
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
            // console.log(this.Productos);
        }
    },
          getTipo: function(){
            const tipos = this.idplantilla;
              axios.get('/visitas/'+tipos)
                .then(response => {
                  // handle success
                  //this.DataResult = response.data;
                  this.IdTipo = response.data;
                  console.log(this.IdTipo);
                })
                .catch(function (error) {
                  // handle error
                  console.log(error);
                })
                .finally(function () {
                  // always executed
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
            idSede:this.usuario[0].id
        }).then(response =>{
          const status = 
            JSON.parse(response.status);

          //redirect logic
          if (status == '200') {
            window.location = bandeja;
            //this.$router.push('/Bandeja');
          }
            //console.log("respuesta"+response.data)
        }).catch(error => {
				  console.log(error.message)
        });
      
        
      }
  }
};
</script>
