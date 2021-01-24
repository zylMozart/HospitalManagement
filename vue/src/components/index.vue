<template>
  <div
    style="
      background: url(https://three-principles.com/wp-content/uploads/2019/02/For-Finding-Ease.png)
        no-repeat center 0px;
      background-position: center 0;
      background-size: 100%;
      height: 28rem;
      padding: 100px;
    "
  >
    <transition name="el-fade-in-linear">
      <div v-show="show">
        <el-row style="height: 5rem;"></el-row>
        <el-row
          style="
            font-size: 4rem;
            padding-bottom: 2rem;
            color: white;
            font-family: Microsoft YaHei;
          "
          >接化发医院监护系统
        </el-row>
        <el-row
          style="font-size: 1.8rem; color: silver; font-family: Microsoft YaHei"
          >智慧医疗解决方案</el-row
        >
      </div>
    </transition>
  </div>
</template>
<script>
/* eslint-disable */
export default {
  data() {
    return {
      aboutMsg: "智慧医疗解决方案",
      show: false,
    };
  },
  mounted: function () {
    this.show = true;
  },
};
</script>

<style>
.transition-box {
  margin-bottom: 10px;
  width: 200px;
  height: 100px;
  border-radius: 4px;
  background-color: #409eff;
  text-align: center;
  color: #fff;
  padding: 40px 20px;
  box-sizing: border-box;
  margin-right: 20px;
}
</style>