<template>
	<div>
		
		<div class="hd_nav">
			<span class=" fa fa-angle-left  fl" @click='back()'></span>
			<h4>新闻资讯</h4>
			<router-link to='/main'>

				<span>
			<img src="../../assets/flyda_img/alertlist/home.png"/>
			</span>
			</router-link>

		</div>
	</div>
</template>

<script>
	export default {
			methods: {

			back: function() {
				window.history.back()
			}
			
		}
	}
</script>

<style>
</style>