<?php
class DashboardAction extends DashboardBaseAction {

    public function index(){
        redirect("/dashboard/account_info");
    }


    function  account_info(){
        $this->display();
    }

    function password_submit(){
        $oldpassword = $this->_param("oldpassword");
        $newpassword = $this->_param("newpassword");

        if(!$oldpassword || !$newpassword) {
            redirect('/dashboard/account_info'); 
        }

        if($oldpassword == $newpassword) {
            Session::Set("error", '新密码和旧密码不能一样');
            redirect('/dashboard/account_info'); 
        }

        $oldpassword = D("CmsUsers")->genPassword($oldpassword);
        $newpassword = D("CmsUsers")->genPassword($newpassword);

        $u = D('CmsUsers')->getById($this->login_user['id']);
        if($u['password'] !== $oldpassword) {
            Session::Set("error", '旧密码有误，请重新输入');
            redirect('/dashboard/account_info'); 
        }

        D("CmsUsers")->where(array("id" => $this->login_user['id']))->setField("password", $newpassword);
        Login::UserLogout();

        Session::Set("success", '密码修改成功，请重新登录');
        redirect("/register/login");
    }
}