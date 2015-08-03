<?php
class CmsUsersModel extends BaseModel {
    // 定义自动验证
    protected $SECRET_KEY = '@4!@#$%@';
    
    public function GetLogin($email, $unpass, $en=true) {
        if($en) $password = self::genPassword($unpass);

        $field = strpos($email, '@') ? 'email' : 'username';
        $user = $this->where(array($field => $email, "password" => $password))->find();
        if ($user)  return $user;
        return array();
    }

    public function genPassword($p) {
        return md5($p . $this->SECRET_KEY);
    }

    public function getManagers() {
        return M('Users')->where("manager='Y'")->select();
        
    }
}