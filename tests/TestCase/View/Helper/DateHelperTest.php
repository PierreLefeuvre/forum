<?php
namespace App\Test\TestCase\View\Helper;

use App\View\Helper\dateHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\dateHelper Test Case
 */
class dateHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\View\Helper\dateHelper
     */
    public $date;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->date = new dateHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->date);

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

    public function testFormatDate()
    {
        $date = '2018-02-20 18:12:35';
        $result = $this->date->formatDate($date);

        $this->assertEquals('20/02/2018', $result);
    }
}
