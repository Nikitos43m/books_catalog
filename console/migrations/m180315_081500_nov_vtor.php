<?php

use yii\db\Migration;

class m180315_081500_nov_vtor extends Migration
{

    public function up()
    {
        $this->addColumn('apartament', 'type_appart', $this->integer());
        $this->addColumn('apartament', 'otdelka', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('apartament', 'type_appart');
        $this->dropColumn('apartament', 'otdelka'); 
    }

}
