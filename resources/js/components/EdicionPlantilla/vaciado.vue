<template>
  <div>
    
    <!-- <el-form :inline="false" :model="formInline" class="form" id="vue-Asignacion"> -->
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Vaciado de Información de Mercados</span>
          <span class="d"></span>
        </div>
        <div slot="header" class="date">
          Fecha:
          <span>{{ fecha }}</span>
        </div>
        <div>
          <table class="table">
            <tbody v-for="(index , ex1) in usuario" :key="ex1">
              <tr >
                <td class="titulo">Sede:</td>
                <td colspan="11">{{ index.sede }}</td>
              </tr>
              <tr >
                <td class="titulo">Verificador:</td>
                <td colspan="11">{{ index.nombre }}</td>
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
                  <tr>
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
                  </tr>
                </tbody>
              </table>
            </div>
          </el-card>
        </div>
        
      </el-card>
    
<el-form :inline="false" :model="formInline" class="form" id="vue-Asignacion">
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
                <th class="ReferencesName">Ref. 1</th>
                <th class="ReferencesName">Ref. 2</th>
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
                <td>{{ index.medida }}</td>
                <td >{{ index.precio1 }}</td>
                <td>{{ index.precio2 }}</td>
                <td class="precioName" v-html="index.inputColumn1"></td>
                <td class="precioName" v-html="index.inputColumn2"></td>
                <td class="precioName" v-html="index.inputColumn3"></td>
                <td class="precioName" v-html="index.inputColumn4"></td>
                <td class="precioName" v-html="index.inputColumn5"></td>
                <td v-html="index.label"></td>
              </tr>
            </tbody>
          </table>
        </el-card>
        <el-button type="success" icon="el-icon-folder-add" plain>Almacenar</el-button>
        <button type="submit" class="btn btn-outline-success">Almacenar</button>
      </el-card>
    </el-form>
  </div>
</template>

<style>
.titulo {
  width: 200px;
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
</style>

<script>
export default {
  name: "vaciado",
  props: ["fecha", "usuario", "coleccion", "categoria", "establecimientos"],
  
  data() {
    return {
      Fecha: "fecha",
      sede1: "Seleccione una Opción",
      select2: "Seleccione una Opción",
      select3: "Seleccione una Opción",
      select4: "Seleccione una Opción",
      select5: "Seleccione una Opción",
      input1: "",
      input2: "",
      input3: "",
      input4: "",
      input5: "",
      linea: 1,
      formInline: {},
      Productos:[],
    };
  },
  mounted() {
    this.DataProductos();

  },
  methods: {
    DataProductos: function(){
          for (let i = 0; i <= this.coleccion.length-1; i++) {
            this.Productos.push({
              NombrePlantilla: this.coleccion[i].NombrePlantilla,
              categoria: this.coleccion[i].categoria,
              created_at: this.coleccion[i].created_at,
              medida: this.coleccion[i].medida,
              producto: this.coleccion[i].producto,
              produto: this.coleccion[i].produto,
              precio1: this.coleccion[i].Anterior1,
              precio2: this.coleccion[i].Anterior2,
              inputColumn1: `<input type=text onblur="mensaje(this.id,${this.coleccion[i].Anterior1},${this.coleccion[i].Anterior2},this.value)" class="form-control" maxlength=10 id=inputColumn1_${ i } name=inputColumn1[${ i }] />`,
              inputColumn2: `<input type=text onblur="mensaje(this.id,${this.coleccion[i].Anterior1},${this.coleccion[i].Anterior2},this.value)" class="form-control" maxlength=10 id=inputColumn2_${ i } name=inputColumn2[${ i }] />`,
              inputColumn3: `<input type=text onblur="mensaje(this.id,${this.coleccion[i].Anterior1},${this.coleccion[i].Anterior2},this.value)" class="form-control" maxlength=10 id=inputColumn3_${ i } name=inputColumn3[${ i }] />`,
              inputColumn4: `<input type=text onblur="mensaje(this.id,${this.coleccion[i].Anterior1},${this.coleccion[i].Anterior2},this.value)" class="form-control" maxlength=10 id=inputColumn4_${ i } name=inputColumn4[${ i }] />`,
              inputColumn5: `<input type=text onblur="mensaje(this.id,${this.coleccion[i].Anterior1},${this.coleccion[i].Anterior2},this.value)" class="form-control" maxlength=10 id=inputColumn5_${ i } name=inputColumn5[${ i }] />`,
              
              
            })
        }
    }
    
  }
};
</script>
