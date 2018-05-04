<?php

use yii\db\Migration;

/**
 * Class m180504_101608_type_account
 */
class m180504_101608_type_account extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('user', 'who', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
   public function down()
    {
        $this->dropColumn('user', 'who');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180504_101608_type_account cannot be reverted.\n";

        return false;
    }
    */
}
