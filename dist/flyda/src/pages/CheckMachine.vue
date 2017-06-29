<template>
	<div class="root">
		<!--    nav   -->
	<x-header :left-options="{showBack: true}">设备报修
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
						<span><span class="cir"></span> 设备编号 </span>
						<span class="ls_fr"> 
					<input type="text" name="" id="" value=""  placeholder="输入设备编号" />
					
					</span>

					</li>
					<li>
						<span class=""><span class="cir"></span> 任务名称 </span>
						<span class="ls_fr">
					<input type="text" name="" id="" value="" class="" placeholder="请输入工程名称" />			
					</span>

					</li>
					<li>
						<span class=""><span class="cir"></span> 设备位置 </span>
						<span class="ls_fr">
					<input type="text" name="" id="" value=""  placeholder="输入设备位置" />
                 	<router-link to='/promap'>        
                   <img src="../../static/flyda_img/prolist/2.png"/>
                    </router-link>
						
					</span>

					</li>

					<li class="other">
						<span class=""><span class="cir"></span> 故障描述 </span>
						<span class="ls_fr">
					<input type="text" name="" id="" value=""  placeholder="请输入出现的故障" />
						
					</span>

					</li>
				
					<li>
						<span class=""><span class="cir"></span> 联系人 </span>
						<span class="ls_fr">
					<input type="text" name="" id="" value="" value="李三保"/>
						
					</span>

					</li>

					<li>
						<span class=""><span class="cir"></span> 联系电话 </span>
						<span class="ls_fr">
                       <input type="datetime-local" name="" id="" value="13689635896" />
						
					</span>

					</li>
					<li>
						<span class=""><span class="cir"></span> 任务指派单位 </span>
						<span class="ls_fr">
                       <input type="text" name="" id="" placeholder="输入任务指派单位"/>
						
					</span>

					</li>
					<li>
						<span class=""><span class="cir"></span> 任务开始日期 </span>
						<span class="ls_fr">
                       <input type="datetime-local" name="" id="" placeholder="输入任务指派单位"/>
						
					</span>

					</li>
					<li>
						<span class=""><span class="cir"></span> 任务截止日期 </span>
						<span class="ls_fr">
                       <input type="datetime-local" name="" id="" placeholder=""/>
						
					</span>

					</li>
				</ul>

				<button type="submit" class="sub_btn">提交</button>
			</form>
		</div>
	</div>
</template>

<script>
import { XHeader } from 'vux';
	
	export default {
			components: {
			XHeader

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
	
	.ls_fr img {
		width: 15px;
	}
	.other{
		margin: 5px auto;
		
	}
</style>