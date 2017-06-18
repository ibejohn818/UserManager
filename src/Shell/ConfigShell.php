<?php

namespace UserManager\Shell;

use Cake\Console\Shell;
use Cake\Utility\Hash;


class ConfigShell extends Shell {

	private $_config = false;

	private $_template = false;

	public function main() {

		$this->loadTemplate();

		$this->loadConfig();

		$this->outputSettingsTemplate();



	}

	public function outputSettingsTemplate() {

		$this->out("Choose a settings groups to modify how the User Manager plugin functions");
		$this->hr();

		$template = $this->loadTemplate();

		$index = 1;
		foreach($template as $groupName => $block) {

			$this->out("<info>{$index}) {$groupName}</info> ");
			$this->out("<info>Description:</info> {$block['help']}");
			$this->hr();
			$choices[] = $index;
			$index++;
		}

		$choices[] = "Q";

		$choice = $this->in("Select a setting group",implode("/",$choices));

		$choice = strtolower($choice);

		if($choice == "q") {
			exit(0);
		}

		$index = 1;
		foreach($template as $k=>$v) {
			if($choice == $index) {
				$this->outputSettingsBlock($k);
				break;
			}

			$index++;
		}

		return $this->outputSettingsTemplate();
	}

	protected function getConfig($setting) {

		if(!$this->_config) {
			$this->loadConfig();
		}
		return $this->_config[$setting];

	}

	public function setConfig($setting,$value) {
		$this->_config[$setting] = $value;
	}

	public function outputSettingsBlock($name) {

		$template = $this->loadTemplate();

		$block = $template[$name];

		$this->out($block['help']);
		$this->hr();

		foreach($block['settings'] as $k=>$v) {

			$currentValue = $this->getConfig($k); 

			$this->out("<info>Setting:</info> {$k}");
			$this->out("<info>Description:</info> {$v['help']}");
			$this->out("<info>Default:</info> {$v['default']}");
			$this->out("<info>Current:</info> {$currentValue}");
			$this->hr();
			$this->out("1 ) Keep Current Value");
			$this->out("2 ) Use Default");
			$this->out("3 ) New Value");
			$this->hr();
			$opt = $this->in("Select an Option",[1,2,3]);

			switch($opt) {
				case 1:
					$value = $currentValue;
					break;
				case 2:
					$value = $v['default'];
					break;
				case 3:
					$value = $this->in("Declare new value");
				break;
			}

			switch(strtolower($k)) {

				case 'profileimagewwwpath':
					$value = rtrim(trim($value,"/"),"/");
					break;

			}

			$this->setConfig($k,$value);

		}


		$this->saveConfig();
	}

	private function saveConfig() {

		if(!$this->_config) {
			return;
		}

		$path = CONFIG.'user-manager.conf.php';

		file_put_contents($path,"<?php return ".var_export($this->_config,true).";");

		$this->_config = false;

		return $this->loadConfig();

	}

	protected function loadTemplate()
	{

		if(!$this->_template) {
			$this->_template = require (realpath(__DIR__)."/../../config/config.template.php");
		}

		return $this->_template;

	}

	private function loadConfig()
	{
		$path = CONFIG.'user-manager.conf.php';

		if(!file_exists($path)) {
			$this->writeDefaults();
			return $this->loadConfig();
		}

		if(!$this->_config) {
			$this->_config = require $path;
		}

		$this->loadTemplate();

		$defs = [];

		foreach($this->_template as $set) {
			foreach($set['settings'] as $k=>$v) {
				$defs[$k] = $v['default'];
			}
		}

		foreach($defs as $key=>$def) {
			if(!array_key_exists($key,$this->_config)) {
				$this->_config[$key] = $def;
			}
		}

		return $this->_config;

	}

	private function writeDefaults() {

		$template = $this->loadTemplate();

		$settings = [];

		foreach($template as $block) {
			foreach($block['settings'] as $key=>$setting) {
				$settings[$key] = $setting['default'];
			}
		}

		file_put_contents(CONFIG."user-manager.conf.php","<?php return ".var_export($settings,true).";");

	}

}
