## 赛友

### 后台管理页面

> http://www.thmaoqiu.cn/saiyou/public/index.php/index

### 登陆注册

#### sms

> http://www.thmaoqiu.cn/saiyou/public/index.php/sms

数据传输方式：POST

数据传输格式为：JSON


参数(类型) | 说明 | 示例
----|------|----
phone(string) | 传入手机号  | 12345678912

发送成功返回 
 ```json
{
    "code": 0,
    "msg": "发送成功",
    "data": {
        "captcha": 7765
    }
}
 ```
发送失败返回（手机号错误）
 ```json
{
    "code": 2,
    "msg": "请求参数格式错误",
    "data": {
        "captcha": 8875
    }
}
 ```

#### 注册

> http://www.thmaoqiu.cn/saiyou/public/index.php/register

数据传输方式：POST

数据传输格式为：JSON


参数(类型) | 说明 | 示例
----|------|----
phone(string) | 传入手机号  | 12345678912
password(string) | 传入密码  | 12345678912

注册成功返回 
 ```json
{
    "code": 0,
    "msg": "注册成功"
}
 ```

注册失败返回
 ```json
{
    "code": 1,
    "msg": "手机号已存在"
}
 ```
 ```json
{
    "code": 2,
    "msg": "请输入手机号"
}
 ```
 ```json
{
    "code": -1,
    "msg": "注册失败"
}
 ```
 
 
 
#### 登录

> http://www.thmaoqiu.cn/saiyou/public/index.php/login

数据传输方式：POST

数据传输格式为：JSON


参数(类型) | 说明 | 示例
----|------|----
phone(string) | 传入手机号  | 12345678912
password(string) | 传入密码  | 12345678912

成功返回 
 ```json
{
    "code": 0,
    "msg": "登录成功"
}
 ```

失败返回
 ```json
{
    "code": 1,
    "msg": "密码错误"
}
 ```
 ```json
{
    "code": 2,
    "msg": "用户名或密码错误"
}
 ```
 ```json
{
    "code": 3,
    "msg": "手机号不能为空"
}
 ```
 
 
#### 忘记密码

> http://www.thmaoqiu.cn/saiyou/public/index.php/forgot

数据传输方式：POST

数据传输格式为：JSON


参数(类型) | 说明 | 示例
----|------|----
phone(string) | 传入手机号  | 12345678912
password(string) | 传入密码  | 12345678912

成功返回 
 ```json
{
    "code": 0,
    "msg": "密码重置成功"
}
 ```

失败返回
 ```json
{
    "code": 1,
    "msg": "密码不能为空"
}
 ```
 ```json
{
    "code": 2,
    "msg": "密码重置失败"
}
 ```
 #### 修改个人信息
 
> http://www.thmaoqiu.cn/saiyou/public/index.php/user/edit

数据传输方式：POST

数据传输格式为：JSON


参数(类型) | 说明 | 示例
----|------|----
phone(string) | 传入手机号  | 12345678912
name(string) | 传入姓名  | thth
gender(int) | 传入性别  | 男：0，女：1
major(string) | 传入专业  | 通信工程
grade(int) | 传入年级  | 2016
studentid(int) | 传入学号  | 20166666
good_at(string) | 传入擅长领域  | 后端开发
pic(file) | 传入用户头像  | C:\Users\hasee\Pictures\Camera Roll\1.jpg
glory_name(string) | 传入荣誉墙赛事名称  | 蓝桥杯
glory_time(string) | 传入荣誉墙获奖时间  | 2017
glory_pic(file) | 传入荣誉墙证书图片  | C:\Users\hasee\Pictures\Camera Roll\2.jpg

成功返回 
 ```json
{
    "code": 0,
    "msg": "修改用户信息成功"
}
 ```

失败返回
 ```json
{
    "code": 1,
    "msg": "修改用户信息失败"
}
 ```
 ```json
{
    "code": 2,
    "msg": "用户不存在"
}
 ```


 #### 显示个人信息
 
> http://www.thmaoqiu.cn/saiyou/public/index.php/user/show

数据传输方式：GET

数据传输格式为：JSON


参数(类型) | 说明 | 示例
----|------|----
phone(string) | 传入手机号  | 12345678912

成功返回 
 ```json
{
    "code": 0,
    "msg": "查询用户资料成功",
    "data": {
        "username": "maoqiu",
        "phone": "15076067012",
        "pic": "http://www.thmaoqiu.cn/saiyou/storage/app/pics/5a0c57e2759f2.jpg",
        "name": "thth",
        "major": "通信工程",
        "grade": 2016,
        "studentid": 20166666,
        "gender": 0,
        "good_at": "后端开发",
        "glory_name": "蓝桥杯,蓝桥杯",
        "glory_time": "2017,2017",
        "glory_pic": ",http://www.thmaoqiu.cn/saiyou/storage/app/glory_pics/5a0c57e273537.jpg"
    }
}
 ```

