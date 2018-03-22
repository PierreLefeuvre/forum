<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\LangHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\LangHelper Test Case
 */
class LangHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\LangHelper
     */
    public $Lang;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->Lang = new LangHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Lang);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
