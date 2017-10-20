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
    "count": 1,
    "fee": 0.05,
    "unit": "RMB",
    "mobile": "12345678912",
    "sid": 18315909642,
    "captcha": 1162   //验证码
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
username(string) | 传入用户名  | 12345678912

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
    "msg": "微信号不能为空"
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