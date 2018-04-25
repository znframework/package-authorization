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

use ZN\Config;
use ZN\Singleton;
use ZN\Protection\Json;

class RoleRules extends PermissionExtends
{
    /**
     * Set permission rules
     * 
     * @param array      $config
     * @param int|string $ruleId = NULL
     * 
     * @return array|string
     */
    public static function setPermRules(Array $config, $roleId = NULL, $ptype = 'perm')
    {
        $roleId   = $roleId ?? self::$roleId;
        $configs  = array_keys(self::getConfigByType(NULL));
        $newRules = [];

        foreach( $configs as $con )
        {
            if( $subconfig = ($config[$con] ?? NULL) )
            {
                if( is_string($subconfig) )
                {
                    self::getJsonDataToDatabaseAfterConvertArray($subconfig, $roleId);
                }

                $newRules[$con] = [$roleId => [$ptype => $subconfig]];
            } 
        }

        Config::set('Authorization', $newRules);
    }

    /**
     * Set no permission rules
     * 
     * @param array      $config
     * @param int|string $ruleId = NULL
     * 
     * @return array|string
     */
    public static function setNopermRules(Array $config, $roleId = NULL)
    {
        self::setPermRules($config, $roleId, 'noperm');
    }

    /**
     * Get permission rules
     * 
     * @param string     $type   = 'page'
     * @param int|string $ruleId = NULL
     * 
     * @return array|string
     */
    public static function getPermRules(String $type = 'page', $roleId = NULL)
    {
        return self::getNopermRules($type, $roleId, 'perm');
    }

    /**
     * Get no permission rules
     * 
     * @param string     $type   = 'page'
     * @param int|string $ruleId = NULL
     * 
     * @return array|string
     */
    public static function getNopermRules(String $type = 'page', $roleId = NULL, $ptype = 'noperm')
    {
        $rules = self::getConfigByType($type);

        $roleId = $roleId ?? self::$roleId;

        if( is_array($return = ($rules[$roleId] ?? NULL)) )
        {
            return $return[$ptype];
        }

        return $return;
    }

    /**
     * Protected get json data to databse after convert array
     */
    protected static function getJsonDataToDatabaseAfterConvertArray(&$subconfig, $roleId)
    {
        if( preg_match('/(\w+)\[(\w+)\]\:(\w+)/', $subconfig, $match) )
        {
            $json = Singleton::class('ZN\Database\DB')
                             ->where($match[2], $roleId)
                             ->select($match[3])
                             ->get($match[1])
                             ->value();
           
            if( Json::check($json) )
            {
                $subconfig = json_decode($json);
            }
        }
    }
}
