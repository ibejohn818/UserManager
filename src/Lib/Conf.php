<?php

namespace UserManager\Lib;

use Cake\Core\Configure;
use Cake\Core\InstanceConfigTrait;

class Conf
{

    use InstanceConfigTrait;

    const PROVIDERS = "config.um.login-providers.php";
    const PROVIDERS_SCHEMA = "config.login-providers.schema.php";

    protected $_defaultConfig = [
        'configSavePath'=>CONFIG
    ];

    public $files = [
        1=>[
            'name'=>'General Settings',
            'schema'=>'config.gen.schema.php',
            'settings'=>'config.gen.php',
            'key'=>'General'
        ],
        2=>[
            'name'=>'Login Providers',
            'schema'=>self::PROVIDERS_SCHEMA,
            'settings'=>self::PROVIDERS,
            'key'=>'LoginProviders'
        ]
    ];

    public function __construct(array $config = []) {
        $this->setConfig($config);
    }

    public function bootstrap()
    {
        $path = \Cake\Core\Plugin::configPath("UserManager");
        foreach($this->files as $k=>$v) {
            $settings = @include trim($this->getConfig("configSavePath"))."/{$v['settings']}";
            if(!is_array($settings)) {
                $schema = include "{$path}/{$v['schema']}";
                $settings = $this->loadDefaults($schema);
                $this->writeSettings($settings, $v['settings']);
            }
            Configure::write("UserManager.{$v['key']}", $settings);
        }

    }

    public function loadDefaults($data)
    {

        $defs = [];

        foreach($data as $k=>$v) {

            if(count($v['settings'])<=0) {
                continue;
            }

            foreach($v['settings'] as $kk=>$vv) {
                $defs[$k][$vv['key']] = $vv['default'];
            }
        }

        return $defs;

    }


    /**
     * Writing missing settings based on defaults to account
     * for updates to settings schema
     */
    public function settingsFillDefaults(array $settings, array $defs)
    {

        foreach($defs as $k=>$v) {

            if(count($v)<=0) {
                continue;
            }

            foreach($v as $kk=>$vv) {
                if(!isset($settings[$k][$kk])) {
                    $settings[$k][$kk] = $vv;
                }
            }
        }

        return $settings;

    }

    public function writeSettings(array $settings, $saveToFilename)
    {

        if(@file_put_contents(trim($this->getConfig("configSavePath"))."/".$saveToFilename, "<?php return ".var_export($settings, true).";")) {
            return true;
        }

        return false;
    }


}
