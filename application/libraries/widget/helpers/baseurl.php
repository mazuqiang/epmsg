<?php
namespace widget\helpers;

class baseurl {
    
    /**
     * 创建url
     * @action 参数
     * @pol 协议 http 或者 https
     */
    public static function site_url($_action = array(), $pol = 'http'){
//         var_dump($_action);exit();
        $ci = &get_instance();
        $class = $ci->router->fetch_class();
        $directory = $ci->router->fetch_directory();
        $router = array();
        $directory && ( array_push($router, $directory));
        $class && ( array_push($router, $class));
        if(is_array($_action)){
            $router = array_merge($router, $_action);
        }elseif (is_string($_action)){
            array_push($router, $_action);
        }else{
            throw new \Exception('baseurl类不支持该类型创建url,如需使用请扩展');
        }
        return site_url($router, $pol);
    }
}