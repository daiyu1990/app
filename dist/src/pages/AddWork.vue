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

					<select name="" v-model='type' required>
						<option value="">请选择任务类型</option>
						<option value="1">维修</option>
						<option value="2">保养</option>
						<option value="3">巡检</option>
						<option value="4">咨询</option>
						
					</select>
					</span>

					</li>
					<li>
						<span class=""><span class="cir"></span> 任务名称</span>
						<span class="ls_fr">
					<input type="text" v-model='name'  placeholder="请输入任务标题" required />
						
					</span>

					</li>
					<li class="other">
						<div class=""><span class="cir"></span> 任务描述 </div>
						<textarea name="" rows="3" cols="100%" placeholder="请输入任务描述文字" v-model='wenti' required></textarea>
					</li>
					<li>
						<span class=""><span class="cir"></span> 任务级别 </span>
						<span class="ls_fr">

						<select name="" v-model='level' required>
							<option value="">请输入任务级别</option>
							<option value="1">高</option>
							<option value="2">中</option>
							<option value="3">低</option>
							<option value="4">紧急</option>
							
							
						</select>
					</span>

					</li>

					<li>
						<span class=""><span class="cir"></span> 开始时间 </span>
						<span class="ls_fr">
											<!--<input type="text"  v-model='start' onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" name="start" value="{$info.start}" id="start" class="check_inp" placeholder=" 请选择任务开始日期" />-->
                       <input type="datetime-local" v-model='start' name="" id="" value="" required />
					</span>

					</li>
					<li>
						<span class=""><span class="cir"></span> 结束时间 </span>
						<span class="ls_fr">

											<!--<input type="text" v-model='end' onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" name="end" value="{$info.end}" id="end" class="check_inp" placeholder=" 2017-06-10 12:00" />-->
						<input type="datetime-local" v-model='end' name="" id="" value="" required />
					</span>

					</li>

				</ul>

				<button type="submit" class="sub_btn" @click='sub'>提交</button>
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
				name: '',
				type: '',
				level: '',
				wenti: '',
				start: '',
				end: ''

			}

		},
		methods: {
			sub: function() {
				var that = this
				if(this.name && this.type && this.level && this.wenti && this.start && this.end) {
					$.ajax({
						url: 'urls/Mission/mission_add',
						dataType: 'json',
						type: 'post',
						data: {
							name: this.name,
							type: this.type,
							level: this.level,
							wenti: this.wenti,
							start: this.start,
							end: this.end
						},
						success: function(e) {

							if(e.status == 1) {
								that.$router.push('/workpage');

							} else {

							}
							return false;
						}
					})

				}

			}

		},
		mounted() {

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
		/*padding-left: 5px;*/
	}
</style>