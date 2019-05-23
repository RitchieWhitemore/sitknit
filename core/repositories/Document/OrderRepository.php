<?php


namespace app\core\repositories\Document;


use app\core\entities\Document\Order;
use app\core\repositories\NotFoundException;

class OrderRepository
{
    public function get($id): Order
    {
        if (!$document = Order::findOne($id)) {
            throw new NotFoundException('Document is not found.');
        }
        return $document;
    }

    public function save(Order $document)
    {
        if (!$document->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Order $document)
    {
        if (!$document->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}