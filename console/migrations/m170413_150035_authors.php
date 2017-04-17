<?php

use yii\db\Migration;

class m170413_150035_authors extends Migration
{
    public function up()
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'name' => $this->char(),
        ]);

        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->char(),
            'author_id'=>$this->integer(),
        ]);
        $this->addForeignKey(
            'FK_book_author', '{{%books}}', 'author_id', '{{%authors}}', 'id', 'CASCADE'
        );
    }

    public function down()
    {   $this->dropForeignKey('FK_book_author', 'authors');
        $this->dropTable('{{%authors}}');
        $this->dropTable('{{%books}}');
    }
}
