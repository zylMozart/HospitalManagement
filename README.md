# 接化发医院监护系统

[TOC]

### 0.概述

目前住院病人主要由护士护理，这样做不仅需要大量的护士，而且由于不能随时观察危重病人的病情变化，还可能会延误抢救时机。某医院打算开发一个以计算机为中心的患者监护系统，试写出问题定义，并且分析开发这个系统的可行性。

医院对患者监护系统的基本要求是随时接受每个病人的生理信号（脉搏、体温、血压、心电图等），定时记录病人情况以形成患者日志，当某个病人的生理信号超出医生规定的安全范围时向值班护士发出警告信息，此外，护士在需要时还可以要求系统打印出某个指定病人的并请报告。

### 1. 可行性研究

#### 1.1 业务流程图

![](.\img\系统流程图.svg)

#### 1.2 数据流图

##### 1.2.1 基本成分

首先，根据问题描述列出所有数据成分，以便于后续数据流图的描述。在下列数据成分中，其中加星号标记的是在问题描述中隐含的成分。


| 源点/终点 | 处理 | 数据流 | 数据存储 |
| :- | :- | :- | :- |
| 医学文献<br/>病人<br/>医生 | 产生报警<br/>生成日志<br/>生成报告 | 报警信息<br/>&emsp;报警类型\*<br/>&emsp;报警内容<br/>&emsp;病人信息<br/>&emsp;报警时间\*<br/>病情报告<br/>&emsp;报告编号\*<br/>&emsp;病人基本信息<br/>&emsp;医生基本信息<br/>&emsp;诊断意见\*<br/>病人日志<br/>&emsp;日志编号\*<br/>&emsp;日志日期\*<br/>&emsp;病人基本信息<br/>&emsp;日志内容<br/>&emsp;&emsp;日志时间<br/>&emsp;&emsp;病人病情<br/>&emsp;&emsp;诊断内容 | 病人信息<br/>病情报告<br/>病情日志<br/>医生信息<br/>护士信息<br/>报警标准 |

##### 1.2.2 顶层图

先从高层次开始画数据流图，在高层次的数据流图上是否列出了所有给定给定数据源点/终点是一目了然的，因此它是很有价值的通信工具。

![](.\img\BasicSystemModel.svg)

##### 1.2.3 0层数据流图

![](.\img\0L_DFD.svg)

##### 1.2.4 1层数据流图

###### 1.2.4.1 标准处理

![](.\img\1L_DFD1.svg)

###### 1.2.4.2 病情处理

![](.\img\1L_DFD2.svg)

###### 1.2.4.3 病情诊断

![](.\img\1L_DFD3.svg)

###### 1.2.4.4 报警响应

![](.\img\1L_DFD4.svg)

###### 1.2.4.5 处理报警

![](.\img\1L_DFD5.svg)

###### 1.2.4.6 查看病情

![](.\img\1L_DFD6.svg)

#### 1.3 数据字典


