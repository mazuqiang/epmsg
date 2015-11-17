<?php
namespace widget\grid;


use widget\baseview;
use widget\basehtml;

include_once dirname(__FILE__) . "/../baseview.php";
include_once dirname(__FILE__) . '/../basehtml.php';
include_once dirname(__FILE__) . '/baselistview.php';


class gridview extends baselistview
{

    public $tableOptions =  ['class' => 'table table-striped table-bordered'];
    public $theadtrOptions = [];
    public $tfoottrOptions = [];
    public $options = ['class' => 'grid-view'];
    
    /**
     * params is string or array
     * new columns(params[0])
     * @var []
     */
    public $columns = [];
    
    public $dataprovider = [];

    public $showheader = TRUE;
    
    public $theadTrOptions = [];

    public $showfooter = FALSE;

    public $tfootTrOptions = [];
    
    public $tbodyTrOptions = [];
    
    public $layout = "{summary}{items}{pager}";
    
    public function init(){
        parent::init();
        $this->initColumns();
    }
    
    public function initColumns(){
        if(empty($this->columns)){
            $data = $this->dataprovider->getModels();
            foreach ($data[0] as $k => $v){
                $this->columns[] = $k;
            }
        }
        foreach ($this->columns as $k => $v){
            if(is_string($v)){
                if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $v, $matches)) {
                    throw new \Exception('The column must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
                }
                $this->columns[$k] = baseview::createobj(array(
                    'grid' => $this,
                    'class' => 'widget\grid\columns',
                    'attribute' => $matches[1],
                    'format' => isset($matches[3]) ? $matches[3] : 'text',
                    'label' => isset($matches[5]) ? $matches[5] : null,
                ));
            }elseif(is_array($v)){
                $v['class'] = empty($v['class']) ? 'widget\grid\columns' : $v['class'];
                $v['grid'] = $this;
                $v['attribute'] = isset($v['attribute']) ? $v['attribute'] : null;
                $v['label'] = isset($v['label']) ? $v['label'] : null;
                $this->columns[$k] = baseview::createobj($v);
//                 var_dump($this->columns[$k]);
            }else{
                throw new \Exception('请扩展该属性'.json_decode($v));
            }

        }
    }
    
    public function run(){
        return parent::run();
    }
    
    public function header(){
        $ths = [];
        foreach ($this->columns as $column) {
            $ths[] = $column->theadTh();
        }
        $content = basehtml::tag_tr(implode('', $ths), $this->theadTrOptions);
        return basehtml::tag_thead($content);
    }
    
    public function body(){
        $rows = array();
        $models = $this->dataprovider->getModels();
        $pk = $this->dataprovider->getKeys();
        foreach ($models as $index => $model){
            $rows[] = $this->tbodytrs($model, $index, $pk);
        }
        if(empty($rows)){
            return basehtml::tag_tbody(basehtml::tag_tr(basehtml::tag_td($this->emptyText, $this->emptyTextOptions)));
        }else{
            return basehtml::tag_tbody(implode("\n", $rows));
        }
    }
    
    public function tbodytrs($model, $index, $pk){
        $tds = array();

        foreach ($this->columns as $column ){
            $tds[] = $column->tbodyTd($model, $index, $pk);
        }
//         var_dump($tds);exit();
        return basehtml::tag_tr(implode('', $tds), $this->tbodyTrOptions);
    }
    
    public function footer(){
        $tds = [];
        foreach ($this->columns as $column) {
            $tds[] = $column->tfootTd();
        }
        $content = basehtml::tag_tr(implode('', $tds), $this->tfootTrOptions);
        return basehtml::tag_tfoot($content);
    }
    
    public function items(){
        $content = array_filter(array(
            $this->showheader ? $this->header() : FALSE,
            $this->body(),
            $this->showfooter ? $this->footer() : FALSE
        ));
//         var_dump($content);
        return basehtml::tag_table(implode("\n", $content), $this->tableOptions);
    }
    
    
    
}