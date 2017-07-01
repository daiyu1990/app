<!--//首页-->

<template>
	<div class="page_root a_gray">
		<x-header :left-options="{showBack: true}">报警提醒
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>

		<!--    报警按钮     -->
		<div class="active_btn btn_tit">
			<span class="fa fa-angle-left"></span>
			<div>
				<p>100条</p>
				<p>2017-6-16</p>
			</div>
			<span class="fa fa-angle-right"></span>
		</div>

		<!--    报警按钮  end   -->

		<!--报警信息列表-->
		<ul class="alert_list" v-for='info in locatAlert'>
			<router-link :to="'/desCrip/'+info.cid+'/'+info.model">
				<li class="alert_li" @click='info.isread = true'>
					<div class="mac_img b_gray">
						<!--    图片路径含有两个部分：机型和状态   拼接字符串-->
						<!--<img :src="{{src}}{{info.status}}'.png'}}" alt="" />-->
						<!--<img :src="src" />-->
						<img src="../assets/flyda_img/alertlist/1.1.png" />
						<span :class="{ 'active_btn':(info.status == 1)}">{{info.status | status}}</span>

					</div>
					<div class="alert_con">
						<div class="alert_bot">
							<span class="a_gray_b">{{info.size}}</span>
							<span :class=" {active_btn:true, mar_top:true}" v-if='info.isread'>未读</span>
							<span class="default_btn mar_top" v-if='!info.isread'>已读</span>

						</div>
						<ul :class="[{'read':isread},{'a_gray':true}]">
							<li>
								<p class="alert_R">{{info.alertR.num}}</p>
								<p>一级报警</p>
							</li>
							<li>
								<p class="alert_O">{{info.alertO.num}}</p>
								<p>报警</p>
							</li>
							<li>
								<p class="alert_G">{{info.alertG.num}}</p>
								<p>预警</p>
							</li>
						</ul>
						<div class="bot_con">
							<span class="a_gray_b">{{info.address}}</span>
							<span>{{info.case}}</span>
						</div>
					</div>

				</li>
			</router-link>
		</ul>
		<!--报警信息列表  end-->

	</div>

</template>

<script>
	import { XHeader } from 'vux';

	export default {
		components: {
			XHeader

		},
		data: function() {
			return {
				isread: false,
				isStatus: true,
				src: '../assets/flyda_img/alertlist/1.1.png',
				locatAlert: [{
						src: '../../static/img/index1.png',
						model: '1012TC011001761',
						cid: '001',
						alertR: { name: '1', num: '12', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						alertO: { name: '2', num: '23', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }, { tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }, { tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						alertG: { name: '3', num: '35', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						size: '赣AA-T0805',
						status: '2',
						machine: '1',
						address: '湖北武汉',
						case: '金城国际中心K2项目',
						isread: false

					},
					//					{
					//						machine: '1',
					//						status: '1',						
					//						model: '1012TC011001761',
					//						cid: '002',
					//						size: '赣AA-T0805',
					//						address: '湖北武汉',
					//						case: '金城国际中心K2项目'
					//
					//					},
					{
						src: '../../static/img/index1.png',
						model: '1012TC011001761',
						cid: '003',
						alertR: { name: '1', num: '12', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						alertO: { name: '2', num: '23', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						alertG: { name: '3', num: '35', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						size: '赣AA-T0805',
						status: '1',
						machine: '2',
						address: '湖北武汉',
						case: '金城国际中心K2项目',
						isread: true

					},
					{
						src: '../../static/img/index1.png',
						model: '1012TC011001761',
						cid: '004',
						alertR: { name: '1', num: '12', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						alertO: { name: '2', num: '23', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						alertG: { name: '3', num: '35', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						size: '赣AA-T0805',
						status: '1',
						machine: '2',
						address: '湖北武汉',
						case: '金城国际中心K2项目',
						isread: true

					},
					{
						src: '../../static/img/index1.png',
						model: '1012TC011001761',
						cid: '005',
						alertR: { name: '1', num: '12', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						alertO: { name: '2', num: '23', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						alertG: { name: '3', num: '35', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
						size: '赣AA-T0805',
						status: '2',
						machine: '2',
						address: '湖北武汉',
						case: '金城国际中心K2项目',
						isread: true

					}

				]

			}
		},

		methods: {

			back: function() {
				window.history.back()
			}
		},
		created: function() {
			//页面加载完成发送请求获取数据

		}
	}
</script>

<style scoped>
	.page_root {
		font-size: 14px;
	}
	
	ul {
		color: #333;
		margin: 0;
	}
	
	.mac_img span {
		background-color: #808080;
	}
</style>