<?php


namespace app\services;


use app\modules\trade\models\DocumentInterface;
use app\modules\trade\models\Order;
use app\core\entities\Document\Receipt;
use Yii;
use yii\db\Exception;

/**
 * Class DocumentRepository
 * @package app\services
 *
 * @property \app\core\entities\Document\Receipt|Order $document
 * @property DocumentInterface $documentTableInitial
 *
 */

class DocumentRepository
{
    private $document;
    private $documentTable;
    private $documentTableInitial;
    private $requestParams;

    public function __construct(DocumentInterface $document, $documentTable, $requestParams)
    {
         $this->document = $document;
         $this->documentTable = $documentTable;
         $this->documentTableInitial = $this->document->documentItems;
         $this->requestParams = $requestParams;
    }

    public function save()
    {
        $this->findRemovedItem();

        $transaction = Yii::$app->getDb()->beginTransaction();

        try {

            $this->document->attributes = $this->requestParams;

            if ($this->document->save()) {

                $this->isEmptyDocumentTable();

                foreach ($this->documentTable as $item) {
                    $tableItem = $this->document->getDocumentItems()->where(['good_id' => $item->good_id])->one();

                    if (!isset($tableItem)) {
                        $tableItem = $this->document->createTableItem($this->document->id, $item->good_id);
                    }

                    $tableItem->qty = $item->qty;
                    $tableItem->price = $item->price;
                    $tableItem->save();
                }

                $this->removeItems();
            } else {
                throw new Exception('ошибка', $this->document->errors);
            }


            $transaction->commit();
            if (!$this->document->hasErrors() && strpos(Yii::$app->request->referrer, 'create')) {
                return ['status' => true, 'id' => $this->document->id];
            } else {
                return ['status' => true];
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
            return ['status' => false];
        }
    }

    private function findRemovedItem()
    {
        foreach ($this->documentTableInitial as $index => $item) {
            foreach ($this->documentTable as $value) {
                if ($item['good_id'] == $value->good_id) {
                    unset($this->documentTableInitial[$index]);
                }
            }
        }
    }

    private function isEmptyDocumentTable()
    {
        if (count($this->documentTable) === 0) {
            throw new Exception('ошибка: ', ['error' =>
                                                 ['Ошибка: В документе должна быть хотя бы одна строка']
            ]);
        }
    }

    private function removeItems()
    {
        foreach ($this->documentTableInitial as $item) {
            $item->delete();
        }
    }
}