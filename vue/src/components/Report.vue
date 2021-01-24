<template>
  <el-main style="box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1)">
    <el-col :span="4" style="height: 30rem">
      <el-input
        placeholder="请输入患者姓名"
        prefix-icon="el-icon-search"
        v-model="searchname"
      >
      </el-input>
      <el-menu
        default-active="101"
        class="el-menu-vertical-demo"
        @open="handleOpen"
        @close="handleClose"
      >
        <div
          v-for="(item, index) in user"
          :key="item.id"
          v-show="searchname == '' || searchname == item.name"
        >
          <el-menu-item
            :index="item.id.toString()"
            @click="getReport(item.id.toString())"
          >
            <i class="el-icon-user-solid"></i>
            <span slot="title">{{ item.name }}</span>
          </el-menu-item>
        </div>
      </el-menu>
    </el-col>
    <el-col
      :span="5"
      v-for="(item,index) in reports"
      style="margin-left: 5%; margin-top: 3%"
       :key="index"
    >
      <el-card :body-style="{ padding: '0px' }">
        <div style="padding: 20px">
          <span style="font-weight: bold">报告编号{{ item.id }}</span>
          <div class="bottom clearfix">
            <el-row class="line-limit-length" style="line-height: 1.5rem;">{{
              item.content
            }}</el-row>
            <el-row style="line-height: 2rem; color: #fca311"
              >主治医生 {{ item.doctor.name }}</el-row
            >
            <el-row style="line-height: 1.5rem; color: #8d99ae;font-size:0.8rem;"
              >{{ item.pubtime }}</el-row
            >
            <el-button type="text" class="button" @click="Detailreport(index)"
              >详细信息</el-button
            >
          </div>
        </div>
      </el-card>
    </el-col>
    <el-dialog
      title="详细报告"
      :visible.sync="dialogVisible"
      width="60%"
      style="font-weight:bold;"
      :before-close="handleClose"
    >
      <el-col :span="10" :offset="1">
        <span style="font-size:1rem;color:black;">报告编号 {{report.id}}</span><el-divider></el-divider>
        <span>姓名 {{report.patient.name}}</span><el-divider></el-divider>
        <span>年龄 {{report.patient.age}}</span><el-divider></el-divider>
        <span>性别 {{report.patient.sex}}</span><el-divider></el-divider>
        <span>床位 {{report.patient.bed}}</span><el-divider></el-divider>
        <span>医生 {{report.doctor.name}}</span><el-divider></el-divider>
        <span>编辑时间 {{report.pubtime}}</span>
      </el-col>
      <el-col :span="10" :offset="2" style="height: 20rem">
        <span style="font-size:1rem;color:black;">诊断内容</span><el-divider></el-divider>
        {{report.content}}</el-col>
      
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">关闭</el-button>
      </span>
    </el-dialog>
  </el-main>
</template>

<script>
// import axios from "axios";
export default {
  data() {
    return {
      currentDate: new Date(),
      dialogVisible: false,
      selected: 1,
      user: [
        { name: " ", age: 28, id: 1 },
        { name: " ", age: 28, id: 2 },
        { name: " ", age: 28, id: 3 },
        { name: " ", age: 28, id: 4 },
        { name: " ", age: 28, id: 5 },
        { name: " ", age: 28, id: 6 },
        { name: " ", age: 28, id: 7 },
        { name: " ", age: 28, id: 8 },
      ],
      reports: [],
      report:{
        patient:{
          name:"",
          age:"",
          sex:"",
          bed:"",
        },
        doctor:{
          name:"",
        },
        pubtime:"",
        id:"",
        content:"",
      },
      alarm: [],
      searchname: "",
      selectname: "101",
    };
  },
  methods: {
    handleClose(done) {
      done();
      // this.$confirm("确认关闭？")
      //   .then((_) => {
      //     done();
      //   })
      //   .catch((_) => {});
    },
    getReport(id) {
      var that = this;
      console.log(id);
      this.$axios
        .post("/api/user/report", { id: id })
        .then(function (response) {
          var res = response.data;
          if (res.status == 1) {
            console.log(res.reports);
            that.reports = res.reports;
          } else {
            console.log(res.message);
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    Detailreport(index){
      var that=this;
      that.report=that.reports[index];
      that.dialogVisible = true;
    },
  },
  mounted() {
    var that = this;
    this.$axios
      .post("/api/allusers", { type: "patient" })
      .then(function (response) {
        var res = response.data;
        if (res.status == 1) {
          // console.log(res.message);
          if(that.$store.state.type=='patient'){
            // console.log(res.user);
            for(let i=0;i<res.user.length;i++){
              if(res.user[i].id==that.$store.state.id){
                that.user=[res.user[i]];
                break;
              }
            }
          }
          else{
            that.user = res.user;
          }
          
        } else {
          console.log(res.message);
        }
      })
      .catch(function (error) {
        console.log(error);
      });
  },
};
</script>

<style>
.time {
  font-size: 13px;
  color: #999;
}

.bottom {
  margin-top: 13px;
  line-height: 12px;
}

.button {
  padding: 0;
  float: right;
}

.image {
  width: 100%;
  display: block;
}

.clearfix:before,
.clearfix:after {
  display: table;
  content: "";
}

.clearfix:after {
  clear: both;
}
.line-limit-length {
 text-overflow: -o-ellipsis-lastline;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
}
.el-divider{
  margin:1rem;
}
</style>


