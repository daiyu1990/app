<template>
	<div class="root">
		<!--    首页发送请求获取数据，传值过来整体遍历数据 ,具体详情页数据是由此页面传值过去的        -->
	<!--    nav       -->
	<x-header :left-options="{showBack: true}">
		{{$route.params.model}}
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>
		<!--    选项卡         -->
		<div class="page_con">
			<ul class="tab_ls">
				<li @click="toggle(index ,tab.view)" v-for="(tab,index) in tabs" :class="{active:active==index}">
					{{tab.type}}
				</li>
			</ul>
			<component :is="currentView"></component>
		</div>
	</div>
</template>

<script>
	import OnePage from '../components/descrip/OnePage'
	import TwoPage from '../components/descrip/TwoPage'

	import ThreePage from '../components/descrip/ThreePage'
	import { XHeader } from 'vux';
	export default {
	components: {
			XHeader

	},
		data: function() {
			return {
				active: 0,
				currentView: OnePage,
				tabs: [{
						type: '一级报警',
						view: OnePage
					},
					{
						type: '报警',
						view: TwoPage
					},
					{
						type: '预警',
						view: ThreePage
					}
				],
				onels: {},
				twols: {},
				threels: {},
				cid: '',

				getBarWidth: function(index) {
					return(index + 1) * 22 + 'px'
				},
				datas: {
					// 根据机器型号发送请求（$route.params.model），获取数据，tab页面根据$parent获取主页面的数据
					cid: '001',
					alertR: {
						name: '1',
						num: '12',
						mes: [
							{ tit: '超载保护器短接', time: '08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' },
							{ tit: '超载保护器短接', time: ' 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' },
							{ tit: '幅度限位器报警', time: ' 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' },
							{ tit: '超载保护器短接', time: ' 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }

						]
					},
					alertO: { name: '2', num: '23', mes: [{ tit: '幅度限位器报警', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }, { tit: '高度预警', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }, { tit: '力矩限位器报警', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },
					alertG: { name: '3', num: '35', mes: [{ tit: '力矩限位器失效', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }] },

				}

			}
		},

		methods: {

			back: function() {
				window.history.back()
			},
			toggle(i, v) {
				this.active = i
				this.currentView = v
			}

		},
		created: function() {
			this.onels = this.datas.alertR
			this.twols = this.datas.alertO
			this.threels = this.datas.alertG
			this.cid = this.datas.cid

		}

	}
</script>

<style scoped>
	.bo_l {
		padding-left: 10px;
		border-left: 4px solid white;
	}
	
	.tit span {
		width: 20px;
		height: 20px;
		line-height: 20px;
		text-align: center;
		background: white;
		display: inline-block;
		border-radius: 50%;
		margin-left: 10px;
		font-size: 10px;
		font-weight: normal;
	}
	
	.mes_ls li {
		height: 40px;
		line-height: 40px;
		/*overflow: hidden;*/
		border-bottom: 1px solid gainsboro;
	}
	
	
	
	.mes_ls li>span:last-of-type {
		color: #CFCFCF;
		float: right;
		margin-top: -32px;
		margin-right: 30px;
		font-size: 1.6em;
	}
	
</style>