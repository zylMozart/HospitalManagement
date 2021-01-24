<template>
  <el-main
    style="
      width: 30rem;
      display: inline-block;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
      margin-top: 1rem;
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
      <el-form-item label="性别">
        <el-select v-model="user.sex" placeholder="请选择" style="width: 90%">
          <el-option
            v-for="item in sexoptions"
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
      <el-form-item label="用户名">
        <el-input v-model="user.name" style="width: 90%"></el-input>
      </el-form-item>
      <el-form-item label="年龄">
        <el-input v-model="user.age" style="width: 90%"></el-input>
      </el-form-item>
      <el-form-item label="密码">
        <el-input
          type="password"
          v-model="user.password"
          style="width: 90%"
        ></el-input>
      </el-form-item>
      <el-form-item label="确认密码">
        <el-input
          type="password"
          v-model="user.password2"
          style="width: 90%"
        ></el-input>
      </el-form-item>
      <el-form-item label="激活码">
        <el-input
          type="password"
          v-model="user.activate"
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
  name: "Rigister",
  data() {
    return {
      user: {
        type: "",
        name: "",
        password: "",
        password2: "",
        activate: "",
        sex: "",
        age: null,
        id: "",
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
      sexoptions: [
        {
          value: "男",
          label: "男",
        },
        {
          value: "女",
          label: "女",
        },
      ],
      usertype: "",
    };
  },
  methods: {
    submitForm(formName) {
      console.log(formName);
      var that = this;
      this.$axios
        .post("/api/user/register", {
          type: formName.type,
          name: formName.name,
          password: formName.password,
          password2: formName.password2,
          activate: formName.activate,
          age: formName.age,
          sex: formName.sex,
          id: formName.id,
        })
        .then(function (response) {
          console.log(response);
          var res = response.data;
          if (res.status == 1) {
            console.log("You have been registered successfully.");
            that.$message({
              message: "注册成功",
              type: "success",
            });
          } else {
            that.$message({
              message: "注册失败",
              type: "error",
            });
          }
        })
        .catch(function (error) {
          console.log(error);
          that.$message({
            message: "注册失败",
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

