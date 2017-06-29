<template>
	<div class="root">
				<!--    nav   -->
	<x-header :left-options="{showBack: true}">更多功能
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>

		
		<ul >
			<li class="bot_one"><img src="../../static/flyda_img/moreuse/1.png"/>人员列表</li>
			<li class="bot_one"><img src="../../static/flyda_img/moreuse/2.png"/>配件列表</li>
			<li class="bot_two"><img src="../../static/flyda_img/moreuse/3.png"/>信息发布</li>
			<li class="bot_two"><img src="../../static/flyda_img/moreuse/4.png"/>设备分布</li>
			<li class="bot_one"><img src="../../static/flyda_img/moreuse/5.png"/>远程锁机</li>
			<li class="bot_one"><img src="../../static/flyda_img/moreuse/6.png"/>远程配置</li>
			<li class="bot_one"><img src="../../static/flyda_img/moreuse/7.png"/>考勤打卡</li>
		
			<li class="bot_one"><img src="../../static/flyda_img/moreuse/8.png"/>知识库</li>
			<li class="bot_one"><img src="../../static/flyda_img/moreuse/9.png"/>问卷调查</li>
			<li><img src="../../static/flyda_img/moreuse/10.png"/>客户服务</li>

		</ul>

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

<style scoped>.root {
	height: 100vh;
	background: #F0EFEE;
	font-size: 1.5rem;
}

ul {
	padding: 10px;
	display: flex;
	justify-content: space-between;
	flex-wrap: wrap;
}

li {
	background: white;
	width: 49%;
	height: 20vw;
	line-height: 20vw;
	text-align: center;
	margin-bottom: 2vw;


}

li span {
	margin-right: 10px;
}



img{
	width: 25px;
	margin-right: 5px;
}
</style>