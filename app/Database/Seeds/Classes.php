<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Classes extends Seeder
{
    public function run()
    {
        $classes = [
            [
                'title' => '7A',
                'max_week_lessons' => 25,
            ],
            [
                'title' => '5C',
                'max_week_lessons' => 20,
            ],
            [
                'title' => '5B',
                'max_week_lessons' => 20,
            ],
            [
                'title' => '8A',
                'max_week_lessons' => 31,
            ],
        ];

        $this->db->table('classes')->truncate();
        $this->db->table('classes')->insertBatch($classes);
    }
}
