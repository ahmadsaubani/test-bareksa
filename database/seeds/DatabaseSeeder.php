<?php

use Database\Seeds\NewsSeeder;
use Database\Seeds\TagSeeder;
use Database\Seeds\TopicSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws Throwable
     */
    public function run()
    {
            $this->call(TopicSeeder::class);
            $this->call(TagSeeder::class);
            $this->call(NewsSeeder::class);
    }
}
