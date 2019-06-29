<template>
<div class="">
    <el-form 
        :inline="false" 
        :model="formInline" 
        class="form"
        id="vue-Asignacion"
        
    >
        <el-form-item label="Plantillas: "> 
          <select name="SPlantillas" id="SPlantilla" class="form-control">
              <option >Seleccione una Opción</option>
              <option v-for="(item, idx) in coleccion" :key="idx"  :value="item.id">{{ item.NombreTemplate}}</option>
          </select>         
        </el-form-item>
        
        <el-form-item label="Sedes: ">
         <select name="SSede" id="SSede" class="form-control">
            <option >Seleccione una Opción</option>
              <option v-for="(item, idx) in Sedes" :key="idx"  :value="item.id_diaco_sede">{{ item.nombre_sede}}</option>
          </select> 
            <!-- <el-select  name="idSede" class="vue-select" v-model="id_diaco_sede" placeholder="Sedes">
                <el-option v-for="(item,idx) in Sedes" :key="idx" :label=" item.nombre_sede " :value=" item.id_diaco_sede "></el-option>
               
            </el-select> -->
        </el-form-item>

        <el-form-item>
            <button @click="onSubmit" type="submit" class="btn btn-success" id="btnAsignar">Asignar</button>
        </el-form-item>
    </el-form>

    <div class="El-table">
        <!-- <el-button @click="resetDateFilter">Borra filtro</el-button>
        <el-button @click="clearFilter">Borrar todos los filtros</el-button> -->
        <el-table
                ref="filterTable"
                :data="tableData"
                style="width: 100%">
                <el-table-column
                prop="address"
                label="Plantilla"
                :formatter="formatter"
                >
                </el-table-column>
                <el-table-column
                prop="name"
                label="Sede"
                width="120">
                </el-table-column>
                <el-table-column
                prop="date"
                label="Creado"
                sortable
                width="140"
                column-key="date"
                :filters="[{text: '2016-05-01', value: '2016-05-01'}]"
                :filter-method="filterHandler"
                >
                <template slot-scope="scope">
                    <i class="el-icon-time"></i>
                    <span style="margin-left: 10px">{{ scope.row.date }}</span>
                </template>
                </el-table-column>
                <el-table-column
                prop="tag"
                label="Estatus"
                width="100"
                :filters="[{ text: 'Home', value: 'Home' }, { text: 'Office', value: 'Office' }]"
                :filter-method="filterTag"
                filter-placement="bottom-end">
                <template slot-scope="scope">
                    <el-tag
                    :type="scope.row.tag === 'Home' ? 'primary' : 'success'"
                    disable-transitions>{{scope.row.tag}}</el-tag>
                </template>
                </el-table-column>
                <el-table-column
                align="right">
                <template slot="header" slot-scope="scope">
                    <el-input
                    v-model="search"
                    size="mini"
                    placeholder="Type to search"/>
                </template>
                <template slot-scope="scope">
                    <el-button
                    size="mini"
                    @click="handleEdit(scope.$index, scope.row)">Edit</el-button>
                    <el-button
                    size="mini"
                    type="danger"
                    @click="handleDelete(scope.$index, scope.row)">Delete</el-button>
                </template>
                </el-table-column>
        </el-table>
    </div>
</div>

</template>


<style>
    .vue-select{
        width: 100%;
        font-weight: bold;
    }
    .el-form-item__label{
        font-weight: bold;
        font-size: 1em;
    }


</style>


<script>
  export default {
    props: ['coleccion','Sedes'],
    data() {
      return {
        formInline: {
          selectPlantilla:'',
          selectSede:''
        },
        'tableData' : [],
        search: '',
         SPlantilla:'',
         SSede:''
      }
    },
    
     methods: {
      onSubmit: function(){
        var url = 'http://128.5.101.19:8000/aLista';
        axios.post(url, {
            SPlantilla: this.SPlantilla,
            SSede: this.SSede
        }).then(response =>{
          console.log("exito");
        }).catch(error => {
				console.log(error.message)
        });
      },
      resetDateFilter() {
        this.$refs.filterTable.clearFilter('date');
      },
      clearFilter() {
        this.$refs.filterTable.clearFilter();
      },
       formatter(row, column) {
        return row.address;
      },
      filterTag(value, row) {
        return row.tag === value;
      },
      filterHandler(value, row, column) {
        const property = column['property'];
        return row[property] === value;
      },
      handleEdit(index, row) {
        console.log(index, row);
      },
      handleDelete(index, row) {
        console.log(index, row);
      }
    }
  }
</script>