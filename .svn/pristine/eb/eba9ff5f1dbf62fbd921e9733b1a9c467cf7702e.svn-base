<?php


function header_nav(){
    $types = D('PageTypes')->getStruectTypes();

    foreach ($types as $k => $v) {
      if(!$k) continue;
      if(!$v['link']) {
        $v['link'] = '#' . $v['id'];
      }

      $navs[$v['link']]['display'] = $v['name'];
      $sub = NULL;
      if($v['subs']) {
        foreach ($v['subs'] as $kk => $vv) {
          if($vv['subs']) {
              $sub[$vv['link']]['display'] = $vv['name'];
              $subsub = array();
              foreach ($vv['subs'] as $kkk => $vvv) {
                $subsub[$vvv['link']] = $vvv['name'];
              }
              $sub[$vv['link']]['sub'] = $subsub;
          } else {
              $sub[$vv['link']] = $vv['name'];
          }
        }
      }
      $navs[$v['link']]['sub'] = $sub;
    }

    //把#xxx换成第一个
    foreach ($navs as $k => $v) {
      if(strpos($k, '#')===0 && $v['sub']) {
          $tmp = array_keys($v['sub']);
          $fixed_navs[$tmp[0]] = $v;
      } else {
        $fixed_navs[$k] = $v;
      }
    }

    // $navs = null;
    return $fixed_navs;
}

function manage_header_nav($login_user) {

  if(!$login_user) return false;

  //静态页面
  $ptypes = D('PageTypes')->getStruectTypes();

  $navs = array(
    "#home" => array(
      "display" => "首页/设置",
        "sub" => array(
        // '/manage/home/feedback' => "用户留言",
        // '/manage/home/subscriber' => "订阅用户",
        '/manage/home/carousel' => "首页滚动图",
        // '/manage/home/project_carousel' => "项目滚动图",
        // '/manage/home/home_side_ads' => "滚动图右侧图",
        // '/manage/home/bottom_carousel' => "我们的服务",
        '/manage/home/partner' => "公益通道",
        // '/manage/home/friendlink' => "友情链接",
        '/manage/home/option' => "常用设置",
      )
    ),

    "/manage/page/types" => array(
      "display" => "导航页面",
    ),

    // "/manage/page/other" => array(
    //   "display" => "其它页面"
    // ),

    "/manage/project" => array(
      "display" => "资助项目",
    ),


    // "/manage/video" => array(
    //   "display" => "视频",
    // ),

    // "/manage/attachment" => array(
    //   "display" => "下载",
    // ),

  );

  if(is_super_manager($login_user)) {
      $subs = array(
        // '/manage/adminManage/index' => "管理员列表",
        // '/manage/adminManage/audit' => "操作日志",
        '/manage/adminManage/password' => "修改密码",
      );
  } else {
    $subs = array(
        '/manage/adminManage/password' => "修改密码",              
      );
  }

  $navs["#adminManage"] = array(
    "display" => "管理员",
    "sub" => $subs
  );

  return $navs;
}

function dashboard_sidenav($module){
  $nav = array(
    // "Dashboard" => array(
    // "/dashboard/org_info" => "机构信息",
    // "/dashboard/team_info" => "机构成员",
    // "/dashboard/award_info" => "获奖信息",
    // "/dashboard/other_grant_info" => "其他资助",
    // "/dashboard/case_info" => "项目案例",
    // "/dashboard/finance_info" => "财务信息",
    // "/dashboard/account_info" => "密码修改",
    // ),
    // "Userproject" => array(
    //   "/userproject/project_list" => "项目列表",
    //   ),
    "edit_userinfo" => array(
        "#_basic_info" => " 一. 基本资料",
        "#_detail" => "二. 问题交流",
        "#attachment_info" => "三. 相关附件",
      ),
    "edit_recommend" => array(
        "#_basic_info" => " 一. 本人信息",
        "#_detail" => "二. 推荐理由",
      )

    );
  return $nav[$module];
}


function dashboard_sidebar($selector, $module_selector=null){
  if(empty($selector)){
    $selector = strtolower(ACTION_NAME);
  };
  if($selector == 'index'){
    $selector = "org_info";
  }
  if( empty($module_selector)){
    $module_selector = MODULE_NAME;
  }
  // var_dump($selector);
  $sidenav = dashboard_sidenav($module_selector);
  foreach ($sidenav as $link => $display) {
    $html .= "<li";
    if(strpos($link, $selector) !== false){
      $html .= " class='active' ";
    }
    $html .=">";
    $html .= "<a href='$link'>";
    $html .= $display;
    $html .= "</a>";

    $html .= "</li>";
  }
  echo $html; 
}

function is_super_manager($login_user) {
  return $login_user['id'] < 10;
}