<?php
class LoginAction extends BaseAction{

    public function index(){
        if ( $_POST ) {
            $email = $this->_get("email");
            $password = $this->_get("password");
            $users = D('Users');
            $login_user = $users->GetLogin($_POST['email'], $_POST['password']);            
            if ( !$login_user ) {
                Session::Set('error', '用户名或密码错误');
                redirect("/manage/login/index");
            } else if ($login_user['is_enabled']=='N' && $login_user['secret']) {
                Session::Set('error', '登录失败');
                redirect("/manage/login/index");
            } else {
                if (abs(intval($_POST['auto_login']))) {
                    Login::Logon($login_user, true);
                } else {
                    Login::Logon($login_user);
                }
                Session::set("success", "登录成功");
                redirect("/manage");
            }
        }else{
            $this->display();
        }
    }

    public function logout(){
        Login::Logout();
        Session::set("success", "您已经退出登录");
        $this->redirect('/manage');
    }

}