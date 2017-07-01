<template>
	<div class="page_root root">
	<x-header :left-options="{showBack: true}">工程详情
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>
	

		<!--<div :class="{alertG:isG, alertO:isO,alertR:isR}">{{datas.model}}</div>-->
		<!--     数据传输如何传输的     ？？？-->
		<div class="des_con">
			<h4 class="default_btn btns">塔机编号：{{datas.model}}</h4>
			<ul v-for='info in datas.alertR.mes' class="con_ls">
				<!--<li><span class="a_gray">产权编号</span> <span>{{$route.params.tit}}</span></li>-->
				<li> <span class="a_gray">发生时间</span> <span>{{info.nums}}</span></li>



				<li> <span class="a_gray">工程名称</span ><span>{{info.case}}</span></li>

				<li><span class="a_gray">操作员</span><span>{{info.person}}</span></li>
				<li class="tel"><span class="a_gray">联系电话</span><span>{{info.tel}}</span>
					<span class="fa fa-phone  active_btn"></span>

				</li>

			</ul>
			<!--    具体详情页面        -->

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
	import DesonePage from '../components/desmodel/DesonePage'
	import DestwoPage from '../components/desmodel/DestwoPage'
	import DesthreePage from '../components/desmodel/DesthreePage'
	import { XHeader } from 'vux';
	export default {
			components: {
			XHeader

	},
		data: function() {
			return {
				active: 0,
				currentView: DesonePage,
				tabs: [{
						type: '实时数据',
						view: DesonePage
					},
					{
						type: '工程信息',
						view: DestwoPage
					},
					{
						type: '地图',
						view: DesthreePage
					}
				],

				datas: {
					model: '1012TC011001761',
					cid: '001',
					alertR: { name: '1', num: '12', mes: [{ tit: '超载保护器短接', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }], mestwo: [{ num: '86963869', uname: '深圳市福田区双李阜名禾苑二期3幢', adress: '深圳市福田区', a_unit: '中国建筑集团第十二建筑局', b_unit: '湖北方圆工程监理有限公司', safty: '湖北省武汉市建筑工程安全监督管理站' }] },
					alertO: { name: '2', num: '23', mes: [{ tit: '幅度限位器报警', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }, { tit: '高度预警', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }, { tit: '力矩限位器报警', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }], mestwo: [{ num: '86963869', uname: '深圳市福田区双李阜名禾苑二期3幢', adress: '深圳市福田区', a_unit: '中国建筑集团第十二建筑局', b_unit: '湖北方圆工程监理有限公司', safty: '湖北省武汉市建筑工程安全监督管理站' }] },
					alertG: { name: '3', num: '35', mes: [{ tit: '力矩限位器失效', time: '2017.02.28 08:52:32', address: '深圳市福田区双李阜名禾苑二期3幢', case: '绿城.名荷苑', nums: '1#塔机', person: '景泰男', tel: '13566689632', moment: '8.21', weight: '0.19', wind: '0.4', range: '29.6', height: '7.9', return: '194.7', body: '0' }], mestwo: [{ num: '86963869', uname: '深圳市福田区双李阜名禾苑二期3幢', adress: '深圳市福田区', a_unit: '中国建筑集团第十二建筑局', b_unit: '湖北方圆工程监理有限公司', safty: '湖北省武汉市建筑工程安全监督管理站' }] },

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

		}

	}
</script>

<style scoped>
.btns{
	color: black;
	font-size: 13px;
	font-weight: bold;
}


</style>