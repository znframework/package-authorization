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

use ZN\Base;
use ZN\Config;
use ZN\Request\Method;

class PermissionExtends
{
    /**
     * Permission
     * 
     * @var array
     */
    protected static $permission = [];

    /**
     * Result
     * 
     * @var string
     */
    protected static $result;

    /**
     * Content
     * 
     * @var string
     */
    protected static $content;

    /**
     * Role ID
     * 
     * @var mixed
     */
    protected static $roleId;

    /**
     * Role ID
     * 
     * @param mixed $roleId
     * 
     * @return void
     */
    public static function roleId($roleId)
    {
        self::$roleId = $roleId;
    }

    /**
     * Permission Common
     * 
     * @param mixed $roleId  = 6
     * @param mixed $process
     * @param mixed $object
     * @param mixed $function
     * 
     * @return mixed
     */
    protected static function common($roleId = 6, $process, $object, $function)
    {
        self::$permission = self::getConfigByType($function);

        if( isset(self::$permission[$roleId]) )
        {
            $rules = self::$permission[$roleId];
        }
        else
        {
            return false;
        }

        if( $function === 'method' )
        {
            $currentUrl = NULL;
        }
        else
        {
            $currentUrl = $process ?? Base::currentPath();
        }

        $object = $object ?? true;
    
        switch( $rules ?? NULL )
        {
            case 'all': return $object;
            case 'any': return false;
        }  
        
        $pages = current($rules); $type = key($rules);

        foreach( $pages as $page )
        {
            $page = trim($page);

            $rule = strpos($page[0], '!') === 0 ? substr($page, 1) : $page;
    
            if( $type === 'perm' )
            {
                if( self::control($currentUrl, $rule, $process, $function) )
                {
                    return $object;
                }
                else
                {
                    self::$result = false;
                }
            }
            else
            {

                if( self::control($currentUrl, $rule, $process, $function) )
                {
                   return false;
                }
                else
                {
                    self::$result = $object;
                }
            }
        }

        return self::$result;   
    }

    /**
     * Control Permission
     * 
     * @param string $currentUrl
     * @param string $page
     * @param string $process
     * @param string $function
     * 
     * @return string
     */
    protected static function control($currentUrl, $page, $process, $function)
    {
        if( $function === 'method' )
        {
            return Method::$process($page);
        }

        return strpos($currentUrl, $page) > -1;
    }

    /**
     * Protected get config by type
     */
    protected static function getConfigByType($type)
    {
        return Config::default('ZN\Authorization\AuthorizationDefaultConfiguration')::get('Authorization', $type);
    }
}