失败返回
 ```json
{
    "code": 1,
    "msg": "查询用户资料失败"
}
 ```
 
 ### 比赛轮播图
 
 #### 添加比赛轮播图
 
 
> http://www.thmaoqiu.cn/saiyou/public/index.php/carousel/add

数据传输方式：POST

数据传输格式为：JSON


参数(类型) | 说明 | 示例
----|------|----
carousel(file) | 传入轮播图文件  | C:\Users\hasee\Pictures\Camera Roll\1.jpg
order(string) | 传入轮播图序号  | 1

成功返回 
 ```json
{
    "code": 0,
    "msg": "轮播图添加成功"
}
 ```

失败返回
 ```json
{
    "code": 1,
    "msg": "轮播图添加失败"
}
 ```
 ```json
{
    "code": 2,
    "msg": "请插入轮播图"
}
 ```
```json
{
    "code": 3,
    "msg": "请输入序号"
}
 ```
```json
{
    "code": 4,
    "msg": "该序号已存在"
}
 ```
 
 
 #### 删除比赛轮播图
 
 
> http://www.thmaoqiu.cn/saiyou/public/index.php/carousel/del

数据传输方式：DELETE

数据传输格式为：JSON


参数(类型) | 说明 | 示例
----|------|----
order(string) | 传入图片序号  | 1

成功返回 
 ```json
{
    "code": 0,
    "msg": "删除轮播图成功"
}
 ```

失败返回
 ```json
{
    "code": 1,
    "msg": "删除轮播图失败"
}
 ```
```json
{
    "code": 3,
    "msg": "请输入序号"
}
 ```
```json
{
    "code": 4,
    "msg": "轮播图未找到"
}
 ```
 
 #### 查询比赛轮播图
  
  
 > http://www.thmaoqiu.cn/saiyou/public/index.php/carousel/show
 
 数据传输方式：GET
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
无 | 无  | 无
 
 成功返回
 (2条数据时)
  ```json
{
    "code": 0,
    "msg": "查询轮播图成功",
    "data": [
        {
            "order": 1,
            "url": "http://www.thmaoqiu.cn/poetry/storage/app/carousels/59f2fb29f3b6d.jpg"
        },
        {
            "order": 2,
            "url": "http://www.thmaoqiu.cn/poetry/storage/app/carousels/59f2ff70e9f2b.jpg"
        }
    ]
}
  ```
  (4条数据时)
  ```json
{
    "code": 0,
    "msg": "查询轮播图成功",
    "data": [
        {
            "order": 1,
            "url": "http://www.thmaoqiu.cn/poetry/storage/app/carousels/59f2fb29f3b6d.jpg"
        },
        {
            "order": 2,
            "url": "http://www.thmaoqiu.cn/poetry/storage/app/carousels/59f2ff70e9f2b.jpg"
        },
        {
            "order": 6,
            "url": "http://www.thmaoqiu.cn/poetry/storage/app/carousels/59f32dfc0240c.jpg"
        }
    ]
}
```
 
 失败返回
  ```json
 {
     "code": 1,
     "msg": "查询轮播图失败"
 }
  ```
  
 ### 比赛类别
 
 #### 添加比赛类别
 
> http://www.thmaoqiu.cn/saiyou/public/index.php/type/add

数据传输方式：POST

数据传输格式为：JSON


参数(类型) | 说明 | 示例
----|------|----
name(string) | 传入比赛类别  | 数学类
order(string) | 传入比赛序号  | 1

成功返回 
 ```json
{
    "code": 0,
    "msg": "添加比赛类别成功"
}
 ```

失败返回
 ```json
{
    "code": 1,
    "msg": "添加比赛类别失败"
}
 ```
```json
{
    "code": 2,
    "msg": "请输入比赛类型"
}
 ```
```json
{
    "code": 3,
    "msg": "请输入比赛序号"
}
 ```
