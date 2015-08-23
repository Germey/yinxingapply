<?php
    function dashboard_input($name, $type, $class, $value, $param=null){
        if(!$class) $class='span4';
        if($type == "textarea"){
            $html = dashboard_textarea($name, $class, $value, $param);
        }else if($type == "select"){
            $html = dashboard_select($name, $class, $value, $param);
        }else if($type == "date"){
            $html = dashboard_date($name, $class, $value, $param);
        }else if($type == "number"){
            $html = dashboard_number($name, $class, $value, $param);
        }else if($type == "file"){
            $html = dashboard_file($name, $class, $value, $param);            
        }else if($type == "address"){
            $html = dashboard_address($name, $value, $param);
        }else if($type == "checkbox"){
            $html = dashboard_checkbox($name, $value, $param['options'], true);
        }else{
            //text
            $html = dashboard_text($name, $class, $value, $param);
        }
        if($param['placeholder']) {
            $html .= '<div class="muted clear">'.$param['placeholder'] . '</div>';
        }
        if($param['limit_size']) {
            $html .= '<div class="muted clear">字符数：<span id="'.$name.'_limit_tip">0</span> / '.$param['limit_size'] . '</div>';
        }        
        return $html;
    }

    function dashboard_textarea($name, $class, $value, $param){
        if($param['template'] && !$value){
            $template_path = WWW_ROOT . "/Tpl/Frontend/Userproject/" . $param['template'] . ".html";
            $value = file_get_contents($template_path);
        }
        if($param['limit_size']>0) {
            $class .= " limited";
            $extra_attr = "data-limit=" . $param['limit_size'];

            if($param['limit_type']) {
                $extra_attr .= " limit_type=" . $param['limit_type'];
            }
        }

        // $class = $class . ' simpleeditor';

        $html .= "<textarea name='$name' id='$name'  class='$class' $extra_attr>";
        $html .= $value;
        $html .= "</textarea>";
        return $html;
    }

    function dashboard_select($name, $class, $value, $param){
        $html .= "<select name='$name' id='$name' class='$class'>";
        $html .= Utility::Option($param['options'], $value);
        $html .="</select>";
        return $html;
    }

    function dashboard_text($name, $class, $value, $param){
        $html .="<input type='text' {$param['additional']} class='$class' name='$name' id='$name'  value='$value' />". $param['append'];
        return $html;
    }

    function dashboard_number($name, $class, $value, $param){
        if($param['step']){
            $step = $param['step'];
        }else{
            $step = '1';
        }
        $html .="<input type='number' step='$step' class='$class' name='$name' id='$name'  value='$value'>" . $param['append'];
        return $html;
    }

    function dashboard_date($name, $class, $value, $param){
        $default_format = 'yyyy-mm-dd';
        if($param['format']) {
            $default_format = $param['format'];
        }
        if($value) {
            $date = substr($value,0, strlen($default_format));
        } else {
            $date = '';
        }
        $html = "<input type='text' class='datepicker {$class}' name='$name' id='$name' value='" . substr($date,0,10) . "'/>";
        return $html;
    }

    function dashboard_file($name, $class, $value, $param){
        $html .="<input type='file' name='$name' id='$name' />";
        if($value) {
            $html .= "<input type='hidden' name='old_$name' value='$value' />";
        }

        if($param['file_type']=='image' && $value) {
            $html .= '<div class="clear"><img src="/uploads/'.$value.'" style="max-width:500px"/></div>';
        }
        return $html;
    }

    function dashboard_address($name, $value) {
        $adds = explode('&nbsp;', $value);

        $str = '<input type="hidden" id="add_province_default" value="'.$adds[0].'" />';
        $str .= '<input type="hidden" id="add_city_default" value="'.$adds[1].'" />';
        $str .= '<input type="hidden" id="add_district_default" value="'.$adds[2].'" />';

        $str .= '<select name="'.$name.'_province" id="s1" class="text" style="width:72px;" ><option value="">-</option></select>
                <select style="width:96px;" id="s2" name="'.$name.'_city"><option value="">-----</option></select>
                <select style="width:96px;" id="s3" name="'.$name.'_area"><option value="">-----</option></select>
                <input type="text" name="'.$name.'" id="'.$name.'" value="'.$adds[3].'" style="float: none;width: 380px;" />';

        return $str;
    }

    // 暂时只有在form中用到
    function dashboard_checkbox($name, $value, $options, $with_other) {
        foreach ($options as $k => $v) {
            $checked = '';
            if(in_array($v, $value)) {
                $checked = 'checked';
            }
            $str .= '<label class="checkbox"><input '.$check_str.' type="checkbox" name="'.$name.'[]" value="'. $v .'" '. $checked .'> '.$v.'</label>';
        }
        if($with_other) {
            $last_val = trim(str_replace('【其他】','',$value[count($value)-1]));
            $checked = '';
            if($last_val) {
                $checked = 'checked';
            }
            $str .= '<div class="clear"></div>
                     <label class="checkbox option_other_tag">
                        <input id="value_option_other_'.$name.'" type="checkbox" name="'.$name.'[]" value="'.$last_val.'" '.$checked.'>其他
                        <input type="text" id="option_other_'.$name.'" class="option_other" style="float:none;" value="'.$last_val.'">
                     </label>';
        }
        return $str;
    }

    function project_block($name, $project_items, $value, $project_prefix_hilight) {
        $item = $project_items[$name];

        if($item['type']=='split') {
            echo '<li class="fw split">'. $item['display'] .'</li>';
            return;
        }
        if($item) {
            $olen = strlen($item['display']);

            if($item['param']['hidden_display']) {
                $item['display'] = '';
            }

            if($item['type'] == 'textarea' || $item['type'] == 'group' || $item['type'] == 'file') {
                $class = "fw";
            }

            if($item['param']['require']) {
                $item['display'] .= '<span class="text-error">&nbsp;*</span>';
            }

            if($project_prefix_hilight) {
                $html .= '<h4 class="clear sub"><span id="'.$name.'_title">' . $project_prefix_hilight . $item['display'] . '</span></h4>';
                $item['display'] = '';
                $class .= ' with_prefix';
            }

            if((strpos($class, 'fw')!==false || strpos($item['li_class'], 'fw')!==false) && $item['class']!=='simpleeditor') {
                $item['class'] .= ' span8';
            }

            $html .= "<li class='$class {$item['li_class']}'>";
            // var_dump($olen);
            if($olen>28 && $item['param']['placeholder']) {
                $label_style = 'style="height:26px"';
            }
            $html .= "<label class='title' ". $label_style .">{$item['display']}</label><div class='detail'>";
            if($item['type'] == 'group') {
                $html .= dashboard_group_edit($name, '', $item['param']['options'], $value, $item['param']['placeholder']);
            } else {
                $html .= dashboard_input($name, $item['type'], $item['class'], $value, $item['param']);
            }

            $html .= "</div>";
            $html .= "</li>";
        }
        echo $html;
    }

    function project_display_block($name, $project_items, $value, $project_prefix_hilight){
        $item = $project_items[$name];

        if($item) {
            if($item['type'] == 'textarea' || $item['type'] == 'group'){
                $class = "fw ";
            }
            
            if($item['type'] == 'textarea') {
                $value = nl2br($value);
            }

            if($item['type'] == 'file' && $value) {
                $value = '<a target="_blank" title="点击查看全图" href="/uploads/'.$value.'"><img src="/uploads/'.$value.'" style="max-width:350px;"/></a>';
            }

            if($item['type'] == 'select'){
                $tmp = $item['param']['options'][$value];
                if($tmp) $value = $tmp; 
            }

            if($item['type'] == 'checkbox' && is_array($value)){
                $value = implode(', ', $value);
            }

            $display = $item['display'];
            if($project_prefix_hilight) {
                $html .= '<div class="title_level_3 clear">'. $project_prefix_hilight . $item['display'] .'</div>';
                $display = '';
                $class .= 'full';
            }

            if($item['param']['hidden_display']) {
                $display = '';
            }

            $html .= "<li class='$class'>";
            $html .= "<label class='title'>$display</label><div class='detail'>";
            if($item['type'] == 'group') {
                $html .= display_group($value, $item['param']['options']); 
            } else {
                $html .= $value;
            }
            $html .= "</div>";
            $html .= "</li>";
        }
        echo $html;
    }