| 病人 |   |   |
| - | - | - |
| 名字：病人基础信息<br/>别名：病人信息<br/>描述：当接收病人时，添加病人信息至医院数据库，在病人相应报表中显示<br/>定义：病人信息 = 病人编号 + 病人姓名 + 病人性别 + 病人年龄 + 病人床位号<br/>位置：病情日志<br/>病情报告<br/>报警信息 | 名字：病人生理信息<br/>别名：生理信息<br/>描述：监护系统硬件实时接受的病人的生理信号<br/>定义：病人生理信息 = 病人编号 + 生理信息提取时间 + 病人脉搏 + 病人体温 + 病人收缩压 + 病人舒张压 + 病人心电<br/>位置：病情日志<br/>病情报告<br/>警报信息 | 名字：病人编号<br/>别名：病号<br/>描述：唯一地标识病人数据库中一个特定病人的关键域<br/>定义：病人编号 = 8{字符}8<br/>位置：病人信息<br/>看护信息<br/>病人生理信息<br/>报警信息<br/>病人查看病情报告<br/>病人查看病情日志 |
| 名字：姓名<br/>别名：病人姓名、医生姓名、护士姓名<br/>描述：人的名称<br/>定义：姓名 = 1{字符}256<br/>位置：病人信息<br/>病人生理信息<br/>医生信息<br/>护士信息 | 名字：性别<br/>别名：病人性别、医生性别、护士性别<br/>描述：人的第一特征决定的属性<br/>定义：性别 = [男\|女]<br/>位置：病人信息 | 名字：年龄<br/>别名：病人年龄、医生年龄、护士年龄<br/>描述：人的年纪<br/>定义：年龄 = 1{数字}3<br/>位置：病人信息<br/>医生信息<br/>护士信息 |
| 名字：病人床位号<br/>别名：床位号、病床号<br/>描述：病人在医院被分配到的床位号<br/>定义：病人床位号 = 16{数字}16<br/>位置：病人信息<br/>报警信息 | 名字：时间<br/>别名：生理信息提取时间、报警时间、报警响应时间、诊断时间<br/>描述：记录事件发生的时刻<br/>定义：时间 = 12{数字}12<br/>位置：病人生理信息<br/>报警信息 | 名字：脉搏<br/>别名：病人脉搏、报警脉搏<br/>描述：某时间病人的脉搏跳动次数<br/>定义：病人脉搏 = 1{数字}3<br/>位置：病人生理信息<br/>报警标准 |
| 名字：体温<br/>别名：病人体温、报警体温<br/>描述：某时间病人身体温度（单位℃）<br/>定义：病人体温 = 1{数字}2<br/>位置：病人生理信息<br/>报警标准 | 名字：血压<br/>别名：病人收缩压、报警收缩压、病人舒张压、报警舒张压<br/>描述：某时间病人血液内压强（单位mmHg）<br/>定义：血压 = 1{数字}3<br/>位置：病人生理信息<br/>报警标准 | 名字：心电<br/>别名：病人心电、报警心电<br/>描述：某时间病人心电情况<br/>定义：血压 = 1{数字}3<br/>位置：病人生理信息<br/>病人日志<br/>报警标准 |
| 名字：病人查看病情报告<br/>别名：查看病情报告<br/>描述：对病人查看病情报告的记录<br/>定义：病人查看病情报告 = 病人编号 + 报告编号<br/>位置： | 名字：病人查看病情日志<br/>别名：查看病情日志<br/>描述：对病人查看病情日志的记录<br/>定义：病人查看病情日志 = 病人编号 + 病人编号<br/>位置： |   |
| **护士** |   |   |
| 名字：护士信息<br/>别名：<br/>描述：当护士就职医院时添加的医生实体<br/>定义：护士编号 = 8{字符}8<br/>位置： | 名字：护士编号<br/>别名：<br/>描述：唯一地标识护士数据库中一个特定护士的关键域<br/>定义：护士编号 = 8{字符}8<br/>位置：护士信息<br/>看护信息<br/>报警响应<br/>护士查看病情报告<br/>护士查看病情日志 | 名字：护士查看病情报告<br/>别名：查看病情报<br/>描述：对护士查看病情报告的记录<br/>定义：护士查看病情报告 = 护士编号 + 报告编号<br/>位置： |
| 名字：护士查看病情日志<br/>别名：查看病情日志<br/>描述：对护士查看病情日志的记录<br/>定义：护士查看病情日志 = 护士编号 + 日志编号<br/>位置： | 名字：看护信息<br/>别名：看护<br/>描述：护士看护患者信息<br/>定义：看护信息 = 病人编号 + 护士编号<br/>位置： |   |
| **医生** |   |   |
| 名字：医生信息<br/>别名：<br/>描述：当医生就职医院时添加的医生实体<br/>定义：医生信息 = 科室 + 医生编号 + 医生姓名 + 医生性别 + 医生年龄<br/>位置：医生更新病情报告<br/>医生查看病情报告<br/>诊断 | 名字：医生编号<br/>别名：<br/>描述：唯一地标识医生数据库中一个特定护士的关键域<br/>定义：医生编号 = 8{字符}8<br/>位置：医生信息<br/>医生更新病情报告<br/>医生查看病情报告<br/>医生更新病情日志<br/>医生查看病情日志<br/>诊断 | 名字：科室<br/>别名：医生所属部门<br/>描述：医生在医院认知的具体位置<br/>定义：科室 = 1{字符}256<br/>位置：医生信息 |
| 名字：医生查看病情报告<br/>别名：查看病情报告<br/>描述：对医生查看病情报告的记录<br/>定义：医生查看病情报告 = 医生编号 + 报告编号<br/>位置： | 名字：医生查看病情日志<br/>别名：查看病情日志<br/>描述：对医生查看病情日志的记录<br/>定义：医生查看病情日志 = 医生编号 + 病人编号<br/>位置： | 名字：医生更新病情报告<br/>别名：更新病情报告<br/>描述：对医生更新病情报告的记录<br/>定义：医生更新病情报告 = 医生编号 + 报告编号 + 诊断内容 + 诊断时间 + 诊断编号<br/>位置： |
| 名字：医生更新病情日志<br/>别名：更新病情日志<br/>描述：对医生更新病情日志的记录<br/>定义：医生更新病情日志 = 医生编号 + 日志编号 + 诊断内容 + 诊断时间 + 诊断编号<br/>位置： | 名字：诊断<br/>别名：<br/>描述：医生对具体病患病情的诊断<br/>定义：诊断 = 医生编号 + 病人编号 + 诊断编号 + 诊断内容 + 诊断时间<br/>位置： | 名字：诊断内容<br/>别名：<br/>描述：对病情诊断的描述<br/>定义：报告内容 = 0{字符}65536<br/>位置：更新病情报告<br/>更新病情日志 |
| 名字：诊断编号<br/>别名：病情诊断编号<br/>描述：唯一地标识诊断数据库中一个特定诊断的关键域<br/>定义：诊断编号 = 16{字母或数字}16<br/>位置：医生更新病情报告<br/>更新病情日志 |   |   |
| **报警标准** |   |   |
| 名字：报警标准<br/>别名：警报标准<br/>描述：某一标准下的临界身体特征<br/>定义：报警标准 = 报警脉搏 + 报警体温 + 报警收缩压 + 报警舒张压 + 报警心电<br/>位置：病情报告<br/>病情日志 | 名字：报警<br/>别名：警报<br/>描述：具体的身体异常状态播报<br/>定义：报警 = 报警编号 + 类型号 + 时间<br/>位置：病情报告<br/>病情日志<br/>报警响应 | 名字：报警编号<br/>别名：警报编号<br/>描述：具体的身体异常状态播报的唯一标识<br/>定义：报警编号 = 8{字母或数字}8<br/>位置：报警 |
| 名字：类型号<br/>别名：报警类型号、警报类型号<br/>描述：具体的身体异常状态播报的类型<br/>定义：类型号 = 8{字母或数字}8<br/>位置：报警 | 名字：报警产生<br/>别名：警报产生<br/>描述：报警的发出<br/>定义：报警产生= 病人编号 + 报警编号<br/>位置： | 名字：报警响应<br/>别名：响应<br/>描述：报警的响应信息<br/>定义：报警响应 = 响应时间 + 护士编号 + 报警编号<br/>位置： |
| **报告** |   |   |
| 名字：病情报告<br/>别名：报告<br/>描述：描述病情的报告<br/>定义：病情报告 = 报告编号 + 病人编号 + 医生编号 + 报告内容<br/>位置： | 名字：报告编号<br/>别名：病情报告编号<br/>描述：唯一地标识报告数据库中一个特定报告的关键域<br/>定义：报告编号 = 16{字母或数字}16<br/>位置：病情报告<br/>查看病情报告<br/>更新病情报告 | 名字：报告内容<br/>别名：<br/>描述：对病情的描述<br/>定义：报告内容 = 0{字符}65536<br/>位置：病情报告 |
| **日志** |   |   |
| 名字：病情日志<br/>别名：日志<br/>描述：每天对某一病人的情况描述<br/>定义：病情日志 = 日志编号  + 病人编号 + 日志内容<br/>位置： | 名字：日志编号<br/>别名：病情日志编号<br/>描述：唯一地标识日志数据库中一个特定日志的关键域<br/>定义：日志编号 = 16{字母或数字}16<br/>位置：病情日志<br/>查看病情日志<br/>更新病情日志 | 名字：日志内容<br/>别名：<br/>描述：对病人每天状况的描述<br/>定义：日志内容 = 0{字符}65536<br/>位置：病情日志 |

