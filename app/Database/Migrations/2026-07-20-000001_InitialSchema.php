<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitialSchema extends Migration
{
    public function up()
    {
        // Admins table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('admins', true);

        // Blog posts table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'images' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('blog_posts', true);

        // Properties table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'images' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'size' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'price' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'rooms' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'masterBedrooms' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'bedrooms' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'bathrooms' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'facebookPost' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('properties', true);
    }

    public function down()
    {
        $this->forge->dropTable('properties');
        $this->forge->dropTable('blog_posts');
        $this->forge->dropTable('admins');
    }
}
