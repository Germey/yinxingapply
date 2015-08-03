<?php
class RegisterAction extends BaseAction{

    public function index() {
        $this->display();
    }

    public function ajax_check_code(){    
        $invite_code = $this->_get('invite_code');
        $org_code = $this->_get('org_code');
        $f['code'] = $invite_code;
        $f['org_code']=$org_code;
        $invite_data=M("InviteCodes")->where($f)->find();
        $is_exist = M("InviteCodes")->where($f)->count();
       
        if($is_exist && ($invite_data['is_bind']==0)){
            $data['is_bind']=1;
            M("InviteCodes")->where($f)->save($data);
        }
        json('org_check_code_callback('.$is_exist.')', 'eval');
    }

    public function submit_reg() {
        $email = htmlspecialchars($this->_param("email"));
        if(!Utility::ValidEmail($email)) {
            Session::Set("error", "邮箱格式有误");
            redirect("/register");
        }

        // $code = M("InviteCodes")->getByCode($this->_post('invite_code'));
        // if(!$code) {
        //     Session::Set("error", "无效邀请码");
        //     redirect("/register");
        // }

        $userModel = D("CmsUsers");
        if($userModel->create()) {
            $userModel->username = $userModel->email;
            $userModel->password = D("CmsUsers")->genPassword($userModel->password);
            $userModel->secret = md5(generate_password());
            $userModel->ip = Utility::GetRemoteIp();
            $userModel->partner_id =intval($this->_param('partner_id'));
            $secret = $userModel->secret;
            $id = $userModel->add();
        } else {
            Session::Set("error", "注册失败，请重新尝试或者联系网站管理员");
            redirect("/register");
        }

        // 绑定邮箱到邀请码
        // $code_data['id'] = $code['id'];
        // $code_data['email'] = $this->_param("email");
        // $code_data['bind_time'] = date('Y-m-d H:i:s');
        // M("InviteCodes")->save($code_data);

        //发验证邮件
        $this->send_verify_mail($id, $email, $secret);

        redirect('/register/preview_verify_email?token=' . Crypt::en($id . '||' . $email));
    }

    public function preview_verify_email() {
        $tokens = explode("||", Crypt::de($this->_get('token')));
        $this->id = Crypt::en($tokens[0]);
        $this->email = $tokens[1];

        $this->display();
    }

    public function resend_email(){

        $id = intval(Crypt::de($this->_get('id')));
        $user = D("CmsUsers")->getById($id);

        if(!$id || !$user) {
            Session::Set('error', 'ID参数有误');
            redirect('/register/preview_verify_email');
        }

        // 最小30S间隔
        $last_send_time = Session::Get('register_resend_email_timestamp');
        if((time() - $last_send_time) < 30) {
            Session::Set('error', '重发邮件间隔至少需要30秒');
            redirect('/register/preview_verify_email?token=' . Crypt::en($id . '||' . $user['email']));
        }

        // 发信
        $this->send_verify_mail($id, $user['email'], $user['secret']);

        Session::Set('register_resend_email_timestamp', time());

        redirect('/register/preview_verify_email?token=' . Crypt::en($id . '||' . $user['email']));
    }

    public function send_verify_mail($id, $email, $secret){
        $subject = D("Options")->getOption("verify_email_subject");
        $content = D("Options")->getOption("verify_email_content");
        $link = D("Options")->getOption("webroot_apply") . "/register/verify_email?id=" . Crypt::en($id) . "&secret=$secret";
        $link = "<a href='$link'>" . $link . "</a>";
        $content = str_replace("[#link#]", $link, $content);
        // $content = "请点击下面链接验证账户<br/><a href='$link'>$link</a>";
        Mailer::SmtpMail(null, $email, $subject, $content);
    }

