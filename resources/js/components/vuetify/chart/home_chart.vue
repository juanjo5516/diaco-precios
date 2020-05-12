<template >
    <div>
        
        <el-row :gutter="25">
            <el-col :span="6" v-for="(item, index) in response_list.response_template" :key="index">
                
                <div class="card text-white  bg-danger mb-3" style="max-width: 25rem;" v-if="item.retrazo > 10">
                    <div class="card-header">{{ item.NombreTemplate }}</div>
                    <div class="card-body">
                        <h5 class="card-title">Correlativo: {{ item.correlativo }}</h5> 
                        <h5 class="card-title">Fecha: {{ item.fecha }}</h5> 
                        <h5 class="card-title">Estatus: {{ item.estatus }}</h5> 
                        <p class="card-text">Este documento tiene {{ item.retrazo }} días de retrazo</p>
                    </div>
                </div>
                
                <div class="card text-white  bg-success mb-3" style="max-width: 25rem;" v-else>
                    <div class="card-header">{{ item.NombreTemplate }}</div>
                    <div class="card-body">
                        <h5 class="card-title">Correlativo: {{ item.correlativo }}</h5> 
                        <h5 class="card-title">Fecha: {{ item.fecha }}</h5> 
                        <h5 class="card-title">Estatus: {{ item.estatus }}</h5> 
                        <p class="card-text">Este documento tiene {{ item.retrazo }} días de retrazo</p>
                    </div>
                </div>
                <el-divider></el-divider>
            </el-col>
            
        </el-row>
        
    </div>
</template>

<script>
export default {
    data () {
        return {
            url_request: {
                request_template: 'getinbox' 
            },
            response_list: {
                response_template: []
            }
        }
    },
    mounted() {
        this.get_template();
    },
    methods: {
        get_template() {
            axios.get(this.url_request.request_template).then(response => {
                this.response_list.response_template = response.data;
                console.log(this.response_list.response_template)
            });
        }
    },
}
</script>