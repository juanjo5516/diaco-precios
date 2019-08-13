<template>
<div>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
        <span>Gas Propano</span>
        <!-- <el-button style="float: right; padding: 3px 0" type="text">Operation button</el-button> -->
        </div>
        <el-form ref="form" :model="form" label-width="120px">
            <el-form-item label="Nombre:">
                <el-input v-model="name"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">Guardar</el-button>
            </el-form-item>
            </el-form>
    </el-card>

    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <span></span>
        </div>
        <el-table
        :data="DataResult.slice((currentPage-1)*pagesize,currentPage*pagesize)"
        style="width: 100%">
        <el-table-column
            prop="id"
            label="Id"
            >
        </el-table-column>
        <el-table-column
            prop="name"
            label="Nombre"
            >
        </el-table-column>
        
        </el-table>
        <div style="text-align: left;margin-top: 30px;">
        <el-pagination
            background
            layout="total,prev, pager, next"
            :total="total"
            @current-change="current_change">
        </el-pagination>
        </div>
    </el-card>
</div>
</template>

<style>
</style>

<script>
export default {
    data() {
      return {
        name: '',
        form: {
          region: '',
          date1: '',
          date2: '',
          delivery: false,
          type: [],
          resource: '',
          desc: ''
        },
        DataResult:[],
        names:'',
        total: 0,
        pagesize:10,
        currentPage:1
      }
    },
    mounted(){
            this.getData();
          },
    methods: {
        getData: function(){
            axios.get('/getPropano')
            .then(response => {
                // handle success
                this.DataResult = response.data;
                this.total= response.data.length;
                console.log(this.DataResult);
            })
            .catch(function (error) {
                console.log(error);
            })
            .finally(function () {
            });
        },
        current_change:function(currentPage){
        console.log(currentPage);
        this.currentPage = currentPage;
      },
      handleSizeChange(val) {
        console.log(`${val} items per page`);
      },
        onSubmit() {
            var url = '/AddPropano';
            console.log(this.name)
            axios.post(url, {
                names: this.name,
            }).then(response =>{
                const status = 
                        JSON.parse(response.status);
            this.$message.success(`Dato Cargado`);
            this.name = "";
          //redirect logic
          if (status == '200') {
              this.getData();
        //     window.location = bandeja;
        //     //this.$router.push('/Bandeja');
          }
            }).catch(error => {
                    console.log(error.message)
            });
      }
    }
    
};
</script>
