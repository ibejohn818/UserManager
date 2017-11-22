<?php

namespace UserManager\Shell\Task;

use Cake\Console\Shell;

class ConfigWizardTask extends Shell
{


    public function wizard(array $schema, array $settings, $saveTo)
    {

        $this->hr();
        $this->hr();


        $choices = [];
        $key = 1;
        foreach($schema as $k=>$v) {

            $this->out("{$key}) {$k}");

            $choices[$key] = $k;

            $key++;

        }

        $choice = $this->in("Choose a category:", array_keys($choices));

        $settingsKey = $choices[$choice];


        foreach($schema[$settingsKey]['settings'] as $k=>$v) {

            $this->hr();
            $this->out("{$settingsKey} >> {$v['key']}");
            $this->hr();
            $this->out("<success>Help:</success> <info>{$v['help']}</info>");
            $this->out("<success>Setting: </success>{$v['key']}");
            $this->out("<success>Current Value:</success> {$settings[$settingsKey][$v['key']]}");
            $this->out("<success>Default Value:</success> {$v['default']}");
            $this->hr();

            $updateChoices = [
                1=>'Keep Current Value',
                2=>'Use Default Value',
                3=>'Enter New Value'
            ];

            foreach($updateChoices as $kk=>$vv) {
                $this->out("{$kk}) {$vv}");
            }

            $this->hr();
            $updateAns = $this->in("Select Action: ", array_keys($updateChoices));

            switch($updateAns) {
                case 1:
                    $this->out("Keeping Current Value: {$settings[$settingsKey][$v['key']]}");
                break;
                case 2:
                    $this->out("Using Default Value: {$v['default']}");
                    $settings[$settingsKey][$v['key']] = $v['default'];
                break;
                case 3:
                    $newValue = $this->in("Enter new value: ");
                    $settings[$settingsKey][$v['key']] = $newValue;
                break;

            }

            $this->out("", 3);

        }

        return $settings;
    }


}
