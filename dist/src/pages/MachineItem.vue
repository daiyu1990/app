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

				<h3>{{datas.facility_number}}</h3>

			</li>
		</ul>
		<ul class="pro_ls">
			<li>
				<h3 class="bor_left">基本信息</h3></li>

			<li>
				<div>设备型号</div>
				<div>{{datas.facility_model_number}}</div>
			</li>
			<li>
				<div>设备类型</div>
				<div>{{datas.facility_type}}</div>
			</li>
			<li>
				<div>制造许可证号</div>
				<div>{{datas.manufacturing_licence_number}}</div>
			</li>
			<li>
				<div>出厂日期</div>
				<div>{{datas.factory_date}}</div>
			</li>
			<li>
				<div>登记日期</div>
				<div>{{datas.record_date}}</div>
			</li>
			<li>
				<div>设备制造单位</div>
				<div>{{datas.name}}</div>
			</li>
		</ul>
		<!--<ul class="pro_ls">
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

		</ul>-->

		<!--<ul class="pro_ls">
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

		</ul>-->

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
				datas: {},

			}

		},
		methods: {
			getddata: function() {

				var that = this
				$.ajax({
					url: 'urls/Facility/fac_detail',
					dataType: 'json',
					type: 'post',
					data: {
						id: this.$route.params.id
					},
					success: function(e) {

						if(e.status == 1) {

							that.datas = e.data

						} else {

						}
						return false;
					}
				})

			}

		},
		mounted() {

			this.getddata()

		}
	}
</script>

<style scoped>

</style>