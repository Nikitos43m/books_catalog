<?php

use yii\db\Migration;

class m180204_164313_image_path extends Migration
{
    public function up()
    {
        $this->addColumn('apartament', 'image_path', $this->char(255));
    }

    public function down()
    {
        $this->dropColumn('apartament', 'image_path');
    }
}
