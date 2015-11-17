<?php
namespace widget\data;

include_once dirname(__FILE__) . "/dataproviderinterface.php";

use widget\component;
use widget\baseview;
use widget\pagination\pagination;



abstract class basedataprovider extends component implements dataproviderinterface{
       
    private $_pagination;
    
    private $_count;
    
    private $_keys;
    
    private $_models;
    
    public function getCount(){
        if($this->getPagination() === FALSE){
            return $this->getPageCount();
        }elseif($this->_count === NULL){
            $this->_count = $this->prepareCount();   
        }
        return $this->_count;
    }
    
    /**
     * (non-PHPdoc)
     * @see \widget\data\dataproviderinterface::getPageCount()
     * 获取当前分页中的数据数量
     */
    public function getPageCount(){
        return count($this->getModels());
    }
    
    /**
     * 获取分页对象
     * (non-PHPdoc)
     * @see \widget\data\dataproviderinterface::getPagination()
     */
    public function getPagination(){
        if($this->_pagination === NULL){
            $this->setPagination();
        }
        return $this->_pagination;
    }
    
    /**
     * 设置分页对象
     * @param unknown $config
     */
    public function setPagination($value = array()){
        if (is_array($value)) {
            $config = ['class' => pagination::className(),];
            $this->_pagination = baseview::createobj(array_merge($config, $value));
        } elseif ($value instanceof pagination || $value === false) {
            $this->_pagination = $value;
        } else {
            throw new \Exception('创建分页对象错误.');
        }
//         $this->_pagination->init();
    }
    
    /**
     * 初始化准备
     * @param string $forcePrepare
     */
    public function prepare($forcePrepare = FALSE)
    {
        if ($forcePrepare || $this->_models === NULL) {
            $this->_models = $this->prepareModels();
        }
        if ($forcePrepare || $this->_keys === NULL) {
            $this->_keys = $this->prepareKeys($this->_models);
        }
    }
    
    /**
     * 获取当前页数据
     * (non-PHPdoc)
     * @see \widget\data\dataproviderinterface::getModels()
     */
    public function getModels(){
        $this->prepare();
        return $this->_models;
    }

    /**
     * 设置当前页数据
     * @param unknown $models
     */
    public function setModels($models)
    {
        $this->_models = $models;
    }
    
    /**
     * 
     * (non-PHPdoc)
     * @see \widget\data\dataproviderinterface::getKeys()
     */
    public function getKeys(){
        $this->prepare();
        return $this->_keys;
    }

    /**
     * 
     * @param unknown $keys
     */
    public function setKeys($keys)
    {
        $this->_keys = $keys;
    }
    
    abstract public function prepareCount();
    
    abstract protected function prepareKeys($models);
    
    abstract protected function prepareModels();

}