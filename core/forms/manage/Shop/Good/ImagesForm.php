<?php


namespace app\core\forms\manage\Shop\Good;


use yii\base\Model;
use yii\web\UploadedFile;

class ImagesForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $files;

    public function rules(): array
    {
        return [
            ['files', 'each', 'rule' => ['image']],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->files = UploadedFile::getInstances($this, 'files');
            return true;
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'file_name' => 'Имя файла',
            'good_id'   => 'ID товара',
        ];
    }
}