<template>
	<div class="root">
		<!--       导航          -->
			<x-header :left-options="{showBack: true}">任务详情
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
					<span class="a_gray">工地名称</span>
					<span>绿城名荷苑</span>

				</li>
				<li>
					<span class="a_gray">工程地址</span>
					<span>湖北省武汉市武昌区</span>

				</li>
				<li>
					<span class="a_gray">联系人</span>
					<span>景泰男</span>

				</li>
				<li class="tel"><span class="a_gray">联系电话</span>
					<span>13658986566</span>
					<span class="fa fa-phone  active_btn"></span>

				</li>
				<li>
					<span class="a_gray">报修人</span>
					<span>李太园</span>

				</li>
				<li class="tel"><span class="a_gray">报修人电话</span>
					<span>13658986566</span>
					<span class="fa fa-phone  active_btn"></span>

				</li>
				</li>

				</li>
				<li>
					<span class="a_gray">故障图片</span>
					<span>
					<span>点击查看</span>
					<span>(无图片时显示--)</span>
					</span>

				</li>
			</ul>
			<div class="btn_wrap">
				<button class="active_btn btn" type="button">提醒设置</button>
				<button class="active_btn btn" type="button">线路规划</button>
				<router-link to='/subwork'>
					<button class="active_btn btn" type="button">任务填报</button>
				</router-link>
			</div>
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
		height: 40px;
		line-height: 40px;
		background: #FFFFFF;
	}
	
	.mess_top>img {
		width: 30px;
	}
	
	.mess_top .fr {
		position: absolute;
		bottom: 5px;
		right: 5px;
		color: #C0C0C0;
	}
	
	.mess_top .fr>img {
		width: 15px;
	}
	
	.con_ls li {
		border: none;
	}
	
	.btn_wrap {
		display: flex;
		flex-wrap: nowrap;
		justify-content: space-between;
	}
	
	.btn_wrap .btn {
		width: 30vw;
		height: 40px;
		margin: 30px auto;
	}
</style>