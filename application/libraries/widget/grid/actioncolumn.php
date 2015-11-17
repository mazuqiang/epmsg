<?php
namespace widget\grid;
include_once dirname(__FILE__) . '/columns.php';


use widget\basehtml;
use widget\helpers\baseurl;

class actioncolumn extends columns{
    public $template = '{view} {update} {delete}';
    public $buttonOptions = [];
    public $urlCreator;
    public $buttons = [];
    
    
    public function init()
    {
        parent::init();
        $this->initDefaultButtons();
    }
    
    public function initDefaultButtons(){
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($model, $index, $pk){
                $model = (array)$model;
                $tag_span = basehtml::tag_span('<span class="glyphicon glyphicon-eye-open"></span>', $this->buttonOptions);
                return basehtml::tag_a($tag_span, array(
                    'href'=>baseurl::site_url(array('view', $pk=>$model[$pk])),
                    'data-row' => $index
                ));
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($model, $index, $pk){
                $model = (array)$model;
                $tag_span =  basehtml::tag_span('<span class="glyphicon glyphicon-pencil"></span>', $this->buttonOptions);
                return basehtml::tag_a($tag_span, array(
                    'href'=>baseurl::site_url(array('update', $pk=>$model[$pk])),
                    'data-row' => $index
                ));
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($model, $index, $pk){
                $model = (array)$model;
                $tag_span = basehtml::tag_span('<span class="glyphicon glyphicon-trash"></span>', $this->buttonOptions);
                return basehtml::tag_a($tag_span, array(
                    'href'=>baseurl::site_url(array('delete', $pk=>$model[$pk])),
                    'data-row' => $index
                ));
            };
        }
    }
    
    public function tbodyTd($model, $index = NULL, $pk = NULL)
    {
        $html = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $index, $pk) {
            $name = $matches[1];
            if (isset($this->buttons[$name])) {
                return call_user_func($this->buttons[$name], $model, $index, $pk);
            } else {
                return '';
            }
        }, $this->template);
        return basehtml::tag_td($html);
    }
    
}