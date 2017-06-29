<template>
	<div class="res_lo">
		<h2>建筑起重机械</h2>
		<div>安全监管物联网平台</div>
		<form class="form-horizontal" id="form2">

			<div class="form-group">

				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/tel.png"/></label>
				<div class="col-xs-10">
					<input type="tel" name="text" id="" required value="" v-model='mobile' data-rule="手机号:required" pattern='^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$' placeholder="输入手机号" />

				</div>
			</div>

			<div class="form-group ">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/ver.png"/></label>
				<div class="col-xs-10 code_wrap">

					<input type="text" placeholder="请输入验证码" name="mobileCode" maxlength="6" v-model='msgcode' data-rule="验证码:required">
					<button @click.prevent="getVerifyCode" id='get_code'>获取验证码</button>

				</div>

			</div>
			<div class="form-group">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/pwd.png"/></label>
				<div class="col-xs-10">

					<input type="text" name="pwd1" id="" v-model='password1' required value="" pattern="^.{6}$" placeholder="输入6位字符密码" data-rule="密码:required" />

				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-1 control-label"><img src="../../../static/flyda_img/login/pwd.png"/></label>
				<div class="col-xs-10">

					<input type="text" require name="pwd2" id="" v-model='password2' value="" pattern="^.{6}$" placeholder="再次输入密码" data-rule="再次输入密码:required;match(password);" />

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
				this.$http({
					method: 'post',
					url: 'http://crane.u-xuan.com/Api/Login/sendMsgCode',
					data: {
						'mobile': that.mobile,

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
			submit: function() {
				var that = this
				if(that.mobile == '') {
					layer.msg('手机号不能为空', { time: 2000 });
					return false;
				}

				var pattern = /^1[34578]\d{9}$/;

				if(pattern.test(that.mobile) == false) {
					layer.msg('手机号码格式不正确', { time: 1500 });
					return false;
				}

				if(that.msgcode == '') {
					layer.msg('验证码不能为空', { time: 2000 });
					return false;
				}

				layer.load(1, {
					shade: [0.1, '#000'] //0.1透明度的白色背景
				});

				//				$.ajax({
				//					url: "http://crane.u-xuan.com/Api/Login/sendMsgCode",
				//					dataType: 'json',
				//					type: 'post',
				//					data: {
				//						do: 'check',
				//						'mobile': that.mobile,
				//						'msgcode': that.msgcode,
				//
				//					},
				//					success: function(res) {
				//						layer.closeAll();
				//						if(res.status != 1) {
				//							layer.msg(res.msg, { time: 2000 });
				//
				//						} else {
				//							layer.msg(res.msg, { time: 2000 });
				//							that.$router.push('/main')
				//
				//						}
				//					}
				//				});
				that.$http({
					method: 'post',
					url: 'http://crane.u-xuan.com/Api/Login/person_register',
					data: {
						do: 'check',
						'mobile': that.mobile,
						'msgcode': that.msgcode,

					},
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					}
				}).then(function(response) {
					alert(response.data.msg)
					that.$router.push('/main')

				}).catch(function(err) {
					alert(err.data.msg)
				})
				return false;

			}
		}
	}
</script>

<style scoped>

</style>