<?php
import("ORG.Crypt.Crypt");

function is_select_active($link){
    $action_url = __ACTION__;
    $action_url = str_replace("/index.php", "", $action_url);
    if($link == $action_url){
        return true;
    }
    return false;
}

function gen_page_link($name) {
  if(D("Options")->GetOption('rewrite_no')) {
    return '/page/?name=' . $name;
  } else {
    return '/' . $name;
  }
}

function get_image_size_map() {
  return array(
        'top_big' => array('w' => 1000, 'h' => 200),
        'carousel' => array('w' => 1000, 'h' => 300),
        'thumbnail' => array('w' => 180, 'h' => 120),
        'index' => array('w' => 220, 'h' => 130),
        'type_top' => array('w' => 670, 'h' => 350),
        'type_index' => array('w' => 300, 'h' => 180),
        'news_index' => array('w' => 230, 'h' => 140),
        'attachment_index' => array('w' => 150, 'h' => 210),
        'service' => array('w' => 180, 'h' => 180),
    );
}


function image_path($image=null, $size=false) {
  if (!$image) return null;
  $image = '/' . trim($image);

  $image_size_map = get_image_size_map();

  if ($size === true) {
      $size = 'index';
  }

  if (is_string($size)) {
      if($size != ""){
        $postfix = "_" . $size;
      }else{
        $postfix = "";
      }
      $path = WWW_ROOT . '/uploads' . $image;

      $image = preg_replace('#(\w+)\.(\w+)$#', "\\1$postfix.\\2", $image);
      $dest = '/uploads' . $image;
      
      $dest_path = WWW_ROOT . $dest;
      if (!file_exists($dest_path) && file_exists($path) ) {
          $mode = Image::MODE_CUT;
          if($image_size_map[$size]['mode']) {
              $mode = $image_size_map[$size]['mode'];
          }
          Image::Convert($path, $dest_path, $image_size_map[$size]['w'], $image_size_map[$size]['h'], $mode);
      }
  } else {
      $dest = '/uploads' . $image;
  }

  return $dest;
}

// that the recursive feature on mkdir() is broken with PHP 5.0.4 for
function RecursiveMkdir($path) {
  if (!file_exists($path)) {
    RecursiveMkdir(dirname($path));
    @mkdir($path, 0777);
  }
}

function upload_image($input, $image=null, $type='page', $scale=false) {
  $year = date('Y'); $day = date('md'); $n = time().rand(1000,9999).'.jpg';
  $z = $_FILES[$input];
  if ($z && strpos($z['type'], 'image')===0 && $z['error']==0) {
    if (!$image) {
      RecursiveMkdir( IMG_ROOT . '/' . "{$type}/{$year}/{$day}" );
      $image = "{$type}/{$year}/{$day}/{$n}";
      $path = IMG_ROOT . '/' . $image;
    } else {
      RecursiveMkdir( dirname(IMG_ROOT .'/' .$image) );
      $path = IMG_ROOT . '/' .$image;
      
      $postfixs = array_keys(get_image_size_map());

      // $postfixs = array('_index','_big');
      foreach ($postfixs as $fix) {
        $index_image = preg_replace('#(\w+)\.(\w+)$#', "\\1_$fix.\\2", $path);
        unlink($index_image);
      }
    }

    move_uploaded_file($z['tmp_name'], $path);

    return $image;
  }
  return $image;
}



function pagestring($count, $pagesize, $wap=false) {
  $p = new Pager($count, $pagesize, 'page');
  return array($pagesize, $p->pageNo, $p->genBasic());
}


function csubstr($str,$start,$len) {
  $strlen = strlen($str);
  $clen = 0;
  for($i=0; $i<$strlen; $i++,$clen++) {
    if ($clen >= $start+$len) {
      break;
    }
    if(ord(substr($str,$i,1))>0xa0) {
      if ($clen>=$start) {
        $tmpstr.=substr($str,$i,3);
      }
      $i = $i+2;
      $clen++;
    } else {
      if ($clen >= $start)
      $tmpstr .= substr($str,$i,1);
    }
  }
  return $tmpstr;
}

function get_short($str,$len, $ending="...") {
  $tempstr = csubstr($str,0,$len);
  if ($str<>$tempstr) {
    $tempstr .= $ending;
  }
  return $tempstr; 
}



if(!function_exists('mime_content_type')) {

    function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }

    function get_url($path){
      $web_root = D("Options")->getOption("webroot_apply");
      return $web_root . $path;
    }
}

//二维数组按照某一个键值排序
function array_sort($arr,$keys,$type='asc'){ 
  $keysvalue = $new_array = array();
  foreach ($arr as $k=>$v){
    $keysvalue[$k] = $v[$keys];
  }
  if($type == 'asc'){
    asort($keysvalue);
  }else{
    arsort($keysvalue);
  }
  reset($keysvalue);
  foreach ($keysvalue as $k=>$v){
    $new_array[$k] = $arr[$k];
  }
  return $new_array; 
} 


