<template>
	<div class="res_lo">
		<h2>建筑起重机械</h2>
		<div>安全监管物联网平台</div>
		<form class="form-horizontal" id="form">

			<div class="form-group">

				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/tel.png"/></label>
				<div class="col-xs-10">
					<input type="tel" name="text" id="company_phone" required value="" v-model='company_phone' pattern='^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$' placeholder="输入手机号" />

				</div>
			</div>

			<div class="form-group ">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/ver.png"/></label>
				<div class="col-xs-10 code_wrap">

					<input type="text" placeholder="请输入验证码" name="mobileCode" maxlength="6" @input="checkVerifyCode" v-model='code'>
					<button @click.prevent="getVerifyCode" id='phone_give_pass'>获取验证码</button>

				</div>

			</div>
			<div class="form-group">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/pwd.png"/></label>
				<div class="col-xs-10">

					<input type="text" name="pwd1" id="" v-model='pwd1' required value="" pattern="^.{6}$" placeholder="输入6位字符密码" />

				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/pwd.png"/></label>
				<div class="col-xs-10">

					<input type="text" require name="pwd2" id="" v-model='pwd2' value="" pattern="^.{6}$" placeholder="再次输入密码" />

				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/coms.png"/></label>
				<div class="col-xs-10">

					<input type="text" require id="company" v-model='company' value="" placeholder="输入单位名称" />

				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/orag.png"/></label>
				<div class="col-xs-10">

					<input type="text" require id="company_code" v-model='company_code' value="" placeholder="输入机构代码" />

				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-1 control-label">
				<img src="../../../static/flyda_img/login/users.png"/>
					
				</label>
				<div class="col-xs-10">

					<input type="text" require name="company_contact" id="" v-model='company_contact' value="" placeholder="输入联系人姓名" />

				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/email.png"/></label>
				<div class="col-xs-10">

					<input type="email" require id="email" v-model='email' value="" placeholder="输入联系人邮箱" />

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
				company_phone: '',
				code: '',
				pwd1: '',
				pwd2: '',
				company: '',
				company_code: '',
				company_contact: '',
				email: ''
			}
		},

		methods: {
			//获取短信验证码
			getVerifyCode: function() {
				this.$http({
					method: 'post',
					url: 'http://crane.u-xuan.com/Api/Login/sendMsgCode',
					data: {
						'company_phone': that.company_phone,

					},
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					}
				}).then(function(response) {
					alert(response.data.msg)

				}).catch(function(err) {
					alert(err.data.msg)
				})

			},

			//提交表单
			submit: function() {
				var that = this

			}
		}
	}
</script>

<style scoped>

</style>