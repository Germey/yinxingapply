<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  lang="en">
<head>
  <meta http-equiv=content-type content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?php echo ($INI['site_title']); ?></title>
  <meta name="description" content="<?php echo ($INI['site_description']); ?>" />
<?php if($seo_keyword): ?><meta name="keywords" content="<?php echo ($seo_keyword); ?>" />
<?php else: ?>
  <meta name="keywords" content="<?php echo ($INI['keywords']); ?>" /><?php endif; ?>
  <link rel="shortcut icon" href="/styles/css/images/favicon.ico" />
  <link rel="stylesheet" href="/styles/css/bootstrap.css" type="text/css" media="screen,print" charset="utf-8" />
  <link rel="stylesheet" href="/styles/css/main.css" type="text/css" media="screen,print" charset="utf-8" />

  <script src="/styles/js/main.js" type="text/javascript"></script>
  <script type="text/javascript" src="/styles/js/jquery.placeholder.min.js"></script>
  <script src="/styles/js/jquery.formatCurrency-1.4.0.js" type="text/javascript"></script>

  <script type="text/javascript" src="/styles/js/location.js"></script>
  <script type="text/javascript" src="/styles/js/jquery.datetimepicker/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="/styles/js/jquery.datetimepicker/bootstrap-datetimepicker.zh-CN.js"></script>
  <link rel="stylesheet" href="/styles/js/jquery.datetimepicker/bootstrap-datetimepicker.css" type="text/css" media="screen" />

  <script type="text/javascript" src="/styles/js/ueditor/editor_config.js"></script>
  <script type="text/javascript" src="/styles/js/ueditor/editor_all_min.js"></script>

  <script type="text/javascript" src="/styles/js/jquery.uploadify/jquery.uploadify.v2.1.4.min.js"></script>
  <script type="text/javascript" src="/styles/js/jquery.uploadify/swfobject.js"></script>
  <link rel="stylesheet" href="/styles/js/jquery.uploadify/uploadify.css" type="text/css" media="screen" charset="utf-8" />
</head>
<body>

<div id="dashboard">

<div class="top">
  <div class="container" style="position: relative">
    <a href="/userinfo"><img id="logo" src="/styles/css/images/logo.png" style="height: 63px;" /></a>
    <div class="pull-right">
      您好<?php echo ($login_user['email']); ?> 欢迎来到<?php echo ($INI['site_name']); ?>！
        <a href="/dashboard/account_info">修改密码</a>
        <a href="/register/logout">退出登录</a>
    </div>
  </div>
</div>

<!-- <div class="clear container">
    <div class="navbar navbar-static-top" style="margin-top:2px">
      <div class="navbar-inner" style="box-shadow: none;">
        <div class="container">
          <div class="nav-collapse collapse" >
            <ul class="nav">
                <li <?php if(MODULE_NAME == 'Userproject'): ?>class="active"<?php endif; ?> >
                  <a href="/userproject">申请项目</a>
                </li>
                <li <?php if(ACTION_NAME == 'account_info'): ?>class="active"<?php endif; ?>>
                  <a href="/dashboard/account_info">密码修改</a>
                </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
</div> -->

