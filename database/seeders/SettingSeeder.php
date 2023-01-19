<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'appName'       => 'JDIH CMS',
            'appDesc'       => 'Jaringan Dokumentasi dan Informasi Hukum',
            'appLogo'       => null,
            'appUrl'        => url()->current(),
            'company'       => 'Balemedia',
            'companyUrl'    => 'https://balemedia.id',
            'address'       => fake()->streetAddress(),
            'city'          => fake()->city(),
            'district'      => fake()->city(),
            'regency'       => fake()->city(),
            'province'      => 'Bali',
            'zip'           => fake()->postcode(),
            'phone'         => fake()->phoneNumber(),
            'fax'           => null,
            'email'         => fake()->safeEmail(),
            'facebook'      => null,
            'twitter'       => null,
            'instagram'     => null,
            'tiktok'        => null,
            'youtube'       => null,
            'jdihnLogo'     => null,
            'jdihnTitle'    => 'Jaringan Dokumentasi dan Informasi Hukum Nasional',
            'jdihnUrl'      => 'https://jdihn.go.id',
            'region_code'   => 0051,
            'maintenance'   => null,
        ];

        foreach ($settings as $key => $value) {
            Setting::create([
                'key'   => $key,
                'value' => $value
            ]);
        }
    }
}
