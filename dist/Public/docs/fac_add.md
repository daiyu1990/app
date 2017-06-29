### 新增工程接口
- 请求 url `/Api/Facility/fac_add`
- 请求类型 POST
- 交互数据协议 JSON
- 请求参数

属性名|类型|说明
---- | --------- | ---------------------------------
code|String|设备编号
type|String|设备类型
xinghao|String|设备型号
xuke|String|制造许可证号


- 返回内容

```
{
    "status": 1,
    "msg":'新增设备成功',
}
```

-状态说明
```
status为状态值，0 为失败，1为成功
msg为状态描述
```