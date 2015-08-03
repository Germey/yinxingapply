<?php
class IndexAction extends BaseAction {
    public function index(){

        $this->assign($data);
        $this->display();
    }

}