<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name'     => '后盾网',
                'link_title'    => '最好的php培训网站',
                'link_url'      => 'http://www.houdunwang.com/',
                'link_order'    => 1
            ],
            [
                'link_name'     => '后盾bbs',
                'link_title'    => '后盾网，人人做php',
                'link_url'      => 'http://bbs.houdunwang.com/portal.php',
                'link_order'    => 2
            ]
        ];
        DB::table('links')->insert($data);
    }
}
