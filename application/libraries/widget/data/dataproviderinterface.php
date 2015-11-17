<?php
namespace widget\data;


interface dataproviderinterface{
    
    public function getCount();
    
    public function getPageCount();
    
    public function getModels();
    
    public function getKeys();
    
//     public function getSort();
    
    public function getPagination();
    
}