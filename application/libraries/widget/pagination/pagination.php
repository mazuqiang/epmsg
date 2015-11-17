<?php
namespace widget\pagination;


include_once 'link.php';
include_once dirname(__FILE__) . "/../baseview.php";
include_once dirname(__FILE__) . '/../basehtml.php';

use widget\basehtml;
use widget\component;


class pagination extends component implements link
{

    /**
     * 分页模版
     *
     * @var string
     */
    public $template = '{first}{prev}{num_link}{next}{last}';

    /**
     * title模版
     *
     * @var string
     */
    public $title = '<div class="summary">第{current_page}页, 共{page_count}页(每页{page_size}条, 共{count}条)</div>';

    /**
     * url链接, 请不要带参数
     *
     * @var string
     */
    public $baseurl = '';

    /**
     * 左右现实的页码
     *
     * @var int
     */
    public $num_links = 2;

    /**
     * 总行数
     *
     * @var int
     */
    public $count = 0;

    /**
     * 共有多少页
     *
     * @var int
     */
    public $page_count = 0;

    /**
     * 每页多少行
     *
     * @var int
     */
    private $page_size = 0;

    public static $spage_size = 10;

    /**
     * 当前页数
     *
     * @var int
     */
    public $current_page = 1;

    /**
     * 以下几个分别是 首部， 尾部， 上一页，下一页，页码， 当前页码 样式配置
     *
     * @var array tag string 标签名
     *      content string 内容页面内容
     *      empty bool 如果为假，content 为空的时候， 直接过滤
     *      itms array 该项可以设置包含情况。
     *     
     */
    public $first_tag = array(
        'tag' => 'a',
        'content' => '首页'
    );

    public $last_tag = array(
        'tag' => 'a',
        'content' => '尾页'
    );

    public $prev_tag = array(
        'content' => '',
        'tag' => 'span',
        'attributes' => array(
            'aria-hidden' => "true"
        ),
        'itms' => array(
            array(
                'content' => '上一页',
                'tag' => 'a',
                'attributes' => array(
                    'aria-label' => "Previous"
                )
            )
        )
    );

    public $next_tag = array(
        'tag' => 'span',
        'content' => '',
        'itms' => array(
            array(
                'content' => '下一页',
                'tag' => 'a'
            )
        )
    );

    public $num_tag = array(
        'tag' => 'a',
        'content' => 0
    );

    public $current_tag = array(
        'tag' => 'a',
        'content' => 0,
        'attributes' => array(
            'class' => "active"
        )
    );

    public $row_tag = array(
        'tag' => 'li',
        'empty' => FALSE
    );

//     public $page_tag = array(
//         'tag' => 'nav',
//         'itms' => array(
//             array(
//                 'tag' => 'ul',
//                 'attributes' => array(
//                     'class' => "pagination pull-right"
//                 )
//             )
//         )
//     );
    
    public $page_tag = array(
        'tag' => 'ul',
        'attributes' => array(
            'class' => "pagination pull-right"
        )
    );

    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->current_page = is_numeric($_GET['page_current']) ? $_GET['page_current'] : 1;
    }
    
