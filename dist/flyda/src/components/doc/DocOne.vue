<template>
	<div class="root machine">
		<!--表格数据-->
		<table >

			<thead>
				<tr class="isgray">

					<th>资料编号</th>
					<th>资料名称</th>
					<th>下载</th>

					
				</tr>
			</thead>
			<tbody >

					<tr class="pro_tr" v-for='info in datas'>
						<td>{{info.code}}</td>
						<td>{{info.name}}</td>
				<router-link :to="'/desproject/'+info.id ">
						
						<td class="isblue">
							<img src="../../../static/flyda_img/doclist/1.png"/>
						</td>
				</router-link>

						


						
					</tr>

			</tbody>
		</table>
			<!--<load-more tip="正在加载更多" style="margin: 4px auto;"></load-more>-->
		
			<div class='item'>暂无数据</div>
		
	</div>
</template>

<script>
	export default{
		data:function(){
			return{
					//发送请求获取的是所有的信息列表，详情页根据工程order动态绑定数据获取order重新发送请求
				datas: []
			}
		},
			methods: {
		
				getdatas: function() {

				var that = this
				$.ajax({
					url: 'urls/File/fac_file',
					dataType: 'json',
					type: 'post',
					data: {

					},
					success: function(e) {

						if(e.status == 1) {

							that.datas = e.data

						}
						else{
							$('.item').css('display','block')
						
							
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
	table{
		width: 100%;
	}
	th,td{
		width: 33%;
	}
	td img{
		width: 15px;
	}
	
</style>