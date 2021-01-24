<template>
  <el-container style="background-color: rgb(101 101 101)">
    <el-main style="background-color: white">
      <el-col :span="4">
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
              @click="selectPatient(item.id.toString())"
            >
              <i class="el-icon-user-solid"></i>
              <span slot="title">{{ item.name }}</span>
            </el-menu-item>
          </div>
        </el-menu>
      </el-col>
      <el-col :span="9" :offset="1" style="height: 100%">
        <el-row style="text-align: left; left: 1rem">
          <el-col :span="3">
            <img style="height: 2rem" src="../assets/logo/heart.png" alt="" />
          </el-col>
          <el-col :span="5">
            <label style="font-size: 1.3rem; color: #d81e06">心跳</label>
          </el-col>
          <el-col :span="12">
            <label style="font-size: 1.5rem; color: #d81e06; float: right"
              >{{ Math.floor(yieldRate[99]) }} bps</label
            >
          </el-col>
        </el-row>
        <el-row style="height: 45%">
          <div id="myChart" style="height: 100%"></div>
        </el-row>
        <el-row style="text-align: left; left: 1rem">
          <el-col :span="3">
            <img style="height: 2rem" src="../assets/logo/blood.png" alt="" />
          </el-col>
          <el-col :span="5">
            <label style="font-size: 1.3rem; color: #d81e06">血压</label>
          </el-col>
          <el-col :span="12">
            <label style="font-size: 1.5rem; color: #d81e06; float: right"
              >{{ Math.floor(yieldRate3[99]) }}/{{
                Math.floor(yieldRate2[99])
              }}
              mmHg</label
            >
          </el-col>
        </el-row>
        <el-row style="height: 45%">
          <div id="myChart2" style="height: 100%"></div>
        </el-row>
      </el-col>
      <el-col :span="9" :offset="1" style="height: 100%">
        <el-row style="text-align: left; left: 1rem">
          <el-col :span="3">
            <img style="height: 2rem" src="../assets/logo/temp.png" alt="" />
          </el-col>
          <el-col :span="5">
            <label style="font-size: 1.3rem; color: #d81e06">体温</label>
          </el-col>
          <el-col :span="12">
            <label style="font-size: 1.5rem; color: #d81e06; float: right"
              >{{ temp }}℃</label
            >
          </el-col>
        </el-row>
        <el-row style="height: 45%">
          <div id="temp" style="width: 100%; height: 100%"></div>
        </el-row>
        <el-row style="text-align: left; left: 1rem">
          <el-col :span="3">
            <img style="height: 2rem" src="../assets/logo/alarm.png" alt="" />
          </el-col>
          <el-col :span="5">
            <label style="font-size: 1.3rem; color: #d81e06">患者警报</label>
          </el-col>
        </el-row>
        <el-row style="height: 10%; width: 100%; margin-top: 2rem">
          <label style="margin: 1rem" v-show="alarm.length > 0">待处理</label>
          <el-badge
            v-for="item in alarm"
            is-dot
            class="item"
            style="margin-right: 1rem"
          >
            <el-button size="small" @click="copewarning(selectname)">{{
              item.name
            }}</el-button>
          </el-badge>
        </el-row>
        <!-- <el-row style="height: 10%; width: 100%; margin-top: 2rem">
          <label style="margin: 1rem">已处理</label>
          <el-badge
            :value="3"
            class="item"
            type="info"
            style="margin-right: 1rem"
          >
            <el-button size="small" disabled>心率过低</el-button>
          </el-badge>
          <el-badge
            :value="1"
            class="item"
            type="info"
            style="margin-right: 1rem"
          >
            <el-button size="small" disabled>患者警报</el-button>
          </el-badge>
          <el-badge
            :value="2"
            class="item"
            type="info"
            style="margin-right: 1rem"
          >
            <el-button size="small" disabled>意识不清</el-button>
          </el-badge>
        </el-row> -->
      </el-col>
    </el-main>
  </el-container>
