<template>
	<div class="desmodel_one">
		<!--    顶部图片   -->
		<div class="num_img">

			<img src="../../assets/flyda_img/alertlist/3.2.png" />
			<img src="../../assets/flyda_img/alertlist/3.3.png" />
		</div>
		<!--   数据信息   -->
		<ul class="num_ls">
			<li class="alertR">
				<div>力矩 <img src="../../assets/flyda_img/alertlist/4.1.png" /></div>
				<div>452KN/m</div>
				<div class="progress">
					<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width:45%;">45%</div>
				</div>
			</li>
			<li class="alertG">
				<div>载重 <img src="../../assets/flyda_img/alertlist/4.2.png" /></div>
				<div>2.19t(x2)</div>
				<div class="progress">
					<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:85%;">85%</div>
				</div>
			</li>
			<li class="alertG">
				<div>幅度 <img src="../../assets/flyda_img/alertlist/4.3.png" /></div>
				<div>--m</div>
				<div class="default_btn">未配置</div>
			</li>
			<li class="alertO">
				<div>高度 <img src="../../assets/flyda_img/alertlist/4.4.png" /></div>
				<div>46.9m</div>
				<div class="default_btn">
					高度上限
				</div>
			</li>
			<li class="alertG">
				<div>回转 <img src="../../assets/flyda_img/alertlist/4.5.png" /></div>
				<div>196.8&deg;</div>
				<div class="emp"></div>
			</li>
		</ul>
		<ul class="num_ls">
			<li class="alertO">
				<div>风速 <img src="../../assets/flyda_img/alertlist/4.6.png" /></div>
				<div>5.6m/s</div>
				<div class="a_gray">
					四级风
				</div>
			</li>
			<li class="alertR">
				<div>垂直度 <img src="../../assets/flyda_img/alertlist/4.7.png" /></div>
				<div>正面：--&acirc;</div>
				<div class="progress">
					左侧:--&acirc;
				</div>
			</li>
		</ul>
		<ul class="num_ls">
			<li class="alertR">
				<div>力矩 <img src="../../assets/flyda_img/alertlist/4.1.png" /></div>

				<div class="default_btn">
					<p>力矩限位器</p>
					<p>失效</p>
				</div>
			</li>
			<li class="alertG">
				<div>载重 <img src="../../assets/flyda_img/alertlist/4.2.png" /></div>
				<div class="default_btn">
					<p>力矩限位器</p>
					<p>失效</p>
				</div>
			</li>
			<li class="alertG">
				<div>幅度 <img src="../../assets/flyda_img/alertlist/4.3.png" /></div>
				<div class="default_btn">
					<p>力矩限位器</p>
					<p>失效</p>
				</div>
			</li>
			<li class="alertR">
				<div>高度 <img src="../../assets/flyda_img/alertlist/4.4.png" /></div>
				<div class="default_btn">
					<p>力矩限位器</p>
					<p>失效</p>
				</div>
			</li>
			<li class="alertG">
				<div>回转 <img src="../../assets/flyda_img/alertlist/4.5.png" /></div>
				<div class="default_btn">
					<p>力矩限位器</p>
					<p>失效</p>
				</div>
			</li>
		</ul>
		<!--  charts图表         -->

	</div>
</template>

<script>
	export default {

	}
</script>

<style scoped>
	p {
		margin: 0;
	}
	
	
</style>