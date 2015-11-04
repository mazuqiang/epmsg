<?php
$config['menus'] = array(
        
        '9' => array(
                'caption' => '短信平台',
                'sub2' => array(
                        '9-1' => array(
                                'caption' => '短信应用',
                                'sub3' => array(
                    /*'9-1-1' => array(
                        'caption' => '短信应用列表',
                        'url' => 'sms/app_index'
                    ),*/
                    '9-1-1' => array(
                                                'caption' => '短信应用列表',
                                                'url' => 'sms/applications'
                                        ),
                                        '9-1-2' => array(
                                                'caption' => '短信应用类型列表',
                                                'url' => 'sms/types'
                                        )
                                )
                        ),
                        '9-2' => array(
                                'caption' => '短信记录',
                                'sub3' => array(
                                        '9-2-1' => array(
                                                'caption' => '短信日志',
                                                'url' => 'sms/log'
                                        )
                                )
                        ),
                        '9-3' => array(
                                'caption' => '短信运营商',
                                'sub3' => array(
                                        '9-3-1' => array(
                                                'caption' => '短信运营商列表',
                                                'url' => 'sms/op_index'
                                        ),
                                        '9-3-2' => array(
                                                'caption' => '手机号码黑名单',
                                                'url' => 'sms/hostdeny'
                                        ),
                                        '9-3-3' => array(
                                                'caption' => '短信模板列表',
                                                'url' => 'sms/module'
                                        )
                                )
                        )
                )
        ),
        
        '7' => array(
                'caption' => '权限管理',
                'sub2' => array(
                        '7-1' => array(
                                'caption' => '管理员管理',
                                'sub3' => array(
                                        '7-1-1' => array(
                                                'caption' => '管理员列表',
                                                'url' => 'authorty/index'
                                        ),
                                        '7-1-2' => array(
                                                'caption' => '添加管理员',
                                                'url' => 'authorty/add'
                                        )
                                )
                        )
                )
        )
);