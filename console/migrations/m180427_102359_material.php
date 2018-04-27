<?php

use yii\db\Migration;

/**
 * Class m180427_102359_material
 */
class m180427_102359_material extends Migration
{
    /**
     * {@inheritdoc}
     */
   public function up()
    {
        $this->addColumn('apartament', 'material', $this->integer());
        $this->addColumn('apartament', 'balkon', $this->integer());
        $this->addColumn('apartament', 'ipoteka', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
   public function down()
    {
        $this->dropColumn('apartament', 'material');
        $this->dropColumn('apartament', 'balkon');
        $this->dropColumn('apartament', 'ipoteka');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180427_102359_material cannot be reverted.\n";

        return false;
    }
    */
}
