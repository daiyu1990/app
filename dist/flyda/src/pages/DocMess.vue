<template>
	<div class="root machine">
			<!--    nav   -->
	<x-header :left-options="{showBack: true}">档案列表
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>

		
		<!--search -->

		<div class="search">
			<input type="text" name="" id="" value="" placeholder="输入搜索内容" />
			<button type="button" class="isblue active_btn">搜索</button>
		</div>

		<!--  按钮 ---选项卡-->
		<ul class="tab_ls">
			<li @click="toggle(index ,tab.view)" v-for="(tab,index) in tabs" :class="{active:active==index}">
				{{tab.type}}
			</li>
		</ul>
		<component :is="currentView"></component>
		
		
		
		
		
	</div>
</template>

<script>
	import { XHeader } from 'vux';
	
		import DocOne from '../components/doc/DocOne'
		import DocTwo from '../components/doc/DocTwo'
		import DocThree from '../components/doc/DocThree'
		import DocFour from '../components/doc/DocFour'
		

	
	export default {
			components: {
			XHeader

		},
		
		data: function() {
			return {
				active: 0,
				currentView: DocOne,

				tabs: [{
						type: '设备资料',
						view: DocOne
					},
					{
						type: '终端资料',
						view: DocTwo
					},
					{
						type: '企业资料',
						view: DocThree
					},
					{
						type: '备案信息',
						view: DocFour
					}
				],
			

			}
		},
		methods: {
			back: function() {
				window.history.back()
			}
			,
			toggle(i, v) {
				this.active = i
				this.currentView = v
			},
		
			
			
			
		},
	
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