    public function verify_email(){
        $id = Crypt::de($this->_param("id"));
        $secret = $this->_param("secret");
        $user = D("CmsUsers")->getById($id);
        if($user){
            //验证成功
            if($user['secret'] && ($user['secret'] == $secret)) {
                $user['secret'] = "";
                D("CmsUsers")->save($user);
                $this->assign('title',"邮箱验证成功");
                $this->display("verify_success");
            }else if($user['secret'] == ""){
                $this->assign('title',"您已经验证过该账户");
                $this->display("verify_success");
            }else{
                $this->display("verify_fail");
            }
        }else{
                $this->display("verify_fail");
        }
    }

    public function login(){
        $this->display();
    }

    public function login_submit(){
        if(!Utility::CaptchaCheck($this->_post('verifycode'))) {
            Session::Set("error", "验证码有误，请重新输入");
            redirect("/register/login");
        }

        $email = $this->_param("email");
        $password = $this->_param("password");
        $md5_pass = D("CmsUsers")->genPassword($password);

        $user = M('CmsUsers')->where(array("email" => $email, "password" => $md5_pass))->find();
        if($user['secret']) {
            $link = '/register/resend_email?id=' . Crypt::en($user['id']);
            Session::Set("error", "对不起，你的账户尚未验证成功，请从你的邮箱点击验证链接，或者<a href='$link'>点此链接重新发送验证邮件</a>");
            redirect("/register/login");            
        }

        if ($user) {
            if($pmer) {
                redirect(D('Options')->getOption('webroot_pm') . '/login?auth_token=' . Crypt::en($email.'|-|'.$password));
            } else {
                Login::LogonUser($user);
                redirect("/userinfo/index");
            }
        }else{
            Session::Set("error", "用户名或密码错误");
            redirect("/register/login");
        }
        // $this->display();
    }

    public function logout(){
        Session::Set("login_user", null);
        Session::Set("success", "退出登录");
        redirect("/register/login");
    }

    public function forget_password(){
        $this->display();
    }

    public function submit_forget_password() {
        $email = $this->_param("email");

        if(!Utility::CaptchaCheck($this->_post('verifycode'))) {
            Session::Set("error", "验证码有误，请重新输入");
            redirect("/register/forget_password");
        }

        if($email){
            $user = D("CmsUsers")->where(array("email" => $email))->find();
            if($user){
                $subject = D("Options")->getOption("verify_email_subject");
                $repasscode = md5(generate_password());
                D("CmsUsers")->where(array('id' => $user['id']))->setField("repasscode" ,$repasscode);
                $link = D("Options")->getOption("webroot_apply") . "/register/verify_repass?id=". Crypt::en($user['id']) ."&repasscode=$repasscode";
                $link = "<a href='$link'>" . $link . "</a>";
                $subject = D("Options")->getOption("repass_email_subject");
                $content = D("Options")->getOption("repass_email_content");
                $content = str_replace("[#link#]", $link, $content);
                Mailer::SmtpMail(null, $email, $subject, $content);
                redirect("/register/submit_forget_password_result?token=" . Crypt::en($email));
            }else{
                Session::Set("error", "无此邮箱");
                redirect("/register/forget_password");
            }
        }else{
            Session::Set("error", "无此邮箱");
            redirect("/register/forget_password");
        }
    }

    public function submit_forget_password_result() {
        $this->email = Crypt::de($this->_get('token'));
        $this->display();
    }

    public function verify_repass(){
        $id =Crypt::de($this->_param("id"));
        $repasscode = $this->_param("repasscode");
        $user = D("CmsUsers")->where(array("id" => $id, "repasscode" => $repasscode))->find();
        if($user){
            //为保证安全，用户信息保存在session中，确认修改后再删除
            Session::set("repass_user", $user);
            $this->display();
        }else{
            $this->display("repass_fail");
        }
    }

    public function submit_repass(){
        $newpass = $this->_param("newpass");
        $user = Session::get("repass_user", true);
        if($user){
            Session::set("repass_user", null);
            $newpass = D("CmsUsers")->genPassword($newpass);
            D("CmsUsers")->where(array("id" => $user['id']))->setField("password" ,$newpass);
            $this->display();
        }else{
            Session::set("error", "密码已设置成功，请勿重复提交");
            redirect("/register/login");
        }
    }
}