<div class="container" style="min-height:500px">
<div style="margin-top: 10px">
  <?php if(($module_selector == 'edit_recommend' || $module_selector == 'edit_userinfo' )&& $display != 'preview' ): ?><div class="sidebar_nav affix" data-spy="affix" data-offset-top="110">
        <ul class="nav nav-pills nav-stacked">
            <?php echo dashboard_sidebar($selector, $module_selector);;?>
        </ul>
          <a href="javascript:void(0)" onclick="ajax_save();">
          <label class="label-warning temp_save" >
            <i class="icon-white icon-file"></i>&nbsp;保存草稿
          </label>
          </a>
        <div class="clear"></div>
        <label class="label-info temp_save" id="click_preview" onclick="click_preview()">
          <i class="icon-white icon-share-alt"></i>&nbsp;点击预览
        </label>
        <label class="label-success temp_save temp_save_nocursor" >
          <i class="icon-white icon-ok"></i>&nbsp;填写进度&nbsp;<span id="complete_percentage">0%</span>
        </label>
     <script type="text/javascript">
        $(document).ready(function(){
          sleep_and_count_percentage();
          // $('[name]').keyup(sleep_and_count_percentage);
          // $('select').change(sleep_and_count_percentage);
        })

        function sleep_and_count_percentage(){
          setInterval(count_percentage, 3000);
        }

        function count_percentage(){
            var total = 0;
            var empty = 0;

            //同步一下ueditor
            var editors = simpleeditor_map.values();
            for (var i = 0; i < editors.length; i++) {
                var editor = editors[i];
                editor.sync();
            }

            var exclude_list = new Array('quality','wmode','allowScriptAccess','flashvars');

            $('form [name]').each(
                function(index, item) {
                  var type = $(item).prop("type");
                  var item_class = $(item).prop("class");
                  
                  if((item_class && item_class.indexOf('group_span')>=0) || type == "hidden" || !$(item).prop("id")) {
                      return true;
                  }

                  if(!$(item).is("a") && !$(item).is("meta") && exclude_list.indexOf($(item).prop('name'))==-1){
                    total++;
                    var value = $(item).val();
                    if(value == ""){
                      empty++;
                    }
                  }

                  // param[$(item).attr('name')] = $(item).val();
                }
            );
            var percentage = Math.floor((1 - parseFloat(empty)/total) * 100);
            $("#complete_percentage").html(percentage + "%");
        }
      </script>


    </div><?php endif; ?>
    <?php if(($module_selector == 'edit_recommend' || $module_selector == 'edit_userinfo' )&& $display != 'preview' ): ?><div class="dashboard_main_content">
    <?php else: ?>
      <div class="dashboard_main_content" style="width:980px;padding:10px"><?php endif; ?>
    <?php if(Session::get('success')): ?><div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <?php echo Session::get("success", true);?>
      </div><?php endif; ?>
    <?php if(Session::get('error')): ?><div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
          <?php echo Session::get("error", true);?>
      </div><?php endif; ?>
    

</script>
<div class="label label-success draft-save-tip" id="draft-save-tip"><p>已自动保存草稿</p></div>
<div class="label label-warning alert-tip" id="alert-tip"><p>警告框</p></div>
<h4 class="justcenter">银杏伙伴成长计划项目推荐材料</h4>
<hr>

<form action="/userinfo/save_recommend" method="post" onsubmit="return beforeSubmit();" id="mainform">
    <input type="hidden" name="id" id="id" value="<?php echo ($recommend['id']); ?>">
    <input type="hidden" name="myformtoken" value="<?php echo ($myformtoken); ?>">

    <a name="_basic_info"></a>
    <h4>一. 本人信息</h4>
    <ul class="info project">
        <?php if(is_array($recommend_items)): foreach($recommend_items as $key=>$one): if($key=='userinfo_email') { $user_info['email'] = $login_user['email']; } if($key=='name') break; ?>
            <?php echo project_block($key, $recommend_items, $user_info[str_replace('userinfo_','',$key)]); endforeach; endif; ?>
    </ul>
    <div class="clear"></div>

    <a name="_detail"></a>
    <h4>二. 推荐理由</h4>
    <ul class="info project">
        <h4 class="clear sub">被推荐人基本情况</h4>
        <?php if(is_array($recommend_items)): foreach($recommend_items as $key=>$one): if(strpos($key,'userinfo_')===0) continue; ?>
            <?php echo project_block($key, $recommend_items, $recommend[$key]); endforeach; endif; ?>
        <?php if(is_array($recommend_questions)): foreach($recommend_questions as $key=>$one): echo project_block($key, $recommend_questions, $recommend_question_answers[$key], ++$idx . '. '); endforeach; endif; ?>
    </ul>

    <div class="clear"></div>
    <br />
    <input type="hidden" value='<?php echo Session::get("project_alert_item_keys", true);?>' id="project_alert_item_keys" />
    <p class="text-center"><input type="submit" class="btn btn-large btn-success" value="保存预览"/></p>
    
</form>
<script type="text/javascript">
//后期整改新增JS
$(function() {
    //不能修改内部函数，利用JS来隐藏输入框
    //$("#userinfo_address").css("display", "none");
    $("#address").css("display", "none");
    //绑定点击事件
    $("table").on("click", ".delete_group_line", function() {
        delete_group_line($(this));
    });
    //检查工作时间
    $("input[name='userinfo_work_from']").on("change", function() {
        var year = parseInt($(this).val().split("-")[0]);
        var nowYear = new Date().getFullYear();
        if(nowYear - year < 10) {
            if (!window.confirm("您的工作年限暂时不符合银杏计划对推荐人的要求，本次推荐有肯能无效，是否继续？")){
                window.location.href="/userinfo";
            } 
        }
    });
});



//获取项目信息中未填写信息的id,将边框变红
var project_alert_item_keys = $("#project_alert_item_keys").val();
if(project_alert_item_keys){
  var idArr = project_alert_item_keys.split(',');
  var len = idArr.length;
  for(var i = 0;i<len;i++){
    var id = "#"+idArr[i];
    $(id).css("border-color",'red');
  }
}

