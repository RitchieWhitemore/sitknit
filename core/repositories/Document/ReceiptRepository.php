<?php


namespace app\core\repositories\Document;


use app\core\repositories\NotFoundException;
use app\core\entities\Document\Receipt;

class ReceiptRepository
{
    public function get($id): Receipt
    {
        if (!$document = Receipt::findOne($id)) {
            throw new NotFoundException('Document is not found.');
        }
        return $document;
    }

    public function save(Receipt $document)
    {
        if (!$document->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Receipt $document)
    {
        if (!$document->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}