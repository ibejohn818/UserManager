<?php

namespace UserManager\Test\TestCase\Lib;

use Cake\TestSuite\TestCase;
use UserManager\Lib\Conf;
use org\bovigo\vfs\vfsStream;

class ConfTest extends TestCase
{


    private $root;

    public function setUp()
    {

        $this->root = vfsStream::setup();

        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testSettingsFillDefaults()
    {

        $defs = [
            'defaults'=>[
                'one'=>'one',
                'two'=>'two'
            ],
            'empty'=>[]
        ];

        $settings = [
            'defaults'=>[
                'one'=>'one-og'
            ]
        ];

        $conf = new Conf();

        $res = $conf->settingsFillDefaults($settings, $defs);

        $this->assertEquals($res['defaults']['two'], "two");
        $this->assertEquals($res['defaults']['one'], $settings['defaults']['one']);

    }

    public function testLoadDefaults()
    {

        $path = \Cake\Core\Plugin::configPath("UserManager");

        $data = include $path."/config.login-providers.schema.php";

        $data['None'] = [
            'settings'=>[]
        ];

        $conf = new Conf();

        $defs = $conf->loadDefaults($data);

        $this->assertEquals($defs['Google']['enabled'], 0);
        $this->assertEquals($defs['Github']['enabled'], 0);
        $this->assertEquals($defs['Bitbucket']['enabled'], 0);
        $this->assertEquals($defs['Facebook']['enabled'], 0);
        $this->assertFalse(isset($defs['None']));

    }

    public function testWriteSettings()
    {

        $conf = new Conf([
            'configSavePath'=>$this->root->url()
        ]);

        $data = [
            'test'=>'test'
        ];

        $filename = "test.conf.php";

        $res = $conf->writeSettings($data,$filename);

        $this->assertTrue($res);

        # test fail
        vfsStream::newFile($filename, 0000)
                 ->withContent('notoverwritten')
                 ->at($this->root);

        $res = $conf->writeSettings($data,$filename);

        $this->assertFalse($res);

    }

    public function testBootstrap()
    {

        $conf = new Conf([
            'configSavePath'=>$this->root->url()
        ]);

        $conf->bootstrap();

        foreach($conf->files as $f) {
            $this->assertTrue(is_array(@include trim($conf->getConfig("configSavePath"))."/".$f['settings']));
        }

    }



}
