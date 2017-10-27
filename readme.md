## 赛友

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

注册成功返回 
 ```json
{
    "code": 0,
    "msg": "登录成功"
}
 ```

注册失败返回
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

注册成功返回 
 ```json
{
    "code": 0,
    "msg": "密码重置成功"
}
 ```

注册失败返回
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
 
 ### 比赛轮播图
 
 #### 添加比赛轮播图
 
 
> http://www.thmaoqiu.cn/saiyou/public/index.php/carousel/add

数据传输方式：POST

数据传输格式为：JSON


参数(类型) | 说明 | 示例
----|------|----
carousel(file) | 传入图片文件  | C:\Users\hasee\Pictures\Camera Roll\1.jpg
order(string) | 传入图片序号  | 1

注册成功返回 
 ```json
{
    "code": 0,
    "msg": "轮播图添加成功"
}
 ```

注册失败返回
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

注册成功返回 
 ```json
{
    "code": 0,
    "msg": "删除轮播图成功"
}
 ```

注册失败返回
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
 
 注册成功返回
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
 
 注册失败返回
  ```json
 {
     "code": 1,
     "msg": "查询轮播图失败"
 }
  ```