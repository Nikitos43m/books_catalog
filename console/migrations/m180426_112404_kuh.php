<?php

use yii\db\Migration;

/**
 * Class m180426_112404_kuh
 */
class m180426_112404_kuh extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function up()
    {
        $this->addColumn('apartament', 'kitchen', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
   public function down()
    {
        $this->dropColumn('apartament', 'kitchen');
    }

}
