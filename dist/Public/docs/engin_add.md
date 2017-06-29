### 新增工程接口
- 请求 url `/Api/Engineering/engin_add`
- 请求类型 POST
- 交互数据协议 JSON
- 请求参数

属性名|类型|说明
---- | --------- | ---------------------------------
code|String|工程编号
name|String|工程名称
address|String|工程地址


- 返回内容

```
{
    "status": 1,
    "msg":'新增工程成功',
}
```

-状态说明
```
status为状态值，0 为失败，1为成功
msg为状态描述
```