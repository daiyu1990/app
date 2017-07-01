<template>
	<div class="root">

		<x-header :left-options="{showBack: true}">我的任务
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>

		<!--    日历       -->
		<div class="caldate"></div>

		<!--    今日任务     -->
		<ul class="con_ls">
			<li class="ls_head">

				<span class="ls_tit">
					 今日任务<span>{{'2017.02.10'}}</span>
				</span>
				<span class="ls_fr">
	             <router-link to='/addwork'>
						<img src="../../static/flyda_img/mywork/5.png"/><span class="isblue">添加任务</span>
				</router-link>
				</span>
			</li>
			<router-link :to="'/workmodel/' +info.id" v-for='info in data'>

				<li>

					<span class="ls_fl">

					<img :src="info.mission_type"/>
					{{info.code }}{{info.name}}</span>
					<span class="ls_fr">
					<span>{{info.start}}</span>&#x3000;
					<span class="fa fa-angle-right font20"></span>
					</span>
				</li>
			</router-link>

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
				data: [],
				time: '2017-06-27 00:00:00'
			}

		},

	
		methods: {
			getddata: function() {
				var that = this
				$.ajax({
					url: 'urls/Mission/my_mission',
					dataType: 'json',
					type: 'post',
					data: {
						date: that.time
					},
					success: function(e) {

						if(e.status == 1) {

							that.data = e.data
							for(var i = 0; i < that.data.length; i++) {
								that.data[i].mission_type = '../../static/flyda_img/mywork/' + that.data[i].mission_type + '.png'

							}

						} else {

						}
						return false;
					}
				})

			},
			gettime: function() {
				var date = new Date()
				var month = (date.getMonth() + 1) < 10 ? ('0' + (date.getMonth() + 1)) : (date.getMonth() + 1)
				this.time = date.getFullYear() + '-' + month + '-' + date.getDate()
				this.time = JSON.stringify(this.time)
				console.log(this.time)
			}

		},
		mounted() {
			this.gettime()
			$('.caldate').datepicker({})

			this.getddata()

		}
	}
</script>

<style scoped>
	.caldate {
		width: 100%;
	}
	
	.font20 {
		font-size: 20px;
	}
</style>