<template>
	<div class="root">

		<x-header :left-options="{showBack: false}">通讯录</x-header>
		<div class="logo_top">
			<img src="../../static/flyda_img/mine/user.png"/>
			
		</div>
		<ul class="con_ls">

			<li>

				<span>姓名</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
               <input type="text" name="" id="" value="" placeholder="输入联系人姓名" />
				</span>
				<!--</router-link>-->
			</li>
			<li>

				<span>手机</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
                   <input type="text" name="" id="" value="" placeholder="输入手机号码"/>
				</span>
				<!--</router-link>-->
			</li>
			<li>

				<span>邮箱</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
               <input type="text" name="" id="" value=""  placeholder="输入联系人邮箱"/>
				</span>
				<!--</router-link>-->
			</li>
			<li>

				<span>电话</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
               <input type="text" name="" id="" value="" placeholder="输入联系人电话" />
				</span>
				<!--</router-link>-->
			</li>
			<li>

				<span>公司</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
                   <input type="text" name="" id="" value="" placeholder="输入公司名称"/>
				</span>
				<!--</router-link>-->
			</li>
			<li>

				<span>地址</span>
				<!--<router-link :to="'/desmodel/'+datas.cid +'/' +info.tit +'/' +info.time">-->
				<span class="ls_fr">
               <input type="text" name="" id="" value=""  placeholder="输入公司地址"/>
				</span>
				<!--</router-link>-->
			</li>
		</ul>
		<button type="submit" class="  sub_btn">确定</button>

	</div>
</template>

<script>
	import { XHeader } from 'vux'

	export default {
		components: {
		
			XHeader
		},
		data() {
			return {
			
			}
		},
		methods:{
			exit:function  () {
			$.post('urls/Api/Login/logout',function  (status,msg) {
				if (status == 1) {
					alert(msg)
					location.href = '/login'
				} else{
					alert(msg)
					
				}
				
			},'json')
				
				
				
				
				
				
				
				
				
				
			}
			
			
			
		}
	}
</script>

<style scoped>
.root{
	height: 100%;
}
input{
	border: none;
	text-align: right;

}
.logo_top {
	text-align: center;
	padding: 30px 0;
}
.logo_top img{
width: 70px;

}


</style>