```json
{
    "code": 4,
    "msg": "该比赛序号已存在"
}
 ```
 
  #### 删除比赛类别
  
 > http://www.thmaoqiu.cn/saiyou/public/index.php/type/del
 
 数据传输方式：DELETE
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
 name(string) | 传入比赛类别  | 数学类
 order(string) | 传入图片序号  | 1
 
 成功返回 
  ```json
 {
     "code": 0,
     "msg": "删除比赛类别成功"
 }
  ```
 
 失败返回
  ```json
 {
     "code": 1,
     "msg": "删除比赛类别失败"
 }
  ```
 ```json
 {
     "code": 2,
     "msg": "比赛类别未找到"
 }
  ```
 ```json
 {
     "code": 3,
     "msg": "请输入比赛序号"
 }
  ```
  
   #### 查询比赛类别
   
  > http://www.thmaoqiu.cn/saiyou/public/index.php/type/show
  
  数据传输方式：GET
  
  数据传输格式为：JSON
  
  
  参数(类型) | 说明 | 示例
  ----|------|----
  order(string) | 传入图片序号  | 1
  
  成功返回 
   ```json
{
    "code": 0,
    "msg": "查询比赛类别成功",
    "data": [
        {
            "name": "数学类",
            "order": 1
        },
        {
            "name": "编程类",
            "order": 2
        },
        {
            "name": "ssss类",
            "order": 3
        },
        {
            "name": "666类",
            "order": 4
        },
        {
            "name": "牛皮类",
            "order": 5
        },
        {
            "name": "bilibili类",
            "order": 6
        }
    ]
}
   ```
  
  失败返回
   ```json
  {
      "code": 1,
      "msg": "查询比赛类别失败"
  }
   ```

### 比赛详情

#### 添加比赛

 > http://www.thmaoqiu.cn/saiyou/public/index.php/desc/add
 
 数据传输方式：POST
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
 name(string) | 传入比赛名称  | emmm比赛
 desc(string) | 传入比赛具体信息  | 123456789098765432345678876543234567898765
 short_desc(string) | 传入简要比赛具体信息)  | 123456789
 registration_time(date) | 传入报名时间  | 2017/10/28(2017-10-28)
 competition_time(date) | 传入比赛时间  | 2017/10/28(2017-10-28)
 pic(file) | 传入比赛缩略图  | C:\Users\hasee\Pictures\Camera Roll\1.jpg
 type(string) | 传入比赛类别  | 数学类
 
 注:若参数未传，则默认为NULL
 
 成功返回 
  ```json
 {
     "code": 0,
     "msg": "创建比赛成功"
 }
  ```
 
 失败返回
  ```json
 {
     "code": 1,
     "msg": "创建比赛失败"
 }
  ```


#### 修改比赛

 > http://www.thmaoqiu.cn/saiyou/public/index.php/desc/edit
 
 数据传输方式：POST
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
 id(int) | 传入比赛id  | 1
 name(string) | 传入比赛名称  | emmm比赛
 desc(string) | 传入比赛具体信息  | 123456789098765432345678876543234567898765
 short_desc(string) | 传入简要比赛具体信息)  | 123456789
 registration_time(date) | 传入报名时间  | 2017/10/28(2017-10-28)
 competition_time(date) | 传入比赛时间  | 2017/10/28(2017-10-28)
 pic(file) | 传入比赛缩略图  | C:\Users\hasee\Pictures\Camera Roll\1.jpg
 type(string) | 传入比赛类别  | 数学类
 
 注:若参数未传则值不变
 
 成功返回 
  ```json
 {
     "code": 0,
     "msg": "修改比赛成功"
 }
  ```
 
 失败返回
  ```json
 {
     "code": 1,
     "msg": "修改比赛失败"
 }
  ```
  ```json
 {
     "code": 2,
     "msg": "比赛id不能为空"
 }
  ```
  
#### 删除比赛

 > http://www.thmaoqiu.cn/saiyou/public/index.php/desc/del
 
 数据传输方式：DELETE
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
 id(int) | 传入比赛id  | 1
 
 成功返回 
  ```json
 {
     "code": 0,
     "msg": "删除比赛成功"
 }
  ```
 
 失败返回
  ```json
 {
     "code": 1,
     "msg": "删除比赛失败"
 }
  ```
  ```json
 {
     "code": 2,
     "msg": "比赛id不能为空"
 }
  ```
  ```json
 {
     "code": 3,
     "msg": "该比赛id不存在"
 }
  ```

  
#### 查询单个比赛

 > http://www.thmaoqiu.cn/saiyou/public/index.php/desc/show
 
 数据传输方式：GET
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
 id(int) | 传入比赛id  | 5
 
 成功返回 
  ```json
{
    "code": 0,
    "msg": "查询成功",
    "data": {
        "id": 5,
        "name": "bilibili",
        "desc": "bbbbbbbbbbbbbb",
        "short_desc": "",
        "registration_time": "2017-10-01",
        "competition_time": "2017-10-30",
        "pic": "http://www.thmaoqiu.cn/saiyou/storage/app/competitions/59f43cdac4066.jpg"
    }
}
  ```
 
 失败返回
