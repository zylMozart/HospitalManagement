<template>
  <div>
    <div id="myChart" style="height:500px"></div>
    <div id="myChart2" style="height:500px"></div>
  </div>
</template>

<script>
import echarts from "echarts";
export default {
  name: "SignStatic",
  data() {
    return {
      // 实时数据数组
      date: [],
      yieldRate: [],
      // 折线图echarts初始化选项
      echartsOption: {
        animation: false,
        legend: {
          data: ["实际收益率"],
        },
        xAxis: {
          name: "时间",
          nameTextStyle: {
            fontWeight: 600,
            fontSize: 18,
          },
          type: "category",
          boundaryGap: false,
          data: this.date, // 绑定实时数据数组
        },
        yAxis: {
          name: "实际心率",
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
      // 折线图echarts初始化选项
      echartsOption2: {
        animation: false,
        legend: {
          data: ["实际收益率"],
        },
        xAxis: {
          name: "时间",
          nameTextStyle: {
            fontWeight: 600,
            fontSize: 18,
          },
          type: "category",
          boundaryGap: false,
          data: this.date, // 绑定实时数据数组
        },
        yAxis: {
          name: "实际心率",
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
            name: "实时血压",
            type: "line",
            data: this.yieldRate, // 绑定实时数据数组
            color: "blue",
          },
        ],
      },
    };
  },
  mounted() {
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
      var actualProfitRate = 100 + 50 * Math.random();
      this.yieldRate2.push(actualProfitRate.toFixed(3));
      this.date2.push(
        this.getTime(
          Math.round(new Date().getTime() - (1000 * (100 - i)) / 1000)
        )
      );
    }
    // console.log(this.yieldRate);
    this.myChart = echarts.init(document.getElementById("myChart"), "light"); // 初始化echarts, theme为light
    this.myChart.setOption(this.echartsOption); // echarts设置初始化选项
    setInterval(this.addData, 1000); // 每三秒更新实时数据到折线图
    this.myChart2 = echarts.init(document.getElementById("myChart2"), "light"); // 初始化echarts, theme为light
    this.myChart2.setOption(this.echartsOption); // echarts设置初始化选项
    setInterval(this.addData2, 1000); // 每三秒更新实时数据到折线图
  },
  methods: {
    // 获取当前时间
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
    addData: function () {
      // 从接口获取数据并添加到数组
      var actualProfitRate = 70 + 20 * Math.random();
      this.yieldRate.push(actualProfitRate.toFixed(3));
      this.date.push(this.getTime(Math.round(new Date().getTime() / 1000)));
      this.yieldRate.reverse();
      this.yieldRate.pop();
      this.yieldRate.reverse();
      this.date.reverse();
      this.date.pop();
      this.date.reverse();
      // this.data.splice(1,1);
      // 重新将数组赋值给echarts选项
      this.echartsOption.xAxis.data = this.date;
      this.echartsOption.series[0].data = this.yieldRate;
      this.myChart.setOption(this.echartsOption);
    },
    addData2: function () {
      // 从接口获取数据并添加到数组
      var actualProfitRate = 100 + 50 * Math.random();
      this.yieldRate2.push(actualProfitRate.toFixed(3));
      this.date2.push(this.getTime(Math.round(new Date().getTime() / 1000)));
      this.yieldRate2.reverse();
      this.yieldRate2.pop();
      this.yieldRate2.reverse();
      this.date2.reverse();
      this.date2.pop();
      this.date2.reverse();
      // this.data.splice(1,1);
      // 重新将数组赋值给echarts选项
      this.echartsOption2.xAxis.data = this.date2;
      this.echartsOption2.series[0].data = this.yieldRate2;
      this.myChart2.setOption(this.echartsOption2);
    },
  },
};
</script>
 
<style>
#myChart {
  width: 100%;
  height: 500px;
  margin: 0 auto;
}
</style>