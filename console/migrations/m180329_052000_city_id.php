<?php

use yii\db\Migration;


class m180329_052000_city_id extends Migration
{

    public function up()
    {
        $this->addColumn('apartament', 'city_id', $this->integer());
    }

   public function down()
    { 
       $this->dropColumn('apartament', 'city_id');  
    }

}
