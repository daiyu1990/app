// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'

import router from './router'
import VueResource from 'vue-resource'
//Vue.prototype.$ajax = axios

import FontAwesome from "./assets/Font-Awesome/css/font-awesome.css"
import './assets/css/common.css'
import './assets/js/validator.js'
//import './assets/js/vuxloader.js'
import 'bootstrap/js/jquery.js'

import 'bootstrap/css/bootstrap.min.css'
import 'bootstrap/css/bootstrap.css'
import 'bootstrap/js/bootstrap.min.js'
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
//import '../../Public/assets/js/laydate/laydate.js'
import '../../Public/assets/js/jquery.form.js'
import '../../Public/assets/js/nice-validator-0.8.1/jquery.validator.css'
import '../../Public/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js'




Vue.use(VueResource);

//过滤器
//import { isf, addPrefix, distanceFilter, blured } from 'utils/filters.js'

//Vue.filter("degree", function(value) {
//	if(value == 1) {
//		return '一级报警';
//
//	} else if(value == 2) {
//		return '报警';
//
//	} else {
//		return '预警';
//
//	}
//});
//Vue.filter("status", function(value) {
//	if(value == 1) {
//		return '在线';
//
//	} else {
//		return '离线';
//
//	}
//});
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

window.onresize = function() {
	calcRem();
}