</template>
<script>
/* eslint-disable */
import SignStatic from "./SignStatic.vue";
import echarts from "echarts";
// import axios from "axios";
export default {
  name: "Sign",
  data() {
    return {
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
      alarm: [],
      searchname: "",
      selectname: "101",
      temp: 36,
      username: "",
      date: [],
      yieldRate: [],
      echartsOption: {
        animation: false,
        legend: {
          data: ["实际收益率"],
        },
        xAxis: {
          name: "t",
          nameTextStyle: {
            fontWeight: 600,
            fontSize: 18,
          },
          type: "category",
          boundaryGap: false,
          data: this.date, // 绑定实时数据数组
        },
        yAxis: {
          name: "bps",
          nameTextStyle: {
            fontWeight: 600,
            fontSize: 18,
          },
          type: "value",
          scale: true,
          boundaryGap: ["15%"],
          axisLabel: {
            interval: "auto",
            formatter: "{value}",
          },
          max: 200,
          min: 0,
        },
        tooltip: {
          trigger: "axis",
        },
        series: [
          {
            name: "实时心跳",
            type: "line",
            data: this.yieldRate, // 绑定实时数据数组
            color: "red",
          },
        ],
      },
      date2: [],
      yieldRate2: [],
      yieldRate3: [],
      echartsOption2: {
        animation: false,
        legend: {
          data: ["实际收益率", "血压"],
        },
        xAxis: {
          name: "t",
          nameTextStyle: {
            fontWeight: 600,
            fontSize: 18,
          },
          type: "category",
          boundaryGap: false,
          data: this.date, // 绑定实时数据数组
        },
        yAxis: {
          name: "mmHg",
          nameTextStyle: {
            fontWeight: 600,
            fontSize: 18,
          },
          type: "value",
          scale: true,
          boundaryGap: ["15%", "15%"],
          axisLabel: {
            interval: "auto",
            formatter: "{value}",
          },
          max: 200,
          min: 0,
        },
        tooltip: {
          trigger: "axis",
        },
        series: [
          {
            name: "实时血压",
            type: "line",
            data: this.yieldRate2, // 绑定实时数据数组
            color: "#48bfe3",
          },
          {
            name: "实时血压",
            type: "line",
            data: this.yieldRate3, // 绑定实时数据数组
            color: "#f8961e",
          },
        ],
      },
      optiontemp: {
        tooltip: {
          formatter: "{a} <br/>{b} : {c}%",
        },
        toolbox: {
          feature: {
            restore: {},
            saveAsImage: {},
          },
        },
        series: [
          {
            axisLine: {
              lineStyle: {
                color: [
                  [0.36, "rgb(91 165 239)"],
                  [0.38, "rgb(90 195 86)"],
                  [0.4, "rgb(239 182 67)"],
                  [1, "rgb(239 111 67)"],
                ],
              },
            },
            name: "业务指标",
            type: "gauge",
            detail: { formatter: "{value}℃" },
            data: [{ value: 36, name: "" }],
          },
        ],
      },
    };
  },
  methods: {
    handleOpen(key, keyPath) {
      console.log(key, keyPath);
    },
    handleClose(key, keyPath) {
      console.log(key, keyPath);
    },
    handleSelect(key, keyPath) {
      console.log(key, keyPath);
      console.log(this.$route.name);
    },
    tempEcharts() {
      // 基于准备好的dom，初始化echarts实例
      var temp = this.$echarts.init(document.getElementById("temp"));
      var optiontemp = {
        tooltip: {
          formatter: "{a} <br/>{b} : {c}%",
        },
        toolbox: {
          feature: {
            restore: {},
            saveAsImage: {},
          },
        },
        series: [
          {
            axisLine: {
              lineStyle: {
                color: [
                  [0.36, "rgb(91 165 239)"],
                  [0.38, "rgb(90 195 86)"],
                  [0.4, "rgb(239 182 67)"],
                  [1, "rgb(239 111 67)"],
                ],
              },
            },
            name: "业务指标",
            type: "gauge",
            detail: { formatter: "{value}℃" },
            data: [{ value: 36, name: "" }],
          },
        ],
      };
      temp.setOption(optiontemp);
    },
    getTime: function () {
      var ts = arguments[0] || 0;
      var t, h, i, s;
      t = ts ? new Date(ts * 1000) : new Date();
      h = t.getHours();
      i = t.getMinutes();
      s = t.getSeconds();
      // 定义时间格式
      return (
        (h < 10 ? "0" + h : h) +
        ":" +
        (i < 10 ? "0" + i : i) +
        ":" +
        (s < 10 ? "0" + s : s)
      );
    },
    // 添加实时数据
    addData0: function () {
      var that = this;
      this.$axios
        .post("/api/data", { id: that.selectname })
        .then(function (response) {
          var nowsign = response.data.data;
          var alarm = response.data.alarm;
          that.alarm = alarm;
          if (alarm.length > 0) {
            // console.log(alarm);
            for (let i = 0; i < alarm.length; i++) {
              that.$message({
                message: "编号为" + that.selectname + "的患者 " + alarm[i].name,
                type: "error",
              });
            }
          }
          that.optiontemp.series[0].data[0].value = nowsign[3];
          that.temp = nowsign[3];
          var temp = that.$echarts.init(document.getElementById("temp"));
          temp.setOption(that.optiontemp);
          that.yieldRate.push(nowsign[0]);
          that.date.push(that.getTime(Math.round(new Date().getTime() / 1000)));
          that.yieldRate.shift();
          that.date.shift();
          // that.data.splice(1,1);
          // 重新将数组赋值给echarts选项
          that.echartsOption.xAxis.data = that.date;
          that.echartsOption.series[0].data = that.yieldRate;
          that.myChart.setOption(that.echartsOption);

          that.yieldRate2.push(nowsign[1]);
          that.date2.push(
            that.getTime(Math.round(new Date().getTime() / 1000))
          );
          that.yieldRate2.shift();

          that.yieldRate3.push(nowsign[2]);
          that.yieldRate3.shift();

          that.date2.shift();
          // that.data.splice(1,1);
          // 重新将数组赋值给echarts选项
          that.echartsOption2.xAxis.data = that.date2;
          that.echartsOption2.series[0].data = that.yieldRate2;
          that.echartsOption2.series[1].data = that.yieldRate3;
          that.myChart2.setOption(that.echartsOption2);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    copewarning(id) {
      console.log(id);
      var that = this;
      this.$axios
        .post("/api/copewarning", { manager_id: that.$store.state.id,patient_id: id})
        .then(function (response) {
          console.log(response);
          if (res.status == 1) {
            console.log(res.message);
          } else {
            console.log(res.message);
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    selectPatient(id) {
      this.selectname = id;
      this.yieldRate = [];
      this.yieldRate2 = [];
      this.yieldRate3 = [];
      this.date = [];
      this.date2 = [];
      this.tempEcharts();
      for (var i = 0; i < 100; i++) {
        var actualProfitRate = 70 + 20 * Math.random();
        this.yieldRate.push(actualProfitRate.toFixed(3));
        this.date.push(
          this.getTime(
            Math.round(new Date().getTime() - (1000 * (100 - i)) / 1000)
          )
        );
      }
      for (var i = 0; i < 100; i++) {
        this.yieldRate2.push((65 + 20 * Math.random()).toFixed(3));
        this.yieldRate3.push((95 + 20 * Math.random()).toFixed(3));
        this.date2.push(
          this.getTime(
            Math.round(new Date().getTime() - (1000 * (100 - i)) / 1000)
          )
        );
      }
      this.myChart = echarts.init(document.getElementById("myChart"), "light"); // 初始化echarts, theme为light
      this.myChart.setOption(this.echartsOption); // echarts设置初始化选项
      this.myChart2 = echarts.init(
        document.getElementById("myChart2"),
        "light"
      ); // 初始化echarts, theme为light
      this.myChart2.setOption(this.echartsOption); // echarts设置初始化选项
      // setInterval(this.addData2, 1000); // 每三秒更新实时数据到折线图
      var that = this;
      this.$axios
        .post("/api/allusers", { type: "patient" })
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
  },

  mounted() {
    this.tempEcharts();
    for (var i = 0; i < 100; i++) {
      var actualProfitRate = 70 + 20 * Math.random();
      this.yieldRate.push(actualProfitRate.toFixed(3));
      this.date.push(
        this.getTime(
          Math.round(new Date().getTime() - (1000 * (100 - i)) / 1000)
        )
      );
    }
    for (var i = 0; i < 100; i++) {
      this.yieldRate2.push((65 + 20 * Math.random()).toFixed(3));
      this.yieldRate3.push((95 + 20 * Math.random()).toFixed(3));
      this.date2.push(
        this.getTime(
          Math.round(new Date().getTime() - (1000 * (100 - i)) / 1000)
        )
      );
    }
    this.myChart = echarts.init(document.getElementById("myChart"), "light"); // 初始化echarts, theme为light
    this.myChart.setOption(this.echartsOption); // echarts设置初始化选项
    setInterval(this.addData0, 2000); // 每三秒更新实时数据到折线图
    this.myChart2 = echarts.init(document.getElementById("myChart2"), "light"); // 初始化echarts, theme为light
    this.myChart2.setOption(this.echartsOption); // echarts设置初始化选项
    // setInterval(this.addData2, 1000); // 每三秒更新实时数据到折线图
    var that = this;
    this.$axios
      .post("/api/allusers", { type: "patient" })
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
};
</script>