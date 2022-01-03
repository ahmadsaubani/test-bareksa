<?php

namespace Database\Seeds;

use App\Models\Item;
use App\Models\Webinar\Webinar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ItemsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [1, 'Design', 230],
            [1, 'Development', 330],
            [1, 'Meetings', 60],
        ];

        foreach ($items as $item) {
            Item::create([
                "type_id"     => $item[0],
                "description" => $item[1],
                "price"       => $item[2]
            ]);
        }
    }
}
