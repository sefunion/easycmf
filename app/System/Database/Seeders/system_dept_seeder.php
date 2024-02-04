<?php


declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SystemDeptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run()
    {
        Db::table('system_dept')->truncate();
        Db::table('system_dept')->insert(
            [
                'parent_id' => 0,
                'level' => '0',
                'name' => 'IT部',
                'leader' => '乔布斯',
                'phone' => '18899996666',
                'created_by' => env('SUPER_ADMIN', 1),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
    }
}
