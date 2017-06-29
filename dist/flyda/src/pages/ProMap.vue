<template>
	<div class="root">
			<!--    nav   -->
	<x-header :left-options="{showBack: true}">工程定位
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>

	
		<!--   -->
		<div>
			<p>保利麓谷林雨 <img src="../../static/flyda_img/prolist/2.png" alt="" /></p>
			<p>岳麓区桐梓西路608号</p>
			
		</div>
		
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

<style>
</style>