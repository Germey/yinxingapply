<?php

class Login
{
    static public $cookie_name = 'chinadolls';

    static public function GetLoginId() {
        $u = self::GetLoginCookie(self::$cookie_name);

        if($u['is_enabled'] == 'Y') {
            $user_id = abs(intval($u['id']));
        }

        return $user_id;
    }

    //专为manage login用的
    static public function Logon($user, $isRemember = false) {
        // if($isRemember) {
        //     $time = 30 * 86400;
        // } else {
        //     $time = 0;
        // }

        Session::set("login_admin", $user);

        // $zone = "{$user['id']}@{$user['password']}@{$time}";
        // Cookie::set(self::$cookie_name, base64_encode($zone), $time);

        //TODO update last login time
        return true;
    }

    static public function LogonUser($user, $isRemember=false){
        Session::set("login_user", $user);
        Session::set('via_pm',0);
    }

    static public function NeedLogin() {
        $user_id = self::GetLoginId();
        return $user_id ? $user_id : False;
    }

    static public function Logout(){
        Session::set("login_admin", null);
        // Cookie::set(self::$cookie_name, null);
    }

    static public function UserLogout(){
        Session::set("login_user", null);
    }


    static public function GetLoginCookie() {
        $cv = Cookie::get(self::$cookie_name);
        if ($cv) {
          $zone = base64_decode($cv);
          $p = explode('@', $zone, 3);
          $result = D("CmsUsers")->where(array(
            'id' => $p[0],
            'password' => $p[1],
          ))->find();

          //丰富login_user的内容
          //team
          //group
          return $result;
        }
        return Array();
    }
}
