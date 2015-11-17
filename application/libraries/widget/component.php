<?php
namespace widget;


class component {
    
    public static $autoIdPrefix;
    public static $counter = 0;
    
    private $_id;
    
    public static function widget($config)
    {
        $config['class'] = get_called_class();
        self::$autoIdPrefix = $config['class'];
        $obj = baseview::createobj($config);
        $obj->run();
        return $obj->run();
    }
    
    public function __construct($config = array()){
        if(!empty($config) && is_array($config)){
            baseview::configure($this, $config);
        }
        $this->init();
    }
    
    public function getId($autoGenerate = true)
    {
        if ($autoGenerate && $this->_id === null) {
            $this->_id = static::$autoIdPrefix . static::$counter++;
        }
        return $this->_id;
    }
    
    public function init(){
        
        
    }
    
    public static function classname(){
        return get_called_class();
    }
    
    public function __set($name, $value){
        $setter = 'set'.$name;
        if(method_exists($this, $setter)){
            $this->$setter($value);
            return ;
        }elseif (method_exists($this, 'get' . $name)) {
            throw new \Exception('该属性只读: ' . get_class($this) . '::' . $name);
        } else {
            throw new \Exception('无法设施该属性: ' . get_class($this) . '::' . $name);
        } 
    }
    
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (method_exists($this, 'set' . $name)) {
            throw new \Exception('该属性只写: ' . get_class($this) . '::' . $name);
        } else {
            throw new \Exception('无法读取该属性: ' . get_class($this) . '::' . $name);
        }
    }
    
}