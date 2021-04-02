<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Rivers seed.
 */
class RiversSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name'=>'信濃川',
            'source'=>'長野',
            'mouse'=>'新潟',
        ];

        $table = $this->table('rivers');
        $table->insert($data)->save();
    }
}
