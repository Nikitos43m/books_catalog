<?php

use yii\db\Migration;

/**
 * Class m180330_054445_floors
 */
class m180330_054445_floors extends Migration
{
 
    public function up()
    {
        $this->addColumn('apartament', 'floor_all', $this->integer());
        $this->addColumn('apartament', 'year', $this->integer());
    }
 
    public function down()
    { 
       $this->dropColumn('apartament', 'floor_all');
       $this->dropColumn('apartament', 'year');
    }

}
