<?php
namespace widget\data;

include_once dirname(__FILE__) . "/datadetailinterface.php";

use widget\component;



class activedetail extends component implements datadetailinterface{
    
    private $_model;
    
    public function setmodel($model)
    {
        $this->_model = $model;
    }
    
    /**
     * return []
     * (non-PHPdoc)
     * @see \widget\data\datadetailinterface::getAtterbutes()
     */
    public function getAtterbutes(){
        return $this->_model->getAtterbutes();
    }
        
    /**
     * $attribute 属性名字
     * 返回对应的值
     * @param unknown $attribute
     */
    public function getValue($attribute){
        return $this->_model->$attribute;
    }
    
    /**
     * $attribute 属性名字
     * 返回对应的文本
     * @param unknown $attribute
     */
    public function getAttributeLabel($attribute){
        return $attribute;
    }
    
    public static function error(){
        throw new \Exception('请重写该方法');
    }
}