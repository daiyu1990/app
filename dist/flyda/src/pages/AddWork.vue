<template>
	<div class="root">
		<!--    nav   -->
	<x-header :left-options="{showBack: true}">添加任务
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
						<span class=""><span class="cir"></span> 任务类型 </span>
						<span class="ls_fr">
					<input type="text" name="" id="" value="" class="" placeholder="请选择任务类型" />			
					</span>

					</li>
					<li>
						<span class=""><span class="cir"></span> 任务名称</span>
						<span class="ls_fr">
					<input type="text" name="" id="" value=""  placeholder="请输入任务标题" />
						
					</span>

					</li>
					<li class="other">
						<div class=""><span class="cir"></span> 任务描述 </div>
						<textarea name="" rows="3" cols="100%" placeholder="请输入任务描述文字"></textarea>
					</li>
					<li>
						<span class=""><span class="cir"></span> 任务级别 </span>
						<span class="ls_fr">
					<input type="text" name="" id="" value=""  placeholder="请输入任务级别" />
						
					</span>

					</li>
				
				
					<li>
						<span class=""><span class="cir"></span> 开始时间 </span>
						<span class="ls_fr">

						<input type="datetime-local" name="" id="" value="2017-06-10 12:00" />
					</span>

					</li>
					<li>
						<span class=""><span class="cir"></span> 结束时间 </span>
						<span class="ls_fr">
                       <input type="datetime-local" name="" id="" value="2017-06-10 12:00" />
						
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
		/*padding-left: 5px;*/
	}
</style>