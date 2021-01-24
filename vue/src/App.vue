<template>
  <div id="app">
    <el-menu
      :default-active="activeIndex2"
      class="el-menu-demo"
      mode="horizontal"
      @select="handleSelect"
      background-color="rgb(64 150 236)"
      text-color="#fff"
      active-text-color="#ffd04b"
    >
      <el-menu-item
        v-show="
          this.$store.state.type == 'doctor' ||
          this.$store.state.type == 'nurse' ||
          this.$store.state.type == 'admin'
        "
        @click="$router.push('/admin/sign')"
        index="1"
      >
        <template slot="title">患者指标</template>
      </el-menu-item>
      <el-menu-item
        v-show="this.$store.state.type == 'doctor'||this.$store.state.type == 'admin'"
        index="2"
        @click="$router.push('/alarm')"
        >报警标准</el-menu-item
      >
      <el-menu-item
        v-show="this.$store.state.type == 'admin'"
        index="3"
        @click="$router.push('/admin/user')"
        >用户管理</el-menu-item
      >
      <el-menu-item v-show="this.$store.state.type=='doctor'||this.$store.state.type=='admin'" index="19" @click="$router.push('/diagnosis')"
        >病情诊断</el-menu-item
      >
      <el-menu-item v-show="this.$store.state.login" index="4" @click="$router.push('/admin/log')"
        >病情日志</el-menu-item
      >
      <el-menu-item v-show="this.$store.state.login" index="5" @click="$router.push('/admin/report')"
        >病情报告</el-menu-item
      >
      <el-menu-item v-show="!this.$store.state.login" index="6" @click="$router.push('/index')"
        >首页</el-menu-item
      >
      <!-- <el-menu-item index="3" v-show="this.$route.name=='login'">消息中心</el-menu-item>
      <el-menu-item index="4"
        ><a href="https://www.ele.me" target="_blank">订单管理</a></el-menu-item
      > -->
      <el-submenu index="9" style="float: right">
        <template slot="title">
          <el-avatar
            src="https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=2515559649,76637542&fm=26&gp=0.jpg"
          ></el-avatar>
        </template>
        <el-menu-item
          v-show="!this.$store.state.login"
          index="6-1"
          @click="$router.push('/login')"
          >登录</el-menu-item
        >
        <el-menu-item
          v-show="!this.$store.state.login"
          index="6-2"
          @click="$router.push('/register')"
          >注册</el-menu-item
        >
        <el-menu-item
          v-show="this.$store.state.login"
          index="6-3"
          @click="logout"
          >注销</el-menu-item
        >
        <el-menu-item
          v-show="this.$store.state.login"
          index="6-4"
          @click="$router.push('/profile')"
          >个人中心</el-menu-item
        >
      </el-submenu>
      <el-menu-item
        v-if="this.$store.state.login"
        index="6"
        style="float: right"
        >欢迎您，{{ this.$store.state.username }}</el-menu-item
      >
      <el-menu-item v-else index="8" style="float: right" @click="$router.push('/login')"
        >请登录</el-menu-item
      >
    </el-menu>
    <!-- <header>
      <router-link to="/home">Home</router-link>
      <router-link to="/about">About</router-link>
      <router-link to="/login">login</router-link>
    </header> -->
    <router-view />
  </div>
</template>
<script>
/* eslint-disable */
import Sign from "./components/Sign.vue";
export default {
  name: "App",
  data() {
    return {
      activeIndex: "1",
      activeIndex2: "1",
    };
  },
  methods: {
    logout() {
      this.$store.state.login = null;
      this.$store.state.type = null;
      this.$router.push("/index");
    },
  },
};
</script>
<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  /* margin-top: 60px; */
}
body {
  width: 100%;
  height: 100%;
  position: relative;
  /* background-color: rgb(101, 101, 101); */
}
</style>
