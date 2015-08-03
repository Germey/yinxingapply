<?php
return array(
	'LOAD_EXT_CONFIG' => 'db,static',
    // 'SHOW_PAGE_TRACE'=>True,
    'APP_AUTOLOAD_PATH' => "@.Autoload.,ORG.Util.",

    'APP_GROUP_LIST' => "Frontend,Manage,Common",
    'DEFAULT_GROUP'   => "Frontend",
    'TMPL_FILE_DEPR'  => "/",
    'URL_MODEL' => 2,
    'OUTPUT_ENCODE'=>false,

    'URL_404_REDIRECT' => "/404",

    'URL_CASE_INSENSITIVE' =>true,
    "LOAD_EXT_FILE"=>"static,json,nav,widget",

    'URL_ROUTER_ON'   => true, //开启路由
    'URL_ROUTE_RULES' => array( //定义路由规则
        'page/:id\d' => 'Frontend/Page/detail',
        'page/:name' => 'Frontend/Page/detail',
        'type/:id\d' => 'Frontend/page/pagetype',
        'type/:name' => 'Frontend/page/pagetype',
        'project/:id\d' => 'Frontend/project/detail',
        '404' => 'Common/Common/page_not_found',
    ),

    'DEFAULT_FILTER'=>'htmlspecialchars,decrypt_id',
    'TMPL_STRIP_SPACE'    => false,
);
?>