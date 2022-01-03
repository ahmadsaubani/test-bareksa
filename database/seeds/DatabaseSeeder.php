<?php

use Database\Seeds\ItemsSeeder;
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
            $this->call(ItemsSeeder::class);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
    }
}
