<?php
namespace widget\data;


interface datadetailinterface{
    
    public function getAtterbutes();
    
    public function getValue($attribute);
    
    public function getAttributeLabel($attribute);
}