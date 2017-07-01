<template>
	<div class="root machine_ls">
		<!--    nav   -->
			<x-header :left-options="{showBack: true}">工程详情
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>
		
		
		

		<!--   工程列表           -->

		<ul class="ls_wrap">
			<li>

				<h3>工程编号{{$route.params.ord_num}}</h3>
				<span class="ls_fr">{{$route.params.order}}</span>

			</li>
		</ul>
		<ul class="pro_ls">
			<li>
				<div>工程名称</div>
				<div>{{datas.uname}}</div>
			</li>
			<li>
				<div>工程位置</div>
				<div>{{datas.address}}</div>
			</li>
			<li>
				<div>建设单位</div>
				<div>{{datas.acompany}}</div>
			</li>
			<li>
				<div>监理单位</div>
				<div>{{datas.bcompany}}</div>
			</li>
			<li>
				<div>安监站</div>
				<div>{{datas.safe}}</div>
			</li>
			<li>
				<div>登记日期</div>
				<div>{{datas.time}}</div>
			</li>

		</ul>

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
				datas: {
					order: '0001',
					ord_num: 'GC13156',
					uname: '绿城.名荷苑',

					address: 'aa',
					acompany: '中国建筑 第十二工程局',
					bcompany: '江西方圆工程监理有限公司',
					safe: '江西省宜春市建筑工程安全监督管理站',
					time: '2017.02.28'

				}

			}

		},
		methods: {
			back: function() {
				window.history.back()
			}
		}
	}
</script>

<style scoped>

</style>