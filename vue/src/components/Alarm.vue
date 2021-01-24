<template>
  <el-main style="box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1)">
    <el-col :span="24" style="padding-left: 2rem; padding-bottom: 5rem">
      <el-col
        :span="10"
        v-for="(item, index) in alarmstds"
        :key="index"
        :offset="index > 0 ? 2 : 0"
        style="margin-left: 5%; margin-top: 3%"
      >
        <el-card :body-style="{ padding: '0px' }">
          <el-col :span="10" style="padding: 1rem">
            <el-avatar
              shape="square"
              :size="80"
              :fit="fill"
              :src="url"
            ></el-avatar>
          </el-col>
          <el-col :span="12">
            <div style="padding: 0.5rem">
              <span>{{ item.name }}</span>
              <div style="text-align: left">
                <!-- <time class="time">{{ currentDate }}</time> -->
                <label style="color: #ffbe0b"> 指标 </label
                ><label style="color: #495057"
                  >{{ item.content.sign }} {{ item.content.cmp }}
                  {{ item.content.num }}</label
                ><br />
                <label style="color: #ffbe0b"> 描述 </label
                ><label style="color: #adb5bd">{{ item.info }}</label
                ><br />
                <label style="color: #ffbe0b">等级</label>
                <label style="color: #ffbe0b">{{
                  types0[item.type].content
                }}</label>
                <el-button
                  type="text"
                  class="button"
                  @click="Detailstd(item.id)"
                  style="padding-bottom: 0.5rem"
                  >修改</el-button
                >
              </div>
            </div>
          </el-col>
        </el-card>
      </el-col>
      <el-col
        :span="10"
        :key="o"
        :offset="index > 0 ? 2 : 0"
        style="margin-left: 5%; margin-top: 3%"
      >
        <el-card :body-style="{ padding: '0px' }">
          <el-col :span="10" style="padding: 1rem">
            <el-avatar
              shape="square"
              :size="80"
              :fit="fill"
              class="el-icon-circle-plus"
              style="font-size: 4rem"
            ></el-avatar>
          </el-col>
          <el-col :span="12" style="padding: 2rem">
            <el-button
              type="primary"
              icon="el-icon-circle-plus-outline"
              @click="dialogVisible2 = true"
              >添加</el-button
            >
          </el-col>
        </el-card>
      </el-col>
      <!-- <el-row v-for="n in 3" :key="n" style="padding-bottom: 1rem">
        <el-col
          :span="4"
          v-for="(o, index) in 4"
          :key="o"
          :offset="index > 0 ? 2 : 0"
        >
          <el-card :body-style="{ padding: '0px' }">
            <img
              src="https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=2349255986,1997424926&fm=26&gp=0.jpg"
              class="image"
            />
            <div style="padding: 14px">
              <span>好吃的脑子</span>
              <div class="bottom clearfix">
                <time class="time">{{ currentDate }}</time>
                <el-button
                  type="text"
                  class="button"
                  @click="dialogVisible = true"
                  >详细信息</el-button
                >
              </div>
            </div>
          </el-card>
        </el-col>
      </el-row> -->
    </el-col>
    <el-dialog
      title="修改标准"
      :visible.sync="dialogVisible"
      width="70%"
      :before-close="handleClose"
    >
      <el-col :span="12">
        <el-card :body-style="{ padding: '0px' }" style="height: 20rem">
          <img :src="url" class="image" />
          <div style="padding: 14px">
            <!-- <span>好吃的脑子</span> -->
            <div class="bottom clearfix">
              <time class="time">{{ currentDate }}</time>
              <el-button
                type="text"
                class="button"
                @click="dialogVisible = true"
                >详细信息</el-button
              >
            </div>
          </div>
        </el-card>
      </el-col>
      <el-col :span="12" style="height: 20rem">
        <el-form
          status-icon
          ref="ruleForm"
          label-width="100px"
          class="demo-ruleForm"
        >
          <el-form-item label="报警名称">
            <el-input v-model="changeform.name" style="width: 90%"></el-input>
          </el-form-item>
          <el-form-item label="指标内容">
            <el-form-item style="width: 30%; display: inline-block">
              <el-select v-model="changeform.content.sign" placeholder="请选择">
                <el-option
                  v-for="item in signs"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                >
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item style="width: 30%; display: inline-block">
              <el-select v-model="changeform.content.cmp" placeholder="请选择">
                <el-option
                  v-for="item in cmps"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                >
                </el-option>
              </el-select>
            </el-form-item>
            <el-input v-model="changeform.content.num" style="width: 25%"></el-input>
          </el-form-item>
          <el-form-item label="报警信息">
            <el-input v-model="changeform.info" style="width: 90%"></el-input>
          </el-form-item>
          <el-form-item label="报警类型">
            <el-radio v-model="changeform.type" label="1">低风险</el-radio>
            <el-radio v-model="changeform.type" label="2">中风险</el-radio>
            <el-radio v-model="changeform.type" label="3">高风险</el-radio>
          </el-form-item>
        </el-form>
      </el-col>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" @click="Changestd(changeform)"
          >更 新</el-button
        >
      </span>
    </el-dialog>
    <el-dialog
      title="添加标准"
      :visible.sync="dialogVisible2"
      width="70%"
      :before-close="handleClose"
    >
      <el-col :span="12">
        <el-card :body-style="{ padding: '0px' }" style="height: 20rem">
          <img :src="url" class="image" />
          <div style="padding: 14px">
            <!-- <span>好吃的脑子</span> -->
            <div class="bottom clearfix">
              <time class="time">{{ currentDate }}</time>
              <el-button
                type="text"
                class="button"
                @click="dialogVisible2 = true"
                >详细信息</el-button
              >
            </div>
          </div>
        </el-card>
      </el-col>
      <el-col :span="12" style="height: 20rem">
        <el-form
          status-icon
          ref="ruleForm"
          label-width="100px"
          class="demo-ruleForm"
        >
          <el-form-item label="报警名称">
            <el-input v-model="addform.name" style="width: 90%"></el-input>
          </el-form-item>
          <el-form-item label="指标内容">
            <el-form-item style="width: 30%; display: inline-block">
              <el-select v-model="addform.content.sign" placeholder="请选择">
                <el-option
                  v-for="item in signs"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                >
                </el-option>
              </el-select>
            </el-form-item>
            <el-form-item style="width: 30%; display: inline-block">
              <el-select v-model="addform.content.cmp" placeholder="请选择">
                <el-option
                  v-for="item in cmps"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                >
                </el-option>
              </el-select>
            </el-form-item>
            <el-input
              v-model="addform.content.num"
              style="width: 25%"
            ></el-input>
          </el-form-item>
          <el-form-item label="报警信息">
            <el-input v-model="addform.info" style="width: 90%"></el-input>
          </el-form-item>
          <el-form-item label="报警类型">
            <el-radio v-model="addform.type" label="1">低风险</el-radio>
            <el-radio v-model="addform.type" label="2">中风险</el-radio>
            <el-radio v-model="addform.type" label="3">高风险</el-radio>
          </el-form-item>
        </el-form>
      </el-col>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible2 = false">取 消</el-button>
        <el-button type="primary" @click="Addstd(addform)">添 加</el-button>
      </span>
    </el-dialog>
  </el-main>
