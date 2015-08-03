<?php
class UserRecommendsModel extends BaseModel {

    function _after_select(&$resultSet,$options){
        foreach ($resultSet as $index => $result) {
            $resultSet[$index] = $this->_after_find($result, $options);
        }
     }

    function  _after_find(&$result,$options){

        // $questions = D("UserTypeQuestions")->getsByTypeId(1);
        // $answers = D("UserQuestionAnswers")->getsByCmsUserId($result['recommond_user_id']);

        // $sql = 'select  a.*,q.question 
        //         from user_question_answers a, user_type_questions q 
        //         where q.type_id=1 and a.question_id=q.id 
        //             and cms_user_id='.$result['recommend_user_id'].
        //             ' order by q.question desc;'
        
        $result['question_answers'] = D("UserQuestionAnswers")->getsByCmsUserId($result['recommond_user_id']);
        $result['address'] = trim($result['address_province'].'&nbsp;'.$result['address_city'].'&nbsp;'.$result['address_area'].'&nbsp;'.$result['address']);
        $result['status_name'] = M('UserStatuses')->where('apply_type_id=1 and id=%d',$result['status'])->getField('name');

        return $result;
    }


    public function genInviteCode() {
        $code = Utility::GenSecret(6,1);
        return $this->where('invite_code="%s"', $code)->find() ? $this->genInviteCode() : $code;
    }

}