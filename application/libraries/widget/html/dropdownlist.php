<?php 
namespace widget\html;

use widget\component;
use widget\basehtml;
use widget\baseview;
use ytool\base\widget;
class dropdownlist extends component{
    
    private $items = [];
    
    public $name;
    
    public $options = ['class' => "form-control"];
    
    public $value;
    
    public $html;
    
    public function run(){
        if(empty($this->name)){
            throw new \Exception('select元素 name 必须设置');
        }
//         $this->lable = empty($this->lable) ? $this->name : $this->lable;
        $options = $this->options;
        $options['value'] = $this->value;
        $options['name'] = $this->name;
        foreach ($this->items as $v){
            $html .= $v->run();
        }
        $this->html = basehtml::tag_select($html, $options);
        return $this->html;
    }
    
    public function __toString(){
        return $this->html;
    }
    
    public function setitems($options){
        if(is_array($options)){
            foreach ($options as $k => $option){
                if(is_array($option)){
                    $this->items[] = baseview::createobj($option);
                }else{
                    $this->setitems($option);
                }
            }
        }elseif (is_string($options)){
            $option = array(
                'class' => 'widget\html\options',
                'lable' => $options
            );
            $this->items[] = baseview::createobj($option);
        }elseif (is_object($options) && $options instanceof options){
            $this->items[] = $options;
        }else{
            throw new \Exception('请扩展该属性');
        }
    }
}