#### 1.4 成本/效益分析

#### 1.4 成本/效益分析

### 2. 需求分析

#### 2.1 总体目标

本项目旨在构建医院监护系统，该系统自动采集用户的生理信息，在上传到服务器分析之后系统将自动分析生理指标，如果出现危险情况将报警。此时将由护士去病房处理紧急情况。医院医护安全智能监护管理系统是建在住院病区和门诊楼室内的定位基站，患者佩戴智能手环，通过对患者活动情况、生命体征等24小时不间断的采集，实现患者监护安全事故主动预警、患者的智能监护功能，有效减少医护事故的发生。

#### 2.2 具体目标

##### 2.2.1人员信息管理模块

**系统：**增删改查病人信息（包括基本信息和病情信息），增删改查医生信息，增删改查护士信息

##### 2.2.2报警响应模块

**系统：**实时采集的用户生理信息，生理信息不正常时发生预警，向值班护士发出警告

**护士：**收到报警后可以取消警报，去病房处理紧急情况并做记录

##### 2.2.3报警标准制定模块

**系统：**收集医学文献，根据最文献制定报警标准

##### 2.2.4病情诊断模块

**系统：**管理病人以及其主治医师，医生做出诊断后更新病情报告和病情日志

**医生：**提供病人基本信息，提供病人病情信息，提供病情报告，提供病情日志，做病情诊断，更新病情报告，更新胜利日志

**护士：**提供病人基本信息，提供病人病情信息，提供病情报告，提供病情日志

##### 2.2.5病情报告模块

**系统：**自动采集病人生理数据生成病情信息，收集来自医生的病情报告

**医生：**处理病人病情生成病情报告，调用病情报告

**护士：**查看病情报告

##### 2.2.6病情日志模块

**系统：**自动收集病人生理数据记录到日志，出现报警时记录日志，护士响应报警时记录日志，医生作出病情诊断时更新日志

**医生：**查看病情日志

**护士：**查看病情日志