```json
 {
     "code": 2,
     "msg": "比赛id不能为空"
 }
```
```json
 {
     "code": 3,
     "msg": "该比赛id不存在"
 }
```

#### 查询多个比赛

 > http://www.thmaoqiu.cn/saiyou/public/index.php/descs/show
 
 数据传输方式：GET
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
 page(int) | 传入页数 | 1
 size(int) | 传入每页显示的数量 | 3
 
 成功返回 
  ```json
{
    "code": 0,
    "msg": "查询队伍成功",
    "data": {
        "totalCount": 1,
        "item": [
            {
                "id": 9,
                "name": "bilibili",
                "desc": "bbbbbbbbbbbbbb",
                "short_desc": "b123",
                "registration_time": "2017-10-01",
                "competition_time": "2017-10-30",
                "pic": "http://www.thmaoqiu.cn/saiyou/storage/app/competitions/59f4804f62901.jpg",
                "type": "bilibili类"
            }
        ]
    }
}
  ```
 
 失败返回
```json
 {
     "code": 1,
     "msg": "查询队伍失败"
 }
```

### 队伍详情

#### 添加队伍

 > http://www.thmaoqiu.cn/saiyou/public/index.php/team/add
 
 数据传输方式：POST
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
 team_name(string) | 传入队伍名称  | 毛球小队
 competition_type(string) | 传入比赛名称  | bilibili比赛
 project_name(string) | 传入项目名称  | 赛友
 declaration(string) | 传入队伍宣言  | 我们是最棒的！
 good_at(string) | 传入目标队员的擅长  | 前端开发,后端开发
 
 
 成功返回 
  ```json
 {
     "code": 0,
     "msg": "保存队伍信息成功"
 }
  ```
 
 失败返回
  ```json
 {
     "code": 1,
     "msg": "保存队伍信息失败"
 }
  ```
  
#### 修改队伍

 > http://www.thmaoqiu.cn/saiyou/public/index.php/team/edit
 
 数据传输方式：POST
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
 team_id(int) | 传入队伍id  | 4006134
 team_name(string) | 传入队伍名称  | 毛球小队
 competition_type(string) | 传入比赛名称  | bilibili比赛
 project_name(string) | 传入项目名称  | 赛友
 declaration(string) | 传入队伍宣言  | 我们是最棒的！
 good_at(string) | 传入目标队员的擅长  | 前端开发,后端开发
 
 
 成功返回 
```json
 {
     "code": 0,
     "msg": "修改队伍信息成功"
 }
```
 
 失败返回
```json
 {
     "code": 1,
     "msg": "修改队伍信息失败"
 }
```
```json
 {
     "code": 2,
     "msg": "队伍id不能为空"
 }
```
```json
 {
     "code": 3,
     "msg": "找不到该队伍id"
 }
```

#### 删除队伍

 > http://www.thmaoqiu.cn/saiyou/public/index.php/team/del
 
 数据传输方式：DELETE
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
 team_id(int) | 传入队伍id  | 4006134
 
 
 成功返回 
```json
 {
     "code": 0,
     "msg": "删除队伍成功"
 }
```
 
 失败返回
```json
 {
     "code": 1,
     "msg": "删除队伍失败"
 }
```
```json
 {
     "code": 2,
     "msg": "队伍id不能为空"
 }
```
```json
 {
     "code": 3,
     "msg": "找不到该队伍id"
 }
```

#### 查询单支队伍

 > http://www.thmaoqiu.cn/saiyou/public/index.php/team/show
 
 数据传输方式：GET
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
 team_id(int) | 传入队伍id  | 4006134
 
 
 成功返回 
```json
 {
     "code": 0,
     "msg": "查询队伍成功"
 }
```
 
 失败返回
```json
 {
     "code": 2,
     "msg": "队伍id不能为空"
 }
```
```json
 {
     "code": 3,
     "msg": "找不到该队伍id"
 }
```

#### 查询多支队伍

 > http://www.thmaoqiu.cn/saiyou/public/index.php/teams/show
 
 数据传输方式：GET
 
 数据传输格式为：JSON
 
 
 参数(类型) | 说明 | 示例
 ----|------|----
 page(int) | 传入第几页  | 2
 size(int) | 传入每页显示数量  | 8
 
 
 成功返回 
```json
{
    "code": 0,
    "msg": "查询队伍成功",
    "data": {
        "0": {
            "id": 8817871,
            "team_name": "毛球小队9",
            "competition_type": "bilibili比赛",
            "project_name": "赛友9",
            "declaration": "我们是最棒的！",
            "good_at": "前端开发,后端开发"
        },
        "totalCount": 1
    }
}
```
 
 失败返回
```json
 {
     "code": 1,
     "msg": "查询队伍失败"
 }
```
