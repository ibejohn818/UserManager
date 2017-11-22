<?php

namespace UserManager\Lib;

class Conf
{


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

        print_r($defs);

    }

    /**
     * Writing missing settings based on defaults to account
     * for updates to settings schema
     */
    public function settingsFillDefaults(array $settings, array $defs)
    {


        foreach($defs as $k=>$v) {

            if(count($v['settings'])<=0) {
                continue;
            }

            foreach($v['settings'] as $kk=>$vv) {

                if(!isset($settings[$k][$vv['key']])) {

                    $settings[$k][$vv['key']] = $vv['default'];

                }

            }

        }

        return $settings;

    }

}
