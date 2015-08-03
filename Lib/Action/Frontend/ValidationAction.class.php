<?php
class ValidationAction extends Action{

    function invite_code(){
        $code = $this->_request("v");
        $rs = M("InviteCodes")->getByCode($code);

        // 不存在或者已经被使用
        if(!$rs) {
            Output::Json(null, 1);
        }else{
            Output::Json(0);
        }
    }

    function org_code(){
        $org_code = $this->_request("v");
        $rs = M("InviteCodes")->getByOrgCode($org_code);

        // 不存在或者已经被使用 
        if(!$rs) {
            Output::Json(null, 1);
        }else{
            Output::Json(0);
        }
    }

    public function ajax_check_code(){
        $invite_code = $this->_get('invite_code');
        $org_code = $this->_get('org_code');

        if(!$invite_code || !$org_code) {
            return;
        }

        $f['code'] = $invite_code;
        $f['org_code']=$org_code;
        $invite_data = M("InviteCodes")->where($f)->find();

        // 如果存在，写对了，对bind++
        if($invite_data) {
            $data['id'] = $invite_data['id'];
            $data['is_bind'] = $invite_data['is_bind']+1;
            M("InviteCodes")->save($data);

            $partner = M('Partners')->where(array('org_code'=>$org_code))->find();
            if(!$partner) {
                $p_data['org_code'] = $org_code;
                $partner_id = M("Partners")->add($p_data);
            } else {
                $partner_id = $partner['id'];
            }

            json('check_code_callback('.$partner_id.',"'.$invite_data['org_name'].'")', 'eval');
        } else {
            json('check_code_callback(0,"")', 'eval');
        }
    }

    function user_email(){
        $email = $this->_request("v");
        $users = D("CmsUsers")->getByEmail($email);
        if($users){
            Output::Json(null, 1);
        }else{
            Output::Json(0);
        }
    }
}