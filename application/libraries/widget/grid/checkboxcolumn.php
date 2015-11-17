<?php
namespace widget\grid;
use widget\basehtml;
include_once dirname(__FILE__) . '/columns.php';



class checkboxcolumn extends columns{
    public $header = '#';
    
    public $name = 'selection';
    
    public $CheckBoxOptions = [];
    
    public $CheckBoxHeaderOptions = [ 'class' => 'select-on-check-all', 'id' => 'select-on-check-all'];
    
    public $DivCheckBoxOptions = [ 'class' => 'checkbox' ,'style'=>"margin:0;"];
    
    public function init()
    {
        parent::init();
        if (empty($this->name)) {
            throw new \Exception('"name" 必须设置.');
        }
        if (substr_compare($this->name, '[]', -2, 2)) {
            $this->name .= '[]';
        }
    }
    
    public function theadTh(){
        $name = rtrim($this->name, '[]') . '_all';
        $html = basehtml::tag_checkobk($name, $this->CheckBoxHeaderOptions);
        $options['for'] = $this->CheckBoxHeaderOptions['id'];
        $html = basehtml::tag_label($html.'全选', $options);
        $html = basehtml::tag_div($html,  $this->DivCheckBoxOptions);
        return basehtml::tag_th($html);
    }
    
    
    public function tbodyTd($model, $index = NULL, $pk = NULL)
    {
        $model = (array)$model;
        $options = $this->CheckBoxOptions;
        if (!isset($options['value'])) {
            $options['value'] = $model[$pk];
        }
        $options['checked'] = !empty($options['checked']);
        $options['name'] = $this->name;
        $options['id'] = $pk.$options['value'];
        $html = basehtml::tag_checkobk($this->name, $options);
        $pagination = $this->grid->dataprovider->getPagination();
        if ($pagination !== false) {
            $index = $pagination->get_limit() + $index + 1;
        } else {
            $index = $index + 1;
        }
        $options['for'] = $options['id'];
        $html = basehtml::tag_label($html.$index, $options);
        $html = basehtml::tag_div($html,  $this->DivCheckBoxOptions);
        return basehtml::tag_td($html) ;
    }
    
}