<template>
  <el-main
    style="
      width: 30rem;
      display: inline-block;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
      margin-top: 5rem;
    "
  >
    <el-form
      status-icon
      ref="ruleForm"
      label-width="100px"
      class="demo-ruleForm"
    >
      <el-form-item label="用户类型">
        <el-select v-model="user.type" placeholder="请选择" style="width: 90%">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          >
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="用户ID">
        <el-input v-model="user.id" style="width: 90%"></el-input>
      </el-form-item>
      <el-form-item label="密码">
        <el-input
          type="password"
          v-model="user.password"
          style="width: 90%"
        ></el-input>
      </el-form-item>
      <el-form-item style="margin-left: -4rem">
        <el-button type="primary" @click="submitForm(user)">提交</el-button>
        <el-button @click="resetForm('ruleForm')">重置</el-button>
      </el-form-item>
    </el-form>
  </el-main>
</template>
<script>
/* eslint-disable */
// import axios from "axios";

export default {
  data() {

    return {
      user: {
        type: "",
        id: "",
        password: "",
      },

      options: [
        {
          value: "patient",
          label: "患者",
        },
        {
          value: "nurse",
          label: "护士",
        },
        {
          value: "doctor",
          label: "医生",
        },
        {
          value: "admin",
          label: "管理员",
        },
      ],
      usertype: "",
    };
  },
  methods: {
    submitForm(formName) {
      var that = this;
      this.$axios
        .post("/api/user/login", {
          id: formName.id,
          password: formName.password,
        })
        .then(function (response) {
          var res = response.data;
          if (res.status == 1) {
            console.log("You have been login successfully.");
            that.$message({
              message: "登陆成功",
              type: "success",
            });
            that.$store.state.username=res.username;
            that.$store.state.login=1;
            that.$store.state.type=res.type;
            that.$store.state.id=res.id;
            that.$router.push('/index');
          }
          else{
            that.$message({
            message: "登陆失败",
            type: "error",
          });
          }
        })
        .catch(function (error) {
          console.log(error);
          that.$message({
            message: "登陆失败",
            type: "error",
          });
        });
      // this.$message({
      //   message: "恭喜你，这是一条成功消息",
      //   type: "success",
      // });
      // this.$refs[formName].validate((valid) => {
      //   if (valid) {
      //     alert("submit!");
      //   } else {
      //     console.log("error submit!!");
      //     return false;
      //   }
      // });
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    },
  },
};
</script>

