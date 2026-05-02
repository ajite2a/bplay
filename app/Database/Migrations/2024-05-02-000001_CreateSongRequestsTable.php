<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSongRequestsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'song_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'singer_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null'       => true,
            ],
            'screenshot' => [
                'type'       => 'VARCHAR',
                'constraint' => '300',
                'null'       => true,
            ],
            'razorpay_order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'razorpay_payment_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'approved', 'played', 'rejected'],
                'default'    => 'pending',
            ],
            'payment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'completed', 'failed'],
                'default'    => 'pending',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'default' => null,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'default' => null,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('song_requests');
    }

    public function down()
    {
        $this->forge->dropTable('song_requests');
    }
}
