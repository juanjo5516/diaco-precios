<template>
    <div>
        <el-form
            :inline="false"
            v-model="formInline"
            class="form"
            ref="formInline"
            id="vue-Asignacion"
        >
            <el-card class="box-card">
                <div slot="header" class="clearfix">
                    <span>Vaciado de Información</span>
                    <span class="d"></span>
                </div>
                <div slot="header" class="date">
                    Fecha:
                    <span>{{ fecha }}</span>
                    <input
                        type="hidden"
                        :value="formInline.idplantilla"
                        name="idPlantilla"
                    />
                </div>
                <div>
                    <el-row
                        :gutter="20"
                        v-for="(item, x) in usuario"
                        v-bind:key="x"
                    >
                        <el-col :xs="25" :sm="6" :md="10" :lg="8" :xl="10">
                            <div><b>Sede:</b></div>
                            {{ item.sede }}
                        </el-col>
                        <el-col :xs="25" :sm="6" :md="10" :lg="8" :xl="10">
                            <div><b> Verificador: </b></div>
                            {{ item.nombre }}
                        </el-col>
                        <el-col
                            :xs="25"
                            :sm="6"
                            :md="10"
                            :lg="8"
                            :xl="10"
                            v-if="handle_categories !== true"
                        >
                            <div><b> Lugar Visita: </b></div>
                            <el-select
                                :name="'LugarMercado'"
                                v-model="sedes['mLugar']"
                                filterable
                            >
                                <el-option
                                    v-for="(sede, index) in mercados"
                                    v-bind:key="index"
                                    :label="sede.nombre"
                                    :value="sede.idMercado"
                                >
                                </el-option>
                            </el-select>
                        </el-col>
                    </el-row>
                </div>
            </el-card>

            <el-card class="box-card">
                <div slot="header" class="clearfix">
                    <span>Categorías </span>
                </div>
                <div>
                    <el-table :data="categoria" style="width: 100%" border>
                        <el-table-column
                            label="Id"
                            type="index"
                        >

                        </el-table-column>
                        <el-table-column
                            label="Categoría"
                            prop="categoria"
                        >

                        </el-table-column>
                        <el-table-column label="Operaciones" width="200">
                            <template slot-scope="scope">
                                <el-button-group>
                                    <el-button
                                        size="mini"
                                        @click="
                                            showDialogEdit(
                                                scope.row.categoria,
                                                scope.$index
                                            )
                                        "
                                        :id="scope.$index"
                                        >Llenar</el-button
                                    >
                                    <el-button
                                        type="success"
                                        disabled
                                        round
                                        class="oculto"
                                        :id="'button_' + scope.$index"
                                        >Enviado ...</el-button
                                    >
                                </el-button-group>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
                <!-- Dialogos  -->
                <el-dialog
                    title="Llenado de Información"
                    :visible.sync="dialogGas"
                    width="70%"
                    top="2vh"
                    destroy-on-close
                >
                    <el-form :model="form">
                        <el-table
                            :data="nColumna"
                            border
                            size="small"
                        >
                                <el-table-column
                                    label="No."
                                    type="index"
                                >
                                </el-table-column>
                                <el-table-column label="Nombre" width="350" >
                                    <template slot-scope="scope">
                                        <el-input

                                            :name="'nombre_'+scope.row.index"

                                            v-model="
                                                inputNombre[
                                                    'nombre' + scope.row.index
                                                ]
                                            "
                                            :ref="'nombre_'+scope.row.index"

                                            @blur="handleInputl('nombre_'+scope.row.index, 'principal')"
                                        >

                                        </el-input>

                                    </template>
                                </el-table-column>

                            <el-table-column label="Dirección" >
                                <template slot-scope="scope">
                                    <el-input
                                        :name="'direccion_'+scope.row.index"
                                        v-model="
                                            inputdireccion[
                                                'direccion' + scope.row.index
                                            ]
                                        "
                                        :ref="'direccion_'+scope.row.index"
                                        @blur="handleInputl('direccion_'+scope.row.index ,'principal')"
                                    >

                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column label="Departamento" width="200">
                                <template slot-scope="scope">
                                    <el-select
                                        v-model="
                                            inputDepartamento[
                                                'departamento' + scope.row.index
                                            ]
                                        "
                                        :ref="'departamento_'+scope.row.index"
                                        @blur="handleInputl('departamento_'+scope.row.index,'principal')"
                                        filterable

                                    >
                                        <el-option
                                            v-for="(item,
                                            index) in departamento"
                                            :key="index"
                                            :label="item.nombre_departamento"
                                            :value="item.codigo_departamento"
                                        >
                                        </el-option>
                                    </el-select>
                                </template>
                            </el-table-column>
                        </el-table>
                        <el-table border :data="Productos" class="table_header" max-height="350">
                            <el-table-column label="Producto" prop="produto">
                            </el-table-column>
                            <el-table-column label="Medida" prop="medida">
                            </el-table-column>
                            <el-table-column label="Ref." prop="precio">
                            </el-table-column>
                            <el-table-column v-for="(index, x) in nColumna" :key="x" :label="'Precio '+index.index">
                                <template slot-scope="scope">
