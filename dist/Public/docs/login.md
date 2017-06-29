### 登录接口
- 请求 url `/Api/Login/login`
- 请求类型 POST
- 交互数据协议 JSON
- 请求参数

属性名|类型|说明
---- | --------- | ---------------------------------
username|String|登录用户名
passwod|String|登录密码
code|String|验证码

- 返回内容

```
{
    "status": 1,
    "msg":'登录成功'
}
```

-状态说明
```
status为状态值，0 为失败，1为成功
msg为状态描述
```