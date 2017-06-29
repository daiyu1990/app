import $ from 'webpack-zepto'

let API = {
    // api: 'http://api.insidersoft.com',
    api: '',
    //申请试用
    apply: '/Api/User/apply',
    //登陆
    login: '/Api/User/login',
    //退出登陆
    logout: '/Api/User/logout',
    //验证码生成
    verify_code: '/Api/User/verify_code',
    //忘记密码
    forget: '/Api/User/forget',

    //添加主题
    add_topic: '/Api/Topic/addTopic',
    //修改主题
    edit_topic: '/Api/Topic/editTopic',
    //删除主题
    del_topic: '/Api/Topic/delTopic',
    //主题排序
    sort_topic: '/Api/Topic/sort',
    //获取所有主题列表
    get_all_topic: '/Api/Topic/getAllTopic',
    //获取单个主题内容
    get_one_topic: '/Api/Topic/getOneTopic',
    //获取对应媒体的文章列表
    get_all_document: '/Api/Topic/getAllDocument',
    //获取文章详情
    get_article_detail: '/Api/Topic/getArticleDetail',


    //创建用户
    add_user: '/Api/CompanyUser/addUser',
    //删除用户
    del_user: '/Api/CompanyUser/delUser',
    //获取单个用户的详细信息
    get_user_info: '/Api/CompanyUser/userInfoById',
    //获取所有用户的详细信息
    get_all_user_info: '/Api/CompanyUser/userInfoList',
    //编辑用户
    edit_user: '/Api/CompanyUser/editUser',

    //添加订阅规则
    add_rule: '/Api/Subscription/addRule',
    //获取单个订阅规则
    get_rule: '/Api/Subscription/getRuleById',
    //编辑修改单个订阅规则
    edit_rule: '/Api/Subscription/setRuleById',
    //删除单个订阅规则
    del_rule: '/Api/Subscription/delRuleById',
    //开启关闭定时订阅规则
    set_state_rule: '/Api/Subscription/setStateById',
    //获取所有订阅规则
    get_rule_list: '/Api/Subscription/getRuleList',
    //获取接收订阅用户列表
    get_receiver_list: '/Api/Subscription/getReceiverList',
    //获取报告类型
    get_report_type: '/Api/Subscription/getReportType',
    //邮件预览接口
    preview: '/Api/Subscription/preview',

    //获取行业分类
    get_industry: '/Api/Industry/getIndustryTree',
    //获取用户信息
    get_login_info: '/Api/User/getUserInfo',


    //预警设置
    set_warning: '/Api/Warning/setWarning',
    //获取预警设置信息
    get_warning_set: '/Api/Warning/getWarningSet',
    //获取机器预警文章信息
    get_warning_rebot: '/Api/Warning/rebot',
    //获取转载量预警文章信息
    get_warning_social: '/Api/Warning/social',
    //关键词预警文章
    get_warning_keyword: '/Api/Warning/keywords',
    //设置文章已读
    set_read: '/Api/Topic/setRead',

    //导出数据
    export_data: '/Api/Topic/exportData',


}

let AJAX = function (url, type = "POST", sendData, callback, timeout) {
    console.log(sendData)
    $('#loading').show()
    $.ajax({
        data: sendData,
        url: API.api + url,
        type: type,
        timeout: timeout || 20000000,
        success: function (result) {
            $('#loading').hide()
            console.log(result)
            if (result.msg == "请先登录系统！") {
                location.href = '/Public/web/public/login.html#!/login'
            } else {
                callback(result)
            }
        },
        complete: function (XMLHttpRequest, status) {
            if (status == 'timeout') {
                $('#loading').hide()
                layer.msg('网络出了点小故障，请稍后再试~~')
            }
        }
    })
}

export {AJAX, API} ;