//////////////////项目详情部分/////////////////////////////

$(document).ready(function(){
    $("textarea.limited").each(function(){
        change_count(this, parseInt($(this).attr('data-limit')));
    })

    $("textarea.limited").keyup(function(){
        change_count(this, parseInt($(this).attr('data-limit')));
    })
})

function change_count(element, max) {
    var len = $(element).val().length;
    var id = $(element).attr('id');
    var limit_type = $(element).attr('limit_type');


    var len_span = $("#"+id+'_limit_tip');

    if(limit_type=='min_as') {
        if(len < max){
            len_span.css("color", "red");
            len += "（还不够）";
        }else{
            len_span.css("color", "#999");
        }
    } else {
        var maxLength=$(element).attr('maxlength',max);
        if(len >= max){
            len_span.css("color", "red");
            len += "（字符超限了）";
        }else{
            len_span.css("color", "#999");
        }
    }
    len_span.html(len);
}


//////////////////////财务文件///////////////////////////////
var attachments = new Map();

$(document).ready(function() {

    // Prevent Users from submitting form by hitting enter
    $('input,select').keypress(function(event) { return event.keyCode != 13; });

    $('#upload-finance').uploadify({
      'uploader' : '/styles/js/jquery.uploadify/uploadify.swf',
      'script' : '/styles/js/jquery.uploadify/uploadify.php',
      'cancelImg' : '/styles/js/jquery.uploadify/cancel.png',
      'buttonImg': '/styles/js/jquery.uploadify/select.png',
      'width': 170,
      'auto' : true,
      'queueID' : 'custom-queue',
      'multi' : true,
      'simUploadLimit' : 1,
      'sizeLimit' : 11000000,
      'removeCompleted' : false,
      'onComplete' : function(event, ID, fileObj, response, data) {
            //安全问题，限制文件后缀
            if(response==0) return alert('文件后缀不允许：' + fileObj.name);
            var file = new Array(response, fileObj.name, fileObj.size);
            attachments.put(ID, file);
      },
      'onCancel' : function(event, ID, fileObj, data) {
          attachments.remove(ID);
          $("#note"+ID).remove();
      }
    });
});


function delete_file(id, element) {
    if(window.confirm('确定删除该附件？')) {
        attachments.remove(id);
        $(element).parent().parent().remove();
        // 真实删除
        X.get('/userinfo/delete_attachment?project_id='+ $("#project_id").val() +'&id='+id);
    }
}

////////////////////////////////提交////////////////////////////////////////////////
function beforeSubmit(){
    // return false;
    var idMap = new Map();

    idMap.put("attachments", attachments);

    var keys = idMap.keys();
    for (var i = 0; i < keys.length; i++) {
        var id = keys[i];
        var list = idMap.get(id);
        if(list){
            var list_vals = list.values();
            list_vals = list_vals.join("||");
            $("#" + id).val(list_vals);
        }
    };
}


//写完题目之后自动保存一下 主要解决的问题好似添加项目计划的时候能有ID
//每隔5分钟自动保存
$(document).ready(function() {
    $("#userinfo_name").blur(function(){  ajax_save();  });
    setInterval(ajax_save, 60 * 1000 );

    $("#email").blur(function(){
        $("#bademailtip").remove();
        var email = $(this).val();
        var reg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/i;
        if(!reg.test(email)) {
            $(this).after('<div class="text-error" id="bademailtip">格式有误</div>');
        }
    });

    // $("#mobile").blur(function(){
    //     $("#badmobiletip").remove();
    //     var mobile = $(this).val();
    //     var reg = /^1[345]\d{9}$|^18d{9}$|^0\d{9,10}$/;
    //     if(!reg.test(mobile)) {
    //         $(this).after('<div class="text-error" id="badmobiletip">格式有误</div>');
    //     }
    // });    
});

function ajax_save(){
    if(!$('#userinfo_name').val()) {
        alert('姓名不能为空'); return;
    }

    beforeSubmit();

    var editors = simpleeditor_map.values();
    for (var i = 0; i < editors.length; i++) {
        var editor = editors[i];
        editor.sync();
    };

    var param = {};
    $('#mainform [name]').each(
        function(index, item) {
            var v = $(item).val();
            var k = $(item).attr('name');

            if(k.indexOf("[]") > 0) {
                if(!param[k]) {
                    param[k] = [];
                }

                if($(item).attr('type')=='checkbox') {
                    if($(item).attr('checked')=='checked') {
                        param[k].push(v);
                    }
                } else {
                    param[k].push(v);
                }
            } else {
                param[k] = v;
            }
        }
    );
    $.ajax({
        url: '/userinfo/ajax_save_recommend',
        type: 'POST',
        async: false,
        data: param,
        dataType: 'html',
        timeout: 18000,
        error: function() {
          alert('Internal server error');
          return false;
        },
        success: function(html) {
          var res = parseInt(html);
          if(res) {
            show_save_tip();
          }
          if(res) {
            $("#id").val(res);
          }
        }
    });
}