#### 2.3 系统数据建模

```
系统数据模型包含三种互相关联的信息：数据对象、数据对象的属性和数据对象彼此间相互连接的关系。本项目使用实体-联系图来清晰、准确地描述用户的数据要求。E-R图属于面向问题的数据模型，即概念性数据模型。它从用户角度出发看待数据，反映用户的现实环境，与软件系统中的实现方法无关。
```


##### 2.3.1 全局E-R图

![](.\img\ER\0ER.svg)

##### 2.3.2 局部E-R图

分解全局E-R图后得到以下局部E-R图

![](.\img\ER\ER_article_make_standard.svg)

<center>2.3.2.1 根据文献指定报警标准</center>
![](.\img\ER\ER_docter_update_log.svg)

<center>2.3.2.2 医生更新查看病情日志</center>
![](.\img\ER\ER_docter_update_report.svg)

<center>2.3.2.3 医生更新查看病情报告</center>
![](.\img\ER\ER_doctor_cure_patient.svg)

<center>2.3.2.4 医生诊断病人</center>
![](.\img\ER\ER_nurse_cope_warning.svg)

<center>2.3.2.5 护士看护病人</center>
![](.\img\ER\ER_nurse_view_log.svg)

<center>2.3.2.6 护士查看病情日志</center>
![](.\img\ER\ER_nurse_view_report.svg)

<center>2.3.2.7 护士查看病情报告</center>
![](.\img\ER\ER_patient_view_log.svg)

<center>2.3.2.8 病情查看病情日志</center>
![](.\img\ER\ER_patient_view_report.svg)

<center>2.3.2.9 病人查看病情报告</center>
![](.\img\ER\ER_patient_yield_warning.svg)

<center>2.3.2.10 病人产生报警</center>
![](.\img\ER\ER_standard_decide_warning.svg)

<center>2.3.2.11 报警依据报警标准</center>
![](.\img\ER\ER_nurse_solve_warning.svg)

<center>2.3.2.12 护士响应报警</center>
#### 2.4 系统功能建模

#### 2.5数据字典


