<template>

	<div >

		<h3 class="alertO">报警 <span class="emp_100">{{datas.alertO.num}}</span>条</h3>
		<ul  class="con_ls">

			
			<li v-for='info in datas.alertO.mes'><span class="cir alertO"></span>
				<span >{{info.tit}}</span>
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
	export default {

		data: function() {
			return {
				datas: []

			}
		},
		methods: {
			getdata: function() {
				this.datas = this.$parent.datas

			}

		},
		created: function() {
			Window.onload = this.getdata()

		}
	}
</script>

<style scoped>
.ls_fr{
		top: 12px;
	}
</style>