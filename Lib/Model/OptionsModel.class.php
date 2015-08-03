<?php
class OptionsModel extends BaseModel {

    public function getOption($option_key) {
        $value = $this->where("option_name = '$option_key'")->getField("option_value");
        return $value;
    }


    public function update($key, $value) {
        if(!$key) return false;
        $o = $this->getByOptionName($key);
        $o['option_name'] = $key;
        $o['option_value'] = $value;
        return $this->saveOrUpdate($o);
    }
}