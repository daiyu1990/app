<template>
	<div class="root">
		<!--       导航          -->
			<x-header :left-options="{showBack: true}">消息详情
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>
		
	
		<!--     信息详情列表         -->
		<div class="mess_con">
			<div class="mess_top">
				<img src="../../static/flyda_img/mywork/1.png" class="active_btn" />
				<span>维修：超载保护器短接</span>
				<span class="fr"><img src="../../static/flyda_img/messlist/5.png"/>126</span>
			</div>
			<ul class="con_ls">
				<li>
					<span class="a_gray">故障描述</span>
					<span>超载保护器短接</span>
				</li>
				<li>
					<span class="a_gray">任务编号 </span>
					<span>0000010106</span>

				</li>
				<li>
					<span class="a_gray">任务级别</span>
					<span>低</span>

				</li>
				<li>
					<span class="a_gray">任务状态</span>
					<span>未开始</span>

				</li>
				<li>
					<span class="a_gray">开始时间</span>
					<span>2017-06-10  08:00</span>

				</li>
				<li>
					<span class="a_gray">结束时间</span>
					<span>2017-06-10  08:00</span>

				</li>
			</ul>
			<ul class="con_ls">
				<li>
					<span class="a_gray">设备编号</span>
					<span>TC00110206</span>
				</li>
				<li>
					<span class="a_gray">设备类型</span>
					<span>塔式起重机</span>

				</li>
				<li>
					<span class="a_gray">设备型号</span>
					<span>TXL-886</span>

				</li>
			<li>
					<span class="a_gray">设备地址</span>
					<span>dizhi</span>

				</li>
				<li>
					<span class="a_gray">联系人</span>
					<span>景泰男</span>

				</li>
				<li class="tel"><span class="a_gray">联系电话</span>
					<span>13658986566</span>
					<span class="fa fa-phone  active_btn"></span>

				</li>
				
			
			</ul>
			<button class="active_btn btn" type="button">任务受理</button>

		</div>

	</div>
</template>

<script>
import { XHeader } from 'vux';
	
	export default {
			components: {
			XHeader

		}
	}
</script>

<style scoped>
	.mess_con {
		padding: 10px;
	}
	
	.mess_top {
		position: relative;
		padding: 10px 0;
	}
	
	.mess_top>img {
		width: 30px;
	}
	
	.mess_top .fr {
		position: absolute;
		top: 12px;
		right: 5px;
		color: #C0C0C0;
	}
	
	.mess_top .fr>img {
		width: 15px;
	}
	
	
	
	.con_ls li {
		border: none;
	}
	
	.btn {
		width: 100%;
		height: 50px;
		margin: 30px auto;
	}
</style>