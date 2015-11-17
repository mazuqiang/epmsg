<?php
namespace widget\grid;

use widget\component;
use widget\basehtml;

class columns extends component
{

    public $options = [];

    public $grid;

    public $lable;

    public $content;

    public $header;

    public $footer;

    public $attribute;

    public $format;

    public $label;

    public $theadThOptions = [];

    public $tbodyTdOptions = [];

    public $tfoottdOptions = [];

    public function init($params = array())
    {}

    public function theadTh()
    {
        if ($this->label) {
            return basehtml::tag_th($this->label, $this->theadThOptions);
        } elseif ($this->attribute) {
            return basehtml::tag_th($this->attribute, $this->theadThOptions);
        }
        return basehtml::tag_th(trim($this->header) !== '' ? $this->header : $this->grid->emptyCell, $this->theadThOptions);
    }

    public function tfootTd()
    {
        return basehtml::tag_td(trim($this->footer) !== '' ? $this->footer : $this->grid->emptyCell, $this->tfoottdOptions);
    }

    public function tbodyTd($model, $index = NULL, $pk = NULL)
    {
        foreach ($model as $k => $v) {
            if($this->attribute == $k)
                return basehtml::tag_td(trim($v) !== '' ? $v : $this->grid->emptyCell, $this->tbodyTdOptions);
        }
    }
}