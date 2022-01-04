<?php

namespace Database\Seeds;

use App\Models\News;
use App\Models\Tag;
use App\Models\Topic;
use App\Repositories\NewsRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $items = [
            [
                "title"         => "2022 Siap Pensiun Muda Dengan Rp5 Miliar? Ini Caranya",
                "description"   => "Kamu yang masih muda pasti masih ingin hura-hura tanpa harus memikirkan masa tua. Tapi bagaimana kalau kamu bisa pensiun muda dan hidup sejahtera?.",
            ],
            [
                "title"         => "Generasi Sandwich, Kamu Membiayai Biaya Hidup atau Gaya Hidup?",
                "description"   => "Apa strategi atau tips buat generasi sandwich agar bisa memutus mata rantai generasi sandwich berikutnya? Mulailah investasi! Sebab hanya dengan investasilah, kita punya peluang untuk memutus mata rantai generasi sandwich berikutnya. ",
            ]
        ];
        $newsRepo = new NewsRepository();

        foreach ($items as $item) {

            $tag    = Tag::find(1);
            $tag2   = Tag::find(2);
            $item["tag_id"] = $tag->uuid . "," . $tag2->uuid;
            $topic = Topic::find(1);
            $item["topic_id"] = $topic->uuid;

            $newsRepo->createNews($item);
        }
    }
}
