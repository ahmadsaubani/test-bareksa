<?php

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
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            $this->call(TopicSeeder::class);
            $this->call(TagSeeder::class);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
