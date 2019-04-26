<?php


namespace app\modules\trade\models;


interface DocumentInterface
{
    public function getDocumentItems();

    public function createTableItem($documentId, $goodId);
}