//     public function init(){
//         $this->get_page_count();
//         $this->get_current_page();
//     }
    
    public function get_current_page(){
        $this->get_page_count();
        if ($this->current_page < 1) {
            $this->current_page = 1;
        } elseif ($this->current_page > $this->page_count) {
            $this->current_page = $this->page_count;
        }
        return $this->current_page;
    }

    public function first()
    {
        $url = $this->get_Link(1);
        $config = $this->first_tag;
        if (is_array($config['itms'])) {
            foreach ($config['itms'] as $k => $v) {
                $config['itms'][$k]['attributes']['href'] = $url;
            }
        } else {
            $config['attributes']['href'] = $url;
        }
        return $this->row(basehtml::itms($config));
    }

    public function last()
    {
        $url = $this->get_Link($this->get_page_count());
        $config = $this->last_tag;
        if (is_array($config['itms'])) {
            foreach ($config['itms'] as $k => $v) {
                $config['itms'][$k]['attributes']['href'] = $url;
            }
        } else {
            $config['attributes']['href'] = $url;
        }
        return $this->row(basehtml::itms($config));
    }

    public function prev()
    {
        $page = $this->get_prev_page();
        if ($page < 1) {
            return '';
        }
        $url = $this->get_Link($page);
        $config = $this->prev_tag;
        if (is_array($config['itms'])) {
            foreach ($config['itms'] as $k => $v) {
                $config['itms'][$k]['attributes']['href'] = $url;
            }
        } else {
            $config['attributes']['href'] = $url;
        }
        return $this->row(basehtml::itms($config));
    }

    public function get_prev_page()
    {
        return $this->get_current_page() - 1;
    }

    public function next()
    {
        $page = $this->get_next_page();
        if ($page > $this->get_page_count()) {
            return '';
        }
        $url = $this->get_Link($page);
        $config = $this->next_tag;
        if (is_array($config['itms'])) {
            foreach ($config['itms'] as $k => $v) {
                $config['itms'][$k]['attributes']['href'] = $url;
            }
        } else {
            $config['attributes']['href'] = $url;
        }
        return $this->row(basehtml::itms($config));
    }

    public function get_next_page()
    {
        return $this->get_current_page() + 1;
    }

    public function num_link()
    {
        $links = array();
        $row_target = $this->row_tag;
        for ($i = - $this->num_links; $i <= $this->num_links; $i ++) {
            $n = $i + $this->get_current_page();
            $links[] = $n == $this->get_current_page() ? $this->current($n) : $this->link($n);
        }
        return implode('', $links);
    }

    public function link($num)
    {
        if ($num < 1 || $num > $this->get_page_count()) {
            return '';
        }
        $url = $this->get_Link($num);
        $config = $this->num_tag;
        if (is_array($config['itms'])) {
            foreach ($config['itms'] as $k => $v) {
                $config['itms'][$k]['attributes']['href'] = $url;
                $config['itms'][$k]['content'] = $num;
            }
        } else {
            $config['attributes']['href'] = $url;
            $config['content'] = $num;
        }
        return $this->row(basehtml::itms($config));
    }

    public function get_Link($num)
    {
        $get = $_GET;
        $get['page_current'] = $num;
        return $this->baseurl . '?'.http_build_query($get);
    }

    public function current($num)
    {
        $config = $this->current_tag;
        if (is_array($config['itms'])) {
            foreach ($config['itms'] as $k => $v) {
                $config['itms'][$k]['attributes']['href'] = basehtml::href;
                $config['itms'][$k]['content'] = $num;
            }
        } else {
            $config['attributes']['href'] = basehtml::href;
            $config['content'] = $num;
        }
        return $this->row(basehtml::itms($config), array(
            'tag' => 'li',
            'attributes' => array(
                'class' => "active"
            )
        ));
    }

    public function row($content, $config = [])
    {
        $config = empty($config) ? $this->row_tag : $config;
        if (is_array($config['itms'])) {
            foreach ($config['itms'] as $k => $v) {
                $config['itms'][$k]['content'] = $content;
            }
        } else {
            $config['content'] = $content;
        }
        return basehtml::itms($config);
    }

    public function page($content)
    {
        $config = $this->page_tag;
        if (is_array($config['itms'])) {
            foreach ($config['itms'] as $k => $v) {
                $config['itms'][$k]['content'] = $content;
            }
        } else {
            $config['content'] = $content;
        }
        return basehtml::itms($config);
    }

//     public function run()
//     {
//         echo $this;
//         echo $this->get_title();
//         echo $this->get_limit();
//         echo $this->get_offest();
//     }

    public function __toString()
    {
        $this->get_page_count();
        return $this->count ? $this->page($this->template()) : '';
    }

    public function get_title()
    {
        $this->get_page_count();
        return preg_replace_callback('/\{(\w+)\}?/iu', function ($matches)
        {
            $matches = $matches[1];
            return empty($this->$matches) ? 0 : $this->$matches;
        }, $this->title);
    }

    public function template()
    {
        $html = preg_replace_callback('/\{(\w+)\}/', function ($matches)
        {
            $matches = $matches[1];
            if (method_exists(get_called_class(), $matches)) {
                $tmp = $this->$matches();
                return $tmp;
            }
        }, $this->template);
        return $html;
    }

    public function setpage_size($value, $validatePageSize = false){
        if ($value === null) {
            $this->page_size = null;
        } else {
            $this->page_size = intval($value);
        }
    }
    
    public function get_page_count()
    {
        if(!$this->page_count){
            if($this->get_page_size() <= 1){
                $this->page_count = $this->count > 0 ? 1 : 0;
            }else{
                $this->page_count = ceil($this->count / $this->get_page_size());
            }
        }
        return $this->page_count;
    }

    public function get_page_size()
    {
        if (! $this->page_size)
            $this->page_size = $this->page_size ? $this->page_size : self::$spage_size;
        return $this->page_size;
    }

    public function get_limit()
    {
        return $this->page_size * ($this->get_current_page() - 1);
    }

    public function get_offest()
    {
        return $this->page_size;
    }
}
