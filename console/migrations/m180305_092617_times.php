<?php

use yii\db\Migration;

class m180305_092617_times extends Migration
{

    public function Up()
    {
        $this->addColumn('apartament', 'created_at', $this->integer(11));
        $this->addColumn('apartament', 'updated_at', $this->integer(11));
    }

    public function Down()
    {
         $this->dropColumn('apartament', 'created_at');
         $this->dropColumn('apartament', 'updated_at');
    }

}
