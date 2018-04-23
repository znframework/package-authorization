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

class Page extends PermissionExtends
{
    /**
     * Page
     * 
     * @param mixed $roleId = 6
     * 
     * @return mixed
     */
    public static function use($roleId = 6)
    {
        return self::common(PermissionExtends::$roleId ?? $roleId, NULL, NULL, 'page');
    }

    /**
     * Page permission rules
     * 
     * @param string|int $roleId = NULL
     * 
     * @return string|array
     */
    public static function getPermRules($roleId = NULL)
    {
        return self::permRules($roleId, 'page');
    }

    /**
     * Page no permission rules
     * 
     * @param string|int $roleId = NULL
     * 
     * @return string|array
     */
    public static function getNopermRules($roleId = NULL)
    {
        return self::noPermRules($roleId, 'page');
    }
}
