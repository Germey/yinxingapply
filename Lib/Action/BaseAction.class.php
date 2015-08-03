<?php
class BaseAction extends Action{
    function __construct(){
        global $login_user;
        $login_user = Login::GetLoginCookie();
        if(!empty($login_user)){
            $this->assign("login_user", $login_user);
        }

        $options = D("Options")->where("autoload = 'Y'")->select();
        $INI = array();
        foreach ($options as $index => $option) {
            $INI[$option['option_name']] = $option['option_value'];
        }
        $this->assign("INI", $INI);
    }

    function getCurrentWebRoot(){
        return "http://" . $_SERVER['HTTP_HOST'];
    }

    function trans_param($param){
        $this->assign($param, $this->_param($param));
    }

    function _empty(){
        header('HTTP/1.1 404 Not Found');
        $this->display('Common:Common:page_not_found');
    }
}