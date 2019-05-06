<?php


namespace app\core\services\manage\Shop;


use app\core\forms\manage\Shop\CountryForm;
use app\core\repositories\Shop\CountryRepository;
use app\core\entities\Shop\Country;

class CountryManageService
{
    private $countries;

    public function __construct(CountryRepository $countries)
    {
        $this->countries = $countries;
    }

    public function create(CountryForm $form): Country
    {
        $country = Country::create($form->name, $form->description);

        $this->countries->save($country);

        return $country;
    }

    public function edit($id, CountryForm $form)
    {
        $country = $this->countries->get($id);

        $country->edit($form->name, $form->description);

        $this->countries->save($country);
    }

    public function remove($id)
    {
        $country = $this->countries->get($id);

        $this->countries->remove($country);
    }
}