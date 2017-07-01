<template>
	<div>
		<!--    nav   -->
	
		
			<x-header :left-options="{showBack: true}">设备报修
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
					<div ><span class="cir"></span> 设备编号 </div>
					<input type="text" name="" id="" value="" class="ls_fr" placeholder="请输入设备编号" />
				</li>
				<li>
					<div ><span class="cir"></span> 工地名称 </div>
					<div class="ls_fr">
						<input type="text" name="" id="" value="" placeholder="请选择设备所在工地" />
						<span class="fa fa-angle-right"></span>
					</div>
				</li>
				<li>
					<div ><span class="cir"></span> 设备地址 </div>
					<div class="ls_fr">
						<input type="text" name="" id="" value="" placeholder="请输入地址或点击自动定位" style="width: 170px;" />
						<span class="fa fa-map-marker"></span>
					</div>

				</li>
				<li class="other">
					<div><span class="cir"></span> 故障描述 </div>
					<textarea name="" rows="3" cols="100%" placeholder="请输入出现的故障"></textarea>
				</li>
				<li>
					<div ><span class="cir"></span> 故障图片 </div>
					<div class="ls_fr">
						<span class="fa fa-plus-circle "> 添加图片</span>

					</div>
				</li>
				<li>
					<div ><span class="cir"></span> 联系人 </div>
					<input type="text" name="" id="" value="" class="ls_fr" placeholder="请选择联系人" />
				</li>
			</ul>
			<router-link to='/reswork'>
				<button type="submit" class="sub_btn">提交</button>
			</router-link>
		</form>

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

</style>