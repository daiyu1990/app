### 新建任务接口
- 请求 url `/Api/Mission/mission_add`
- 请求类型 POST
- 交互数据协议 JSON
- 请求参数

属性名|类型|说明
---- | --------- | ---------------------------------
name|String|任务名称
type|String|任务类型
level|String|任务级别
wenti|String|问题描述
start|String|任务开始时间
end|String|任务截止时间


- 返回内容

```
{
    "status": 1,
    "msg":'新建任务成功',
}
```

-状态说明
```
status为状态值，0 为失败，1为成功
msg为状态描述
```