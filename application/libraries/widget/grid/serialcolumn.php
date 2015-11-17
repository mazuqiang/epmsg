<?php
namespace widget\grid;
use widget\basehtml;
include_once dirname(__FILE__) . '/columns.php';



class serialcolumn extends columns{
    public $header = '#';
    
    public function tbodyTd($model, $index = NULL, $pk = NULL)
    {
        $pagination = $this->grid->dataprovider->getPagination();
        if ($pagination !== false) {
            return basehtml::tag_td($pagination->get_limit() + $index + 1);
        } else {
            return basehtml::tag_td($index + 1);
        }
    }
    
}