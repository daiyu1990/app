### 添加报修接口
- 请求 url `/Api/Mission/maintain_add`
- 请求类型 POST
- 交互数据协议 JSON
- 请求参数

属性名|类型|说明
---- | --------- | ---------------------------------
fac_code|String|设备编号
name|String|任务名称
address|String|设备地址
company_name|String|任务指派单位名称
wenti|String|问题描述
contact|String|联系人
mobile|String|联系人电话
start|String|任务开始时间
end|String|任务截止时间


- 返回内容

```
{
    "status": 1,
    "msg":'添加报修成功',
}
```

-状态说明
```
status为状态值，0 为失败，1为成功
msg为状态描述
```