</template>

<script>
// import axios from "axios";
export default {
  data() {
    return {
      addform: {
        name: "",
        content: { sign: "", cmp: "", num: null },
        info: "",
        type: null,
      },
      changeform: {
        name: "haaha",
        content: { sign: "", cmp: "", num: null },
        info: "",
        type: null,
      },
      radio: 1,
      signs: [
        { value: "心跳", label: "心跳" },
        { value: "体温", label: "体温" },
        { value: "收缩压", label: "收缩压" },
        { value: "舒张压", label: "舒张压" },
      ],
      cmps: [
        { value: "大于", label: "大于" },
        { value: "小于", label: "小于" },
      ],
      types: [
        { value: 1, label: "低风险" },
        { value: 2, label: "中风险" },
        { value: 3, label: "高风险" },
        // { value: "small", label: "小于" },
      ],
      types0: [
        {},
        { content: "低风险", color: "#f9c74f" },
        { content: "中风险", color: "#f3722c" },
        { content: "高风险", color: "#f94144" },
      ],
      sign: null,
      cmp: null,
      currentDate: new Date(),
      dialogVisible: false,
      dialogVisible2: false,
      user: [
        { name: "马保国", age: 28, id: 1 },
        { name: "妈宝过", age: 28, id: 2 },
        { name: "吗包裹", age: 28, id: 3 },
        { name: "嘛吧个", age: 28, id: 4 },
        { name: "妈宝过", age: 28, id: 5 },
        { name: "弥补该", age: 28, id: 6 },
        { name: "忙不过", age: 28, id: 7 },
        { name: "没办过", age: 28, id: 8 },
      ],
      alarmstds: [

      ],
      url:
        "https://5b0988e595225.cdn.sohucs.com/q_70,c_zoom,w_640/images/20180615/59b199ade0e245b2ab83d6204fd9957c.jpg",
    };
  },
  methods: {
    Detailstd(id) {
      var that = this;
      that.dialogVisible = true;
      for(let i=0;i<that.alarmstds.length;i++){
          if(that.alarmstds[i].id==id){
              that.changeform=that.alarmstds[i];
          }
      }
    },
    Showstd() {
      var that = this;
      this.$axios
        .post("/api/alarmstd/show", form)
        .then(function (response) {
          console.log(response);
          that.alarmstds = response.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    Addstd(form) {
      var that = this;
      this.$axios
        .post("/api/alarmstd/add", form)
        .then(function (response) {
          console.log(response);
          var res = response.data;
          if (res.status == 1) {
            that.$message({
              message: "提交成功",
              type: "success",
            });
            that.alarmstds.push(form);
          } else {
            that.$message({
              message: "提交失败",
              type: "error",
            });
          }
        })
        .catch(function (error) {
          console.log(error);
          that.$message({
            message: "提交失败",
            type: "error",
          });
        });
      that.dialogVisible2 = false;
    },
    Changestd(form) {
      var that = this;
      this.$axios
        .post("/api/alarmstd/change", form)
        .then(function (response) {
          console.log(response);
          var res = response.data;
          if (res.status == 1) {
            that.$message({
              message: "修改成功",
              type: "success",
            });
            that.alarmstds.push(form);
          } else {
            that.$message({
              message: "修改失败",
              type: "error",
            });
          }
        })
        .catch(function (error) {
          console.log(error);
          that.$message({
            message: "修改失败",
            type: "error",
          });
        });
      that.dialogVisible2 = false;
    },
    handleClose(done) {
      done();
      // this.$confirm("确认关闭？")
      //   .then((_) => {
      //     done();
      //   })
      //   .catch((_) => {});
    },
  },
  mounted() {
    var that = this;
    this.$axios
      .post("/api/alarmstd/show")
      .then(function (response) {
        console.log(response);
        var res = response.data;
        for (let i = 0; i < res.length; i++) {
          res[i].content = JSON.parse(res[i].content);
        }
        that.alarmstds = response.data;
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
</style>


