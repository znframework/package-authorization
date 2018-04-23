<?php namespace ZN\Authorization;
/**
 * ZN PHP Web Framework
 * 
 * "Simplicity is the ultimate sophistication." ~ Da Vinci
 * 
 * @package ZN
 * @license MIT [http://opensource.org/licenses/MIT]
 * @author  Ozan UYKUN [ozan@znframework.com]
 */

use ZN\Controller\Factory;

class Permission extends Factory
{
    const factory =
    [
        'methods' =>
        [
            'start'              => 'Process::start',
            'end'                => 'Process::end',
            'process'            => 'Process::use',
            'processpermrules'   => 'Process::getPermRules',
            'processnopermrules' => 'Process::getNopermRules',
            'page'               => 'Page::use',
            'pagepermrules'      => 'Page::getPermRules',
            'pagenopermrules'    => 'Page::getNopermRules',
            'post'               => 'Method::post',
            'get'                => 'Method::get',
            'request'            => 'Method::request',
            'method'             => 'Method::use',
            'methodpermrules'    => 'Method::getPermRules',
            'methodnopermrules'  => 'Method::getNopermRules',
            'roleid'             => 'PermissionExtends::roleId'
        ]
    ];
}
