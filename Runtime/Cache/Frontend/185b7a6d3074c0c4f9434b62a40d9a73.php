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

<div class="front">

<div class="top">
    <div class="container">
        <a href="/"><img id="logo" src="/styles/css/images/logo.png" style="height: 63px;" /></a>
    </div>
</div>

<div class="container" style="min-height:500px">
    <div class="justcenter">
        <?php if(Session::get('success')): ?><div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
              <?php echo Session::get("success", true);?>
          </div><?php endif; ?>
        <?php if(Session::get('error')): ?><div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">×</button>
              <?php echo Session::get("error", true);?>
          </div><?php endif; ?>
    </div>

<div style="margin-top: 10px">
    
    <div class="container" style="width:780px">

        <div class="reg_image">
            <img src="/styles/css/images/register_flow_2.png" alt="" />
        </div>
        <div class="register_block" style="padding:20px">
            <img src="/styles/css/images/big_correct.png" alt="" style="height: 30px; float: left; margin: 4px 5px"/> <h4>恭喜您注册成功</h4>
            <hr />
            我们发了一封邮件到<?php echo ($email); ?>，请查收您的邮件并点击邮件中的链接进行验证
            <div class="no_email_tips">
              <h5>没有收到邮件？</h5>
              <ul>
                <li>请稍等几分钟，邮件服务器可能会有延迟</li>
                <li>可能被误判为垃圾邮件了，请到垃圾邮件箱找找看</li>
                <li>如果没有找到，请点击这里重新发送到<?php echo ($email); ?> : <a href="/register/resend_email?id=<?php echo ($id); ?>">点击这里重新发送</a></li>
              </ul>
            </div>
        </div>
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