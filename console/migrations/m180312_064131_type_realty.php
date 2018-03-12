<?php

use yii\db\Migration;

class m180312_064131_type_realty extends Migration
{
    public function up()
    {
        $this->addColumn('apartament', 'realty_type', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('apartament', 'realty_type');
    }

}
