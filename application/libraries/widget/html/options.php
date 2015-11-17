<?php 
namespace widget\html;

use widget\component;
use widget\basehtml;
class options extends component{
    
    public $lable;
    
    public $options;
    
    public $value;
    
    public function run(){
        $this->lable = empty($this->lable) ? $this->value : $this->lable;
        $options = $this->options;
        $options['value'] = $this->value;
        return basehtml::tag_option($this->lable, $options);
    }   

    
}