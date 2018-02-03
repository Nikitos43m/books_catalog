<?php

use yii\db\Migration;

class m180203_094937_foreign_key extends Migration
{
    public function up()
    {
        $this->addColumn('apartament', 'user_id', $this->integer());
        $this->addForeignKey('user_apart_foreign_key', 'apartament', 'user_id', 'user', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('user_apart_foreign_key', 'apartament');
        $this->dropColumn('apartament', 'user_id');
    }


}
