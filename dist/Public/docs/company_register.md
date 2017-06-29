### 个人注册接口
- 请求 url `/Api/Login/person_register`
- 请求类型 POST
- 交互数据协议 JSON
- 请求参数

属性名|类型|说明
---- | --------- | ---------------------------------
mobile|String|注册手机号
msgcode|String|短信验证码
password1|String|密码
password2|String|确认密码
company_name|String|企业名称
code|String|组织机构代码
name|String|联系人姓名
email|String|联系人邮箱

- 返回内容

```
{
    "status": 1,
    "msg":'注册成功'
}
```

-状态说明
```
status为状态值，0 为失败，1为成功
msg为状态描述
```