<!--                                    {{ index.index }}-->
                                    <el-input
                                        :name="'data_'+ scope.$index+ '_' + index.index"
                                        class="input_precios"
                                        v-model="inputprecios['data_'+ scope.$index+ '_' + index.index]"
                                        size="mini"
                                        :ref="'data_'+ scope.$index+ '_' + index.index"
                                        @blur="handleInputl('data_'+ scope.$index+ '_' + index.index,'precio')"
                                        @keyup.enter.native="enter('data_',scope.$index,'_',index.index)"
                                        type="text"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-form>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="dialogGas = false"
                            >Cancelar</el-button
                        >
                        <el-button type="primary" @click="ver()"
                            >Guardar</el-button
                        >
                    </span>
                </el-dialog>
                <!-- fin -->
                <el-dialog
                    title="Vaciado de Información"
                    :visible.sync="dialogFormVisible"
                    width="70%"
                    top="2vh"
                    destroy-on-close
                >
                    <el-form :model="form">
                        <el-table
                            :data="nColumna"
                            style="width: 100%"
                            border
                            size="small"
                        >
                            <el-table-column
                                label="No."
                                type="index"
                            >

                            </el-table-column>
                            <el-table-column label="No. Local" width="170">
                                <template slot-scope="scope">
                                    <el-input-number
                                        size="small"
                                        v-model="
                                            inputMercados[
                                                'mercado' + scope.row.index
                                            ]
                                        "
                                        :min="0"
                                        :max="1000"
                                    >

                                    </el-input-number>
                                </template>
                            </el-table-column>
                            <el-table-column
                                label="Establecimiento (campo obligatorio)"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        v-model="
                                            sedes['select' + scope.row.index]
                                        "
                                        placeholder="Ingrese Establecimiento"
                                    >

                                    </el-input>
                                    <!-- <el-select   v-model="sedes['select' + scope.row.index ]" filterable >
                                                <el-option
                                                v-for="(sede,index) in establecimientos"
                                                v-bind:key=" index "
                                                :label=" sede.nombre  "
                                                :value=" sede.idEstablecimiento "
                                                ></el-option>
                                          </el-select> -->
                                </template>
                            </el-table-column>
                        </el-table>
                        <el-table border :data="Productos" class="table_header" max-height="350">
                            <el-table-column label="Producto" prop="produto">
                            </el-table-column>
                            <el-table-column label="Medida" prop="medida">
                            </el-table-column>
                            <el-table-column label="Ref." prop="precio" v-if="(precio === undefined)">
                                    sin Referencia
                            </el-table-column>
                            <el-table-column label="Ref." prop="precio" v-else>
                            </el-table-column>
                            <el-table-column v-for="(index, x) in nColumna" :key="x" :label="'Precio '+index.index">
                                <template slot-scope="scope">
                                    <!--                                    {{ index.index }}-->
                                    <el-input
                                        :name="'data_'+ scope.$index+ '_' + index.index"
                                        class="input_precios"
                                        v-model="inputprecios['data_'+ scope.$index+ '_' + index.index]"
                                        size="mini"
                                        :ref="'data_'+ scope.$index+ '_' + index.index"
                                        @blur="handleInputl('data_'+ scope.$index+ '_' + index.index,'precio')"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                        </el-table>
