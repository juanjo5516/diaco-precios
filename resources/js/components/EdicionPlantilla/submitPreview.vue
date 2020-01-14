<template>
    <div>
        <el-row :gutter="10">
            <el-col :xs="25" :sm="6" :md="8" :lg="6" :xl="10">
                <div>Sedes:</div>
                <el-select
                    v-model="selectSede"
                    placeholder="Seleccione"
                    @change="change"
                    
                >
                    <el-option
                        v-for="item in getSedes"
                        :key="item.code"
                        :label="item.name"
                        :value="item.code"
                    >
                    </el-option>
                </el-select>
            </el-col>
        </el-row>
        <el-table
            v-if="vista"
            :data="
                DataResult.slice(
                    (currentPage - 1) * pagesize,
                    currentPage * pagesize
                )
            "
            :empty-text="mensajeData"
            border
            
            :cell-class-name="cellRow"
            
            style="width: 100%;margin-top: 25px;"
        >
            <el-table-column prop="NombreTemplate" label="Nombre">
            </el-table-column>
            <el-table-column prop="correlativo" label="Correlativo">
            </el-table-column>
            <el-table-column prop="nombre_sede" label="Sede"> </el-table-column>
            <el-table-column prop="estatus" label="Estado"> </el-table-column>
            <el-table-column prop="nombre" label="Usuario"> </el-table-column>
            <el-table-column width="220" label="Operaciones">
                <template slot-scope="scope">
                    <el-button-group>
                        <el-link
                            :underline="false"
                            v-bind:href="
                                '/viewSubmit/' +
                                    scope.row.id +
                                    '/' +
                                    scope.row.correlativo +
                                    '/' +
                                    idUser
                            "
                        >
                            <el-button
                                size="small"
                                type="success"
                                icon="el-icon-data-analysis"
                            >
                                Ver Datos
                            </el-button>
                        </el-link>
                        <el-link
                            :underline="false"
                            v-bind:href="
                                '/viewSubmitPricesEdit/' +
                                    scope.row.id +
                                    '/' +
                                    scope.row.correlativo +
                                    '/' +
                                    idUser
                            "
                        >
                            <el-button size="small" type="primary">
                                Editar
                            </el-button>
                        </el-link>
                    </el-button-group>
                </template>
            </el-table-column>
        </el-table>
        <div style="text-align: left;margin-top: 30px;" v-if="vista">
            <el-pagination
                background
                :page-size="10"
                layout="total,sizes,prev, pager, next"
                :total="total"
                @current-change="current_change"
                @size-change="handleSizeChange"
                :current-page.sync="currentPage"
                :page-sizes="[10, 20, 100, 200]"
            ></el-pagination>
        </div>
    </div>
    <!-- </el-card> layout="total,prev, pager, next"-->
</template>

<style >

    .el-table .warning-row {
        background: #F56C6C !important;
        color: #FFF;
        text-align: center !important;
    }

    .el-table .success-row {
        background: #E6A23C !important;
        color: #FFF;
    }

    .el-table .outData {
        background: #909399;
        color: #fff;
    }

    .el-table--enable-row-hover .el-table__body tr:hover>td{
        background-color: #212e3e !important;
        color:#FFF;
        /* transition: all 400ms ease-out; */
    }
</style>


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
            vista: false,
            selectSede: "",
            getSedes: [],
            mensajeData: "Cargando datos..."
        };
    },
    mounted() {
        this.getSede();
        // this.getData();
        this.getUserAuth();
        
    },
    methods: {
        cellRow ({row, column, rowIndex, columnIndex}) {
            console.log(column)
            if(column.property == 'estatus'){
                return 'warning-row';
            }
            // if (column.label == 'Ingresada') {
            //     return 'outData';
            // }else if(row.estatus == 'Enviada'){
            //     return 'success-row';
            // }else if(row.estatus == 'Publicada'){
            //     return 'warning-row'
            // }
        },
        tableRowClassName({row, rowIndex}) {
            // console.log(row.estatus)
            if (row.estatus == 'Ingresada') {
                return 'outData';
            }else if(row.estatus == 'Enviada'){
                return 'success-row';
            }else if(row.estatus == 'Publicada'){
                return 'warning-row'
            }

        // if (rowIndex === 1) {
        //   return 'warning-row';
        // } else if (rowIndex === 3) {
        //   return 'success-row';
        // }
        return '';
      },
        
        change(index) {
            this.getData(index);
            
            this.vista = true;
        },
        getSede() {
            axios
                .get("/getSedeData") 
                .then(response => {
                    this.getSedes = response.data;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        getData: function(idSede) {
            axios
                .post("/GetFilterSubmit", {
                    sede: idSede
                })
                .then(response => {
                    this.DataResult = response.data;
                    this.total = response.data.length;
                    if (this.DataResult.length == 0) {
                        this.mensajeData =
                            "No se ingresaron datos para esta sede";
                    }
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
