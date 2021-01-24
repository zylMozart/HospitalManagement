<template>
  <el-main>
    <el-radio-group style="margin-bottom: 20px">
      <el-button type="primary" @click.native="getusers('patient')" plain
        >患者</el-button
      >
      <el-button type="primary" @click.native="getusers('nurse')" plain
        >护士</el-button
      >
      <el-button type="primary" @click.native="getusers('doctor')" plain
        >医生</el-button
      >
    </el-radio-group>

    <el-table
      :data="user"
      border
      style="width: 100%; box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1)"
    >
      <el-table-column fixed prop="id" label="编号" width="150">
      </el-table-column>
      <el-table-column prop="type" label="类型" width="120"> </el-table-column>
      <el-table-column prop="name" label="姓名" width="120"> </el-table-column>
      <el-table-column prop="sex" label="性别" width="120"> </el-table-column>
      <el-table-column prop="age" label="年龄" width="150"> </el-table-column>
      <el-table-column prop="bed" label="床位" width="500"> </el-table-column>
      <el-table-column fixed="right" label="操作" width="180">
        <template slot-scope="scope">
          <el-button
            @click="handleClick(scope.row, 'show')"
            type="text"
            size="small"
            >查看</el-button
          >
          <el-button
            @click="handleClick(scope.row, 'change')"
            type="text"
            size="small"
            >编辑</el-button
          >
          <el-button @click="deleteuser(scope.row)" type="text" size="small"
            >删除</el-button
          >
          <el-button
            @click="handleClick(scope.row, 'add')"
            type="text"
            size="small"
            >添加</el-button
          >
        </template>
      </el-table-column>
    </el-table>

    <el-dialog
      title="用户信息"
      :visible.sync="centerDialogVisible"
      width="50%"
      center
    >
      <el-form
        status-icon
        ref="ruleForm"
        label-width="100px"
        class="demo-ruleForm"
      >
        <el-form-item label="编号">
          <el-input
            v-model="curuser.id"
            style="width: 90%"
            :disabled="opt"
          ></el-input>
        </el-form-item>
        <el-form-item label="用户类型">
          <el-select
            v-model="curuser.type"
            placeholder="请选择"
            style="width: 90%"
            :disabled="opt"
          >
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            >
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="姓名">
          <el-input
            v-model="curuser.name"
            style="width: 90%"
            :disabled="opt"
          ></el-input>
        </el-form-item>
        <el-form-item label="性别">
          <el-select
            v-model="curuser.sex"
            placeholder="请选择"
            style="width: 90%"
            :disabled="opt"
          >
            <el-option
              v-for="item in sexs"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            >
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="年龄">
          <el-input
            v-model="curuser.age"
            style="width: 90%"
            :disabled="opt"
          ></el-input>
        </el-form-item>
        <el-form-item label="地址">
          <el-input
            v-model="curuser.bed"
            style="width: 90%"
            :disabled="opt"
          ></el-input>
        </el-form-item>

        <el-form-item style="text-align: center" v-show="!opt">
          <el-button type="primary" @click="changeuser()">修改</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
    <el-dialog
      title="用户信息"
      :visible.sync="centerDialogVisible2"
      width="50%"
      center
    >
      <el-form
        status-icon
        ref="ruleForm"
        label-width="100px"
        class="demo-ruleForm"
      >
        <el-form-item label="编号">
          <el-input
            v-model="blankuser.id"
            style="width: 90%"
            :disabled="opt"
          ></el-input>
        </el-form-item>
        <el-form-item label="用户类型">
          <el-select
            v-model="blankuser.type"
            placeholder="请选择"
            style="width: 90%"
            :disabled="opt"
          >
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            >
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="姓名">
          <el-input
            v-model="blankuser.name"
            style="width: 90%"
            :disabled="opt"
          ></el-input>
        </el-form-item>
        <el-form-item label="性别">
          <el-select
            v-model="blankuser.sex"
            placeholder="请选择"
            style="width: 90%"
            :disabled="opt"
          >
            <el-option
              v-for="item in sexs"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            >
            </el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="年龄">
          <el-input
            v-model="blankuser.age"
            style="width: 90%"
            :disabled="opt"
          ></el-input>
        </el-form-item>
        <el-form-item label="地址">
          <el-input
            v-model="blankuser.bed"
            style="width: 90%"
            :disabled="opt"
          ></el-input>
        </el-form-item>

        <el-form-item style="text-align: center" v-show="!opt">
          <el-button type="primary" @click="adduser()">添加</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
  </el-main>
