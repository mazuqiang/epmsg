<?php
namespace widget\pagination;

interface link{
    public function first();
    
    public function last();
    
    public function prev();
    
    public function next();
    
    public function current($num);
}