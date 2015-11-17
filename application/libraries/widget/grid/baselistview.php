<?php
namespace widget\grid;

use widget\component;
use widget\baseview;
include_once dirname(__FILE__) . '/../component.php';


abstract class baselistview extends component
{
    
    public $emptyText = '尚无数据';
    
    public $emptyCell = '&nbsp;';
    
    public $emptyTextOptions = ['class' => 'empty'];

    public $fiterUrl = '';

    public $layout = '';

//     public $data = '';
    
    abstract public function items();

    public function init()
    {
        if (! isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    public function run()
    {
        if (preg_match_all('/\w+/i', $this->layout, $layout)) {
            $layout = $layout[0];
            $layout = preg_replace_callback('/\w+/', function ($matches)
            {
                $matches = $matches[0];
                if (method_exists($this, $matches)) {
                    return $this->$matches();
                } elseif (class_exists($matches)) {
                    return new $matches();
                }
            }, $layout);
            $layout = implode('', $layout);
            return $layout;
        }
    }
    
    public function __toString(){
        
    }
    
    public function summary(){
//         $Pagination = $this->dataprovider->getPagination();
//         return $Pagination->get_title();
//         $obj = baseview::createobj(array(
//             'class' => 'widget\pagination\pagination',
//              'count'=> count($this->data)
//         ));
//         return $obj->get_title();
    }
    
    
    public function pager(){
        $Pagination = $this->dataprovider->getPagination();
//         echo $Pagination->__toString().'11';
//         var_dump($Pagination);exit();
//         echo $Pagination->get_title();
        return $Pagination;
         
    }
    
}
