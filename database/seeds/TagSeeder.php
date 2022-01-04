<?php

namespace Database\Seeds;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ["Belajar Investasi"],
            ["Bareksa Navigator"],
            ["Berita Hangat"]
        ];

        foreach ($items as $item) {
            Tag::create([
                "title"     => $item[0],
                "slug"      => Str::slug($item[0])
            ]);
        }
    }
}
