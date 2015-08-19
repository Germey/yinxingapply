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
    <div class="container">
        <div id="print_and_submit" style="text-align: center">
            <a href="/userinfo" class="btn btn-primary">返回首页</a>
            <?php if(intval($recommend['status']) == 1 OR $recommend['editable'] == 1): ?><a href="/userinfo/edit_recommend?id=<?php echo ($recommend['id']); ?>" class="btn btn-danger">编辑</a>
                <a class="btn btn-primary" onclick="submit_recommend(<?php echo ($recommend['id']); ?>)">提交</a><?php endif; ?>            
            <a href="javascript:void(0)" onclick="print_page()" class="btn btn-success">打印</a><span class="muted">
            &nbsp;&nbsp;使用Chrome浏览器可以直接打印另存为PDF文件</span>
        </div>

        <div class="dashboard_main_content dashboard_preview">
            <h4 class="justcenter" style="margin-top: 40px;">银杏伙伴成长计划项目推荐材料</h4>
            <hr />
            <div class="dashboard_preview">
                <h4>一. 本人信息</h4>
                <ul class="info project">
                    <?php if(is_array($recommend_items)): foreach($recommend_items as $key=>$one): if($key=='name') break; ?>
                        <?php echo project_display_block($key, $recommend_items, $user_info[str_replace('userinfo_','',$key)]); endforeach; endif; ?>
                </ul>
                <div class="clear"></div>

                <h4>二. 推荐理由</h4>
                <ul class="info project">
                    <h5 class="clear sub" style="padding-left: 36px;">被推荐人基本情况</h5>
                    <?php if(is_array($recommend_items)): foreach($recommend_items as $key=>$one): if(strpos($key,'userinfo_')===0) continue; ?>
                        <?php echo project_display_block($key, $recommend_items, $recommend[$key]); endforeach; endif; ?>
                    <?php if(is_array($recommend_questions)): foreach($recommend_questions as $key=>$one): echo project_display_block($key, $recommend_questions, $recommend_question_answers[$key], ++$idx . '. '); endforeach; endif; ?>

                </ul>
            </div>
        </div>
    </div>
</div>  <!--end of container-->

<script type="text/javascript">
    function print_page(){
        $("#print_and_submit").remove();
        window.print();
    }

    function submit_recommend(id) {
        if(window.confirm("是否确认提交申请，提交之后将不能再修改")) {
            window.location.href = "/userinfo/submit_recommend?id="+id;
        }
    }

</script>