<template>
	<div class="page_root">
		<!--   导航              -->

		<x-header :left-options="{showBack: true}">消息提醒
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>

		<!--  报警按钮 ---选项卡-->
		<ul class="tab_ls">
			<li @click="toggle(index ,tab.view)" v-for="(tab,index) in tabs" :class="{active:active==index}">
				{{tab.type}}
			</li>
		</ul>
		<component :is="currentView"></component>

	</div>

</template>

<script>
	import MessonePage from '../components/mess/MessonePage'
	import MessotwoPage from '../components/mess/MessotwoPage'
	import MessthreePage from '../components/mess/MessthreePage'
	import MessfourPage from '../components/mess/MessfourPage'
	import { XHeader } from 'vux';
	export default {
		components: {
			XHeader

		},
		data: function() {
			return {
				active: 0,
				currentView: MessonePage,
				tabs: [{
						type: '任务提醒',
						view: MessonePage
					},
					{
						type: '通知',
						view: MessotwoPage
					},
					{
						type: '新闻资讯',
						view: MessthreePage
					},
					{
						type: '供求信息',
						view: MessfourPage
					}
				],

				isread: false,
				isStatus: true,
				src: '../assets/flyda_img/alertlist/1.1.png',

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
			//页面加载完成发送请求获取数据

		}
	}
</script>

<style scoped>
	.tab_ls {
		padding: 5px;
	}
	
	.tab_ls li {
		width: 24%;
	}
</style>