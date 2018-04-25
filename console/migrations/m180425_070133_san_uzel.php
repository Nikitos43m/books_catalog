<?php

use yii\db\Migration;

/**
 * Class m180425_070133_san_uzel
 */
class m180425_070133_san_uzel extends Migration
{

   public function up()
    {
        $this->addColumn('apartament', 'san_uzel', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('apartament', 'san_uzel');
    }

}
