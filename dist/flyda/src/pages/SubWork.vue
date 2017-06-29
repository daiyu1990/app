<template>

	<div class="">
		<!--       导航          -->
			<x-header :left-options="{showBack: true}">任务填报
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>
		
		
		<div class="mess_con">
			<div class="mess_top">
				<img src="../../static/flyda_img/mywork/1.png" class="active_btn" />
				<h4 style="display: inline-block;">000114维修任务填报</h4>

			</div>
			<!--   消息列表       -->
			<form action="">
				<ul class="ls_wrap  cir_blue ls_model">
					<li class="other">
						<div>
							<span class="cir"></span> 处理过程

						</div>
						<textarea name=""  cols="" placeholder="请输入处理过程" style="width: 96%;height: 120px;"></textarea>

					</li>
					<li style="height: 240px;">
						<div><span class="cir"></span> 更换配件 </div>

						<div>
							<table>
								<tr>
									<td style="text-align: left;">配件名称</td>
									<td>数量</td>
									<td>单位</td>
									<td>删除</td>
								</tr>
								<tr v-for='info in machines'>
									<td>{{info.name}}</td>
									<td>{{info.num}}</td>
									<td>{{info.unit}}</td>
									<td><span class="fa fa-minus-circle"></span></td>
								</tr>

							</table>

							<button class="clear">
							&#x3000;<span class="fa fa-plus-circle"> 添加配件</span>
						</button>

						</div>

					</li>
					<li class="border">
						<div><span class="cir"></span> 维修图片 </div>
						<button class="clear ls_fr">
						<span class="fa fa-plus-circle " >上传图片</span>


					</button>

					</li>

					<li>
						<div><span class="cir"></span> 任务状态 </div>
						<div class=" ls_fr  ">

							<input type="text" name="" id="" value="" placeholder="请选择任务状态>" />

						</div>

					</li>
				</ul>
				<router-link to='/addwork'>
					<button type="submit" class="  sub_btn">提交</button>
				</router-link>
			</form>
		</div>
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

				machines: [{
						name: '吊机轮轴转子40-12in套装',
						num: '2',
						unit: '套'

					},
					{
						name: '吊机轮轴转子40-12in套装',
						num: '2',
						unit: '套'

					},
					{
						name: '吊机轮轴转子40-12in套装',
						num: '2',
						unit: '套'

					}

				]

			}

		},
		methods: {

			back: function() {
				window.history.back()
			}

		}

	}
</script>

<style scoped>
	.mess_top {
		padding: 15px 0 0 15px;
	}
	
	table {
		margin-left: 8px;
	}
	
	td {
		width: 20vw;
		text-align: center;
	}
	
	input {
		text-align: right;
	}
	
	input::placeholder {
		text-align: right;
	}
	textarea{
		text-align: left!important;
		
	}
textarea::placeholder {
		text-align: left;
	}

	
	
</style>