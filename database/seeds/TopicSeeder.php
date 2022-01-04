<?php

namespace Database\Seeds;

use App\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TopicSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ["Investasi"],
            ["Pasar Modal"],
            ["Reksa Dana"]
        ];

        foreach ($items as $item) {
            Topic::create([
                "title"     => $item[0],
                "slug"      => Str::slug($item[0])
            ]);
        }
    }
}
