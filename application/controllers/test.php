<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

include APPPATH . '/libraries/widget/grid/gridview.php';
include APPPATH . '/libraries/widget/html/dropdownlist.php';
include APPPATH . '/libraries/widget/pagination/pagination.php';
include APPPATH . '/libraries/widget/data/activedataprovider.php';
include APPPATH . '/libraries/widget/data/activedetail.php';
include APPPATH . '/libraries/widget/html/detailview.php';
use basehtml\basehtml;
use baseview\baseview;
use widget\data\activedataprovider;
use widget\grid\gridview;
use widget\data\activedetail;

class test extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->output->enable_profiler(TRUE);
        try {
            $this->load->model('cf_requests_model', 'admin');
            $this->admin->get_info();
//             var_dump($p);
            $this->data['activedetail'] = new activedetail([
                'model' => $this->admin
            ]);
            
            $this->data['pagination'] = new activedataprovider(array(
                'model' => $this->admin,
                'Pagination' => [
                    'page_size' => 12
                ]
            ));
            $this->load->view('test', $this->data);
        } catch (Exception $e) {
            var_dump($e);
        }
    }
}