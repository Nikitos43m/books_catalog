<?php

use yii\db\Migration;

class m180203_090747_new_columns extends Migration
{
    public function up()
    {
        $this->dropColumn('apartament', 'apartament');
    }

    public function down()
    {
        $this->addColumn('apartament', 'apartament', $this->integer());
    }

}
