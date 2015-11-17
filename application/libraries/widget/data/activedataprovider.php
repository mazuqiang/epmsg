<?php
namespace widget\data;

include_once dirname(__FILE__) . "/basedataprovider.php";

class activedataprovider extends basedataprovider{
    
    /**
     * AR模型
     * @var model
     */
    public $model;
    
    public function init()
    {
        parent::init();
        $this->getCount();
    }
    
    /**
     * 获取当前分页数据
     * (non-PHPdoc)
     * @see \widget\data\basedataprovider::prepareModels()
     */
    public function prepareModels(){
        $where = array();
        $like = array();
        if (!!$pagination = $this->getPagination()) {
            $pagination->count = $this->getCount();
        }
        $limit = array( $pagination->get_offest(), $pagination->get_limit());
        return $this->model->get_list($where, $like, $limit);
//         self::error();
    }
    
    /**
     * 获取主键key
     * (non-PHPdoc)
     * @see \widget\data\basedataprovider::prepareKeys()
     */
    public function prepareKeys($models){
        return $this->model->get_pk();
//         self::error();
    }
    
    /**
     * 获取总数据数量
     * (non-PHPdoc)
     * @see \widget\data\basedataprovider::prepareCount()
     */
    public function prepareCount(){
        return $this->model->get_count();
//         self::error();
    }
    
    public static function error(){
        throw new \Exception('请重写该方法');
    }

}