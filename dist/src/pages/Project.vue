<template>
	<div class="root machine">
		<!--    nav   -->
		<x-header :left-options="{showBack: true}">工程列表
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>

		<!--头部搜索-->
		<div class="search">
			<input type="text" name="" id="" value="" placeholder="输入搜索内容" />
			<button type="button" class="isblue active_btn">搜索</button>
		</div>
		<!--   工程列表           -->

		<ul class="ls_wrap">
			<li>
				<h3>工程列表</h3>
				<div class="fr_btn">
					<router-link to='/newproject'>
						<button type="button" class="  active_btn"><span class="fa fa-plus"></span> 新建工程</button>
					</router-link>
				</div>
			</li>
		</ul>

		<table>

			<thead>
				<tr class="isgray">

					<th style="">工程编号</th>
					<th style="width: 35%;">工程名称</th>
					<th style="width: 18%;">塔机</th>
					<th style="width: 18%;">升降机 </th>

				</tr>
			</thead>
			<tbody>

				<tr class="pro_tr" v-for='info in datas'>
					<td>{{info.code}}</td>
					<td style="width: 35%;">{{info.name}}</td>
					<!--<router-link :to="'/desproject/'+info.id ">-->

						<td class="isblue" style="width: 18%;">{{info.taji}}</td>
					<!--</router-link>-->
					<!--<router-link :to="'/desproject/'+info.id  ">-->

						<td class="isblue" style="width: 18%;">{{info.shengjiangji}}</td>
					<!--</router-link>-->

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
					url: 'urls/Engineering/engin_list',
					dataType: 'json',
					type: 'post',
					data: {
						p: 1
					},
					success: function(e) {

						if(e.status == 1) {

							that.datas = e.data

						} else {

						}
						return false;
					}
				})

			}

		},
		mounted() {

			this.getdatas()
		}

	}
</script>

<style scoped>
	.ls_wrap {
		padding: 0;
		width: 90vw;
		margin: 15px auto;
	}
	
	.ls_wrap li {
		margin: 0 auto;
		padding: 0;
		height: 50px;
		background: #FFFFFF;
	}
	
	table {
		width: 100%;
	}
	
	.isgray th {
		width: 25%;
	}
	
	.pro_tr td {
		width: 25%;
		border-bottom: 1px solid #F0F0F0;
		float: left;
		background: white;
	}
</style>