<!--                        <table class="table table-bordered head" width="100%">-->
<!--                            <thead>-->
<!--                                <tr>-->
<!--                                    <th style="width:40%">Producto</th>-->
<!--                                    <th style="width:40%">Medida</th>-->
<!--                                    <th-->
<!--                                        style="width:10%"-->
<!--                                        v-for="(index, x) in nColumna"-->
<!--                                        v-bind:key="x"-->
<!--                                    >-->
<!--                                        {{ index.index }}-->
<!--                                    </th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody>-->
<!--                                <tr-->
<!--                                    v-for="(index, ix) of Productos"-->
<!--                                    v-bind:key="ix"-->
<!--                                >-->
<!--                                    <td>{{ index.produto }}</td>-->
<!--                                    <td class="ReferencesName">-->
<!--                                        {{ index.medida }}-->
<!--                                    </td>-->
<!--                                    <td-->
<!--                                        v-for="(n, x) in nColumna"-->
<!--                                        v-bind:key="x"-->
<!--                                    >-->
<!--                                        <el-input-number-->
<!--                                            v-model="index['valor' + n.index]"-->
<!--                                            size="mini"-->
<!--                                            :precision="2"-->
<!--                                            :min="0"-->
<!--                                            :max="1000000000"-->
<!--                                        >-->

<!--                                        </el-input-number>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
                    </el-form>
                    <span slot="footer" class="dialog-footer">
                        <el-button @click="dialogFormVisible = false"
                            >Cancelar</el-button
                        >
                        <el-button type="primary" @click="onSubmit()"
                            >Guardar</el-button
                        >
                    </span>
                </el-dialog>
            </el-card>
            <el-progress
                :text-inside="true"
                :stroke-width="24"
                :percentage="porcentaje"
                status="success"
            >

            </el-progress>
            <el-button
                class="my-5"
                type="success"
                id="enviar"
                round
                @click="terminar"
                v-loading.fullscreen.lock="fullscreenTerminar"
                >Guardar</el-button
            >
        </el-form>
    </div>
</template>

<style >
    .table{
        padding-top:1em !important;
    }
    .table_header th {

        background-color: #000 !important;
        color: #fff;
        text-align: center !important;
    }
    .validate_input input{
        border:2px solid red;
        background-color: #ffffcc

    }

    .input_precios{
        font-size: medium;
        text-align: center;

    }


    /*.el-table--enable-row-hover .el-table__body tr:hover>td{*/
    /*    background: none !important;*/
    /*    color: inherit;*/
    /*    !* transition: all 400ms ease-out; *!*/
    /*}*/

.oculto {
    display: none;
}

strong {
    color: red;
}

.titulo {
    width: 300px;
}