| 病人 |   |   |
| - | - | - |
| 名字：病人基础信息<br/>别名：病人信息<br/>描述：当接收病人时，添加病人信息至医院数据库，在病人相应报表中显示<br/>定义：病人信息 = 病人编号 + 病人姓名 + 病人性别 + 病人年龄 + 病人床位号<br/>位置：病情日志<br/>病情报告<br/>报警信息 | 名字：病人生理信息<br/>别名：生理信息<br/>描述：监护系统硬件实时接受的病人的生理信号<br/>定义：病人生理信息 = 病人编号 + 生理信息提取时间 + 病人脉搏 + 病人体温 + 病人收缩压 + 病人舒张压 + 病人心电<br/>位置：病情日志<br/>病情报告<br/>警报信息 | 名字：病人编号<br/>别名：病号<br/>描述：唯一地标识病人数据库中一个特定病人的关键域<br/>定义：病人编号 = 8{字符}8<br/>位置：病人信息<br/>看护信息<br/>病人生理信息<br/>报警信息<br/>病人查看病情报告<br/>病人查看病情日志 |
| 名字：姓名<br/>别名：病人姓名、医生姓名、护士姓名<br/>描述：人的名称<br/>定义：姓名 = 1{字符}256<br/>位置：病人信息<br/>病人生理信息<br/>医生信息<br/>护士信息 | 名字：性别<br/>别名：病人性别、医生性别、护士性别<br/>描述：人的第一特征决定的属性<br/>定义：性别 = [男\|女]<br/>位置：病人信息 | 名字：年龄<br/>别名：病人年龄、医生年龄、护士年龄<br/>描述：人的年纪<br/>定义：年龄 = 1{数字}3<br/>位置：病人信息<br/>医生信息<br/>护士信息 |
| 名字：病人床位号<br/>别名：床位号、病床号<br/>描述：病人在医院被分配到的床位号<br/>定义：病人床位号 = 16{数字}16<br/>位置：病人信息<br/>报警信息 | 名字：时间<br/>别名：生理信息提取时间、报警时间、报警响应时间、诊断时间<br/>描述：记录事件发生的时刻<br/>定义：时间 = 12{数字}12<br/>位置：病人生理信息<br/>报警信息 | 名字：脉搏<br/>别名：病人脉搏、报警脉搏<br/>描述：某时间病人的脉搏跳动次数<br/>定义：病人脉搏 = 1{数字}3<br/>位置：病人生理信息<br/>报警标准 |
| 名字：体温<br/>别名：病人体温、报警体温<br/>描述：某时间病人身体温度（单位℃）<br/>定义：病人体温 = 1{数字}2<br/>位置：病人生理信息<br/>报警标准 | 名字：血压<br/>别名：病人收缩压、报警收缩压、病人舒张压、报警舒张压<br/>描述：某时间病人血液内压强（单位mmHg）<br/>定义：血压 = 1{数字}3<br/>位置：病人生理信息<br/>报警标准 | 名字：心电<br/>别名：病人心电、报警心电<br/>描述：某时间病人心电情况<br/>定义：血压 = 1{数字}3<br/>位置：病人生理信息<br/>病人日志<br/>报警标准 |
| 名字：病人查看病情报告<br/>别名：查看病情报告<br/>描述：对病人查看病情报告的记录<br/>定义：病人查看病情报告 = 病人编号 + 报告编号<br/>位置： | 名字：病人查看病情日志<br/>别名：查看病情日志<br/>描述：对病人查看病情日志的记录<br/>定义：病人查看病情日志 = 病人编号 + 病人编号<br/>位置： |   |
| **护士** |   |   |
| 名字：护士信息<br/>别名：<br/>描述：当护士就职医院时添加的医生实体<br/>定义：护士编号 = 8{字符}8<br/>位置： | 名字：护士编号<br/>别名：<br/>描述：唯一地标识护士数据库中一个特定护士的关键域<br/>定义：护士编号 = 8{字符}8<br/>位置：护士信息<br/>看护信息<br/>报警响应<br/>护士查看病情报告<br/>护士查看病情日志 | 名字：护士查看病情报告<br/>别名：查看病情报<br/>描述：对护士查看病情报告的记录<br/>定义：护士查看病情报告 = 护士编号 + 报告编号<br/>位置： |
| 名字：护士查看病情日志<br/>别名：查看病情日志<br/>描述：对护士查看病情日志的记录<br/>定义：护士查看病情日志 = 护士编号 + 日志编号<br/>位置： | 名字：看护信息<br/>别名：看护<br/>描述：护士看护患者信息<br/>定义：看护信息 = 病人编号 + 护士编号<br/>位置： |   |
| **医生** |   |   |
| 名字：医生信息<br/>别名：<br/>描述：当医生就职医院时添加的医生实体<br/>定义：医生信息 = 科室 + 医生编号 + 医生姓名 + 医生性别 + 医生年龄<br/>位置：医生更新病情报告<br/>医生查看病情报告<br/>诊断 | 名字：医生编号<br/>别名：<br/>描述：唯一地标识医生数据库中一个特定护士的关键域<br/>定义：医生编号 = 8{字符}8<br/>位置：医生信息<br/>医生更新病情报告<br/>医生查看病情报告<br/>医生更新病情日志<br/>医生查看病情日志<br/>诊断 | 名字：科室<br/>别名：医生所属部门<br/>描述：医生在医院认知的具体位置<br/>定义：科室 = 1{字符}256<br/>位置：医生信息 |
| 名字：医生查看病情报告<br/>别名：查看病情报告<br/>描述：对医生查看病情报告的记录<br/>定义：医生查看病情报告 = 医生编号 + 报告编号<br/>位置： | 名字：医生查看病情日志<br/>别名：查看病情日志<br/>描述：对医生查看病情日志的记录<br/>定义：医生查看病情日志 = 医生编号 + 病人编号<br/>位置： | 名字：医生更新病情报告<br/>别名：更新病情报告<br/>描述：对医生更新病情报告的记录<br/>定义：医生更新病情报告 = 医生编号 + 报告编号 + 诊断内容 + 诊断时间 + 诊断编号<br/>位置： |
| 名字：医生更新病情日志<br/>别名：更新病情日志<br/>描述：对医生更新病情日志的记录<br/>定义：医生更新病情日志 = 医生编号 + 日志编号 + 诊断内容 + 诊断时间 + 诊断编号<br/>位置： | 名字：诊断<br/>别名：<br/>描述：医生对具体病患病情的诊断<br/>定义：诊断 = 医生编号 + 病人编号 + 诊断编号 + 诊断内容 + 诊断时间<br/>位置： | 名字：诊断内容<br/>别名：<br/>描述：对病情诊断的描述<br/>定义：报告内容 = 0{字符}65536<br/>位置：更新病情报告<br/>更新病情日志 |
| 名字：诊断编号<br/>别名：病情诊断编号<br/>描述：唯一地标识诊断数据库中一个特定诊断的关键域<br/>定义：诊断编号 = 16{字母或数字}16<br/>位置：医生更新病情报告<br/>更新病情日志 |   |   |
| **报警标准** |   |   |
| 名字：报警标准<br/>别名：警报标准<br/>描述：某一标准下的临界身体特征<br/>定义：报警标准 = 报警脉搏 + 报警体温 + 报警收缩压 + 报警舒张压 + 报警心电<br/>位置：病情报告<br/>病情日志 | 名字：报警<br/>别名：警报<br/>描述：具体的身体异常状态播报<br/>定义：报警 = 报警编号 + 类型号 + 时间<br/>位置：病情报告<br/>病情日志<br/>报警响应 | 名字：报警编号<br/>别名：警报编号<br/>描述：具体的身体异常状态播报的唯一标识<br/>定义：报警编号 = 8{字母或数字}8<br/>位置：报警 |
| 名字：类型号<br/>别名：报警类型号、警报类型号<br/>描述：具体的身体异常状态播报的类型<br/>定义：类型号 = 8{字母或数字}8<br/>位置：报警 | 名字：报警产生<br/>别名：警报产生<br/>描述：报警的发出<br/>定义：报警产生= 病人编号 + 报警编号<br/>位置： | 名字：报警响应<br/>别名：响应<br/>描述：报警的响应信息<br/>定义：报警响应 = 响应时间 + 护士编号 + 报警编号<br/>位置： |
| **报告** |   |   |
| 名字：病情报告<br/>别名：报告<br/>描述：描述病情的报告<br/>定义：病情报告 = 报告编号 + 病人编号 + 医生编号 + 报告内容<br/>位置： | 名字：报告编号<br/>别名：病情报告编号<br/>描述：唯一地标识报告数据库中一个特定报告的关键域<br/>定义：报告编号 = 16{字母或数字}16<br/>位置：病情报告<br/>查看病情报告<br/>更新病情报告 | 名字：报告内容<br/>别名：<br/>描述：对病情的描述<br/>定义：报告内容 = 0{字符}65536<br/>位置：病情报告 |
| **日志** |   |   |
| 名字：病情日志<br/>别名：日志<br/>描述：每天对某一病人的情况描述<br/>定义：病情日志 = 日志编号  + 病人编号 + 日志内容<br/>位置： | 名字：日志编号<br/>别名：病情日志编号<br/>描述：唯一地标识日志数据库中一个特定日志的关键域<br/>定义：日志编号 = 16{字母或数字}16<br/>位置：病情日志<br/>查看病情日志<br/>更新病情日志 | 名字：日志内容<br/>别名：<br/>描述：对病人每天状况的描述<br/>定义：日志内容 = 0{字符}65536<br/>位置：病情日志 |

