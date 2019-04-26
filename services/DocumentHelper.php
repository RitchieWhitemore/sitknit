<?php


namespace app\services;


use yii\db\Exception;

class DocumentHelper
{

    public static function findRemovedItem($documentTable, $documentTableInitial)
    {
        foreach ($documentTableInitial as $index => $item) {
            foreach ($documentTable as $value) {
                if ($item['good_id'] == $value->good_id) {
                    unset($documentTableInitial[$index]);
                }
            }
        }

        return $documentTableInitial;
    }

    public static function removeItems($documentTableInitial)
    {
        foreach ($documentTableInitial as $item) {
            $item->delete();
        }
    }

    public static function checkIfNullPosition($documentTable)
    {
        if (count($documentTable) === 0) {
            throw new Exception('ошибка: ', ['error' =>
                                                 ['Ошибка: В документе должна быть хотя бы одна строка']
            ]);
        }
    }

}