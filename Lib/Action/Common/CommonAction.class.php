<?php
class CommonAction extends BaseAction{

    function alert($msg) {
        header('Content-type: text/html; charset=UTF-8');
        die(json_encode(array('error' => 1, 'message' => $msg)));
    }

    function ajax_image_dialog(){
        $id = $this->_param("id");
        if($id){
            $image = D("Images")->getById($id);
        }
        $this->assign("image", $image);
        $html = $this->fetch("Common:Public:image_dialog");
        json($html, "dialog");
    }


    function locale() {
        $locale = Cookie::get('locale');
        if(!$locale) $locale = 'cn';
        Cookie::set('locale', ($locale=='cn' ? 'tw' : 'cn'));        
        json($html, "refresh");        
    }

    function captcha() {
        ob_get_clean();
        Utility::CaptchaCreate(4);
    }

    function page_not_found(){
        header("HTTP/1.0 404 Not Found");
        $this->display();
    }
}
