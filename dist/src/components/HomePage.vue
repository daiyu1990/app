<!--//首页-->

<template>
	<div class="page_root">

		<!--<x-header :left-options="{showBack: false}" title='建筑起重机械安全监管物联网平台'></x-header>-->
		<div class="hd_nav">

			<h4>建筑起重机械安全监管物联网平台</h4>

		</div>

		<!--    swipper  -->

		<div class="swiper">

			<swiper auto loop dots-position="center" style="height: 150px;">
				<swiper-item class="black"><img src="../../static/flyda_img/home/0banner.png" /></swiper-item>
				<swiper-item class="black"><img src="../../static/flyda_img/home//0banner.png" /></swiper-item>
				<swiper-item class="black"><img src="../../static/flyda_img/home//0banner.png" /></swiper-item>

			</swiper>
		</div>
		<!--    swipper end -->
		<!--   list-Item-->
		<div class="home_wrap">

			<ul class="list">

				<router-link to="alertpage">

					<li class="home_fir_li">
						<p class="home_fir_p">
							<span class="alertR">{{report_warn.sumalertR}}</span>
							<!--<span class="alertO">{{report_warn.sumalertO}}</span>-->
							<!--<span class="alertG">{{report_warn.sumalertG}}</span>-->

						</p>
						<img src="../../static/flyda_img/home/1.png" />

						<p>报警提醒</p>

					</li>
				</router-link>

				
				<router-link to='messPage'>

					<li class="home_fir_li">
						<p class="home_fir_p">
							<span class="alertR">{{mess_warn.sumalertR}}</span>
							<!--<span class="alertO">{{mess_warn.sumalertO}}</span>-->
							<!--<span class="alertG">{{mess_warn.sumalertG}}</span>-->

						</p>
						<img src="../../static/flyda_img/home/2.png" />
						<p>消息提醒</p>

					</li>
				</router-link>

				<li>
					<img src="../../static/flyda_img/home/3.png" />
					<p>实时监控</p>

				</li>
			</ul>
				
			<ul class="list">
				
				<router-link to='project'>

					<li>
						<img src="../../static/flyda_img/home/4.png" />
						<p>工程信息</p>

					</li>
				</router-link>
				<router-link to='machine'>

					<li>
						<img src="../../static/flyda_img/home/5.png" />
						<p>设备信息</p>

					</li>
				</router-link>
				<router-link to='docmess'>

					<li>
						<img src="../../static/flyda_img/home/6.png" />
						<p>档案信息</p>

					</li>
				</router-link>
			</ul>
				
			<ul class="list">
				<router-link to='/WorkPage'>

					<li>
						<img src="../../static/flyda_img/home/7.png" />
						<p>我的任务</p>

					</li>
				</router-link>
				<li>
					<img src="../../static/flyda_img/home/8.png" />
					<p>汇总统计</p>

				</li>
				<router-link to='/moreUse'>

					<li>
						<img src="../../static/flyda_img/home/9.png" />
						<p>更多功能</p>

					</li>
				</router-link>
			</ul>
		</div>

		<!--   list-Item-->

	</div>

</template>

<script>
	import { XHeader, Swiper, SwiperItem } from 'vux';

	import CarPage from "../components/CarPage";
	export default {

		components: {

			XHeader,
			Swiper,
			SwiperItem,
			CarPage

		},
		data: function() {
			return {

				report_warn: {
					sumalertR: '26',
					sumalertO: '32',
					sumalertG: '26'

				},
				mess_warn: {
					sumalertR: '26',
					sumalertO: '32',
					sumalertG: '26'

				},

			}
		},

		methods: {
			re: function() {
//				location.reload()
				return 
			},
			getmess: function() {
				//  以当前时间为值， 发送请求获取整体数据，当前数据喝历史数据以当前时间为界限
				//			请求1获取报警信息      获取报警总量
				//          请求2获取消息提醒       获取信息总量
				//过滤器，status值为1，status为在线，为0，离线
			}
		},

		mounted() {

			$('.caldate').datepicker({})

		}
	}
</script>

<style>
	.home_wrap {
		padding-bottom: 50px;
	}
	/*    swipper   */
	
	.swiper img {
		width: 100%;
	}
	/*  首页内容   */
	
	.list {
		text-align: center;
		overflow: hidden;
		list-style: none;
		margin: 0;
		padding: 0;
		background: white;
	}
	
	.list li {
		width: 33.3%;
		float: left;
		border: 1px solid #E7E7E7;
		height: 122px;
		padding-top: 30px;
		font-size: 14px;
		padding-bottom: 50px;
	}
	
	.list img {
		height: 30px;
	}
	
	.list p {
		margin: 0;
		margin: 10px auto;
	}
	
	.list li span {
		display: inline-block;
		width: 16px;
		height: 16px;
		border-radius: 50%;
		line-height: 16px;
		color: #FFFFFF;
		font-size: 12px;
	}
	
	.home_fir_li {
		position: relative;
	}
	
	.home_fir_p {
		position: absolute;
		top: 0px;
		left: calc(16vw - 6px);
		text-align: center;
		
	}
</style>