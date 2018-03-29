<?php

use yii\db\Migration;

/**
 * Class m180329_100711_term
 */
class m180329_100711_term extends Migration
{

    public function up()
    {
        $this->addColumn('apartament', 'term', $this->integer());
    }


  public function down()
    { 
       $this->dropColumn('apartament', 'term');  
    }


}
