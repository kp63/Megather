<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
                                       'user_id' => 1,
                                       'game' => 'siege',
                                       'content' => 'どうも、こんにちは。この投稿はdemoユーザーから投稿されました。' . "\n" . '改行のテストです。'
                                   ]);
        DB::table('posts')->insert([
                                       'user_id' => 1,
                                       'game' => 'siege',
                                       'content' => 'Hello, World!' . "\n" . '1\' or \'1\' = \'1\';--' . "\n" . '<script>alert(\'Script!!!\');</script>',
                                       'created_at' => date('Y-m-d H:i:s', strtotime('-3 hour'))
                                   ]);
        DB::table('posts')->insert([
                                       'user_id' => 2,
                                       'game' => 'apex',
                                       'content' => 'どうも、こんにちは。この投稿はadminユーザーから投稿されました。',
                                       'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
                                   ]);
        DB::table('posts')->insert([
                                       'user_id' => 2,
                                       'game' => 'valorant',
                                       'content' => '5ヶ月前の投稿です。今日が5月以降なら日付から年の表示が消えているはずです。',
                                       'created_at' => date('Y-m-d H:i:s', strtotime('-5 month'))
                                   ]);
        DB::table('posts')->insert([
                                       'user_id' => 2,
                                       'game' => 'valorant',
                                       'content' => '1年前の投稿です。hey yo!',
                                       'created_at' => date('Y-m-d H:i:s', strtotime('-1 year'))
                                   ]);
    }
}
