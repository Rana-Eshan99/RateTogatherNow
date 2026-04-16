<?php

namespace Database\Seeders;

use App\Enums\ConfigurationEnum;
use App\Enums\ServerEnum;
use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (env('APP_ENV') == ServerEnum::Staging) {
            $server = ServerEnum::Staging;
            $defaultValueArray = [
                false, // IS_TWILLIO_ENABLED
            ];
        } else if (env('APP_ENV') == ServerEnum::Local) {
            $server = ServerEnum::Local;
            $defaultValueArray = [
                false, // IS_TWILLIO_ENABLED
            ];
        } else if (env('APP_ENV') == ServerEnum::Acceptance) {
            $server = ServerEnum::Acceptance;
            $defaultValueArray = [
                false, // IS_TWILLIO_ENABLED
            ];
        } else if (env('APP_ENV') == ServerEnum::Production) {
            $server = ServerEnum::Production;
            $defaultValueArray = [
                false, // IS_TWILLIO_ENABLED
            ];
        }

        $defaultCommentArray = [
            "If it's Enabled then OTP Message will send to Number and if Disabled then OTP Message will not send to Number.", // POST_PRODUCT_NOTIFICATION_DIALOG
        ];

        if (empty(Configuration::where('name', '=', 'IS_TWILLIO_ENABLED')->first())) {
            Configuration::create([
                'configName' => 'Enable Or Disable Twillio',
                'name' => 'IS_TWILLIO_ENABLED',
                'value' => $defaultValueArray[0],
                'type' => ConfigurationEnum::ConfigBoolean,
                'serverType' => $server,
                'comment' => $defaultCommentArray[0],
            ]);
        }
    }
}
