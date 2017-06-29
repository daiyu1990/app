<template>
	<div class="root ">
		<!--    nav   -->
		<x-header :left-options="{showBack: true}">新增设备
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>

		<!--    报修内容列表    -->
		<form action="">

			<ul class="ls_wrap cir_blue ls_model">
				<li>
					<div><span class="cir"></span> 设备编号 </div>

					<div class="ls_fr">
						<input type="text" name="" id="" value="" placeholder="请输入设备编号" v-model='code' required/>
						<span class="fa fa-angle-right"></span>
					</div>
				</li>
				<li>
					<div><span class="cir"></span> 设备类型 </div>
					<div class="ls_fr">
						<!--<input type="text" name="" id="" value="" placeholder="输入设备类型" />-->
						<select name="" required v-model='type'>
							<option value="">选择设备类型</option>
							<option value="1">塔式起重机</option>
							<option value="2">施工升降机</option>

						</select>
						<span class="fa fa-angle-right"></span>
					</div>
				</li>
				<li>
					<div><span class="cir"></span> 设备型号 </div>
					<div class="ls_fr">
						<input type="text" required placeholder="输入设备型号" v-model='xinghao' />
						<span class="fa fa-angle-right"></span>
					</div>
				</li>
				<li>
					<div><span class="cir"></span> 制造许可证号 </div>
					<div class="ls_fr">
						<input type="text" required placeholder="输入制造许可证号" v-model='xuke' />
						<span class="fa fa-angle-right"></span>
					</div>
				</li>

			</ul>

			<button type="submit" class="isblue sub_btn" @click='sub'>提交</button>

		</form>

	</div>
</template>

<script>
	import { XHeader } from 'vux';

	export default {
		data: function() {
			return {
				code: '',
				type: '',
				xinghao: '',
				xuke: ''

			}
		},

		components: {
			XHeader

		},
		methods: {
			sub: function() {
				var that = this

				$.ajax({
					url: 'urls/Facility/fac_add',
					dataType: 'json',
					type: 'post',
					data: {
						code: that.code,
						type: that.type,
						xinghao: that.xinghao,
						xuke: that.xuke
					},
					success: function(e) {

						if(e.status == 1) {
							that.$router.push('/machine');
						} else {

						}
						return false;
					}
				})
			}

		}
	}
</script>

<style scoped>
	.sub_btn {
		background: blue;
	}
	
	ul {
		margin: 0;
	}
	
	.ls_wrap input {
		width: 9rem;
	}
	
	.padding5 {
		padding: 5px;
	}
</style>