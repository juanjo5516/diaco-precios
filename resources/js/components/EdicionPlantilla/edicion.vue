<template>
<div class="container">
    <el-transfer
        v-model="value"
        :data="data"
        :titles="titulo"
        :render-content="renderFunc"
        :button-texts="
        [
        'A la izquierda', 
        'A la derecha']
        ">
    </el-transfer>
</div>
</template>

<style>
.el-transfer-panel, .el-checkbox-group{
    height: 500px;
}
.el-icon-arrow-right, .el-icon-arrow-left{
    display:none;
}
</style>

<script>
  export default {
    data() {
      const generateData = _ => {
        const data = [];
        for (let i = 1; i <= 15; i++) {
          data.push({
            key: i,
            label: `Option ${ i }`
          });
        }
        return data;
      };
      return {
        data: generateData(),
        value: [1, 4],
        titulo:['Lista 1','Lista 2']
      };
      
    }
    
  };
</script>

