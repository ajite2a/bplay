<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePaymentsTable extends Migration
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
            'song_request_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'payment_gateway' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'comment'    => 'razorpay, stripe, paypal',
            ],
            'payment_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'comment'    => 'Gateway transaction ID',
            ],
            'order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'comment'    => 'Gateway order/reference ID',
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'currency' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'default'    => 'INR',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['created', 'success', 'failed'],
                'default'    => 'created',
            ],
            'payment_response' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Full gateway response (JSON)',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Primary Key
        $this->forge->addKey('id', true);
        $this->forge->addKey('song_request_id');
        // Foreign Key
        $this->forge->addForeignKey(
            'song_request_id',
            'song_requests',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('payments');
    }

    public function down()
    {
        $this->forge->dropTable('payments');
    }
}
