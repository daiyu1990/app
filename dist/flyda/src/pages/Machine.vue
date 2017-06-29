<template>
	<div class="root machine">
		<!--    nav   -->
	<x-header :left-options="{showBack: true}">设备信息
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>
	
		<!--头部搜索-->
		<div class="search">
			<input type="text" name="" id="" value="" placeholder="输入搜索内容" />
			<button type="button" class="active_btn">搜索</button>
		</div>
		<!--   工程列表           -->

		<ul class="ls_wrap">
			<li>
				<h3>设备列表</h3>
				<div class=" fr_btn">
					<router-link to='newmachine'>
					
					<button type="button" class="active_btn" style="margin-right: 10px;"><img src="../../static/flyda_img/maclist/1.png" style="width: 15px;"/> 分布</button>
					</router-link>
					
					<router-link to='newmachine'>
						<button type="button" class="active_btn"><span class="fa fa-plus"></span> 新建</button>
					</router-link>
				</div>
			</li>
		</ul>

		<table>

			<thead>
				<tr class="isgray">
					<th>序号 </th>
					<th>工程编号</th>
					<th>状态</th>
					<th>报修</th>

				</tr>
			</thead>
			<tbody >

					<tr class="pro_tr" v-for='info in datas'>
						<td>{{info.facility_number}}</td>
						
				<router-link :to="'/machine/'+info.order +'/' +info.id  " >
						
						<td>{{info.equity_number}}</td>
				</router-link>
						
						<td>{{info.is_on}}</td>
				<router-link :to="'/checkmachine/'+info.order +'/' +info.id  " >
						
						<td>
							<img src="../../static/flyda_img/maclist/2.png" alt="" />
						
						</td>
				</router-link>
						
					</tr>

			</tbody>
		</table>

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
				//发送请求获取的是所有的信息列表，详情页根据工程order动态绑定数据获取order重新发送请求
				datas: []

			}
		},
		methods: {
			back: function() {
				window.history.back()
			},
			getdatas: function() {

				var that = this
				$.ajax({
					url: 'urls/Facility/fac_list',
					dataType: 'json',
					type: 'post',
					data: {

					},
					success: function(e) {

						if(e.status == 1) {

							that.datas = e.data

						}
						else{

							
						}
						return false;
					}
				})

			}
		},
			mounted(){
		 
			this.getdatas()
		}

	}
</script>

<style scoped>
	.isgray th {
		width: 25vw;
	}
	
	.pro_tr td {
		width: 25vw;
	}
		
	
	.ls_wrap{
		padding: 0;
		width: 90vw;
		
		margin: 15px auto;

		
	}
	.ls_wrap li{

		margin: 0 auto;
		padding: 0;
		height: 50px;

		background: #FFFFFF;
		
	}
</style>