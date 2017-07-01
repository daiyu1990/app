<template>
	<div class="res_lo">
		<h2>建筑起重机械</h2>
		<div>安全监管物联网平台</div>
		<router-link to='/person'>
			<button type="button" class="btn fir"> 
		<img src="../../../static/flyda_img/login/user.png"/>
		个人注册
	</button>
		</router-link>
		<router-link to='/company'>

			<button type="button" class="btn">
		<img src="../../../static/flyda_img/login/comp.png"/>
		企业注册
	</button>
			<p>已有账号
				<router-link to='/login'>
					<span class="links">立即登录</span>
				</router-link>
			</p>
		</router-link>

	</div>
</template>

<script>
	export default {
	
		
		
	}
</script>

<style scoped>
	.btn {
		height: 60px;
		line-height: 45px;
		width: 90%;
		margin: 25px auto;
		color: #2164ff;
		font-size: 20px;
		border-radius: 30px;
		background: white;
	}
	
	.fir {
		margin-top: 100px;
	}
	
	p {
		color: white;
	}
	
	.res_lo button img {
		width: 25px;
	}
</style>