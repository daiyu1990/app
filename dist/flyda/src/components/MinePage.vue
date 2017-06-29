<template>
	<div class="root">

		<x-header :left-options="{showBack: false}">我的</x-header>
		<div class="logo_top">
			<img src="../../static/flyda_img/mine/user.png" />
			<p>杨小关</p>

		</div>
		<ul class="con_ls">

			<li>
				<img src="../../static/flyda_img/mine/rename.png" alt="" />
				<span>实名认证</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
					<span class="fa fa-angle-right"></span>
				</span>
				<!--</router-link>-->
			</li>
			<li>
				<img src="../../static/flyda_img/mine/reset_tel.png" alt="" />
				<span>修改手机号</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
					<span class="fa fa-angle-right"></span>
				</span>
				<!--</router-link>-->
			</li>
			<li>
				<img src="../../static/flyda_img/mine/reset_pwd.png" alt="" />
				<span>密码设置</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
					<span class="fa fa-angle-right"></span>
				</span>
				<!--</router-link>-->
			</li>
			<li>
				<img src="../../static/flyda_img/mine/voice.png" alt="" />
				<span>音效提示</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
					<span class="fa fa-angle-right"></span>
				</span>
				<!--</router-link>-->
			</li>

		</ul>
		<ul class="con_ls">

			<li>
				<img src="../../static/flyda_img/mine/service.png" alt="" />
				<span>客服中心</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
					<span class="fa fa-angle-right"></span>
				</span>
				<!--</router-link>-->
			</li>
			<li>
				<img src="../../static/flyda_img/mine/user_point.png" alt="" />
				<span>用户指南</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
					<span class="fa fa-angle-right"></span>
				</span>
				<!--</router-link>-->
			</li>
			<li>
				<img src="../../static/flyda_img/mine/upload.png" alt="" />
				<span>版本更新</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
					<span class="fa fa-angle-right"></span>
				</span>
				<!--</router-link>-->
			</li>
			<li>
				<img src="../../static/flyda_img/mine/law.png" alt="" />
				<span>法律条款</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
					<span class="fa fa-angle-right"></span>
				</span>
				<!--</router-link>-->
			</li>
			<li>
				<img src="../../static/flyda_img/mine/about.png" alt="" />
				<span>关于我们</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
					<span class="fa fa-angle-right"></span>
				</span>
				<!--</router-link>-->
			</li>
		</ul>
		<ul class="con_ls">

			<li @click='exit' style="cursor: pointer;">
				<img src="../../static/flyda_img/mine/exit.png" alt="" />
				<span>退出账户</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
					<span class="fa fa-angle-right"></span>
				</span>
				<!--</router-link>-->
			</li>

		</ul>
	</div>
</template>

<script>
	import { XHeader } from 'vux';

	//******************
	export default {
		components: {

			XHeader

		},
		data: function() {
			return {

			}

		},

		methods: {
			exit: function() {
				var that = this
				$.ajax({
					url: 'urls/Login/logout',
					dataType: 'json',
					type: 'post',
					data: {},
					success: function(e) {
						if(e.status == 1) {
							that.$router.push('/login');
						} else {
							alert(e.msg)
						}
						return false;
					}
				})

			}

		}

	};
</script>

<style scoped>
	.logo_top {
		text-align: center;
		padding: 30px 0 0;
	}
	
	.logo_top img {
		width: 70px;
	}
	
	.logo_top p {
		margin-top: 15px;
	}
	
	li img {
		width: 20px;
	}
</style>