<?php

use yii\db\Migration;

class m170823_105321_apartament extends Migration
{
    public function up()
    {
        $this->createTable('{{%apartament}}', [
            'id' => $this->primaryKey(),
            'type' => $this->char(),
            'street' => $this->char(),
            'house' => $this->char(),
            'apartament' => $this->integer(),
            'rooms' => $this->integer(),
            'floor' => $this->integer(),
            'area' => $this->integer(),
            'price' => $this->integer(),
            'telephone' =>$this->char(),
            'lat' => $this->float(),
            'lng' => $this->float(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%apartament}}');
    }
}
