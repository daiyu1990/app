<template>
	<div>

		<!--    报警按钮     -->
		<div class="active_btn btn_tit">
			<span class="fa fa-angle-left"></span>
			<div>
				<p>100条</p>
				<p>2017-6-16</p>
			</div>
			<span class="fa fa-angle-right"></span>
		</div>

		<!--    报警按钮  end   -->

		<!---->
		<ul class="alert_list alert_list_b">

			<router-link v-for='(info,index) in   historyAlert' :to="'/read/'+info.cid +'/' +info.model">

				<li class="alert_li" @click='read(index)'>


					<div class="mac_img b_gray">
						<img :src="info.imgurl" />
						<span :class='{isread:info.isread}'>{{info.order}}</span>
					</div>

					<div class="alert_con">
						<p class="time">{{info.time}}</p>

						<h4>{{info.tit}}</h4>
						<div>
							<span class="a_gray">{{info.model}}</span>
							<span class="a_gray">{{info.num}}</span>
						</div>



					</div>

				</li>
			</router-link>

		</ul>
	</div>
</template>

<script>
	export default {
		data: function() {
			return {

				historyAlert: [{
						imgurl: '../../../static/flyda_img/messlist/3.1.2.png',
						model: '1012TC011',
						order: '00001018',
						num: 'TC0110689',
						cid: '001',
						tit: '故障：超载保护器短接',
						time: '2017-5-28 07:58:16',
						address: '深圳市福田区双利阜镇名荷苑二期3幢',
						deg: '紧急',
						size: '1',
isread:true,
						

					},
					{
						imgurl: '../../../static/flyda_img/messlist/3.2.2.png',
						model: '1012TC011',
							order: '00001018',
						num: 'TC0110689',
						cid: '001',
						tit: '故障：超载保护器短接',
						time: '2017-5-28 07:58:16',
						address: '深圳市福田区双利阜镇名荷苑二期3幢',
						deg: '中',
						size: '1',
isread:false,
						

					},
					{
						imgurl: '../../../static/flyda_img/messlist/3.2.png',
						model: '1012TC011',
							order: '00001018',
						num: 'TC0110689',
						cid: '001',
						tit: '故障：超载保护器短接',
						time: '2017-5-28 07:58:16',
						address: '深圳市福田区双利阜镇名荷苑二期3幢',
						deg: '紧急',
						size: '1',
isread:false,
						

					},
					{
						imgurl: '../../../static/flyda_img/messlist/3.3.2.png',
						model: '1012TC011',
							order: '00001018',
						num: 'TC0110689',
						cid: '001',
						tit: '故障：超载保护器短接',
						time: '2017-5-28 07:58:16',
						address: '深圳市福田区双利阜镇名荷苑二期3幢',
						deg: '低',
						size: '1',
isread:true,
						

					},
					{
						imgurl: '../../../static/flyda_img/messlist/3.4.png',
						model: '1012TC011',
							order: '00001018',
						num: 'TC0110689',
						cid: '001',
						tit: '故障：超载保护器短接',
						time: '2017-5-28 07:58:16',
						address: '深圳市福田区双利阜镇名荷苑二期3幢',
						deg: '中',
						size: '1',
isread:true,
						

					}
				]

			}
		},

		methods: {

			back: function() {
				window.history.back()
			},
			read: function(ins) {
				//				var li = $('.alert_li')
				//				for(var i = 0;i<li.length;i++){
				//					li[ins].find('img').src = li[ins].find('img').src.slice(0,-3) +'2.png'
				//
				//					
				//				}
			}

		}
	}
</script>

<style scoped>
.a_gray,.b_gray{
	color: #666;
}
.alert_con{
	padding: 20px ;
}
.alert_con .time{
	color: #999;
}
.alert_con .a_gray{
	padding: 3px 8px;
	border-radius: 20px;
	font-size: 15px;
}
.isread{
	color: #2164ff;
}



</style>