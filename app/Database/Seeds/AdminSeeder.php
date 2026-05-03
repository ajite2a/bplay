<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'            => 'Admin User',
                'email'           => 'admin@admin.com',
                'password'        => password_hash('admin123', PASSWORD_BCRYPT),
                'role'            => 'admin',
                'status'          => 'active',
                'profile_picture' => null,
                'phone'           => '1234567890',
                'address'         => 'Gym Address',
                'gender'          => 'male',
                'joined_at'       => date('Y-m-d H:i:s'),
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