</template>

<script>
// import axios from "axios";
export default {
  methods: {
    handleClick(row, opt) {
      var that = this;
      if (opt == "show") {
        that.opt = true;
        that.centerDialogVisible = true;
        that.curuser = row;
      } else if (opt == "change") {
        that.opt = false;
        that.centerDialogVisible = true;
        that.curuser = row;
        console.log(row);
      } else if (opt == "add") {
        that.opt = false;
        that.centerDialogVisible2 = true;
        that.curuser = that.blankuser;
      } else if (opt == "delete") {
        that.opt = false;
        that.centerDialogVisible = true;
      }
    },
    getusers(type) {
      var that = this;
      if (type == "patient") that.type = 1;
      else if (type == "nurse") that.type = 2;
      else that.type = 3;
      this.$axios
        .post("/api/allusers", { type: type })
        .then(function (response) {
          var res = response.data;
          if (res.status == 1) {
            console.log(res.message);
            that.user = res.user;
          } else {
            console.log(res.message);
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    changeuser() {
      var that = this;
      that.centerDialogVisible = false;
      this.$axios
        .post("/api/user/change", { user: that.curuser })
        .then(function (response) {
          console.log(response);
          var res = response.data;
          if (res.status == 1) {
            console.log(res.message);
            that.$message({
              message: "更新成功",
              type: "success",
            });
          } else {
            console.log(res.message);
            that.$message({
              message: "更新失败",
              type: "error",
            });
          }
        })
        .catch(function (error) {
          console.log(error);
          that.$message({
            message: "更新失败",
            type: "error",
          });
        });
    },
    adduser() {
      var that = this;
      that.centerDialogVisible2 = false;
      // console.log(that.blankuser);
      that.blankuser.pwd = "12345678";
      this.$axios
        .post("/api/user/add", { user: that.blankuser })
        .then(function (response) {
          console.log(response);
          var res = response.data;
          if (res.status == 1) {
            console.log(res.message);
            that.user.push(that.blankuser);
            that.$message({
              message: "添加成功",
              type: "success",
            });
          } else {
            console.log(res.message);
            that.$message({
              message: "添加失败",
              type: "error",
            });
          }
        })
        .catch(function (error) {
          console.log(error);
          that.$message({
            message: "添加失败",
            type: "error",
          });
        });
    },
    deleteuser(user) {
      var that = this;
      console.log(user);
      this.$axios
        .post("/api/user/delete", { id:user.id })
        .then(function (response) {
          var res = response.data;
          if (res.status == 1) {
            console.log(res.message);
            for(let i=0;i<that.user.length;i++){
              if(that.user[i].id==user.id){
                that.user.splice(i,1);
                break;
              }
            }
            that.$message({
              message: "删除成功",
              type: "success",
            });
          } else {
            console.log(res.message);
            that.$message({
            message: "删除失败",
            type: "error",
          });
          }
        })
        .catch(function (error) {
          console.log(error);
          that.$message({
            message: "删除失败",
            type: "error",
          });
        });
    },
  },
  mounted() {},
  data() {
    return {
      opt: false,
      centerDialogVisible: false,
      centerDialogVisible2: false,
      type: 1,
      isCollapse: true,
      user: [],
      blankuser: {
        age: null,
        bed: null,
        id: null,
        name: null,
        pwd: null,
        sex: null,
        type: null,
      },
      curuser: {},
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
      ],
      sexs: [
        {
          value: "男",
          label: "男",
        },
        {
          value: "女",
          label: "女",
        },
      ],
    };
  },
};
</script>