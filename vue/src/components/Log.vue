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
        @close="handleClose"
      >
        <div
          v-for="(item, index) in user"
          :key="item.id"
          v-show="searchname == '' || searchname == item.name"
        >
          <el-menu-item
            :index="item.id.toString()"
            @click="getthing(item.id.toString())"
          >
            <i class="el-icon-user-solid"></i>
            <span slot="title">{{ item.name }}</span>
          </el-menu-item>
        </div>
      </el-menu>
    </el-col>
    <el-col :span="20">
      <el-row style="float: left; padding-left: 1rem; width: 100%">
        <el-button type="primary" @click="Curthing()" plain>近期事件</el-button>
        <el-button type="primary" @click="Curheart()" plain>近期心跳</el-button>
        <el-button type="primary" @click="Curtemp()" plain>近期体温</el-button>
        <el-button type="primary" @click="Curpress()" plain>近期血压</el-button>
      </el-row>
      <el-main
        v-show="logthing == 1"
        style="width: 60%; padding-top: 3rem; padding-left: 35%"
      >
        <el-timeline>
          <el-timeline-item
            v-for="(activity, index) in things"
            :key="index"
            :timestamp="activity.pubtime"
            :color="activity.type == 'warning' ? '#e63946' : '#43aa8b'"
          >
            {{ activity.title }}
          </el-timeline-item>
        </el-timeline>
      </el-main>
      <el-main v-show="logthing == 2">
        <div id="heart" style="height: 500px"></div>
      </el-main>
      <el-main v-show="logthing == 3">
        <div id="temp" style="height: 500px"></div>
      </el-main>
      <el-main v-show="logthing == 4">
        <div id="press" style="height: 500px"></div>
      </el-main>
    </el-col>
  </el-main>
</template>

<script>
// import axios from "axios";
import echarts from "echarts";
export default {
  data() {
    return {
      activities: [
        {
          content: "支持使用图标",
          timestamp: "2018-04-12 20:46",
          size: "large",
          type: "primary",
          icon: "el-icon-more",
        },
        {
          content: "支持自定义颜色",
          timestamp: "2018-04-03 20:46",
          color: "#0bbd87",
        },
        {
          content: "支持自定义尺寸",
          timestamp: "2018-04-03 20:46",
          size: "large",
        },
        {
          content: "默认样式的节点",
          timestamp: "2018-04-03 20:46",
        },
      ],
      things: [{}],
      currentDate: new Date(),
      dialogVisible: false,
      logthing: 0,
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
      report: {
        patient: {
          name: "",
          age: "",
          sex: "",
          bed: "",
        },
        doctor: {
          name: "",
        },
        pubtime: "",
        id: "",
        content: "",
      },
      alarm: [],
      searchname: "",
      selectname: "101",
      heart: {
        xAxis: {
          type: "category",
          data: [
            "2020/12/21",
            "2020/12/22",
            "2020/12/23",
            "2020/12/24",
            "2020/12/25",
            "2020/12/26",
            "2020/12/27",
          ],
        },
        yAxis: {
          type: "value",
          max: 200,
          min: 0,
        },
        animationDuration: 3000,
        animation: true,
        series: [
          {
            data: [60, 65, 63, 70, 68, 67, 66],
            type: "line",
            smooth: true,
          },
        ],
      },
      temp: {
        xAxis: {
          type: "category",
          data: [
            "2020/12/21",
            "2020/12/22",
            "2020/12/23",
            "2020/12/24",
            "2020/12/25",
            "2020/12/26",
            "2020/12/27",
          ],
        },
        yAxis: {
          type: "value",
          max: 50,
          min: 0,
        },
        animationDuration: 3000,
        animation: true,
        series: [
          {
            data: [36, 36, 35, 36, 36, 36, 37],
            type: "line",
            smooth: true,
          },
        ],
      },
      press: {
        xAxis: {
          type: "category",
          data: [
            "2020/12/21",
            "2020/12/22",
            "2020/12/23",
            "2020/12/24",
            "2020/12/25",
            "2020/12/26",
            "2020/12/27",
          ],
        },
        yAxis: {
          type: "value",
          max: 150,
          min: 0,
        },
        animationDuration: 3000,
        animation: true,

        series: [
          {
            data: [100, 101, 103, 104, 105, 110, 109],
            type: "line",
            smooth: true,
          },
          {
            data: [60, 65, 68, 69, 79, 72, 70],
            type: "line",
            smooth: true,
          },
        ],
      },
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
    Curthing() {
      var that = this;
      that.logthing = 1;
    },
    Curheart() {
      var that = this;
      that.logthing = 2;
      var temp = that.$echarts.init(document.getElementById("heart"));
      temp.setOption(that.heart);
      temp.resize({ height: 400 });
    },
    Curtemp() {
      var that = this;
      that.logthing = 3;
      var temp = that.$echarts.init(document.getElementById("temp"));
      temp.setOption(that.temp);
      temp.resize({ height: 400 });
    },
    Curpress() {
      var that = this;
      that.logthing = 4;
      var temp = that.$echarts.init(document.getElementById("press"));
      temp.setOption(that.press);
      temp.resize({ height: 400 });
    },
    compare(property) {
      return function (a, b) {
        var value1 = a[property];
        var value2 = b[property];
        return value1 - value2;
      };
    },
    getthing(id) {
      var that = this;
      that.logthing = 1;
      this.$axios
        .post("/api/user/log", { id: id })
        .then(function (response) {
          var res = response.data;
          that.things = res;
          console.log(that.things);
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
.el-divider {
  margin: 1rem;
}
</style>


