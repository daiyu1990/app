<template>
	<div>
			<!--    nav   -->
	<x-header :left-options="{showBack: true}">设备分布
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>
		
		
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