<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RiversTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RiversTable Test Case
 */
class RiversTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RiversTable
     */
    protected $Rivers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Rivers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Rivers') ? [] : ['className' => RiversTable::class];
        $this->Rivers = $this->getTableLocator()->get('Rivers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Rivers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
