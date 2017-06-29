### 设备详情接口
- 请求 url `/Api/Facility/fac_detail`
- 请求类型 POST
- 交互数据协议 JSON
- 请求参数

属性名|类型|说明
---- | --------- | ---------------------------------
id|Int|设备id
- 返回内容

```
{
    "status": 1,
    "msg":'获取数据成功',
    "data":{
            "id":设备id,
            "facility_number":设备编号
            "facility_model_number":设备型号,
            "facility_type":设备类型,
            "manufacturing_licence_number":制造许可证号,
            "factory_date":出厂日期,
            "record_date":登记日期,
            "name":设备制造单位,

    }
}
```

-状态说明
```
status为状态值，0 为失败，1为成功
msg为状态描述
```