function show_save_tip() {
    $("#draft-save-tip").show();
    setTimeout("$('#draft-save-tip').slideUp('slow', function(){ $('#draft-save-tip').hide(); })", 5000);
}

function show_alert_tip(msg) {
    $("#alert-tip").html("<p>"+msg+"</p>").show();
    setTimeout("$('#alert-tip').slideUp('slow', function(){ $('#alert-tip').hide(); })", 5000);
}

function click_preview() {
    var id = $("#id").val();
    if(!id) {
        setTimeout(ajax_save(), 4000);
    }
    window.open('/userinfo/preview_recommend?id='+id);
}

// jQuery(document).bind('keydown', 'Ctrl+s',function (evt) { ajax_save(); return false; });

function nl2br(str, is_xhtml) {
    if($.browser.msie == true) {
      var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display
      return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');    
    }
    return str;
}

$(document).ready(function() {
    $("#title").blur(function(){  ajax_save();  });

    // 城市下拉框
    setupcity();

    $('.option_other_tag').click(function(){
        $(this).find(".option_other").focus();
    });

    $('.option_other').change(function(){
        // $(this).find(".option_other").focus();
        var target_id = 'value_' + $(this).attr('id');
        $("#"+target_id).val('【其他】' + $(this).val());
    });

    $('.option_other').click(function(){
        var target_id = 'value_' + $(this).attr('id');
        $("#"+target_id).prop('checked', true);
    });

});

//删除一行
function delete_group_line(element) {
    var parentLine = element.parent().parent();
    var siblings = parentLine.siblings();
    if (siblings.length > 0) {
        parentLine.remove();
    } else {
        show_alert_tip("至少需要填写一行");
    }
    
}

function add_group_line(key) {
    var line = $('<div>').append($('#group_new_table_'+key).find("tr:last").clone()).html();
    $('#group_new_table_'+key).find("tbody").append(line);
    
}

function caculate_budget_fee() {
    var sum = 0;
    var total = $('#need_budget').val();
    $(".type_fee").each(function(){
        var val = parseFloat($(this).val().replace(/,/g,''));
        if(!isNaN(val)) {
            sum += val;
        }
    });
    
    var left = parseFloat(total.replace(/,/g,'')) - sum;
    if(left<0) {
        alert('填写预算超了');
    }

    $('#temp_fee').remove();
    $('#project_detail_finance_title').after('<span id="temp_fee" style="padding-left:10px;color:red">预算总额：￥'+total+'，已填写：￥<span class="money">'+sum+'</span>，剩余：￥<span class="money">'+left+'</span></span>');
    init_money_input();
}

function init_money_input() {
  $('.money').formatCurrency({ symbol: '', negativeFormat: '-%s%n', roundToDecimalPlace: 1 });    
  $('.money').blur(function() {
    $(this).formatCurrency({ symbol: '', negativeFormat: '-%s%n', roundToDecimalPlace: 1 });
  });
}

function change_type(item) {
    if(window.confirm('确定要修改申请类型？')) {
        X.get('/userinfo/ajax_change_type?to='+item.value);
    }

}

</script>

</div>
<div id="modaldialog"></div>
</div>
</div>  <!--end of container-->
<script type="text/javascript">
    $(document).ready(function(){
        $(".datepicker").datetimepicker({language: 'zh-CN',startView: 2,minView: 2,format: "yyyy-mm",autoclose: true,todayBtn: true});
    });
</script>
<div id="footer">
    <div class="container">
        <table style="width:100%">
            <tr>
                <td>
                    <p>Copyright©<?php echo date('Y');?> <?php echo ($INI['site_name']); ?> 版权所有</p>
                    <p><a target="_blank" href="http://www.naradafoundation.org/category/35">回到<?php echo ($INI['site_name']); ?>官网</a></p>
                    <div>京ICP备12048184号</div>
                </td>
                <td class="text-right">
                    <img style="width:100px;" src="/styles/css/images/wechat.png" />
                </td>
            </tr>
        </table>
    </div>
</div>

</div> <!--end of front-->
</body>
</html>