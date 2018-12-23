<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property string $fileName
 * @property int $goodId
 * @property int $main
 *
 * @property Good $good
 */
class Image extends \yii\db\ActiveRecord
{

    /**
     * @var UploadedFile
     */
    public $imageFile;
    protected $_goodId;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fileName', 'goodId'], 'required'],
            [['goodId', 'main'], 'integer'],
            [['fileName'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['goodId'], 'exist', 'skipOnError' => true, 'targetClass' => Good::className(), 'targetAttribute' => ['goodId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'fileName' => 'Имя файла',
            'goodId'   => 'Товар',
            'main'     => 'Главная картинка товара',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood()
    {
        return $this->hasOne(Good::className(), ['id' => 'goodId']);
    }

    public function upload()
    {
        $fileName = md5($this->imageFile->baseName);
        $this->fileName = $fileName . '.' . $this->imageFile->extension;

        $this->_goodId = $this->goodId;
        if ($this->validate()) {
            if ($this->save()) {
                FileHelper::createDirectory($this->getDirGoodImg());
                $this->imageFile->saveAs($this->getDirGoodImg() . $fileName . '.' . $this->imageFile->extension);
                return true;
            };
            return false;

        }

        return false;
    }

    protected function getDirGoodImg()
    {
        return Yii::$app->basePath . '/web/img/product/' . $this->_goodId . '/';
    }

    public function getUrl()
    {
        return Yii::$app->params['dirImageProduct'] . $this->goodId . '/' . $this->fileName;
    }

    public function removeOldImage($fileName)
    {
        if (file_exists($this->getDirGoodImg() . $fileName)) {
            unlink($this->getDirGoodImg() . $fileName);
        }
    }
}
