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
    

<table style="width: 100%">
  <tr>
    <th style="width: 120px;text-align: center;font-size: 16px;vertical-align: top">我的申请</th>
    <td>
      <?php if($userinfo['invite_code']): ?><span>&nbsp;&nbsp;推荐人：<?php echo ($recommend_name); ?>@<?php echo ($userinfo['recommend_info']['recommend_submit_time']); ?></span>
          <span class="pull-right">          
            <?php if(intval($user_info['status']) == 50 OR $user_info['editable'] == 1): ?><a href="/userinfo/edit" class="btn btn-danger"><i class="icon-pencil icon-white"></i> 编辑</a>&nbsp;
                <a href="javascript:void(0)" class="btn btn-primary" onclick="submit_userinfo()"><i class="icon-ok icon-white"></i> 提交</a>&nbsp;<?php endif; ?>
            <a href="/userinfo/preview" class="btn" target="_blank"><i class="icon-print"></i> 预览</a>
            <?php if($user_info['status'] > 50): ?><a href="/userinfo/upload_files" class="btn btn-danger" target="_blank"><i class="icon-chevron-up icon-white"></i> 上传资料</a><?php endif; ?>
          </span>
      <?php else: ?>
        <div class="text-center">
          <div>
            <a class="ajaxlink btn btn-success btn-large" onclick="$(this).hide();$('#invide_code_form').show();">我是候选人，校验邀请码</a>
            <form id="invide_code_form" method="get" action="/userinfo/check_invite_code" style="margin: 10px 0 0 0; display: none;">
              <div class="input-append">
                <input type="number" class="span3" name="invite_code" placeholder="请输入六位邀请码">
                <input type="submit" class="btn btn-success" value="验证" />
              </div>    
            </form>
          </div>
          <div></div>
        </div><?php endif; ?>
    </td>
  </tr>
  <tr><td colspan="2"><hr style="margin: 30px; border-top: 1px dashed #CCC;" /></td></tr>
  <tr>
    <th style="width: 120px;text-align: center;font-size: 16px;vertical-align: top">我的推荐</th>
    <td>
      <?php if($recommends): ?><table class="table table-bordered" style="margin-bottom: 0">
          <tr>
            <th style="width: 100px;">被推荐人姓名</th>
            <th>更新时间</th>
            <th>操作</th>
          </tr>
          <?php if(is_array($recommends)): foreach($recommends as $key=>$one): ?><tr>
              <td><?php echo ($one['name']); ?></td>
              <td><span title="<?php echo ($one['update_time']); ?>"></span><?php echo substr($one['update_time'],0,10);?></span></td>
              <td>
                <?php if(intval($one['status']) < 2 OR $one['editable'] == 1): ?><a class="btn btn-small btn-danger" href="/userinfo/edit_recommend?id=<?php echo ($one['id']); ?>">编辑</a>
                  <a class="btn btn-small btn-primary" onclick="submit_recommend(<?php echo ($one['id']); ?>)">提交</a><?php endif; ?>
                <a target="_blank" class="btn btn-small" href="/userinfo/preview_recommend?id=<?php echo ($one['id']); ?>">预览</a>
              </td>
            </tr><?php endforeach; endif; ?>
        </table>
        <div class="text-center">
          <a href="/userinfo/edit_recommend" class="btn btn-primary btn-large again-recommend">继续推荐</a>
        </div>
      <?php else: ?>
        <div class="text-center">
          <a href="/userinfo/edit_recommend" class="btn btn-primary btn-large">我是推荐人，马上去推荐</a>
        </div><?php endif; ?>
    </td>
  </tr>  
</table>

<script type="text/javascript">

    function submit_userinfo(id) {
        if(window.confirm("是否确认提交申请，提交之后将不能再修改")) {
            window.location.href = "/userinfo/submit_notice";
        }
    }

    function submit_recommend(id) {
        if(window.confirm("是否确认提交推荐表，提交之后将不能再修改")) {
            window.location.href = "/userinfo/submit_recommend?id="+id;
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