function dashboard_group_edit($key,$label_name, $options, $value, $placeholder) {

    $table = '<table class="table table-noborder" id="group_new_table_'.$key.'"><thead><tr>';
    foreach ($options as $k => $v) {
        $table .= '<th>'.$v['name'].'</th>';       
    }
    $table .= '</thead></tr>';

    $name_prefix = $key . '_group_';

    $vs = unserialize($value);
    foreach ($vs as $v) {
        $table .= '<tr>';
        foreach ($options as $ok => $ov) {
            if($ov['type']=='select') {
                $table .= '<td>'. group_edit_select($name_prefix . $ok, $v[$ok], $ov['class'], $ov['options']) .'</td>';
            } else if($ov['type'] == 'textarea') {
                $table .= '<td>'. group_edit_textarea($name_prefix . $ok, $v[$ok], $ov['class']) .'</td>';
            } else {
                $table .= '<td>'. group_edit_input($name_prefix . $ok, $v[$ok], $ov['class'], $ov['extra_attr']) .'</td>';
            }
        }
        $table .= '<td><a class="delete_group_line" alt="删除">-</a></td>';
        $table .= '</tr>';
    }
    $table .= '<tr id="group_new_line_'. $key .'">';
    foreach ($options as $k => $v) {
        if($v['type']=='select') {
            $table .= '<td>'. group_edit_select($name_prefix . $k, '', $v['class'], $v['options']) .'</td>';
        }  else if($v['type'] == 'textarea') {
            $table .= '<td>'. group_edit_textarea($name_prefix . $k,'', $v['class']) .'</td>';
        } else {
            $table .= '<td>'. group_edit_input($name_prefix . $k,'', $v['class'], $v['extra_attr']) .'</td>';
        }
    }
    $table .= '<td><a class="delete_group_line" alt="删除">-</a></td>';
    $table .= '</tr></table>';
    $table .= '<p><a href="javascript:void(0);" onclick="add_group_line(\''.$key.'\')">+增加新记录</a>&nbsp;&nbsp;</p>';
    
    $str .= '<div class="muted">'. $placeholder .'</div>';
    $str .= '<div class="control-group">';
    $str .= '<label class="control-label">' . $label_name . '</label>';
    $str .= '<div class="controls">';
    $str .= $table;
    $str .= '</div></div>';

    return $str;
}

