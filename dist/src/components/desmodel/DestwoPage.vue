<template>
	<div class="des_two">

		<ul v-for='info in datas.alertR.mes' class="con_ls">
			<!--<li><span class="a_gray">工程编号</span> <span>{{$route.params.tit}}</span></li>-->
			<li> <span class="a_gray">工程名称</span> <span>{{info.nums}}</span></li>

			<li><span class="a_gray">工程地址</span><span> {{info.time}}</span></li>

			<li> <span class="a_gray">施工单位</span ><span>{{info.case}}</span></li>

			<li><span class="a_gray">监理单位</span><span>{{info.person}}</span></li>
			<li><span class="a_gray">安监站</span><span>{{info.tel}}</span></li>

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

<style>

</style>