<template>
	<div class=" root machine_ls">
		<!--    nav   -->
	<x-header :left-options="{showBack: true}">设备详情
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>

	

		<!--   工程列表           -->

		<ul class="pro_ls">
			<li>

				<h3>设备编号{{$route.params.ord_num}}</h3>
				<span >{{$route.params.order}}</span>

			</li>
		</ul>
		<ul class="pro_ls">
			<li>
				<h3 class="bor_left">基本信息</h3></li>
			<li>
				<div>设备状态</div>
				<div>{{datas.uname}}</div>
			</li>
			<li>
				<div>设备类型</div>
				<div>{{datas.address}}</div>
			</li>
			<li>
				<div>设备型号</div>
				<div>{{datas.acompany}}</div>
			</li>

		</ul>
		<ul class="pro_ls">
			<li>
				<h3 class="bor_left">设备参数</h3></li>
			<li>
				<div>最大起重</div>
				<div>{{datas.uname}}</div>
			</li>
			<li>
				<div>臂长</div>
				<div>{{datas.address}}</div>
			</li>
			<li>
				<div>尾臂长</div>
				<div>{{datas.acompany}}</div>
			</li>

		</ul>

		<ul class="pro_ls">
			<li>
				<h3 class="bor_left">关联信息</h3></li>
			<li>
				<div>产权编号</div>
				<div>{{datas.uname}}</div>
			</li>
			<li>
				<div>终端编号</div>
				<div>{{datas.address}}</div>
			</li>
			<li>
				<div>终端类型</div>
				<div>{{datas.acompany}}</div>
			</li>
			<li>
				<div>生产厂家</div>
				<div>{{datas.acompany}}</div>
			</li>
			<li>
				<div>工地名称</div>
				<div>{{datas.acompany}}</div>
			</li>
			<li>
				<div>工程地址</div>
				<div>{{datas.acompany}}</div>
			</li>
			<li>
				<div>施工单位</div>
				<div>{{datas.acompany}}</div>
			</li>
			<li>
				<div>项目经理</div>
				<div>{{datas.acompany}}</div>
			</li>
			<li>
				<div>联系电话</div>
				<div>{{datas.acompany}}</div>
			</li>
			<li>
				<div>产权单位</div>
				<div>{{datas.acompany}}</div>
			</li>
			<li>
				<div>监理单位</div>
				<div>{{datas.acompany}}</div>
			</li>
			<li>
				<div>安监站</div>
				<div>{{datas.acompany}}</div>
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