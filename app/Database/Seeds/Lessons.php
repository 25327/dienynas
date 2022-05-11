<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Lessons extends Seeder
{
    public function run()
    {
        $lessons = [
            [
                'title' => 'Lietuviu kalba',
            ],
            [
                'title' => 'Matematika',
            ],
            [
                'title' => 'Istorija',
            ],
            [
                'title' => 'Fizika',
            ],
            [
                'title' => 'Chemija',
            ],
            [
                'title' => 'Biologija',
            ],
        ];

        $this->db->table('lessons')->truncate();
        $this->db->table('lessons')->insertBatch($lessons);
    }
}
