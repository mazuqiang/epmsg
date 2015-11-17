<?php
namespace widget;
include_once dirname(__FILE__).'/helpers/baseurl.php';
class baseview
{

    public $enable_ajax = 0;

    public static $_singletons = NULL;
    
    public static $_reflections = NULL;
    
    public static $_dependencies = [];

    public static function createobj($config = array(), $params = array())
    {
        $class = NULL;
        if (is_string($config)) {
            $class = $config;
            $config = array();
        } elseif (is_array($config)) {
            $class = $config['class'];
            unset($config['class']);
        }
        if ($class && empty(self::$_singletons[$class])) {
            ! class_exists($class) && self::Load($class);
            if (class_exists($class)) {
                list($reflection, $dependencies) = self::getDependencies($class);
                foreach ($params as $index => $param) {
                    $dependencies[$index] = $param;
                }
                if(empty($config))
                    return $reflection->newInstanceArgs($dependencies);
                if (!empty($dependencies)) {
                    $dependencies[count($dependencies) - 1] = $config;
                    return $reflection->newInstanceArgs($dependencies);
                } else {
                    $object = $reflection->newInstanceArgs($dependencies);
                    foreach ($config as $name => $value) {
                        $object->$name = $value;
                    }
                    return $object;
                }
            }
        }
        return self::$_singletons[$class];
    }
    
    public static function configure($object, $properties){
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }
        return $object;
    }

    public static function Load($class, $dir = NULL)
    {
        $path = dirname(dirname(__FILE__));
        if (file_exists($path . "/" . $class . '.php')) {
            include_once $path . "/" . $class . '.php';
        }
    }
    
    protected static function getDependencies($class){
        if (isset(self::$_reflections[$class])) {
            return [self::$_reflections[$class], self::$_dependencies[$class]];
        }
        $dependencies = [];
        $reflection = new \ReflectionClass($class);
        
        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $param) {
                if ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
                } else {
                    throw new \Exception($param->getClass().'请拓展此功能');
                }
            }
        }
        self::$_reflections[$class] = $reflection;
        self::$_dependencies[$class] = $dependencies;
        
        return [$reflection, $dependencies];
        
    }
}