.selectMercado {
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

.paso {
    background-color: green;
    width: 23px;
    height: 22px;
    border-radius: 10px;
    margin-top: 10px;
}

.aumento {
    background-color: red;
    width: 23px;
    height: 22px;
    border-radius: 10px;
    margin-top: 10px;
}

.inputAumento {
    background-color: red !important;
}

.inputPaso {
    background-color: green !important;
}
.el-select {
    width: 100%;
}
</style>

<script>
export default {
    name: "vaciado",
    props: [
        "fecha",
        "usuario",
        "coleccion",
        "categoria",
        "establecimientos",
        "idplantilla",
        "mercados",
        "correlativo"
    ],

    data() {
        return {
            Fecha: "fecha",
            sedes: {
                select1: "",
                select2: "",
                select3: "",
                select4: "",
                select5: "",
                mLugar: ""
            },
            // sedes:[],
            input1: "",
            input2: "",
            input3: "",
            input4: "",
            input5: "",
            linea: 1,
            n: "",
            tipo: "",
            IdTipo: {},

            formInline: {
                idplantilla: "",
                id_usuario: "",
                sede1: "",
                sede2: "",
                sede3: "",
                categoria: {},

                Productos: {},
                coleccion: {}
            },
            Productos: [],
            dataProductos: [],
            formData: "asdf",
            idVerificador: "",
            Data1: {},
            valor1: "",
            inputs1: {},
            sede: {},
            inputDepartamento: [],
            inputMunicipio: [],
            inputNombre: [],
            inputdireccion: [],
            inputprecios:[],
            inputMercados: {
                mercado1: "",
                mercado2: "",
                mercado3: "",
                mercado4: "",
                mercado5: ""
            },
            // DataAdd:[],
            Data: [],
            idP: "",
            Mercados: [],
            Propano: [],
            idTt: "",
            SMercado: [],
            fullscreenLoading: false,
            fullscreenTerminar: false,
            nColumna: [],
            plantillasall: [],
            dialogFormVisible: false,
            dialogGas: false,
            form: {
                name: "",
                producto: "",
                medida: "",
                seleccionMercado: [],


            },
            rules: {
                inputNombre: [
                {
                    required: true,
                    message: "Ingrese un Nombre de Categoria",
                    trigger: "blur"
                }
                ]
            },
            formLabelWidth: "120px",
            ListadoProducto: [],
            ListadoMedidas: [],
            filas: 0,
            categoriaFiltro: "",
            porcentaje: 0,
            cantitdadPorcentaje: 0,
            precios: [],
            button: "",
            type_error: "",
            result_error: "",
            cantidadColumna: 0,
            departamento: [],
            municipio: [],
            dataNames:[],
            handle_error_name:[],
            handle_categories: false
        };
    },
    mounted() {

        this.getTipo();
        this.getPropano();
        this.getSMercado();
        this.getColumnas();

        this.cantitdadPorcentaje = parseInt(100 / this.categoria.length, 10);
        for (let x = 0; x < this.categoria.length; x++){
            if(this.categoria[x].code === '16'){
                this.handle_categories= true
            }
        }
        if (this.categoria.length > 10) {
            this.cantitdadPorcentaje += 1;
        }
    },
    methods: {
        dataDepartamento() {
            var url = "/getDepartamento";
            axios.get(url).then(response => {
                this.departamento = response.data;
            });
        },
        dataMunicipio(dato) {
            this.municipio = dato;
        },
        getVisitas: function() {
            var url = "/findAllVisita";
            axios.get(url).then(response => {
                this.plantillasall = response.data;
                //   this.total = response.data.length;
            });
        },
        showDialogEdit(producto, button) {

            this.inputNombre = [];
            this.inputdireccion = [];
            this.inputDepartamento = []
            if (producto == "Gas propano") {
            // if (producto == "Gas Propano") {
                this.dataDepartamento();
                this.dialogGas = true;
            } else {
                this.dialogFormVisible = true;
            }
            this.categoriaFiltro = producto;
            this.DataProductos();
            this.button = button;
            // this.form.producto = producto;
            // this.form.medida = medida;
        },

        DataProductos: function() {
            console.log(this.coleccion[0].precio);
            this.Productos = [];
            for (let i = 0; i <= this.coleccion.length - 1; i++) {
                if (this.categoriaFiltro === this.coleccion[i].categoria) {
                    this.Productos.push({
                        categoria: this.coleccion[i].categoria,
                        created_at: this.coleccion[i].created_at,
                        medida: this.coleccion[i].medida,
                        producto: this.coleccion[i].producto,
                        produto: this.coleccion[i].produto,
                        medidaId: this.coleccion[i].idmedida,
                        precio: this.coleccion[i].precio
                    });
                }
            }
        },
        getTipo: function() {
            const tipos = this.idplantilla;
            axios.get("/visitas/" + tipos).then(response => {
                this.IdTipo = response.data;

            });
        },
        getSMercado: function() {
            axios
                .get("/findAllSmarket")
                .then(response => {
                    this.SMercado = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                })
                .finally(function() {});
        },
        getColumnas: function() {
            axios
                .post("/getCountColumn", { id: this.idplantilla })
                .then(response => {
                    for (let i = 1; i <= response.data[0].Columna; i++) {
                        this.nColumna.push({
                            index: i
                        });
                    }
                    this.cantidadColumna = response.data[0].Columna;
                })
                .catch(function(error) {
                    console.log(error);
                })
                .finally(function() {});
        },
        getPropano: function() {
            axios
                .get("/getPropano")
                .then(response => {
                    this.Propano = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        onSubmit() {
            for (let i = 1; i <= this.cantidadColumna ; i++) {
                this.dataNames.push({
                    'dataName': this.inputNombre['nombre'+i],
                    'dataAddress': this.inputdireccion['direccion'+i],
                    'dataDepartment': this.inputDepartamento['departamento'+i]
                });

            }
            let option = [];
            // axios.post(url, {
            //             idP: this.idplantilla,
            //             Mercados: this.inputMercados,
            //             Sedes: this.sedes,
            //             Usuarios: this.usuario[0].id_usuario,
            //             Data: this.Productos,
            //             idSede: this.usuario[0].id,
            //             idTipo: this.IdTipo,
            //             columnas: this.cantidadColumna,
            //             Ncorrelativo: this.correlativo
            //         })
            // if(this.categoria[0].code === '16'){
            if(this.categoria[0].code === '6'){
                option.push({
                    idP: this.idplantilla,
                    user: this.usuario[0].id_usuario,
                    dataProduct: this.Productos,
                    idOffice: this.usuario[0].id,
                    idType: this.IdTipo,
                    column: this.cantidadColumna,
                    nCorrelative: this.correlativo,
                    dataNames: this.dataNames,
                })
            }
            const h = this.$createElement;
            // if (this.checkValidation(this.sedes) == true) {
            //     this.fullscreenLoading = true;
                this.dataProductos = [];
                // for (let a = 0; a <= this.coleccion.length - 1; a++) {
                //     if (this.categoriaFiltro === this.coleccion[a].categoria) {
                //         this.dataProductos.push({
                //             idDataProducto: this.coleccion[a].producto,
                //             idDataMedida: this.coleccion[a].idmedida
                //         });
                //     }
                // }
                // var url = "/mercadoCBA";
                var url = "/setDataSubmit";
                // const bandeja = "/Bandeja";

                axios.post(url, {
                        option
                    })
                    .then(response => {
                        const status = JSON.parse(response.status);
                        if (status == "200") {
                            // window.location = bandeja;
                            // this.dialogFormVisible = false;
                            // document.getElementById(
                            //     this.button
                            // ).disabled = true;
                            // this.porcentaje =
                            //     this.porcentaje + this.cantitdadPorcentaje;
                            // this.fullscreenLoading = false;
                            // this.checkPorcentaje(this.porcentaje, this.button);
                        }
                    })
                    .catch(error => {
                        this.fullscreenLoading = false;
                        console.log(error.message);
                    });
            // } else {
            //     this.result_error = this.checkValidation(this.sedes);
            //     this.$message.error({
            //         message: h("p", null, [
            //             h("i", { style: "color: red" }, this.result_error)
            //         ])
            //     });
            // }
        },
        checkPorcentaje(porcentaje, idBotton) {
            document.getElementById(idBotton).style.display = "none";
            const el = document.querySelector("#button_" + idBotton);
            el.classList.remove("oculto");

            const env = document.querySelector("#enviar");
            if (porcentaje === 100) {
                env.classList.remove("oculto");
            }
        },
        terminar() {
            // console.log(this.nColumna);
            this.fullscreenTerminar = true;
            var url = "/updateStatusVaciado";
            const bandeja = "/Bandeja";
            axios
                .post(url, {
                    idP: this.idplantilla,
                    idSede: this.usuario[0].id,
                    Usuarios: this.usuario[0].id_usuario,
                    correlativo: this.correlativo
                })
                .then(response => {
                    const status = JSON.parse(response.status);
                    if (status == "200") {
                        this.fullscreenTerminar = false;
                        window.location = bandeja;
                    }
                })
                .catch(error => {});

        },
        handleInputl(val,nivel){
            if(nivel === 'principal'){
                const ctx = this.$refs[val];

                if(ctx.value === undefined){
                    ctx.$el.classList.add('validate_input');
                    this.handle_error_name.push(
                        val
                    )

                }else{
                    this.handle_error_name = this.handle_error_name.filter((i) => i !== val);
                    ctx.$el.classList.remove('validate_input');
                }
            }else if(nivel === 'precio'){
                const ctx = this.$refs[val][0];

                if(ctx._props.value === undefined || ctx._props.value === '' ){
                    ctx.$el.classList.add('validate_input');
                    this.handle_error_name.push(
                        val
                    )
                }else{
                    this.handle_error_name = this.handle_error_name.filter((i) => i !== val);
                    ctx.$el.classList.remove('validate_input');
                }
            }


        },
        ver (){
            console.log(this.precios)
        },
        enter(data,index,guion,indexrow){

            try {
                if(indexrow < 5){
                    let input_data = (data+index+guion+(indexrow+1));
                    const ref = this.$refs[input_data][0].focus();
                }else{
                    indexrow = 1
                    let input_data = (data+(index+1)+guion+(indexrow));
                    const ref = this.$refs[input_data][0].focus();
                }
            }catch(err){

            }


        },
        checkValidation(selecciones) {
            if (selecciones.mLugar === "Seleccione una Opción") {
                this.type_error = "El lugar de visita no puede ir vacio";
                return this.type_error;
            } else if (selecciones.select1 === "Seleccione una Opción") {
                this.type_error = "Por favor selecione un establecimiento";
                return this.type_error;
            } else if (selecciones.select2 === "Seleccione una Opción") {
                this.type_error = "Por favor selecione un establecimiento";
                return this.type_error;
            } else if (selecciones.select3 === "Seleccione una Opción") {
                this.type_error = "Por favor selecione un establecimiento";
                return this.type_error;
            } else if (selecciones.select4 === "Seleccione una Opción") {
                this.type_error = "Por favor selecione un establecimiento";
                return this.type_error;
            } else if (selecciones.select5 === "Seleccione una Opción") {
                this.type_error = "Por favor selecione un establecimiento";
                return this.type_error;
            } else {
                return true;
            }
        }
    }
};
</script>
