<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddApiTokenToAdmins extends Migration
{
    public function up()
    {
        $fields = $this->db->getFieldNames('admins');

        if (! in_array('api_token', $fields, true)) {
            $this->forge->addColumn('admins', [
                'api_token' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('admins', 'api_token');
    }
}
