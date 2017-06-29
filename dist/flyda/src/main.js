// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'

//Vue.prototype.$ajax = axios
import { Actionsheet, AlertPlugin } from 'vux';
import FontAwesome from "./assets/Font-Awesome/css/font-awesome.css"
import './assets/css/common.css'
import './assets/js/validator.js'
//import './assets/bootstrap/css/bootstrap.css'
//import './assets/bootstrap/js/bootstrap.min.js'
//import './assets/bootstrap/css/bootstrap.min.css'
import 'bootstrap/js/jquery.js'

import 'bootstrap/css/bootstrap.min.css'
import 'bootstrap/css/bootstrap.css'
import 'bootstrap/js/bootstrap.min.js'

import axios from 'axios'
Vue.prototype.$http = axios;

//import Qs from 'qs'



//var axios_instance = axios.create({
//
//
//  transformRequest: [function (data) {
//      data = Qs.stringify(data);
//      return data;
//  }],
//
//  headers:{'Content-Type':'application/x-www-form-urlencoded'}
//})
//Vue.use(VueAxios, axios_instance)

//日历插件
import '../../Public/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js'
import '../../Public/assets/plugins/jquery-cookie/jquery.cookie.js'
import '../../Public/assets/plugins/slimscroll/jquery.slimscroll.min.js'
import '../../Public/assets/plugins/bootstrap-datepicker/css/datepicker.css'
import '../../Public/assets/plugins/bootstrap-datepicker/css/datepicker3.css'
import '../../Public/assets/plugins/gritter/css/jquery.gritter.css'
import '../../Public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
import '../../Public/assets/js/layer/layer.js'
import '../../Public/assets/js/nice-validator-0.8.1/jquery.validator.js'
import '../../Public/assets/js/nice-validator-0.8.1/local/zh-CN.js'
import '../../Public/assets/js/laydate/laydate.js'
import '../../Public/assets/js/jquery.form.js'
import '../../Public/assets/js/nice-validator-0.8.1/jquery.validator.css'
import '../../Public/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'
//日历插件
//import './Public/assets/js/layer/layer.js'
//import './Public/assets/js/jquery.form.js'
//import './Public/assets/plugins/jquery/jquery-migrate-1.1.0.min.js'
//import './Public/assets/js/jquery.form.js'
//import './Public/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js'
//import './Public/assets/js/jquery.form.js'
//import './Public/assets/plugins/slimscroll/jquery.slimscroll.min.js'
//import './Public/assets/plugins/jquery-cookie/jquery.cookie.js'
//import './Public/assets/js/apps.min.js'

//import './assets/js/moment.js'
//import './assets/js/bootstrap-datetimepicker.js'
//import './assets/css/styles.css'

//注册组件
Vue.component("Actionsheet", Actionsheet);

//注册插件
Vue.use(AlertPlugin);

import { AjaxPlugin } from 'vux'
Vue.use(AjaxPlugin)

//过滤器
import { isf, addPrefix, distanceFilter, blured } from 'utils/filters.js'
Vue.filter("isf", isf);
Vue.filter("addPrefix", addPrefix);
Vue.filter("distanceFilter", distanceFilter);
Vue.filter("blured", blured);
Vue.filter("degree", function(value) {
	if(value == 1) {
		return '一级报警';

	} else if(value == 2) {
		return '报警';

	} else {
		return '预警';

	}
});
Vue.filter("status", function(value) {
	if(value == 1) {
		return '在线';

	} else {
		return '离线';

	}
});
//fastclick
import fastClick from "fastclick";
document.addEventListener('DOMContentLoaded', function() {
	fastClick.attach(document.body);
}, false);

/* eslint-disable no-new */
new Vue({
	el: '#app',
	router,
	template: '<App/>',
	components: { App }
});

function calcRem() {
	var http = document.getElementsByTagName("html")[0];
	var w = document.documentElement.clientWidth;
	if(w < 320) {
		http.style.fontSize = "10px";
	} else if(w < 640) {
		http.style.fontSize = w / 32 + "px";
	} else {
		http.style.fontSize = "20px";
	}
}
calcRem();

var instance = axios.create({
	baseURL: 'http://crane.u-xuan.com'
});
//          登录
//    获取验证码动画
var giveCheckCode = {
	num: 60,
	timeSet: '',
	init: function() {
		var _this = this;
		$(document).on('click', '#phone_give_pass', function(e) {
			var phone = $('#person_phone').val();

			if(phone == '') {
				layer.msg('请填写手机号', { time: 1500 });
				return false;
			}
			var pattern = /^1[34578]\d{9}$/;

			if(pattern.test(phone) == false) {
				layer.msg('手机号码格式不正确', { time: 1500 });
				return false;
			}

			layer.load(1, {
				shade: [0.1, '#000'] //0.1透明度的白色背景
			});

			e.preventDefault();
			$(this).addClass('phone_give_pass_move');
			_this.resetMove(this);

			$.ajax({
				url: "{:U('Admin/Login/forgot')}",
				dataType: 'json',
				type: 'post',
				data: {
					do: 'send',
					mobile: phone
				},
				success: function(res) {
					if(res.status != 1) {
						layer.closeAll();
						layer.confirm(res.msg, {
							btn: ['确定'], //按钮
							closeBtn: 0
						}, function() {
							layer.closeAll();
							//                                // $('#username,#password,#verify').val('')
							//                                window.location.reload();
						});
					} else {
						layer.closeAll();
						_this.waitTime();
						$(this).prop('disabled', true);
					}
				}
			});

		})
	},
	resetMove: function(now) {
		setTimeout(function() {
			$(now).removeClass('phone_give_pass_move');
		}, 600);
	},
	waitTime: function() {
		this.timeSet = setInterval(function() {
			this.num--;
			$('#phone_give_pass').html('(' + this.num + 's)重新发送')
			if(this.num <= 0) {
				clearInterval(this.timeSet);
				$('#phone_give_pass').html('获取验证码');
				$('#phone_give_pass').prop('disabled', false);
				this.num = 60;
			}
		}.bind(this), 1000);
	}
}
window.onload = function() {
	giveCheckCode.init();
	$('#phone_give_pass').prop('disabled', false);
	$('body').addClass('set_come');
	//日历呈现

}

//登录   end

window.onresize = function() {
	calcRem();
}
$('.caldate').datepicker({})