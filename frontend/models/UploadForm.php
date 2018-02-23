<?php
namespace frontend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $image;

    public function rules()
    {
        return [
            [['image'], 'file', 'extensions' => 'png, jpg, gif', 'maxFiles' => 8],
        ];
    }
    
    public function upload($path)
    {
        if ($this->validate()) { 
            foreach ($this->image as $file) {
                //$file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
                 $file->saveAs("{$path}/{$file->baseName}.{$file->extension}");
            }
            return true;
        } else {
            return false;
        }
    }
    
    public function delete($path_img){
        unlink('$path_img');
    }
}
