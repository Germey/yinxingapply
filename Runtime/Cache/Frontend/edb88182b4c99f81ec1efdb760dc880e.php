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
    <script type="text/javascript" src="/styles/js/jquery.uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" src="/styles/js/jquery.uploadify/swfobject.js"></script>
<link rel="stylesheet" href="/styles/js/jquery.uploadify/uploadify.css" type="text/css" media="screen" charset="utf-8" />


<h4 class="justcenter">
  上传项目附件（阶段报告，统计表格等）
  <a class="pull-right" href="/userinfo" style="font-size:14px;">&lt;返回</a>
</h4>

<hr>
<?php if($attachments): ?><h5>已上传的文件列表</h5>
  <table class="table table-bordered">
    <tr><th>所在目录</th><th>文件名称</th><th>大小</th><th>上传人</th><th>上传日期</th><th>操作</th></tr>
    <?php if(is_array($attachments)): foreach($attachments as $key=>$one): ?><tr>
        <td nowrap><?php echo ($dirs[$one['dir_id']]); ?></td>
        <td nowrap><?php echo ($one['title']); ?></td>
        <td><b><?php echo formatBytes($one['size']);?></b></td>
        <td>
          <?php echo ($one['create_user_id']>2000?$user_info['name']:'管理员'); ?>
        </td>
        <td><?php echo substr($one['create_time'],0,16);?></td>
        <td>
          <a href="/attachment/download?module=user&uid=<?php echo ($login_user['id']); ?>&id=<?php echo ($one["id"]); ?>">下载</a>
          <?php if($user_info['id'] == $one['create_user_id']): ?>&nbsp;<a href="/attachment/ajax_delete?module=user&uid=<?php echo ($login_user['id']); ?>&id=<?php echo ($one["id"]); ?>" class="ajaxlink">删除</a><?php endif; ?>
        </td>
      </tr><?php endforeach; endif; ?>
  </table><?php endif; ?>

<form action="/userinfo/submit_attachment" method="post" onsubmit="return beforeSubmit();">
    <input type="hidden" name="user_id" value="<?php echo ($login_user['id']); ?>">
    <p>
      <div>1. 上传支教相关的任何附件，包括但不限于：各种报告，财务报表，反馈感想等</div>
      <div>2. 单个文件大小不超过10M，允许上传的文件类型：压缩包、Word、Excel、PPT、PDF、TXT、常用图片文件</div>
    </p>    
    <div>
      <input type="file" id="upload-finance" name="upload-finance" />
      <p id="custom-queue" name="custom-queue"></p>
    </div>
    <input type="hidden" name="attachments" id="attachments" value="" />
    <input type="submit" class="btn btn-danger" value="确认保存" id="save_attachment_btn" style="display: none;" />
</form>

<script type="text/javascript">
  var attachments = new Map();

  $(document).ready(function() {
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
        'sizeLimit' : 10000000,            //大概4M
        'removeCompleted' : false,
        'onComplete' : function(event, ID, fileObj, response, data) {
              //安全问题，限制文件后缀
              if(response==0) return alert('文件后缀不允许：' + fileObj.name);
              var file = new Array(response, fileObj.name, fileObj.size, ID);
              attachments.put(ID, file);
              $("#save_attachment_btn").show();

              var str = '<select name="dir_id'+ID+'" id="dir_id'+ID+'"><option value="0">- 请选择所在目录 -</option><?php if(is_array($dirs)): foreach($dirs as $key=>$value): ?><option value="'+"<?php echo ($key); ?>"+'">'+"<?php echo ($value); ?>"+'</option><?php endforeach; endif; ?></select>';
              $("#upload-finance"+ID).after(str);

        },
        'onCancel' : function(event, ID, fileObj, data) {
            attachments.remove(ID);
            $("#note"+ID).remove();
        }
      });
  });


function beforeSubmit() {

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
    }
}
</script>



</div>
<div id="modaldialog"></div>
</div>
</div>  <!--end of container-->
<script type="text/javascript">
    $(document).ready(function(){
        $(".datepicker").datetimepicker({language: 'zh-CN',startView: 2,minView: 2,format: "yyyy-mm-dd",autoclose: true,todayBtn: true});
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