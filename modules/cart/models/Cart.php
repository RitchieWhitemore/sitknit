<?php


namespace app\modules\cart\models;


use app\core\entities\Shop\Good\Good;

class Cart
{
    private $items;

    /**
     * @return CartItem[]
     */
    public function getItems(): array
    {
        $this->loadItems();
        return $this->items;
    }

    public function getAmount(): int
    {
        $this->loadItems();
        return count($this->items);
    }

    public function add(Good $good, $qty)
    {
        foreach ($this->getItems() as $i => $item) {
            if ($item->good->id == $good->id) {
                $this->items[$i] = $item->plusQty($qty);
                $this->saveItems();
                return;
            }
        }

        $this->items[] = new CartItem($good, $qty);
        $this->saveItems();
    }

    public function set(Good $good, $qty)
    {
        foreach ($this->getItems() as $i => $item) {
            if ($item->good->id == $good->id) {
                $this->items[$i] = $item->setQty($qty);
                $this->saveItems();
                return;
            }
        }

        $this->items[] = new CartItem($good, $qty);
        $this->saveItems();
    }

    public function delete($id)
    {
        $this->loadItems();
        foreach ($this->getItems() as $i => $item) {
            if ($item->getId() == $id) {
                unset($this->items[$i]);
                $this->saveItems();
                return;
            }
        }
        throw new \DomainException('Item is not found.');
    }

    public function getTotalSum()
    {
        $sum = 0;
        foreach ($this->getItems() as $item) {
            $sum += $item->getSum();
        }
        return $sum;
    }

    private function loadItems()
    {
        if ($this->items === null) {
            $this->items = \Yii::$app->session->get('cart', []);
        }
    }

    private function saveItems()
    {
        \Yii::$app->session->set('cart', $this->items);
    }
}