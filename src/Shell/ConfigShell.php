<?php

namespace UserManager\Shell;

use Cake\Console\Shell;
use Cake\Utility\Hash;


class ConfigShell extends Shell {

	private $_config = false;

	private $_template = false;

    public $tasks = [
        'UserManager.ConfigWizard'
    ];


    public function initialize()
    {
        $conf = new \UserManager\Lib\Conf();

        $this->settings = $conf->files;

        parent::initialize();
    }

    public function main()
    {
        $this->hr();
        $this->out("Select settings group");
        $this->hr();

        $conf = new \UserManager\Lib\Conf();

        foreach($conf->files as $k=>$v)
        {

            $this->out("{$k}) {$v['name']}");

        }

        $this->out("Q) Quit");

        $ans = $this->in("Select a group:", array_merge(array_keys($conf->files),['Q']));

        if(strtolower($ans) == 'q') {
            $this->out("Exiting...");
            return;
        }

        $schema = include \Cake\Core\Plugin::configPath("UserManager")."/{$conf->files[$ans]['schema']}";
        $settings = include CONFIG."{$conf->files[$ans]['settings']}";

        $settings = $this->ConfigWizard->wizard($schema, $settings, "testing");

        $this->out("Saving settings....");
        $this->out("", 2);

        // patch defaults that are not present
        $settings = $conf->settingsFillDefaults($settings, $conf->loadDefaults($schema));

        // save file
        $conf->writeSettings($settings, CONFIG.$conf->files[$ans]['settings']);

        return $this->main();

    }

    public function patchSettings()
    {


    }

}
