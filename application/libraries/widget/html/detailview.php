<?php
namespace widget\html;

use widget\component;
use widget\data\activedetail;
use widget\basehtml;
class detailview extends component{
    public $model;
    
    public $attributes;
    
    public $template = "<tr><th>{label}</th><td>{value}</td></tr>";
    
    public $options = ['class' => 'table table-striped table-bordered detail-view'];
    
    public function init(){
        if(empty($this->model) || !$this->model instanceof activedetail ){
            throw new \Exception('model 必须设置 且必须是或者继承  activedetail');
        }
        $this->normalizeAttributes();
    }
    
    public function run($attribute, $index)
    {
        $rows = [];
        $i = 0;
        foreach ($this->attributes as $attribute) {
//             var_dump($attribute);
            $rows[] = $this->renderAttribute($attribute, $i++);
        }
        $options = $this->options;
//         $tag = ArrayHelper::remove($options, 'tag', 'table');
        return basehtml::tag_table(implode("\n", $rows), $options);

    }
    
    protected function renderAttribute($attribute, $index){
        if (is_string($this->template)) {
            return strtr($this->template, [
                '{label}' => $attribute['label'],
                '{value}' => $attribute['value'],//$this->formatter->format($attribute['value'], $attribute['format']),
            ]);
        } else {
            throw new \Exception('请扩展该方法 detailview::renderAttribute');
//             return call_user_func($this->template, $attribute, $index, $this);
        }
    }
    
    
    protected function normalizeAttributes(){
       if(empty($this->attributes)){
           $this->attributes = $this->model->getAtterbutes();
       } 
       foreach ($this->attributes as $i => $attribute) {
           if (is_string($attribute)) {
               if (!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/', $attribute, $matches)) {
                   throw new \Exception('The attribute must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
               }
               $attribute = [
                   'attribute' => $matches[1],
                   'format' => isset($matches[3]) ? $matches[3] : 'text',
                   'label' => isset($matches[5]) ? $matches[5] : null,
               ];
           }
           if (!is_array($attribute)) {
               throw new \Exception('The attribute configuration must be an array.');
           }
           
           if (!isset($attribute['format'])) {
               $attribute['format'] = 'text';
           }
           
           if (isset($attribute['attribute'])) {
               $attributeName = $attribute['attribute'];
               if (!isset($attribute['label'])) {
                   $attribute['label'] =  $this->model->getAttributeLabel($attributeName) ;
               }
               if (!array_key_exists('value', $attribute)) {
                   $attribute['value'] = $this->model->getValue($attributeName);
               }
           } elseif (!isset($attribute['label']) || !array_key_exists('value', $attribute)) {
               throw new \Exception('The attribute configuration requires the "attribute" element to determine the value and display label.');
           }
//            var_dump($attribute);
           $this->attributes[$i] = $attribute;
           
       }
    }
    
}