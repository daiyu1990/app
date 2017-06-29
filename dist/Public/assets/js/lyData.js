$(document).ready(function(){
	//点击实时数据图片，弹出对应的数据
	$("a.lyDataNow").live("click", function(event){
		var data=[];
	  	$(".lyData").fadeIn("slow");
	  	var num=$(this).parent().parent().find("td");	  	
	  	for(var i=0; i<14;i++){
	  		data.push(num.eq(i).html())
	  	}
	  	$(".num1").each(function(i){
	  		$(this).html(data[i+7]);
	  	})
	})
	
	//点击查询
	$("a.refer").click(function(){
		$(".lyData").fadeIn("slow");
	})
	//点击关闭
	$(".lyClose").click(function(){
		$(".lyData").fadeOut("slow");
	})
	//点击按钮
	$(".lyButtons .lyButton").click(function(){
		$(".lyButtons .lyButton").removeClass("cur").eq($(this).index()).addClass("cur");
		if($(this).index()<3){
			if($(this).index()==1){
				$(".lyList").css("display","none");
				$(".line-two").css("display","none");
			}else{
				$(".lyList").css("display","block");
				$(".line-two").css("display","block");
			}
			$(".lyLineLeft").removeClass("leftDis").eq($(this).index()).addClass("leftDis");
		}else{
			alert("error")
		}	
	})
	//起重机动图
	var h=28;
	var w=45;
	var ow=$(".lyArm span:nth-child(2)").html();
	var oh=$(".lyTower span:nth-child(2)").html();
	$(".goods").css({"left":ow/w*100+"%"})
	$(".heavy").css({"left":ow/w*100+"%","bottom":(oh/h*100)-8+"%"})
	var ropeHeight =(100-parseInt($(".heavy").css("bottom")))/100*170;

	$(".rope").height(ropeHeight-16)
	//实时数据
	var reg=/\w{0,3}%/;
	$(".lyNum").each(function(i){
		var str=$(".lyNum").eq(i).text();
		if(reg.test(str)){
			$(this).css({
				"width":$(".lyNum").eq(i).text()
			}).removeClass("progress1").parent().css("border","1px solid #fad4d1");
		}else{
			$(this).addClass("progress1").parent().css("border","1px solid #666");
		}	   
	});
	//设置当前时间
	function today(){//构建方法
		var today=new Date();//new 出当前时间
		var h=today.getFullYear();//获取年
		var m=today.getMonth()+1;//获取月
		var d=today.getDate();//获取日
		return h+"-"+m+"-"+d; //返回 年-月-日 时:分:秒
	}
	$(".lyInfoData").val(today());

	// 百度地图API功能
	var map = new BMap.Map('map');
	//取一个点进行缩放
	var poi = new BMap.Point(116.307852, 40.057031);
	map.centerAndZoom(poi, 16);
	map.enableScrollWheelZoom();
	
	var overlays = [];
	var overlaycomplete = function(e) {
	    overlays.push(e.overlay);
	    //覆盖物删除事件
	    var removeMarker = function(e, ee, overlay) {
	        map.removeOverlay(overlay);
	    }
	    //信息窗口
	    var info = "";
	    if (e.overlay instanceof BMap.Polygon) {
	        //var pol=(BMap.Polygon)e.overlay;
	        var poi_arr = e.overlay.getPath();
	        for (var i = 0; i < poi_arr.length; i++) {
	            info += "坐标" + i + ":经度为" + poi_arr[i].lng + ",纬度为" + poi_arr[i].lat + "\n";
	
	        }
	        var infoWindow = new BMap.InfoWindow(info); // 创建信息窗口对象
	        map.openInfoWindow(infoWindow, poi_arr[0]); //开启信息窗口
	        //alert(info);
	    } else if (e.overlay instanceof BMap.Marker) {
	
	        info += "坐标:经度为" + e.overlay.getPosition().lng + ",纬度为" + e.overlay.getPosition().lat + "\n";
	        var infoWindow = new BMap.InfoWindow(info); // 创建信息窗口对象
	        map.openInfoWindow(infoWindow, e.overlay.getPosition()); //开启信息窗口
	
	    }
	
	    //创建右键菜单
	    var markerMenu = new BMap.ContextMenu();
	    markerMenu.addItem(new BMap.MenuItem('删除', removeMarker.bind(e.overlay)));
	    e.overlay.addContextMenu(markerMenu);
	};
	
	var styleOptions = {
	    strokeColor: "red", //边线颜色。
	    fillColor: "red", //填充颜色。当参数为空时，圆形将没有填充效果。
	    strokeWeight: 3, //边线的宽度，以像素为单位。
	    strokeOpacity: 0.8, //边线透明度，取值范围0 - 1。
	    fillOpacity: 0.6, //填充的透明度，取值范围0 - 1。
	    strokeStyle: 'solid' //边线的样式，solid或dashed。
	}
	//实例化鼠标绘制工具
	var drawingManager = new BMapLib.DrawingManager(map, {
	    isOpen: false, //是否开启绘制模式
	    enableDrawingTool: true, //是否显示工具栏
	    drawingToolOptions: {
	        anchor: BMAP_ANCHOR_TOP_RIGHT, //位置
	        offset: new BMap.Size(5, 5), //偏离值
	    },
	    circleOptions: styleOptions, //圆的样式
	    polylineOptions: styleOptions, //线的样式
	    polygonOptions: styleOptions, //多边形的样式
	    rectangleOptions: styleOptions //矩形的样式
	});
	//添加鼠标绘制工具监听事件，用于获取绘制结果
	drawingManager.addEventListener('overlaycomplete', overlaycomplete);
	
	function clearAll() {
	    for (var i = 0; i < overlays.length; i++) {
	        map.removeOverlay(overlays[i]);
	    }
	    overlays.length = 0;
	}
	
	
	
	
	//json初始化多边形覆盖物
	var json_data = {
	    "Point": [{
	            "lng": 116.298438,
	            "lat": 40.054905
	        },
	        {
	            "lng": 116.303217,
	            "lat": 40.055126
	        },
	        {
	            "lng": 116.303037,
	            "lat": 40.05253
	        },
	        {
	            "lng": 116.295743,
	            "lat": 40.053303
	        }
	    ]
	};
	
	
	var obj = eval(json_data);
	//alert(obj.Point[0].lat);
	
	//point数组
	var point_array = obj.Point;
	//array初始化多边形覆盖物
	/*var point1=new BMap.Point(116.298438,40.054905);
	var point2=new BMap.Point(116.303217,40.055126);
	var point3=new BMap.Point(116.303037,40.05253);
	var point4=new BMap.Point(116.295743,40.053303);
	var point_array=new Array();
	point_array.push(point1);
	point_array.push(point2);
	point_array.push(point3);
	point_array.push(point4);*/
	
	var polygon = new BMap.Polygon(point_array, {
	    strokeColor: "blue",
	    strokeWeight: 2,
	    strokeOpacity: 0.5
	});
	map.addOverlay(polygon);
	
	var p_arr = polygon.getPath();
	var init_info = "";
	for (var i = 0; i < p_arr.length; i++) {
	    init_info += "坐标" + i + ":经度为" + p_arr[i].lng + ",纬度为" + p_arr[i].lat + "\n";
	}
	var infoWindow1 = new BMap.InfoWindow(init_info); // 创建信息窗口对象
	var point1 = new BMap.Point(obj.Point[0].lng, obj.Point[0].lat);
	map.openInfoWindow(infoWindow1, point1); //开启信息窗口
})
