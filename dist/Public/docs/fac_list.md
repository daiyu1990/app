### 设备列表接口
- 请求 url `/Api/Facility/fac_list`
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
    "msg":'获取数据成功',
    "data":{
        [
            "id":设备id,
            "facility_number":设备编号,
            "equity_number":产权备案号,
            "is_on":在线／离线

        ]
    }
}
```

-状态说明
```
status为状态值，0 为失败，1为成功
msg为状态描述
```