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

					<!--<img :src="../../static/flyda_img/mywork/ +{{info.mission_type}} +'.png'"/>-->
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
	import cal from '../cal.js'
	export default {
		components: {
			XHeader

		},
		//						img_url: '../../static/flyda_img/mywork/3.png'
		data: function() {
			return {
				data: [],
				time: ''
			}

		},

		created: function() {

		},

		methods: {
			getddata: function() {
				var that = this
				$.ajax({
					url: 'urls/Mission/my_mission',
					dataType: 'json',
					type: 'post',
					data: {
						date: this.time
					},
					success: function(e) {

						if(e.status == 1) {

							that.data = e.data

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
				alert(this.time)
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