<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            'companyname' => 'Kettlitz Gevel- en Dakadvies b.v.',
            'address' => 'Computerweg',
            'housenumber' => '11',
            'postalcode' => '3542 DP',
            'city' => 'Utrecht',
            'phone' => '030 303 26 50',
            'email' => 'info@gevelsendaken.nl',
            'kvk' => '27308128',
            'btw' => 'NL818707264.B01',
            'websitename' => 'Kettlitz Gevel- en Dakadvies',
            'description' => 'Expert op het gebied van gevels en daken',
            'linkedinlink' => 'https://www.linkedin.com/company/gevelsendaken/?originalSubdomain=nl',
            'instagramlink' => '',
            'facebooklink' => '',
            'googlemapslink' => 'https://www.google.com/maps/place/Kettlitz+%7C+ESG+Gevel-+en+Dakadvies+B.V./@52.1277561,5.0420847,17z/data=!3m1!4b1!4m6!3m5!1s0x47c66fd48cdef2f9:0xeeb8d27779b56e77!8m2!3d52.1277528!4d5.0446596!16s%2Fg%2F11g1dsxtnl',
            'attachment' => 'settings-files/Kettlitz_beeldmerk_fc.png',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
