<?php


namespace app\core\repositories\Shop;


use app\core\entities\Shop\Country;
use app\core\repositories\NotFoundException;

class CountryRepository
{
    public function get($id): Country
    {
        if (!$country = Country::findOne($id)) {
            throw new NotFoundException('Country is not found.');
        }
        return $country;
    }

    public function save(Country $country)
    {
        if (!$country->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Country $country)
    {
        if (!$country->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}