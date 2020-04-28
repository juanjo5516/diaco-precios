<template>
    <div class="">
        <el-form
            :inline="false"
            :model="formInline"
            class="form"
            id="vue-Asignacion"
        >
            <el-form-item label="Usuario: ">
                <el-select
                    name="idSede"
                    class="vue-select"
                    v-model="select1"
                    placeholder="Usuarios"
                >
                    <el-option
                        v-for="(item, idx) in coleccion"
                        :key="idx"
                        :label="item.name"
                        :value="item.code"
                    ></el-option>
                </el-select>
            </el-form-item>

            <el-form-item label="Plantilla: ">
                <el-select
                    name="idSede"
                    class="vue-select"
                    v-model="select2"
                    placeholder="Sedes"
                >
                    <el-option
                        v-for="(item, idx) in Plantillas"
                        :key="idx"
                        :label="item.name"
                        :value="item.code"
                    ></el-option>
                </el-select>
            </el-form-item>

            <el-form-item>
                <!-- <button @click="onSubmit" type="submit" class="btn btn-success" id="btnAsignar">Asignar</button> -->
                <el-button
                    @click="onSubmit"
                    type="success"
                    size="medium"
                    :loading="load"
                    >Asignar</el-button
                >
            </el-form-item>
        </el-form>
        <!-- <div id="snoAlertBox" class="alert alert-warning" data-alert="alert">Asignación Exitosa.</div>
    <div id="snoAlertBoxE" class="alert alert-danger" data-alert="alert">Error al asignar.</div> -->
        <div class="container-fluid">
            <el-table
                :data="
                    plantillasall
                        .slice(
                            (currentPage - 1) * pagesize,
                            currentPage * pagesize
                        )
                        .filter(
                            data =>
                                !search ||
                                data.correlativo
                                    .toLowerCase()
                                    .includes(search.toLowerCase())
                        )
                "
                style="width: 100%"
                border
            >
                <el-table-column type="index"  label="#" width="50"></el-table-column>
                <el-table-column prop="correlativo" label="Correlativo"></el-table-column>
                <el-table-column prop="estatus" label="Estado"></el-table-column>
                <el-table-column label="Fecha Asignación">
                       <template slot-scope="scope">
                              <i class="el-icon-time"></i>
                              <span style="margin-left: 10px">{{ scope.row.fecha }}</span>
                        </template>
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>

<style>
.vue-select {
    width: 100%;
    font-weight: bold;
}
.el-form-item__label {
    font-weight: bold;
    font-size: 1em;
}
</style>

<script>
export default {
    props: ["coleccion", "Plantillas"],
    data() {
        return {
            plantillasall: [],
            select1: "Seleccione una Opción",
            select2: "Seleccione una Opción",
            pagesize: 10,
            total: 0,
            currentPage: 1,
            formInline: {},
            Data: [],
            search: "",
            SPlantilla: "",
            SSede: "",
            created_at_new: "",
            fullscreenLoading: false,
            load: false
        };
    },
    mounted() {
      //   this.getAsignaciones();
        this.getDataAsignacion();
        // console.log(this.coleccion[0].sede);
    },
    methods: {
        onSubmit: function() {
            // console.log(this.select1);
            this.load = true;
            const h = this.$createElement;
            var url = "/AUsuario";
            axios
                .post(url, {
                    SPlantilla: this.select2,
                    SSede: this.coleccion[0].sede,
                    created_at_new: new Date(),
                    Usuario: this.select1
                })
                .then(response => {
                    const status = JSON.parse(response.status);
                    if (status == "200") {
                        this.$notify({
                            title: "Exitoso",
                            message: "Asignacion Completa",
                            type: "success",
                            duration: 2000
                        });
                        this.load = false;
                        this.select2 = "";
                        this.select1 = "";
                        // this.NewProducto = "";
                        // this.NewMeasure = "";
                        // console.log(this.respuestaMedida);
                        this.getDataAsignacion();
                    }
                })
                .catch(error => {
                    console.log(error.message);
                });
        },

        getAsignaciones: function() {
            var url = "/findAllUserSystem";
            axios.get(url).then(response => {
                this.plantillasall = response.data;
                // console.log(response);
                this.total = response.data.length;
            });
        },
        handleEdit(row) {
            this.$prompt("Nombre Producto", "Edición de Productos", {
                confirmButtonText: "Actualizar",
                cancelButtonText: "Cancel"
            })
                .then(({ value }) => {
                    const config = {
                        headers: { "Content-Type": "application/json" }
                    };
                    const h = this.$createElement;
                    var url = "/UpdateProduct";
                    axios
                        .put(
                            url,
                            {
                                id: row,
                                name: value
                            },
                            config
                        )
                        .then(response => {
                            const status = JSON.parse(response.status);
                            if (status == "200") {
                                this.$message({
                                    message: h("p", null, [
                                        h(
                                            "i",
                                            { style: "color: teal" },
                                            "Datos Actualizados!"
                                        )
                                    ]),
                                    type: "success"
                                });
                                this.getAsignaciones();
                            }
                        })
                        .catch(error => {
                            this.$message.error({
                                message: h("p", null, [
                                    h(
                                        "i",
                                        { style: "color: red" },
                                        "Error, servidor no encontrado"
                                    )
                                ])
                            });
                        });
                })
                .catch(() => {
                    this.$message({
                        type: "info",
                        message: "Proceso Cancelado"
                    });
                });
        },
        handleDelete(row) {
            const config = { headers: { "Content-Type": "application/json" } };
            const h = this.$createElement;
            this.fullscreenLoading = true;
            var url = "/deleteByIdUserSystem";
            axios
                .put(
                    url,
                    {
                        id: row
                    },
                    config
                )
                .then(response => {
                    const status = JSON.parse(response.status);
                    if (status == "200") {
                        this.$message({
                            message: h("p", null, [
                                h(
                                    "i",
                                    { style: "color: teal" },
                                    "Asignación inactivada!"
                                )
                            ]),
                            type: "success"
                        });
                        // this.formInline.name = "";
                        this.fullscreenLoading = false;
                        this.getAsignaciones();
                    }
                })
                .catch(error => {
                    this.$message.error({
                        message: h("p", null, [
                            h(
                                "i",
                                { style: "color: red" },
                                "Error, servidor no encontrado"
                            )
                        ])
                    });
                    this.fullscreenLoading = false;
                });
        },
        current_change: function(currentPage) {
            console.log(currentPage);
            this.currentPage = currentPage;
        },
        handleSizeChange(val) {
            console.log(`${val} items per page`);
        },
        getDataAsignacion (){
              axios.get('getinbox')
                        .then(response => {
                              // console.log(response.data)
                              this.plantillasall = response.data;
                        })
        }
    }
};
</script>
