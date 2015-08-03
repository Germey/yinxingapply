<?php
class AttachmentAction extends BaseAction {

    function __construct(){
        parent::__construct();

        $id = intval($this->_get('id'));
        
        $module = $this->_get('module') ? $this->_get('module') : 'project';
        $this->tb_name = ucfirst($module)."Attachments"; 

        $f['id'] = $id;
        // $f['create_user_id'] = $this->_get('uid');
        $attachment = M($this->tb_name)->where($f)->find();

        if(!$attachment) {
            $this->error = 'invalid file';
            return;
        }

        $this->attachment = $attachment;
    }

    public function index() {
    }

    public function download() {
        $attachment = $this->attachment;
        if(!$attachment) {
            echo $this->error;
            return;
        }

        $path = $attachment["path"];
        $name = $attachment["title"];

        //download it
        header('Content-type: ' . mime_content_type($path));
        header('Content-Disposition: attachment; filename="' . urlencode($name) . '"');

        $full_path = UPLOAD_ROOT  . $path;
        readfile($full_path);
    }

    public function ajax_delete()
    {
        $attachment = $this->attachment;
        if(!$attachment) {
            echo $this->error;
            return;
        }

        var_dump($attachment,$this->tb_name);
        M($this->tb_name)->delete($this->_get('id'));
        json($html, "refresh");
    }
}