### 3. 总体设计

#### 3.1系统结构图

因为本系统在前面需求分析阶段已经得到了较为完善可行的顶层数据流图、0层数据流图以及1层数据流图，所以在本总体设计阶段直接沿用上述得到的图即可，具体详见*图2.7-图2.11*。

​		层次图可以用来描述软件的层次结构，适用于在自顶向下设计软件的过程中使用，本系统分别从系统管理员端、医生端、护士端、患者端四个方面绘制系统结构图，具体如下所示：

系统结构

![](.\img\Structure\SC_0.drawio.svg)

管理员端

![](.\img\Structure\3_1admin.drawio.svg)

医生端

![](.\img\Structure\3_1doctor.drawio.svg)

护士端

![](.\img\Structure\3_1nurse.drawio.svg)

患者端

![](.\img\Structure\3_1patient.drawio.svg)

#### 3.2数据库设计

##### 3.2.1逻辑结构设计

###### （1）关系模式设计

系统的关系模式可由系统数据建模中的E-R图分析设计而得。其中E-R图模式中的实体和联系都可以转化成关系型，其属性可以转化为关系型的属性，实体型的主键也可以转化为关系型的主键。而对实体集之间的联系转换受到其自身类型的影响，需要具体问题进行具体分析。针对该项目中的联系转换，本项目作出以下几点调整：

​	(1)对于1:1型的联系转换：先将两个实体型分别转换为对应的关系模式后，再将其中一个实体的主键属性加入另一个实体当中，即可完成相关转换。例如，对于本项目中报警和报警标准的1:1型联系，将其中一个实体的主键属性加入另一个实体当中，即可完成相关转换。

​	(2)对于1:n型的联系转换：除了需要将实体自身的属性直接进行转换，对在n端的实体，需要将在1端实体的主键放入其中。需要按其修改的联系有病人和病情日志的查看联系、病人和病情报告的查看联系、病人与报警的产生联系以及医学文献和报警标准的制定联系。

​	(3)对于某些特殊的联系转换：日志报表的作用是方便护士及医生对这个月或某段时间下病情日志的统计，由于时间范围的不准确性，本项目不对该报表进行存储，只对该操作进行运算显示。因此，对于该实体型以及其与相关实体型间的联系本项目不对其进行转换。

​	(4)对于n:m型的联系转换：除了需要将实体自身的属性直接进行转换，在设计时还需要将两者间的联系转换为一个关系型。该关系型的属性需要包含其对应两个实体的主键属性和联系自身的属性，需要进行该操作的联系有报警与护士的处理联系、护士与病人的看护联系、医生对病人的诊断联系、医生、护士对病情日志、病情报告的查询联系以及医生对病情日志和病情报告的更新联系。

