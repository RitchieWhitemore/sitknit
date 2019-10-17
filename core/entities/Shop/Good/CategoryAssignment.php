<?php


namespace app\core\entities\Shop\Good;


use app\core\entities\Shop\Category;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $good_id;
 * @property integer $category_id;
 * @property Category $category
 */
class CategoryAssignment extends ActiveRecord
{
    public static function create($categoryId): self
    {
        $assignment = new static();
        $assignment->category_id = $categoryId;
        return $assignment;
    }

    public function isForCategory($id): bool
    {
        return $this->category_id == $id;
    }

    public static function tableName(): string
    {
        return '{{%category_assignment}}';
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}