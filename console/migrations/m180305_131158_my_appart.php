<?php

use yii\db\Migration;

class m180305_131158_my_appart extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'my_appart', $this->char());
    }

    public function down()
    {
        $this->dropColumn('user', 'my_appart');
    }

}
