<template>
	<div>

		<h3 class="alertR">一级报警信息 <span class="emp_100">{{datas.alertR.num}}</span>条</h3>
		<ul class="con_ls">

			<li @click='rem(index)' v-for='(info,index) in datas.alertR.mes'><span class="cir "></span>

				<span>{{info.tit}}</span>
				<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">

					<span class="ls_fr">{{info.time}}
					<span class="fa fa-angle-right"></span>
					</span>
				</router-link>
			</li>
		</ul>

	</div>
</template>

<script>
	import { XHeader, Group, Cell } from 'vux';

	export default {
		components: {
			XHeader,

			Group,
			Cell,

		},
		data: function() {
			return {

				datas: [],
				addressData: 'ChinaAddressData',
				addressValue: ['广东省', '深圳市', '南山区'],
				value1: '张三',
				value2: '工艺技术',
				value3: '',
				value7: '',
				value8: '',
				value4: '',
				time1: '2017-06-01',
				value5: ['A'],
				value6: [],
				list: ['A', 'B', 'C'],
				numberValue: 0

			}
		},
		methods: {
			getdata: function() {
				this.datas = this.$parent.datas

			},
			rem: function(ins) {
				$('.con_ls>li')[ins].find('span').eq(0).removeClass('alertR')

			}

		},
		created: function() {
			Window.onload = this.getdata()

		}
	}
</script>

<style>
	.ls_fr {
		top: 12px;
	}
</style>