<template>
  <div>
    
    <el-form :inline="false" :model="formInline" class="form" id="vue-Asignacion">
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
                      <el-select name="sede1" class="vue-select" v-model="sede1"  >
                        <el-option
                          v-for="(sede,index) in establecimientos"
                          v-bind:key=" index "
                          :label=" sede.nombre  " 
                          :value=" sede.idMercado "
                        ></el-option>
                      </el-select>
                    </td>
                    <td>
                       <el-input v-model="input1" name="Mercado1" maxlength="3"></el-input> 
                    </td>
                  </tr>
                  
                   <tr>
                    <td>2</td>
                    <td>
                      <el-select
                        name="idSede2"
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
                      <el-input v-model="input2" name="Mercado2" maxlength="3"></el-input>
                    </td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>
                      <el-select
                        name="idSede3"
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
                      <el-input v-model="input3" name="Mercado3" maxlength="3"></el-input>
                    </td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>
                      <el-select
                        name="idSede4"
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
                      <el-input v-model="input4" name="Mercado4" maxlength="3"></el-input>
                    </td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>
                      <el-select
                        name="idSede5"
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
                      <el-input v-model="input5" name="Mercado5" maxlength="3"></el-input>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </el-card>
        </div>
      </el-card>

      <!-- Vaciado -->
      <el-card class="box-card">
        <el-card clas="box-card categoria" v-for="(item, it) in categoria" :key="it">
          <div slot="header" class="clearfix">
            <span>{{ item.categoria }}</span>
          </div>
          <table class="table table-bordered" id="vue">
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
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(index, ix) of coleccion "
                :key="ix"
                v-if="index.categoria == item.categoria"
              >
                <td>{{ index.produto }}</td>
                <td>{{ index.medida }}</td>
                <td></td>
                <td>&nbsp;</td>
                <td class="precioName">
                  <input name="precio1[]" class="form-control" />
                </td>
                <td class="precioName">
                  <input name="precio2[]" class="form-control" />
                </td>
                <td class="precioName">
                  <input name="precio3[]" class="form-control" />
                </td>
                <td class="precioName">
                  <input name="precio4[]" class="form-control" />
                </td>
                <td class="precioName">
                  <input name="precio5[]" class="form-control" />
                </td>
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
      
    };
  },
  mounted() {
    
    //for (var prop in establecimientos) { if (establecimientos.hasOwnProperty(prop)) { console.log(prop.id) } }
    // invocar los métodos
    //this._filas("#vue");
    // this.pollData();
  },
  methods: {}
};
</script>
