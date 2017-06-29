### 备案信息接口
- 请求 url `/Api/File/fac_record`
- 请求类型 POST
- 交互数据协议 JSON
- 请求参数

属性名|类型|说明
---- | --------- | ---------------------------------
p|Int|页数


- 返回内容

```
{
    "status": 1,
    "msg":'获取备案信息成功',
    "data"{
        [
            "facility_number":设备编号,
            "is_record":是否备案,
            "equity_number":产权备案号,
        ]
    }
}
```

-状态说明
```
status为状态值，0 为失败，1为成功
msg为状态描述
```