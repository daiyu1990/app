<!--//首页-->

<template>
	<div class="page-root">

		<!--   tab-bottom -->
		<transition name="tabani">
			<tabbar style="position: fixed;"  v-model="pageIndex">

				<tabbar-item  >
					<img slot="icon" src="../../static/flyda_img/home/21.png" v-show="pageIndex == 0"/>
					<img slot="icon" src="../../static/flyda_img/home/31.png" v-show="pageIndex !== 0"/>
					
					<span slot="label" :class='{red:pageIndex == 0 }'>首页</span>
				</tabbar-item>

				<tabbar-item >
					<img slot="icon" src="../../static/flyda_img/home/22.png"  v-show="pageIndex == 1"/>
					<img slot="icon" src="../../static/flyda_img/home/32.png"  v-show="pageIndex !== 1"/>
					
					<span slot="label" :class='{red:pageIndex == 1 }'>通讯录</span>
				</tabbar-item>

				<tabbar-item >
					<img slot="icon" src="../../static/flyda_img/home/23.png"  v-show="pageIndex == 2"/>
					<img slot="icon" src="../../static/flyda_img/home/33.png"  v-show="pageIndex !== 2"/>
					
					<span slot="label" :class='{red:pageIndex == 2 }'>考勤</span>
				</tabbar-item>

				<tabbar-item >
					<img slot="icon" src="../../static/flyda_img/home/34.png"  v-show="pageIndex !== 3" />
					
					<img slot="icon" src="../../static/flyda_img/home/24.png"  v-show="pageIndex == 3" />

					
					<span slot="label" :class='{red:pageIndex == 3 }'>我的</span>
				</tabbar-item>

			</tabbar>
		</transition>

		<home-page v-show="pageIndex==0"></home-page>
		<tel-page v-show="pageIndex==1"></tel-page>
		<mine-page v-show="pageIndex==3"></mine-page>
		<work-page v-show="pageIndex==2"></work-page>

		<!--   tab-bottom  end -->
	</div>

</template>

<script>
	import HomePage from '../components/HomePage'
	import TelPage from '../components/TelPage'
	import MinePage from '../components/MinePage'
	import WorkPage from '../components/WorkPage'

	import { Tabbar, TabbarItem } from 'vux';

	export default {

		data: function() {
			return {
				animationType: "",
				isShowTabBar: true,
				pageIndex: 0,

			}
		},
		activated: function() {
			this.initData();

		},
		components: {
			Tabbar,
			TabbarItem,
			MinePage,
			HomePage,
			TelPage,
			WorkPage
		},
		mounted: function() {
			//		console.log(this.$route);
			if(this.$route.path.split("/").length > 2) {
				this.isShowTabBar = false;
			} else {
				this.isShowTabBar = true;
			}
		},
		watch: {
			$route: function(to, from) {
				var toNum = to.path.split("/").length;
				var fromNum = from.path.split("/").length;
				if(toNum == fromNum) {
					//平级切换
					this.animationType = "qqq";
				} else if(toNum > fromNum) {
					//进入
					this.animationType = "routein";
				} else {
					//退出
					this.animationType = "routeout";
				}

				if(toNum > 2) {
					this.isShowTabBar = false;
				} else {
					this.isShowTabBar = true;
				}
			}
		},
		methods: {
			initData: function() {

				this.pageIndex = 0;

			}
	
			
		},
		created:function(){
			
			
			
			
			
			
			
			
			
		}
	

	}
</script>

<style scoped>
	

	/*退出动画*/
	
	.routeout-enter-active,
	.routeout-leave-active {
		transition: all 0.3s;
		position: absolute;
	}
	
	.routeout-enter {
		transform: translateX(-50%);
	}
	
	.routeout-leave-active {
		transform: translateX(100%);
		z-index: 10;
	}
	/*tab动画*/
	
	.tabani-enter-active,
	.tabani-leave-active {
		transition: all 0.3s;
	}
	
	.tabani-enter,
	.tabani-leave-active {
		transform: translateY(100%);
	}
	
	.qqq-enter-active,
	.qqq-leave-active {
		position: absolute;
	}
	
	.qqq-enter {
		position: absolute;
	}
	
	.active{
		color: red;
		
	}
	.red{
		color: #2164ff;
	}
</style>