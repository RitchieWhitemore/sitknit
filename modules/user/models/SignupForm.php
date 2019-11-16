<?php

namespace app\modules\user\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $firstName;
    public $lastName;
    public $middleName;
    public $email;
    public $password;
    public $verifyCode;

    public function rules()
    {
        return [
            [['firstName', 'lastName', 'middleName'], 'filter', 'filter' => 'trim'],
            [['firstName', 'lastName'], 'required', 'message' => 'Пожалуйста, заполните поле'],
            //['username', 'match', 'pattern' => '#^[\w_- ]+$#i'],
            // ['username', 'unique', 'targetClass' => User::className(), 'message' => 'This username has already been taken.'],
            [['firstName', 'lastName', 'middleName'], 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => 'Этот email уже занят'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['verifyCode', 'captcha', 'captchaAction' => '/user/default/captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Код верификации',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->first_name = $this->firstName;
            $user->last_name = $this->lastName;
            $user->middle_name = $this->middleName;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->status = User::STATUS_WAIT;
            $user->generateAuthKey();
            $user->generateEmailConfirmToken();

            if ($user->save()) {

                Yii::$app->mailer->compose('@app/modules/user/mails/emailConfirm', ['user' => $user])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject('Email confirmation for ' . Yii::$app->name)
                    ->send();
                return $user;
            }
        }

        if ($this->hasErrors()) {
            foreach ($this->errors as $key => $error) {
                Yii::$app->getSession()->addFlash('error', $error[0]);
            }
        }
        return null;
    }
}