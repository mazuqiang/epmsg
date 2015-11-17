<?php
namespace widget;

class basehtml
{

    const href = 'javascript:void(0);';
    
    static $item = array();

    public static function tag_a($content, $attributes = NULL, $empty = TRUE)
    {
        $attributes = self::getAttributesHtml($attributes, array(
            'href'
        ));
        return "<a {$attributes} >{$content}</a>";
    }

    public static function tag_nav($content, $attributes = NULL, $empty = TRUE){
        return self::tag('nav', $content, $attributes, $empty);
    }
    
    public static function tag_li($content, $attributes = NULL, $empty = TRUE){
        return self::tag('li', $content, $attributes, $empty);
    }
    
    public static function tag_ul($content, $attributes = NULL, $empty = TRUE){
        return self::tag('ul', $content, $attributes, $empty);
    }
    
    public static function tag_span($content, $attributes = NULL, $empty = TRUE){
        return self::tag('span', $content, $attributes, $empty);
    }
    
    public static function tag_table($content, $attributes = NULL, $empty = TRUE){
        return self::tag('table', $content, $attributes, $empty);
    }
    
    public static function tag_thead($content, $attributes = NULL, $empty = TRUE){
        return self::tag('thead', $content, $attributes, $empty);
    }
    
    public static function tag_tfoot($content, $attributes = NULL, $empty = TRUE){
        return self::tag('tfoot', $content, $attributes, $empty);
    }
    
    public static function tag_th($content, $attributes = NULL, $empty = TRUE){
        return self::tag('th', $content, $attributes, $empty);
    }
    
    public static function tag_tr($content, $attributes = NULL, $empty = TRUE){
        return self::tag('tr', $content, $attributes, $empty);
    }
    
    public static function tag_td($content, $attributes = NULL, $empty = TRUE){
        return self::tag('td', $content, $attributes, $empty);
    }
    
    public static function tag_tbody($content, $attributes = NULL, $empty = TRUE){
        return self::tag('tbody', $content, $attributes, $empty);
    }
    
    public static function tag_div($content, $attributes = NULL, $empty = TRUE){
        return self::tag('div', $content, $attributes, $empty);
    }
    
    public static function tag_checkobk($content, $attributes = NULL, $empty = TRUE){
        return self::input('checkbox', $content, $attributes, $empty);
    }
    
    public static function tag_label($content, $attributes = NULL, $empty = TRUE){
        return self::tag('label', $content, $attributes, $empty);
    }
    
    public static function tag_select($content, $attributes = NULL, $empty = TRUE){
        return self::tag('select', $content, $attributes, $empty);
    }
    
    public static function tag_option($content, $attributes = NULL, $empty = TRUE){
        return self::tag('option', $content, $attributes, $empty);
    }
    
    /**
     * 返回文本内容
     * @param unknown $content
     * @param string $attributes
     * @return unknown
     */
    public static function tag_($content, $attributes = NULL){
        return $content;
    }
    
    public static function tag($tag, $content, $attributes = NULL, $empty = TRUE){
        if(!$empty && $content == ''){
            return '';
        }
        $attributes = self::getAttributesHtml($attributes, array(
        ));
        return "<{$tag} {$attributes} >{$content}</{$tag}>";
    }
    
    public static function input($tag, $content, $attributes = NULL, $empty = TRUE){
        if(!$empty && $content == ''){
            return '';
        }
        $attributes = self::getAttributesHtml($attributes, array(
        ));
        return "<input type={$tag} {$attributes} value={$content} />";
    }
    
    public static function getAttributesHtml($attributes = '', $config = array())
    {
        $html = '';
        if (is_array($attributes)) {
            foreach ($attributes as $k => $v) {
                $html .= " {$k}='{$v}' ";
            }
            foreach ($config as $v) {
                if (!in_array($v, array_keys($attributes)) && defined(get_called_class().'::'.$v)) {
                    $html = " {$v}='" .constant(get_called_class().'::'.$v) . "' ";
                }
            }
        } else{
            foreach ($config as $v) {
                if (is_string($attributes) && $v == $attributes){
                    $html .= " {$v}={$attributes} ";
                }elseif(defined(get_called_class().'::'.$v)){
                    $html .= " {$v}=" . constant(get_called_class().'::'.$v) . " ";
                }
            }
        }
        return $html;
    }
    
    public static function itms($config = array()){
        $function_name = 'tag_'.$config['tag'];
        if(is_array($config['itms'])){
            foreach ($config['itms'] as $v){
                $html .= self::itms($v);
            }
            return self::$function_name($html, $config['attributes']);
        }
        $content = $config['content'];
        $empty = $config['empty'];
        unset($config['tag']);
        unset($config['content']);
        return self::$function_name($content, $config['attributes'], $empty);
    }
    
}