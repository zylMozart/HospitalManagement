<template>
  <el-main
    style="
      width: 50rem;
      display: inline-block;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
      margin-top: 3rem;
    "
  >
    <el-form
      status-icon
      ref="ruleForm"
      label-width="100px"
      class="demo-ruleForm"
    >
      <h1>接化发医院诊断表</h1>
      <el-form-item label="用户ID">
        <el-input v-model="patient_id" style="width: 90%"></el-input>
      </el-form-item>
      <el-form-item label="诊断内容">
        <el-input
          type="textarea"
          :rows="10"
          v-model="patient_diagnosis"
          style="width: 90%"
        ></el-input>
      </el-form-item>
      <el-form-item style="margin-left: -4rem">
        <el-button type="primary" @click="submitForm()">提交</el-button>
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
      patient_id: null,
      patient_diagnosis: null,
    };
  },
  methods: {
    submitForm() {
      var that = this;
      this.$axios
        .post("/api/diagnosis", {
          patient_id: that.patient_id,
          manager_id: that.$store.state.id,
          patient_diagnosis: that.patient_diagnosis,
        })
        .then(function (response) {
          var res = response.data;
        //   console.log(response);
          if (res.status == 1) {
            that.patient_id = null;
            that.patient_diagnosis = null;
            that.$message({
              message: "提交成功",
              type: "success",
            });
          }
        })
        .catch(function (error) {
        //   console.log(error);
          that.$message({
            message: "提交失败",
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
    resetForm() {
      this.patient_id = null;
      this.patient_diagnosis = null;
    },
  },
};
</script>

