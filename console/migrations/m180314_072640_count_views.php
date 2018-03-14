<?php

use yii\db\Migration;

/**
 * Class m180314_072640_count_views
 */
class m180314_072640_count_views extends Migration
{

    public function up()
    {
        $this->addColumn('apartament', 'count_views', $this->integer());
    }

    public function down()
    { 
       $this->dropColumn('apartament', 'count_views');  
    }
}
