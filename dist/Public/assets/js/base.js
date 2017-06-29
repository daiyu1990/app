var Base = {
    ajax : function(options,loadingTar){
        var _this = this;
        var obj = {
            type : "POST",
            dataType : 'json'
        },options = options;
        var opts = $.extend({},obj,options);
        opts.success = function(data){
            var data = data;
            // loadingTar&&_this.unLoading(loadingKey);
            options.success&&options.success(data);
            // data.msg&&_this.tips(data.msg);
        };
        opts.error = function(){
            // loadingTar&&_this.unLoading(loadingKey);
            // _this.tips('something is wrong...');
        }
        // var loadingKey = loadingTar&&_this.loading(loadingTar);
        $.ajax(opts);
    },
	oLanguage: {
        "processing": "正在加载中......",
        "loadingRecords": "正在加载中......",
        "lengthMenu": "_MENU_",
        "zeroRecords": "抱歉，没有找到",
        "emptyTable": "查询无数据",
        "info": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
        "infoEmpty": "",
        "infoFiltered": "",
        "search": "搜索：",
        "searchPlaceholder":"请输入查询内容",
        "paginate": {
            "first": "首页",
            "previous": "上一页",
            "next": "下一页",
            "last": "末页"
        }
    },
    isURL: function (str_url){
        var strRegex = "^((https|http|ftp|rtsp|mms)?://)"
        + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@
        + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
        + "|" // 允许IP和DOMAIN（域名）
        + "([0-9a-z_!~*'()-]+\.)*" // 域名- www.
        + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名
        + "[a-z]{2,6})" // first level domain- .com or .museum
        + "(:[0-9]{1,4})?" // 端口- :80
        + "((/?)|" // a slash isn't required if there is no file name
        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";
        var re=new RegExp(strRegex);
        //re.test()
        if (re.test(str_url)){
            return (true);
        }else{
            return (false);
        }
    },
    getDateByType: function(type){
        switch(type){
            case 'today':
                return [moment().format('YYYY-MM-DD'),moment().format('YYYY-MM-DD')];
            case 'yesterday':
                return [moment().subtract(1,'days').format('YYYY-MM-DD'),moment().subtract(1,'days').format('YYYY-MM-DD')];
            case 'day_before_yesterday':
                return [moment().subtract(2,'days').format('YYYY-MM-DD'),moment().subtract(2,'days').format('YYYY-MM-DD')];
            case '7day':
                return [moment().subtract(6,'days').format('YYYY-MM-DD'),moment().format('YYYY-MM-DD')];
            case '30day':
                return [moment().subtract(29,'days').format('YYYY-MM-DD'),moment().format('YYYY-MM-DD')];
            case 'this_month':
                return [moment().startOf('month').format('YYYY-MM-DD'),moment().endOf('month').format('YYYY-MM-DD')];
        }
    },
}
