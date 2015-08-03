<?php

/** 
*    UrlHelper generate url link for user, event, tag or any url which can be identify by id.
*    For example: it can generate url /event/1.html with invoke of UrlHelper::EventUrl(1) or UrlHelper::EventUrl(1， true)
*    Static function combine by two part first part is type like 'Event' or 'User' or any type you need,
*    second part is fixed string of 'Url'. Function have three parameters, first one is $id, second one is if result need to
*    echo out (default true). The third parameter is params following the url it can be a string or a array.
*/
class UrlHelper{

    /** 服务器php版本5.3以下的不支持__callStatic这种调用方式，为方便，改成静态static方式直接调用 */
    // public static function PageUrl($id) {
    //     return "/page?id=" . $id;
    // }

    private static function CommonUrlHelper($type, $id, $echo = true, $params = ""){
        $link = "/$type/".$id;
        $param_str = "";
        if($params){
            if(is_array($params)){
                foreach ($params as $key => $param) {
                    $param_str .="&$key='$param'";
                }
                $param_str = substr($param_str, 1, strlen($param_str));
                $param_str = "?" . $param_str;
            }elseif(is_string($params)){
                $param_str = $params;
            }
        }
        if($echo) {
            echo $link.$param_str;
        } else {
            return $link.$param_str;  
        }
    }

    public function __call($funName,$argu){  
        return $this->__callStatic($funName,$argu);
    }

    public function __callStatic($funName,$argu){
        if(($index = strpos($funName, "Url")) && !method_exists(UrlHelper, $funName)){
            $type = strtolower(substr($funName, 0, $index));
            return UrlHelper::CommonUrlHelper($type, $argu[0], $argu[1], $argu[2]);
        }
    }
}
?>