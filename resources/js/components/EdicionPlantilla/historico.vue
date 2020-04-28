<template>
    <div>
        <el-table
            :data="
                DataResult.slice(
                    (currentPage - 1) * pagesize,
                    currentPage * pagesize
                )
            "
            border
            stripe
            style="width: 100%"
            empty-text="Cargando datos, Espere un momento!"
        >
            <el-table-column prop="NombreTemplate" label="Nombre">
            </el-table-column>
            <el-table-column prop="correlativo" label="Correlativo">
            </el-table-column>
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
                        v-bind:href="
                            '/view/' +
                                scope.row.id +
                                '/' +
                                scope.row.correlativo +
                                '/' +
                                idUser
                        "
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
                            icon="el-icon-data-analysis"
                        >
                            Ver Datos
                        </el-button>
                    </el-link>
                </template>
            </el-table-column>
        </el-table>
        <div style="text-align: left;margin-top: 30px;">
            <el-pagination
                background
                :page-size="10"
                layout="total,sizes,prev, pager, next"
                :total="total"
                @current-change="current_change"
                @size-change="handleSizeChange"
                :current-page.sync="currentPage"
                :page-sizes="[10, 20, 100,200]"
            ></el-pagination>
        </div>
    </div>
    <!-- </el-card> -->
</template>

<style></style>

<script>
export default {
    data() {
        return {
            DataResult: [],
            userInfo: [],
            idUser: 0,
            total: 0,
            currentPage: 1,
            pagesize: 10,
            currentPage2: 5,
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
                    this.total = response.data.length;
                    
                })
                .catch(function(error) {
                    console.log(error);
                })
                .finally(function() {});
        },
        getUserAuth() {
            axios.get("/getInfoUser").then(response => {
                this.userInfo = response.data;
                this.idUser = this.userInfo[0].usuario_id;
            });
        },
        current_change: function(currentPage) {
            this.currentPage = currentPage;
        },
        handleSizeChange(val) {
            this.pagesize = val;
            
        }
    }
};
</script>
