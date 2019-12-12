<template>
<div>
        <el-table :data="DataResult" border stripe style="width: 100%">
            <el-table-column prop="NombreTemplate" label="Nombre">
            </el-table-column>
            <el-table-column prop="correlativo" label="Correlativo"> </el-table-column>
            <el-table-column prop="nombre_sede" label="Sede"> </el-table-column>
            <el-table-column prop="estatus" label="Estatus"> </el-table-column>
            <el-table-column prop="nombre" label="Usuario"> </el-table-column>
            <!-- <el-table-column label="Fecha de Envio">
                <template slot-scope="scope">
                    <i class="el-icon-time"></i>
                    <span style="margin-left: 10px">{{
                        scope.row.created_at
                    }}</span>
                </template>
            </el-table-column> -->
            <el-table-column width="220" label="Operaciones">
                <template slot-scope="scope">
                    <el-link
                        :underline="false"
                        v-bind:href="'/view/' + scope.row.id+'/'+scope.row.correlativo+'/'+ idUser"
                        > 
                        <!-- <el-button
                            size="small"
                            type="success"
                            icon="el-icon-office-building">
                        Excel
                        </el-button> -->
                        <el-button
                            size="small"
                            type="success"
                            icon="el-icon-data-analysis">
                              Ver Datos
                        </el-button>
                    </el-link>
                </template>
            </el-table-column>
        </el-table>
  </div>       
    <!-- </el-card> -->
</template>

<style></style>

<script>
export default {
    data() {
        return {
            DataResult: [],
            userInfo:[],
            idUser:0
        };
    },
    mounted() {
        this.getData();
        this.getUserAuth();
    },
    methods: {
        getData: function() {
            axios
                .get("/getEnviados") 
                .then(response => {
                    this.DataResult = response.data; 
                    console.log(this.DataResult);
                })
                .catch(function(error) {
                    console.log(error);
                })
                .finally(function() {});
        },
        getUserAuth () {
              axios.get('/getInfoUser')
                  .then(response => {
                        this.userInfo = response.data;
                        this.idUser = this.userInfo[0].usuario_id;
                        
                  })
        }
    }
};
</script>
