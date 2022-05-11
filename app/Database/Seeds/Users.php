<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $users = [
            [
                'email' => 'direktorius@direktorius.lt',
                'password' => md5('dir123'),
                'firstname' => 'Petras',
                'lastname' => 'Petraitis',
                'type' => 'director',
            ],
            [
                'email' => 'mokytojas@mokytojas.lt',
                'password' => md5('mok123'),
                'firstname' => 'Antanas',
                'lastname' => 'Antanaitis',
                'type' => 'teacher',
            ],
            [
                'email' => 'mokinys@mokinys.lt',
                'password' => md5('moki123'),
                'firstname' => 'Ona',
                'lastname' => 'Onute',
                'type' => 'student',
            ],
        ];

        $this->db->table('users')->truncate();
        $this->db->table('users')->insertBatch($users);
    }
}
