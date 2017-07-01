<template>
	<div class="root">
	<x-header :left-options="{showBack: true}">报警提醒
			<a slot="right">
				<router-link to='/main'>
					<img src="../assets/flyda_img/alertlist/home.png" class="hd_img" />
				</router-link>
			</a>
		</x-header>



		<div class="hd_nav">
			<span class=" fa fa-angle-left fl" @click='back()'></span>
			<h4>维修任务详情</h4>

		</div>

		<div class="des_con">
			<div class="btns alertG">任务编号：{{$route.params.model}}</div>
			<ul v-for='info in historyAlert' class="des_ls">
				<li>设备编号：{{info.model}}</li>
				<li>报警描述：{{info.tit}}</li>
				<li>发生时间：{{info.time}}</li>
				<li>发生位置：{{info.address}}</li>
				<li>项目名称：{{info.uname}}</li>
				<li>工地自编号:{{info.order}}</li>
				<li>任务级别：{{info.deg}}</li>
				<li class="emp"></li>

			</ul>
			<div class="mach_img">
				<p>故障报修图片：</p>
				<img src="../assets/mach01.png" />
			</div>

			<div v-for='info in historyAlert ' class="mess">
				<div>
					<img src="../assets/admin01.png" alt="" />
					<p>操作员：{{info.person}}</p>
					<p>{{info.tel}}</p>
				</div>
				<div>
					<img src="../assets/admin01.png" alt="" />
					<p>操作员：{{info.persons}}</p>
					<p>{{info.tels}}</p>
				</div>

			</div>

			<button class="btn btn-success btn-lg sub" data-toggle="modal" data-target="#myModal">受理该任务</button>
			<!-- 模态框  -->

			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">

						</div>
						<div class="modal-body">

							<img src="../../static/flyda_img/messlist/4.png" />

							<p>维修已受理</p>
							<p>可到我的任务中查看</p>
							<div class="modal_btn">
								<button class="active_btn sub" data-dismiss="modal" aria-hidden="true">知道了</button>
								<router-link to='/WorkPage'>
									<button class="active_btn">去查看</button>
								</router-link>
							</div>
						</div>

					</div>
				</div>
			</div>

			<!--模态框end-->

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
				dialogVisible: false,
				historyAlert: [{
						imgurl: '../../static/img/index1.png',
						model: '1012TC011001761',
						cid: '001',
						tit: '故障：超载保护器短接',
						time: '2017-5-28 07:58:16',
						address: '深圳市福田区双利阜镇名荷苑二期3幢',
						deg: '紧急',
						uname: '绿城.名荷苑',
						order: '1#塔机',
						person: '景泰男',
						tel: '13256656898',
						persons: '熊柏柏',
						tels: '13568915815'

					}

				]

			}
		},
		methods: {
			handleClose(done) {
				this.$confirm('确认关闭？')
					.then(_ => {
						done();
					})
					.catch(_ => {});
			},
			back: function() {
				window.history.back()
			}

		}

	}
</script>

<style scoped>
	.root {
		padding-bottom: 30px;
	}
	
	.btns {
		background: blue;
		color: white;
		height: 40px;
		line-height: 40px;
		padding-left: 20px;
	}
	
	.mach_img>img {
		width: 98%;
		margin: 20px auto;
	}
	
	.mach_img {
		padding: 10px;
		border: 3px solid gainsboro;
		margin-bottom: 10px;
	}
	
	.mess {
		padding: 20px;
		display: flex;
		justify-content: space-around;
		flex-wrap: nowrap;
	}
	
	.mess>div {
		width: 49%;
		text-align: center;
	}
	
	.mess>div p {
		margin: 6px auto;
	}
	
	.sub {
		width: 80%;
		display: block;
		margin: 0 auto;
	}
	/*   模态框   */
	
	.modal {
		text-align: center;
		font-size: 18px;
		margin-top: 150px;
	}
	
	.modal img {
		width: 55px;
		margin-bottom: 20px;
	}
	
	.modal-header {
		border: none;
	}
	
	.modal-header .close {
		margin-top: -8px;
	}
	
	.modal-body {
		padding: 0;
	}
	
	.modal_btn {
		overflow: hidden;
	}
	
	.modal .active_btn {
		width: 50%;
		height: 50px;
		line-height: 50px;
		text-align: center;
		float: left;
		border: 1px solid blue;
		margin-top: 30px;
	}
</style>