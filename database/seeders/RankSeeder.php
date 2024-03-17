<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rank::truncate();

        $csvFile = fopen(base_path("database/data/ranks.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            if (!$firstline) {
                Rank::create([
                    "code" => $data['0'],
                    "name" => $data['1'],
                    "alias" => $data['2']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
