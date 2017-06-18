<?php
namespace UserManager\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

/**
 * User shell command.
 */
class UserShell extends Shell
{

	public function password()
	{

		print_r($this->params);
	}

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

		$UserAccounts = TableRegistry::get("UserAccounts");

		$parser->addSubcommand('password',[
			'arguments'=>[
				[
					'help'=>'User ID or Email Address',
					'required'=>true
				]
			],
			'options'=>[
			]
		]);

        return $parser;
    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $this->out($this->OptionParser->help());
    }
}
