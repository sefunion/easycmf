<?php


declare(strict_types=1);

use App\Setting\Model\SettingConfigGroup;
use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class SettingConfigGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Db::table('setting_config_group')->truncate();
        $tableName = env('DB_PREFIX') . SettingConfigGroup::getModel()->getTable();

        if (env('DB_DRIVER') == 'pgsql') {
            Db::select("SELECT setval('{$tableName}_id_seq', 2)");
            $sql = [
                "INSERT INTO \"{$tableName}\"(\"id\", \"name\", \"code\", \"created_by\", \"updated_by\", \"created_at\", \"updated_at\", \"remark\") VALUES (1, '站点配置', 'site_config', 1, 1, '2022-07-23 15:08:44', '2022-07-23 15:08:44', NULL)",
                "INSERT INTO \"{$tableName}\"(\"id\", \"name\", \"code\", \"created_by\", \"updated_by\", \"created_at\", \"updated_at\", \"remark\") VALUES (2, '上传配置', 'upload_config', 1, 1, '2022-07-23 15:09:31', '2022-07-23 15:09:33', NULL)",
            ];
        } else {
            $sql = [
                "INSERT INTO `{$tableName}`(`id`, `name`, `code`, `created_by`, `updated_by`, `created_at`, `updated_at`, `remark`) VALUES (1, '站点配置', 'site_config', 1, 1, '2022-07-23 15:08:44', '2022-07-23 15:08:44', NULL)",
                "INSERT INTO `{$tableName}`(`id`, `name`, `code`, `created_by`, `updated_by`, `created_at`, `updated_at`, `remark`) VALUES (2, '上传配置', 'upload_config', 1, 1, '2022-07-23 15:09:31', '2022-07-23 15:09:33', NULL)",
            ];
        }
        foreach ($sql as $item) {
            Db::insert($item);
        }
    }
}
