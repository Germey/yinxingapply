<?php
class BaseModel extends Model{

    public $_auto = array (
            array('create_time', 'date', Model::MODEL_INSERT, 'function',array('Y-m-d H:i:s')),
            array('update_time', 'date', Model::MODEL_BOTH, 'function',array('Y-m-d H:i:s')),
    );

        
}