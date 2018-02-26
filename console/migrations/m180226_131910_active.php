<?php

use yii\db\Migration;


class m180226_131910_active extends Migration
{

    public function up()
    {
        $this->addColumn('apartament', 'active', $this->boolean());
        $this->addColumn('apartament', 'description', $this->char(255));
    }

    public function down()
    {
        $this->dropColumn('apartament', 'active');
        $this->dropColumn('apartament', 'description');
    }

}
