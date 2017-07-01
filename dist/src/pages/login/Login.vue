<template>

	<div class="res_lo">
		<h2>建筑起重机械</h2>
		<div>安全监管物联网平台</div>

		<form id="form1" class="form-horizontal" role="form">

			<div class="form-group">
				<label class="col-xs-1 control-label"><img :src="user"/></label>
				<div class="col-xs-10">
					<input class="username text" id="login_username" type="text" placeholder="用户名或手机号" v-model='username'>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-1 control-label"><img :src="pwd"/></label>
				<div class="col-xs-10">
					<input class="password text" id='login_password' type="password" placeholder="密码" v-model='password'>
					<span class="forget">忘记密码</span>

				</div>

			</div>
			<!--<div class="form-group">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/ver.png"/></label>
				<div class="col-xs-10 code_v">
					<input id="login_code" name="verify" type="text" placeholder="请输入验证码" v-model='code'>
					<span class="code_set">
                                    <img :src="src" id='verify_img'  style="vertical-align: top;width: 80px;" @click='getvercode'><span id="msg_holder"></span>
					</span>
				</div>
			</div>-->
			<button type="submit" @click='login'>登录</button>
			<button type="button" class="wechat" ><span class="fa fa-wechat " style="font-size: 20px;margin-top: 3px;margin-right: 10px;"></span> 微信登录 </button>
			<!--weixin-->
			<!--<div id="weixin" style="display: none" class="detail_content">
				<form id="form2" action="#">
					<div class="login_welcome">
						<span>登录</span>
					</div>
				</form>
				<div class="weixin_block">
					<div class="weixin_content">
						<div>
							<img src="/Public/assets/images/login/check_code_img.png" alt="">
						</div>
						<p>微信扫一扫立即登录</p>
						<a class="come_user_page" href="#" @click='slidedown'>帐号登录</a>
					</div>
				</div>
			</div>-->

		</form>
		<div>还没有账号？
			<router-link to='/register'>
				<span class="links">点击注册</span>
			</router-link>

		</div>
	</div>

</template>

<script>import Qs from 'qs'

export default {

	data: function() {
		return {
			user: require('../../../static/flyda_img/login/users.png'),
			pwd: require('../../../static/flyda_img/login/pwd.png'),

			data: {

				status: '',
				img: ''

			},
			src: '',
			username: null,
			password: null,
			code: null

		}
	},
	methods: {
		//获取验证码
		getvercode: function() {
			var that = this

			$.ajax({
				url: 'urls/Login/verify_code',
				dataType: 'json',
				type: 'post',
				data: {

				},
				success: function(e) {

					if(e.status == 1) {
						that.src = e.img

					} else {

					}
					return false;
				}
			})

		},
		//获取微信
		slideup: function() {
			$('#person_user').slideUp(200);
			$('#weixin').slideDown(200);
		},
		slidedown: function() {
			$('#person_user').slideDown(200);
			$('#weixin').slideUp(200);
		},
		//登陆
		login(ev) {
			ev.preventDefault()
			var that = this
			var data = { 'username': that.username, 'password': that.password, 'code': that.code };
			//验证输入手机号
			if(!this.username) {
				//					Toast('请输用户名');
				alert('1')
				return;
			}
			//				if(!(/^1[358]\d{9}$/.test(this.tel))) {
			//					Toast('手机号输入有误');
			//					return;
			//				}
			if(!this.password) {
				alert('1')

				//					Toast('请输入密码');
				return;
			}
			if(!this.code) {
				alert('1')

				//					Toast('请输入验证码');
				return;
			}

			$.ajax({
				url: 'urls/Login/login',
				dataType: 'json',
				type: 'post',
				data: {
					'username': this.username,
					'password': this.password,
					'code': this.code,
				},
				success: function(e) {

					if(e.status == 1) {
						that.$router.push('/main');

					} else {

					}
					return false;
				}
			})

		}
	},
	mounted: function() {
		this.getvercode()

	}

}</script>

<style scoped>.codeImg {
	display: inline-block;
}

.wechat {
	background: #01C853;
	margin-bottom: 50px;
}

.forget {
	float: right;
	margin-top: -20px;
}

.red {
	border: 1px solid red;
	color: red;
}

.code_set {
	display: inline-block;
	margin-top: 22px;
}</style>