function formatBytes($bytes) {
    if($bytes >= 1073741824) {
        $bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
    } elseif($bytes >= 1048576) {
        $bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
    } elseif($bytes >= 1024) {
        $bytes = round($bytes / 1024 * 100) / 100 . 'KB';
    } else {
        $bytes = $bytes . 'Bytes';
    }
    return $bytes;
}


function display_tag_string($obj_id, $tags) {
  
    $html = '';
    foreach ($tags as $t) {
        $html .= '<a class="label label-info">'.$t['name'].'</a>&nbsp';
    }
    return $html;
}

function search_type_tip($type, $type_id) {
    if(!$type) return;
    if($type == 'news') {
        return '<a class="label label-info" target="_blank" href="/pagelist/news">新闻动态</a>&nbsp;&nbsp;';
    } else if(strpos($type, 'event_') !== FALSE && $type_id) {
        $event = M('Events')->getById($type_id);
        $event_str = $event['category'] . ' ' . $event['title'];
        $key = str_replace('event_', '', $type);
        $modules = get_event_modules();
        $type_name = $modules[$key]['name'];
        $event_str .= ' - ' . $type_name;
        return "<a target='_blank' class='label label-info' href='/pagelist/eventnews?eid=$type_id&module=$key'>$event_str</a>&nbsp;&nbsp;";
    }
    return;
}

//判断PHP数组是否索引数组（列表/向量表）
function is_list($arr) {
    if (!is_array($arr) ) {
        return false;
    } else {
        $keys = array_keys($arr);
        $idx = 0;
        foreach ($keys as $k) {
            if(intval($k) !== $idx++)
              return false;
        }
    }
    return true;
}

function array_to_map($arr) {
    foreach ($arr as $v) {
        $rs[$v] = $v;
    }
    return $rs;
}

function generate_password( $length = 8 ) {
    // 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    // $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_[]{}<>~`+=,.;:/?|';
    $password = '';
    for ( $i = 0; $i < $length; $i++ ) 
    {
        // 这里提供两种字符获取方式
        // 第一种是使用 substr 截取$chars中的任意一位字符；
        // 第二种是取字符数组 $chars 的任意元素
        // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }
    return $password;
}



  function encrypt_request($m) {
    $id = $m[2];
    if(is_numeric($id)) {
      return str_replace($m[2], encrypt_id($m[2]), $m[0]);
    }
    return $m[0];
  }

  //xor + convert it to base 31 + reverse
  function encrypt_id($id) {
    return 'JXD' . Crypt::en(intval($id));
  }

  function decrypt_id($eid) {

    if(strpos($eid, 'JXD') === 0) {
      $eid = substr($eid, 3);
      return Crypt::de($eid);
    }
    return $eid;
  }


  function moneyit($val, $with_sign=true) {
      if(!$val) return '-';
      $n = str_replace(',', '', $val);
      $c = is_float($n) ? 1 : number_format($n,2);
      $d = '.';
      $t = ',';
      $sign = ($n < 0) ? '-' : '';
      $i = $n=number_format(abs($n),2); 
      $j = (($j = $i.length) > 3) ? $j % 3 : 0;
      if($with_sign) {
          $symbol = '<span style="font-weight:normal; font-size:12px">￥</span>';
      }  else {
          $symbol = '';
      }
      $res = $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j));
      return str_replace('.00', '', $res);
  }



  function captcha_image() {
      $fun = "jQuery('#verifyimg').attr('src','/Common/common/captcha?'+ Math.random())";
      $str = '<img id="verifyimg" style="height:30px; cursor: pointer" src="/Common/common/captcha" onclick="'. $fun .'" title="点击刷新验证码" />';
      $str .= '<input type="text" name="verifycode" class="span1" style="margin-bottom: 0;" placeholder="验证码"/>';
      return $str;
  }


    // start end format: 
    function get_quarter_ranges($start, $end) {
        // 检时间格式
        
        $tmp = explode('-', $start);
        $start_year = $tmp[0];
        $start_quarter = get_quarter_by_month($tmp[1]);

        $tmp = explode('-', $end);
        $end_year = $tmp[0];
        $end_quarter = get_quarter_by_month($tmp[1]);

        $loop_quarter = $start_quarter;
        for($i=$start_year;$i<=$end_year;$i++) {
            for($j=$loop_quarter; $j<=4;$j++) {    
                $range[] = $i . $j;
                if($i==$end_year && $j==$end_quarter) {
                    break;
                }
            }
            $loop_quarter=1;
        }

        return $range;
    }

    function get_quarter_by_month($month) {
        $map = array('1'=>1, '2'=>1, '3'=>1, '4'=>2, '5'=>2, '6'=>2, '7'=>3, '8'=>3, '9'=>3, '10'=>4, '11'=>4, '12'=>4);
        return $map[intval($month)];
    }

    // str 20151这样格式
    function get_quarter_display_name($str) {
        $map = array('1'=>'一', '2'=>'二', '3'=>'三', '4'=>'四', );

        return substr($str, 0, 4) . $map[substr($str, 4)] . '季度';
    }  