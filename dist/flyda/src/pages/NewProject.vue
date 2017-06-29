<template>
	<div class="root">
		<!--    nav   -->
		<x-header :left-options="{showBack: true}">新增工程
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>

		<!--  添加任务列表     -->
		<div class="">
			<form action="" class="">
				<ul class="ls_wrap  cir_blue ls_model">

					<li>
						<span class=""><span class="cir"></span> 工程编号 </span>
						<span class="ls_fr">
					<input type="text" name="" id="" value="" class="" required placeholder="请选择工程编号"  v-model='code'/>			
					</span>

					</li>
					<li>
						<span class=""><span class="cir"></span> 工程名称 </span>
						<span class="ls_fr">
					<input type="text" name="" id="" value="" required placeholder="请输入工程名称" v-model='name' />
						
					</span>

					</li>
					<li>
						<div class=""><span class="cir"></span> 工地位置 </div>
						<span class="ls_fr">
					<input type="text" name="" id="" value="" required  placeholder="手动输入" v-model='address' />
					<router-link to='/promap'>        
                   <img src="../../static/flyda_img/prolist/2.png"/>
                    </router-link>
					</span>
					</li>

				</ul>
			<router-link to='/project'>
				<button type="submit" class="sub_btn" @click='sub'>提交</button>
			</router-link>
				
			</form>
		</div>
	</div>
</template>

<script>
	import { XHeader } from 'vux';

	export default {
		data: function() {
			return {
				code: '',
				name: '',
				address: ''
			}
		},
		components: {
			XHeader

		},
		methods: {
			sub: function() {
				var that = this

				$.ajax({
					url: 'urls/Engineering/engin_add',
					dataType: 'json',
					type: 'post',
					data: {
						code: that.code,
						name: that.name,
						address: that.address
					},
					success: function(e) {

						if(e.status == 1) {

						} else {
							$('.item').css('display', 'block')

						}
						return false;
					}
				})
			}

		}
	}
</script>

<style scoped>
	input {
		border: none;
		text-align: right;
	}
	
	li {
		background: #FFFFFF;
	}
	
	.bor_left {
		border-left: 3px solid black;
		font-size: 14px;
		font-weight: bold;
		padding-left: 5px;
	}
	
	img {
		width: 15px;
	}
</style>