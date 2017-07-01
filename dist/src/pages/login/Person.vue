<template>
	<div class="res_lo">
		<h2>建筑起重机械</h2>
		<div>安全监管物联网平台</div>
		<form class="form-horizontal" id="form2">

			<div class="form-group">

				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/tel.png"/></label>
				<div class="col-xs-10">
					<input type="tel" name="text" id="" required value="" v-model='mobile'  pattern='^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$' placeholder="输入手机号" />

				</div>
			</div>

			<div class="form-group ">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/ver.png"/></label>
				<div class="col-xs-10 code_wrap">

					<input type="text" placeholder="请输入验证码" name="mobileCode" maxlength="6" v-model='msgcode' >
					<button @click="getVerifyCode" id='get_code'>获取验证码</button>

				</div>

			</div>
			<div class="form-group">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/pwd.png"/></label>
				<div class="col-xs-10">

					<input type="text" name="pwd1" id="" v-model='password1' required value="" pattern="^.{6}$" placeholder="输入6位字符密码" />

				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/pwd.png"/></label>
				<div class="col-xs-10">

					<input type="text" required  name="pwd2" id="" v-model='password2' value="" pattern="^.{6}$" placeholder="再次输入密码"  />

				</div>
			</div>

			<button type="submit" @click='submit'>注册</button>

		</form>

	</div>

</template>

<script>
	export default {
		data: function() {
			return {
				mobile: '',
				msgcode: '',
				password1: '',
				password2: ''

			}
		},

		methods: {
			//获取短信验证码
			getVerifyCode: function() {
				$.ajax({
					url: 'urls/Login/sendMsgCode',
					dataType: 'json',
					type: 'post',
					data: {
						mobile:  this.mobile
					},
					success: function(e) {

						if(e.status == 1) {


							

						} else {

						}
						return false;
					}
				})

			},
			submit: function() {
				var that = this
				if(that.mobile == '') {

					return false;
				}

				var pattern = /^1[34578]\d{9}$/;

				if(pattern.test(that.mobile) == false) {

					return false;
				}

				if(that.msgcode == '') {

					return false;
				}

				layer.load(1, {
					shade: [0.1, '#000'] //0.1透明度的白色背景
				});

				
			
			
			
			
			
				return false;

			}
		}
	}
</script>

<style scoped>

</style>