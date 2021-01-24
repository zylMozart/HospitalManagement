<template>
  <div>
    <h1>报警统计</h1>
    <el-col :span="8">
      <div id="main2" style="width: 100%; height: 30rem"></div>
    </el-col>
    <el-col :span="16">
      <div id="main" style="width: 100%; height: 30rem"></div>
    </el-col>
  </div>
</template>
<script>
/* eslint-disable */
// import echarts from 'echarts';
// import 'echarts-gl';
// import 'echarts-gl/src/chart/bar3D';

export default {
  name: "Echarts",
  methods: {
    myEcharts() {
      // 基于准备好的dom，初始化echarts实例
      var myChart = this.$echarts.init(document.getElementById("main"));

      var xAxisData = [];
      var data1 = [];
      var data2 = [];
      for (var i = 0; i < 80; i++) {
        xAxisData.push("时间" + i);
        data1.push((Math.sin(i / 5) * (i / 5 - 10) + i / 6) * 5);
        data2.push((Math.cos(i / 5) * (i / 5 - 10) + i / 6) * 5);
      }

      var option = {
        title: {
          text: "历史报警情况",
        },
        legend: {
          data: ["报警", "已处理"],
        },
        toolbox: {
          // y: 'bottom',
          feature: {
            magicType: {
              type: ["stack", "tiled"],
            },
            dataView: {},
            saveAsImage: {
              pixelRatio: 2,
            },
          },
        },
        tooltip: {},
        xAxis: {
          data: xAxisData,
          splitLine: {
            show: false,
          },
        },
        yAxis: {},
        series: [
          {
            name: "报警",
            type: "bar",
            data: data1,
            animationDelay: function (idx) {
              return idx * 10;
            },
          },
          {
            name: "已处理",
            type: "bar",
            data: data2,
            animationDelay: function (idx) {
              return idx * 10 + 100;
            },
          },
        ],
        animationEasing: "elasticOut",
        animationDelayUpdate: function (idx) {
          return idx * 5;
        },
      };

      myChart.setOption(option);
    },
    myEcharts2() {
      // 基于准备好的dom，初始化echarts实例
      var myChart2 = this.$echarts.init(document.getElementById("main2"));
      var option2 = {
        backgroundColor: "#fff",

        title: {
          text: "当前病情状况统计",
          left: "center",
          top: 20,
          textStyle: {
            color: "#000",
          },
        },

        tooltip: {
          trigger: "item",
          formatter: "{a} <br/>{b} : {c} ({d}%)",
        },

        visualMap: {
          show: false,
          min: 80,
          max: 600,
          inRange: {
            colorLightness: [0, 1],
          },
        },
        series: [
          {
            name: "访问来源",
            type: "pie",
            radius: "70%",
            center: ["50%", "50%"],
            data: [
              { value: 335, name: "直接访问" },
              { value: 310, name: "邮件营销" },
              { value: 274, name: "联盟广告" },
              { value: 235, name: "视频广告" },
              { value: 400, name: "搜索引擎" },
            ].sort(function (a, b) {
              return a.value - b.value;
            }),
            roseType: "radius",
            label: {
              color: "rgba(255, 255, 255, 0.3)",
            },
            labelLine: {
              lineStyle: {
                color: "rgba(255, 255, 255, 0.3)",
              },
              smooth: 0.2,
              length: 10,
              length2: 20,
            },
            itemStyle: {
              color: "#c23531",
              shadowBlur: 200,
              shadowColor: "rgba(0, 0, 0, 0.5)",
            },

            animationType: "scale",
            animationEasing: "elasticOut",
            animationDelay: function (idx) {
              return Math.random() * 200;
            },
          },
        ],
      };
      // 使用刚指定的配置项和数据显示图表。
      myChart2.setOption(option2);
    },
  },
  mounted() {
    this.myEcharts();
    this.myEcharts2();
  },
};
</script>