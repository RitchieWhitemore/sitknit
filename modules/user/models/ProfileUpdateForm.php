<?php

namespace app\modules\user\models;

use yii\base\Model;

class ProfileUpdateForm extends Model
{
    public $email;
    public $firstName;
    public $lastName;
    public $middleName;
    public $address;
    public $photo;

    /**
     * @var User
     */
    private $_user;

    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        //$this->email = $user->email;
        $this->firstName = $user->first_name;
        $this->lastName = $user->last_name;
        $this->middleName = $user->middle_name;
        $this->address = $user->partner->address;
        $this->photo = $user->photo;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            /*['email', 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => User::className(),
                'message'     => 'Такой e-mail существует',
                'filter'      => ['<>', 'id', $this->_user->id],
            ],
            ['email', 'string', 'max' => 255],*/
            [['firstName', 'lastName', 'middleName', 'address'], 'filter', 'filter' => 'trim'],
            [['firstName', 'lastName', 'address'], 'required', 'message' => 'Пожалуйста, заполните поле'],
            [['firstName', 'lastName', 'middleName', 'address'], 'string', 'min' => 2, 'max' => 255],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
            'middleName' => 'Отчество',
            'address' => 'Адрес',
            'photo' => 'Фото',
        ];
    }

    public function update()
    {
        if ($this->validate()) {
            $user = $this->_user;

            $partner = $user->partner;
            $partner->address = $this->address;
            $partner->full_name = $this->lastName . ' ' . $this->firstName . ' ' . $this->middleName;
            $user->partner = $partner;

            //$user->email = $this->email;
            $user->first_name = $this->firstName;
            $user->last_name = $this->lastName;
            $user->middle_name = $this->middleName;
            $user->photo = $this->photo;
            return $user->save();
        }
        else {
            return false;
        }
    }
}