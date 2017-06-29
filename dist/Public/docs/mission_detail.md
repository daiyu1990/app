### 任务详情接口
- 请求 url `/Api/Mission/mission_detail`
- 请求类型 POST
- 交互数据协议 JSON
- 请求参数

属性名|类型|说明
---- | --------- | ---------------------------------
id|Int|任务id
- 返回内容

```
{
    "status": 1,
    "msg":'获取数据成功',
    "data":{
            "id":任务id,
            "wenti":故障描述
            "code":任务编号,
            "level":任务级别,
            "status":任务状态,
            "start":开始时间,
            "end":结束时间,
            "facility_number":设备编号,
            "facility_type":设备类型,
            "facility_model_number":设备型号,
            "address":设备地址,
            "contact":联系人,
            "mobile":联系电话,
    }
}
```

-状态说明
```
status为状态值，0 为失败，1为成功
msg为状态描述
```