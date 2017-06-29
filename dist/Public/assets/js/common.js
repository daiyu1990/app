//需加载layer

var SJ={
	init:function(){
            this.chosen();
            this.delete();
            this.formInit();
	},
  edTools:'',
	//三级联动地级市
	//省市区选择器可以为id可以为元素也可以为类
	    setArea:function(province,city,area){
  		   $(province).change(function(){
      			var that = $(this);
      			if(that.attr('target')==undefined){
      				return false;
      			}
      			if(that.val() == 0){
      				if(that.attr('target').indexOf('city') >-1){
      					$(city).html('<option value="0">城市</option>');
      					$(area).html('<option value="0">地区</option>');
      					return false;
      				} else if(that.attr('target').indexOf('area') >-1){
      					$(area).html('<option value="0">地区</option>');
      					return false;
      				}
      			}
      			$.ajax({
      				url:'/Api/Plugin/getChild',
      				data:{'pid':that.val(),'code':'area'},
      				type:'post',
      				dataType:'json',
      				success:function(res){
      					if(res.status==1){
      					res = res.nextData;
      					var html = '<option value="0">'+(that.attr('target').indexOf('city') >-1?'城市':'地区')+'</option>';
      					for(var i in res){
      						html += '<option value="'+res[i].id+'">'+res[i].name+'</option>';
      					}
      					$(that.attr('target')).html(html);
      					}else{
      						//layer.msg(res.msg);
      					}
      				}
      			})
      		})
           $(document).on('change',city,function(){
            var that = $(this);
            if(that.attr('target')==undefined){
              return false;
            }
            if(that.val() == 0){
                $(area).html('<option value="0">地区</option>');
                return false;              
            }
            $.ajax({
              url:'/Api/Plugin/getChild',
              data:{'pid':that.val(),'code':'area'},
              type:'post',
              dataType:'json',
              success:function(res){
                if(res.status==1){
                res = res.nextData;
                var html = '<option value="0">'+(that.attr('target').indexOf('city') >-1?'城市':'地区')+'</option>';
                for(var i in res){
                  html += '<option value="'+res[i].id+'">'+res[i].name+'</option>';
                }
                $(that.attr('target')).html(html);
                }else{
                  //layer.msg(res.msg);
                }
              }
            })
          })
	   },
      selCate:function(element){
           $(element).change(function(){
                  var that = $(this);
                  if(that.index()==1){
                        return false;
                  }
                  $.ajax({
                        url:'/Api/Plugin/getChild',
                        data:{'pid':that.val(),'code':'business'},
                        type:'post',
                        dataType:'json',
                        success:function(res){
                              if(res.status != 1){
                                    // layer.alert(res.msg);
                                    return false;
                              }
                              res = res.nextData;
                              var html = '';
                              for(var i in res){
                                    html += '<option value="'+res[i].id+'">'+res[i].name+'</option>';
                              }
                              that.next('select').html(html);
                        }
                  })
            }) 
      },
      getFx:function(element,_code){
           $(element).change(function(){
                  var that = $(this);
                  if(that.index()==1){
                        return false;
                  }
                  $.ajax({
                        url:'/Api/Plugin/getFx',
                        data:{'pid':that.val()},
                        type:'post',
                        dataType:'json',
                        success:function(res){
                              if(res.status != 1){
                                    // layer.alert(res.msg);
                                    return false;
                              }
                              res = res.nextData;
                              var html = '';
                              for(var i in res){
                                    html += '<option value="'+res[i].id+'">'+res[i].name+'</option>';
                              }
                              that.next('select').html(html);
                        }
                  })
            }) 
      },
      //打开窗口
      openLayer: function(title,html,name){
        layer.closeAll('loading');
        this.name = layer.open({
            type: 1,
            title: title,
            area: ['680px', '600px'], //宽高
            closeBtn: 2, //不显示关闭按钮
            shift: 2,
            shadeClose: true, //开启遮罩关闭
            content: html
        });
    },
      load:function(){
        layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
      } ,
      //删除记录
      delete:function(_id){
        var _this = this;
        $(document).on('click','.ajax-delete-btn',function(){
              var _that = $(this);
              layer.confirm('确认'+_that.text(), {
                btn: ['确定','取消'] //按钮
              }, function(){
              _this.load();
              var _url = $(_that).attr('href');  
              $.post(
                    _url,
                    {id:_id},
                    function(e){
                          layer.closeAll('loading');
                          if(e.ok!=undefined){
                                Page.renderTable();
                          }else{
                                layer.msg(e.error)
                          }
                    },
                    'json'
                    );                     
              });            
                return false;
        })
      },
      //下拉框优化
      chosen:function(){
            var opt = {
            no_results_text: "查询无记录", 
            placeholder_text : "", 
            search_contains: true,
            disable_search_threshold: 1
            }
            $('.chosen-select').chosen(opt);
      },
//接下来是表单类
      formInit:function(){
        $('.form-must').on('click',function(){
          $(this).removeClass('has-success');
          $(this).addClass('has-error')
        })
        $('.form-must').on('blur',function(){
          $(this).addClass('has-success');
          $(this).removeClass('has-error')
        })        
      },
      ajaxUploadone: function(element){
            var _this = this;
            new AjaxUpload($(element),{
                action: "/Api/Plugin/upload_img",
                name: 'upload_pic',
                responseType:'json',
                onSubmit : function(file, ext){
                    if (ext && /^(jpg|png|jpeg|gif|JPG)$/.test(ext)){
                        this.setData({
                            'do': 'upload',
                            'oldimg':$('#default_img').attr('src')
                        });
                    } else {
                         layer.msg('文件格式错误，请上传格式为.png .jpg .jpeg 的图片');
                        return false;               
                    }
                    this.disable();
                    _this.load();
                },
                onComplete: function(file, response){
                    layer.closeAll();
                    if(response.status==0){
                        layer.msg(response.msg);
                    } else {
                        $('#default_img').attr('src',response.img);
                        $('#upload_pic').val(response.img);
                    }                
                                
                    this.enable();     
                         
                }
            });
        },
      qiniu:function(qn_token){
          var loadingIndex;
                  //引入Plupload 、qiniu.js后
          var uploader = Qiniu.uploader({
              runtimes: 'html5,flash,html4',    //上传模式,依次退化
              browse_button: 'file_upload',       //上传选择的点选按钮，**必需**
              uptoken : qn_token,
              unique_names: true, // 默认 false，key为文件名。若开启该选项，SDK为自动生成上传成功后的key（文件名）。
              domain: 'http://qiniu.adoceans.com/',   //bucket 域名，下载资源时用到，**必需**
              get_new_uptoken: false,  //设置上传文件的时候是否每次都重新获取新的token
              max_file_size: '30mb',           //最大文件体积限制
              flash_swf_url: 'js/plupload/Moxie.swf',  //引入flash,相对路径
              max_retries: 3,                   //上传失败最大重试次数
              chunk_size: '4mb',                //分块上传时，每片的体积
              auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
              init: {
                  'FilesAdded': function(up, files) {
                  },
                  'BeforeUpload': function(up, file) {
                      loadingIndex = layer.load(1, {
                        shade: [0.1,'#fff'] //0.1透明度的白色背景
                      });
                         // 每个文件上传前,处理相关的事情
                  },
                  'UploadProgress': function(up, file) {
                         // 每个文件上传时,处理相关的事情
                  },
                  'FileUploaded': function(up, file, info) {
                         var domain = up.getOption('domain');
                         var res = $.parseJSON(info);
                         var sourceLink = domain + res.key;

                         console.info(sourceLink);
                         //$('#imgsName').val($('#imgsName').val()+sourceLink+',');
                         var html = '';
                          html = '<div class="row"><div class="col-md-6">'
                          html +='<img width="150px;" src="'+sourceLink+'" class="showImg"/>'
                          html +='</div><div class="col-md-6">'
                          html +='<a href="javascript:;" class="img_del btn btn-sm btn-danger">删除</a>'
                          html +='<input type="hidden" value="'+sourceLink+'" name="img[]"/></div></div>';
                          $('#show_img').append(html);
                         
                  },
                  'Error': function(up, err, errTip) {
                      layer.close(loadingIndex);
                         //上传出错时,处理相关的事情
                  },
                  'UploadComplete': function() {
                      layer.close(loadingIndex);
                         //队列文件处理完毕后,处理相关的事情
                  },
                  'Key': function(up, file) {
                      // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                      // 该配置必须要在 unique_names: false , save_key: false 时才生效
                      var key = "";
                      // do something with key here
                      return key
                  }
              }
          }); 
          $(document).on('click','.img_del',function(){
              var that = $(this);
              if(!window.confirm('确定删除？')){
                  return false;
              }
              var loadingIndex = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                  });
              var imgpath = that.parent().parent().find('.showImg').attr('src');
              $.ajax({
                  url:'/Api/Plugin/deleteQiNiu',
                  type:"post",
                  data:{do:'del',img:imgpath},
                  success:function(res){
                      layer.close(loadingIndex);
                      if(res == 'ok'){
                          that.parent().parent().remove();
                          // var curimgs = $('#imgsName').val();
                          // var c_curimgs = curimgs.replace(imgpath+',','');
                          // $('#imgsName').val(c_curimgs);
                      } else {
                          layer.alert(res);
                      }
                  }
              })
          })                 
      }          
     
}
$(function(){
      SJ.init();
})