function group_edit_input($name, $value, $class, $extra_attr) {
    $class .= " group_span";
    return '<input type="text" class="'.$class.'" name="'. $name .'[]" value="'.$value.'" '.$extra_attr.'/>';
}

function group_edit_select($name, $value, $class, $options) {
    $class .= " group_span";
    return '<select type="text" class="'.$class.'" name="'. $name .'[]" />'.Utility::Option($options,$value).'</select>';   
}

function group_edit_textarea($name, $value, $class) {
    return '<textarea type="text" class="'.$class.'" name="'. $name .'[]" >'. $value .'</textarea>';
}


function display_group($value, $options) {
    $value = unserialize($value);

    $table = '<table class="table table-bordered"><thead><tr>';
    foreach ($options as $ok => $ov) {
        $table .= '<th>'.$ov['name'].'</th>';
    }
    $table .= '</thead></tr>';

    foreach ($value as $v) {
        $table .= '<tr>';
        foreach ($options as $ok => $ov) {
            if(strpos($ov['class'], 'money')>0) {
                $v[$ok] = moneyit($v[$ok]);
            }
            $wrap="";
            if(strlen($v[$ok]) < 20) {
                $wrap = 'nowrap';
            }
            $table .= '<td '. $wrap .'>'.nl2br($v[$ok]).'</td>';
        }
        $table .= '</tr>';
    }
    $table .= '</table>';

    return $table;
}

//获得新的编号
function createIdentifier($province) {
    $provinces = D("UserRecommends")->getsByAddressProvince($province);
    //获取该省所有标识符的最后一个，生成下一个
    $last_province = $provinces[count($provinces) - 1];
    //每个省份对应编号的最后一个的数字，例如北京5，获取5这个数字
    $last_num = substr($last_province['identifier'], strlen($province));
    $next_num = 1;
    //如果数字存在，那么加1，否则默认为1
    if (is_numeric($last_num)) {
        $next_num = intval($last_num) + 1;
    }
    return $province.$next_num;
}

