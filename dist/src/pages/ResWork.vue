<template>
	<div class="root">
		<!--    nav   -->
		<div class="hd_nav">
			<span class=" fa fa-angle-left fl" @click='back()'></span>
			<h4>任务填报</h4>
			<span class="fa fa-home fa-2x fr"></span>
		</div>
		<!--    报修内容列表    -->
		<form action="">
			<ul class="ls_wrap  cir_blue ls_model">
				<li>
					<div ><span class="cir"></span> 任务编号 </div>
					<input type="text" name="" id="" value="" class="ls_fr" value="02316868" />
				</li>
				<li>
					<div ><span class="cir"></span> 任务类型 </div>

					<div class="ls_fr">
						<select name="">
							<option value="">请选择任务类型</option>
							<option value="">请选择任务类型</option>
							<option value="">请选择任务类型</option>

						</select>
					</div>
				</li>
				<li>
					<div ><span class="cir"></span> 设备编号 </div>
					<input type="text" name="" id="" value="" class="ls_fr" placeholder="请输入设备编号" />

				</li>
				<li>
					<div ><span class="cir"></span> 工地名称 </div>
					<input type="text" name="" id="" value="" class="fr" placeholder="请输入工地名称" />

				</li>
				<li>
					<div><span class="cir"></span> 设备地址 </div>
					<input type="text" name="" id="" value="" class="ls_fr" placeholder="请输入设备地址" />
				</li>
				<li class="other">
					<div><span class="cir"></span> 故障描述 </div>

					<textarea name="" rows="3" cols="100%" placeholder="请输入出现的故障"></textarea>
				</li>
				<li>
					<div><span class="cir"></span> 故障图片 </div>
					<div class="ls_fr">
						<span class="fa fa-plus-circle"></span>
						<span>添加图片</span>
					</div>
				</li>
				<li>
					<div ><span class="cir"></span> 联系人 </div>
					<input type="text" name="" id="" value="" placeholder="请输入联系人姓名" class="ls_fr" />
				</li>
				<li>
					<div ><span class="cir"></span> 联系人电话 </div>
					<input type="text" name="" id="" value="" class="ls_fr" placeholder="请输入联系人电话" />
				</li>
				<li>
					<div ><span class="cir"></span> 报修人 </div>
					<input type="text" name="" id="" value="" class="ls_fr" placeholder="请输入报修人姓名" />
				</li>
				<li>
					<div ><span class="cir"></span> 报修人电话 </div>
					<input type="text" name="" id="" value="" class="ls_fr" placeholder="请输入报修人电话" />
				</li>
				<li class="other">
					<div><span class="cir"></span> 处理过程 </div>
					<textarea name="" rows="3" cols="100%" placeholder="请输入处理过程"></textarea>
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
						<div>
							&#x3000;<span class="fa fa-plus-circle"> 添加配件</span>
						</div>
					</div>

				</li>

				<li style="border: 5px solid #F0F0F0; box-sizing: content-box;">
					<div ><span class="cir"></span> 维修图片 </div>

					<router-link to='/addmore'>

						<!--					<input type="text" name="" id="" value="" class="fr" placeholder="添加附件" />-->

						<span class="ls_fr"><span class="fa fa-plus-circle "></span> 添加图片</span>
					</router-link>

				</li>
				<li>
					<div ><span class="cir"></span> 任务状态 </div>
					<input type="text" name="" id="" value="" class="ls_fr" placeholder="请选择任务状态" />
				</li>
			</ul>
			<button type="submit" class="sub_btn">提交</button>
		</form>

	</div>
</template>

<script>
	export default {
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
	table {
		margin-left: 12px;
	}
	
	.fr {
		color: #989898;
	}
	
	td {
		width: 20%;
		text-align: center;
		color: #989898;
	}
</style>