(5)对于某些特殊的n:m型的联系转换：对于上述管理员对各实体的管理联系，虽然其符合n:m型的联系模式，但是这里考虑的是任何一个管理员可以对所有实体进行操作。这样的模式更类似于一种权限而已，因此无需将该联系转换为一个新的关系型。对于一些病情日志及病情报告的查阅联系，其本质是个体对于图书查找的权限，这样的n:m型关系也无需转换为一个新的关系型。需要进行上述处理的关系有医生对病情日志、病情报告的查询及更新的联系。

​	按上述要求建立系统的关系模式，其主要内容如下所示，其中，下划线表示该关系型的主键，波浪线表示该关系型的外键。

①医学文献表(<u>索引</u>,标题,简介,发布时间,来源)

②报警标准表(<u>标准编号</u>,报警名称,指标内容,报警信息,报警类型)

③报警信息表(<u>报警编号</u>, *病人编号*,*护士编号*,*报警类型*,*报警内容*,报警时间,处理时间)

④用户信息表(<u>用户编号</u>,用户类型,姓名,性别,年龄,床位号,密码)

⑤病情报告表(<u>报告编号</u>,*病人编号*,日志内容,生成时间,*处理者编号*)

⑥病情日志表(<u>日志编号</u>,*病人编号*,日志内容,生成日期)

###### （2）数据类型设计

医学文献表


| 数据项名 | 英文名 | 数据类型 | 长度 | 实体完整性约束 | 参照完整性约束 | 用户自定义约束 |
| - | - | - | - | - | - | - |
| 索引 | article_id | VARCHAR | 128 | √ | / | / |
| 标题 | title | VARCHAR | 128 | / | / | / |
| 简介 | content | VARCHAR | 1024 | / | / | / |
| 发布时间 | pubtime | DATE | / | / | / | / |
| 来源 | source | VARCHAR | 128 | / | / | / |

报警标准表


| 数据项名 | 英文名  | 数据类型 | 长度 | 实体完整性约束 | 参照完整性约束 | 用户自定义约束 |
| -------- | ------- | -------- | ---- | -------------- | -------------- | -------------- |
| 标准编号 | id      | VARCHAR  | 128  | √              | /              | /              |
| 报警名称 | name    | VARCHAR  | 128  | /              | /              | /              |
| 指标内容 | content | VARCHAR  | 1024 | /              | /              | /              |
| 报警信息 | info    | VARCHAR  | 1024 | /              | /              | /              |
| 报警类型 | type    | VARCHAR  | 32   | /              | /              | /              |

报警信息表


| 数据项名 | 英文名  | 数据类型 | 长度 | 实体完整性约束 | 参照完整性约束 | 用户自定义约束 |
| -------- | ------- | -------- | ---- | -------------- | -------------- | -------------- |
| 报警编号 | id      | VARCHAR  | 128  | √              | /              | /              |
| 病人编号 | id      | VARCHAR  | 128  | /              | √              | /              |
| 护士编号 | id      | VARCHAR  | 128  | /              | √              | /              |
| 报警类型 | type    | VARCHAR  | 32   | /              | √              | /              |
| 报警内容 | content | VARCHAR  | 128  | /              | √              | /              |
| 报警时间 | time    | DATE     | /    | /              | /              | /              |
| 处理时间 | cure    | DATE     | /    | /              | /              | /              |

用户信息表


| 数据项名 | 英文名 | 数据类型 | 长度 | 实体完整性约束 | 参照完整性约束 | 用户自定义约束 |
| - | - | - | - | - | - | - |
| 用户编号 | user_id | VARCHAR | 128 | √ | / | / |
| 用户类型 | user_type | VARCHAR | 128 | / | / | user/doctor/nurse |
| 姓名 | user_name | VARCHAR | 32 | / | / | / |
| 性别 | sex | VARCHAR | 2 | / | / | / |
| 年龄 | age | INT | / | / | / | / |
| 床位号 | bed | VARCHAR | 64 | / | / | / |
| 密码 | pwd | VARCHAR | 128 | / | / | / |

病情报告表//医生to日志改成 1:n


| 数据项名 | 英文名 | 数据类型 | 长度 | 实体完整性约束 | 参照完整性约束 | 用户自定义约束 |
| - | - | - | - | - | - | - |
| 报告编号 | report_id | VARCHAR | 128 | √ | / | / |
| 病人编号 | patient_id | VARCHAR | 128 | / | √ | / |
| 日志内容 | report_content | VARCHAR | 1024 | / | / | / |
| 生成时间 | pub_time | VARCHAR | / | / | / | / |
| 处理者编号 | master_id | VARCHAR | 128 | / | √ | 医生/护士编号，可以为空 |

病情日志表// 医生to日志改成 1:n


| 数据项名 | 英文名 | 数据类型 | 长度 | 实体完整性约束 | 参照完整性约束 | 用户自定义约束 |
| - | - | - | - | - | - | - |
| 日志编号 | report_id | VARCHAR | 128 | √ | / | / |
| 病人编号 | patient_id | VARCHAR | 128 | / | √ | / |
| 日志内容 | report_content | VARCHAR | 1024 | / | / | json形式保存 |
| 生成日期 | pub_time | VARCHAR | / | / | / | / |

