<template>
	<div class="root machine">
		<!--表格数据-->
		<table>

			<thead>
				<tr class="isgray">

					<th>设备编号</th>
					<th>备案状态</th>
					<th>产权备案号</th>

				</tr>
			</thead>
			<tbody>

				<tr class="pro_tr" v-for='info in datas'>
					<td>{{info.facility_number}}</td>
					<td>{{info.is_record}}</td>
					<td>{{info.equity_number}}</td>
				

				</tr>

			</tbody>
		</table>
		<load-more tip="正在加载更多" style="margin: 4px auto;" v-if="loadComplete"></load-more>

		<div class='item'>暂无数据</div>

	</div>
</template>

<script>
	import { Scroller, LoadMore } from 'vux';

	export default {
		components: {

			Scroller,
			LoadMore
		},
		data: function() {
			return {
				//发送请求获取的是所有的信息列表，详情页根据工程order动态绑定数据获取order重新发送请求
				datas: [],
				isLoading: false,
				isShowBackTop: false,
				currentOffset: 0,
				loadComplete: false
			}
		},
		methods: {

			getdatas: function() {
				if(this.isLoading) {
					return;
				}
				this.isLoading = true;
				var that = this
				$.ajax({
					url: 'urls/File/fac_record',
					dataType: 'json',
					type: 'post',
					data: {

					},
					success: function(e) {

						if(e.status == 1) {

							that.datas = that.datas.concat(e.data)
							this.isLoading = false;
							this.loadComplete = true;
						} else {

							$('.item').css('display', 'block')
						}
						return false;
					}
				})

			}

		},
		mounted() {

			this.getdatas()
			this.$el.onscroll = function(e) {
				var offset = e.target.scrollTop;
				this.currentOffset = offset;
				var height = e.target.clientHeight;
				var contentHeight = e.target.scrollHeight;
				if(offset + height >= contentHeight - 20) {
					this.getdatas();
				}
				if(offset > 400) {
					this.isShowBackTop = true;
				} else {
					this.isShowBackTop = false;
				}
			}.bind(this);
		},
		activated: function() {
			this.$el.scrollTop = this.currentOffset;
		},
	}
</script>

<style scoped>
	table {
		width: 100%;
	}
	
	th,
	td {
		width: 33%;
	}
	
	td img {
		width: 15px;
	}
</style>