##### 3.2.2物理结构设计

###### （1）聚簇设计

用于描述通过LAN连接的两个或多个物理服务器（节点）的集合，每个物理服务器承载一个MYSQL实例并具有对共享存储的相同访问权限。每当托管MYSQL实例的服务器发生故障时，群集MYSQL都可以提供高可用性并防止灾难。在独立服务器上，则硬件故障可能会使您的操作停止。但是，使用聚簇时，如果一个节点出现问题，则可以在故障停机时间最少的情况下自动故障转移到另一个节点，并在人员解决问题的同时继续让您的用户继续工作。固定主服务器后，您可以快速还原操作。与使用独立服务器相比，MYSQL聚簇还可以在应用升级和安全补丁程序时限制停机时间。虽然MYSQL聚簇提供了高可用性并最大程度地减少了系统停机时间，但MYSQL群集不会提高服务器或应用程序的性能。为了提高性能，您需要升级服务器的计算能力。建立聚簇有如下原则：

1.当对一个关系的某些属性列的访问是该关系的主要应用，而对其他属性的访问很少或是次要应用时，可以考虑对该关系在这些属性列上建立聚簇。

2.如果一个关系在某些属性列上的值重复率很高，则可以考虑对该关系在这些组属性列上建立聚簇。

3.如果一个关系一旦装入数据，某些属性列的值很少修改，也很少增加或删除元组，则可以考虑对该关系在这些组属性列上建立聚簇。

由于在MYSQL中，每张基本表就已经默认在主键属性上建立聚簇索引，且由于每张基本表上，最多只能建立一个聚簇索引，所以不需要再进行聚簇索引的设计。

###### （2）分区设计设计

磁盘分区设计的本质是确定数据库数据的存放位置，其目的是提高系统性能，是数据库物理设计的内容之一。

磁盘分区设计的一般原则：

（1） 减少访问冲突，提高I/O并发性。多个事物并发访问同一磁盘时，会产生磁盘访问冲突而导致效率低下，如果事务访问数据均能分布于不同磁盘上，则I/O可并发执行，从而提高数据库访问速度。

（2） 分散热点数据，均衡I/O负担。在数据库中数据访问的频率是不均匀的，那些经常被访问的数据成为热点数据，此类数据宜分散存在于不同的磁盘上，以均衡各个磁盘的负荷，充分发挥多磁盘的并行操作的优势。

（3）保证关键数据快速访问，缓解系统瓶颈。在数据库中有些数据如数据字典等的访问频率很高，为保证对它的访问不直接影响整个系统的效率，可以将其存放在某一固定磁盘上，以保证其快速访问。

本实验的接化发医院监护系统由于程序较小，所以不进行分区设计。

#### 3.3系统模块IPO表

##### 3.3.1生理标准制定模块

1. ###### 功能描述

   根据医学文献指定报警生理标准
2. ###### 模块IPO表


| 系统名称 | 接化发医院监护系统 |
| - | - |
| **模块名称/模块编号** | 生理标准制定模块/01 |
| **作者** | 郑逸伦 |
| **日期** | 2020/12/17 |
| **模块描述** | 根据医学文献指定报警生理标准 |
| **调用模块** | 无 |
| **被调用模块** | 病人监控模块 |
| **输入** | 医学文献 |
| **处理** | 1. 医学专家阅读医学文献<br />2. 医学专家输入报警生理标准<br />3. 返回处理结果 |
| **输出** | 更新反馈信息 |
| **局部数据元素** | 医学文献表，报警标准表 |
| **注释** | 无 |
3. ###### 主要算法

   添加：添加新的生理标准

   提交：尝试更新的生理标准

   取消：删除旧的生理标准

##### 3.3.2报警系统

1. ###### 功能描述

   收集用户生理特征，经过系统自动判别之后产生警报
2. ###### 用户


| 系统名称 | 接化发医院监护系统 |
| - | - |
| **模块名称/模块编号** | 报警系统/02 |
| **作者** | 郑逸伦 |
| **日期** | 2020/12/17 |
| **模块描述** | 收集用户生理特征，经过系统自动判别之后产生警报 |
| **调用模块** | 生理标准制定模块 |
| **被调用模块** | 无 |
| **输入** | 病人生理特征 |
| **处理** | 1. 收集生理特征<br />2. 判断生理特征是否在正常值范围内<br />3. 如果生理特征不在正常范围内，添加，发出警报 |
| **输出** | 警报 |
| **局部数据元素** | 警报标准，病人基础信息 |
| **注释** | 无 |
3. ###### 主要算法

   判断：判断病人生理特征是否在正常范围内

##### 3.3.3
