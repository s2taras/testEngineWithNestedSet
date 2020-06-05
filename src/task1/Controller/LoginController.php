<?php

namespace Task1\Controller;

use Task1\Model\LoginModel;
use Task1\Model\LoginModelInterface;
use Task1\View\LoginPage;
use Task1\View\AccountPage;

class LoginController
{
    /** @var LoginModelInterface */
    public $model;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->model = new LoginModel();
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function account(array $parameters)
    {
        if ($this->model->isLoggined($parameters['session'])) {
            return AccountPage::view($parameters);
        }

        $this->redirectTo('/login');
    }

    /**
     * @param array $parameters
     * @return string
     */
    public function login(array $parameters)
    {
        if($this->model->checkBanTime($parameters)) {
            return LoginPage::view(['ban_time' => $parameters['ban_time']]);
        }

        if ($this->model->isLoggined($parameters['session'])) {
            $this->redirectTo('/account');
        }

        if ($parameters['request_method'] == 'POST') {
            $result = $this->model->login($parameters);

            if ($result['status'] == 'success') {
                $this->model->clearAttempts($parameters);
                $this->redirectTo('/account');
            }

            $this->model->countAttempts($parameters);

            return LoginPage::view($result);
        }

        return LoginPage::view([]);
    }

    /**
     * @param array $parameters
     */
    public function logout(array $parameters)
    {
        if ($this->model->isLoggined($parameters['session'])) {
            $parameters['session'] = null;
        }

        $this->redirectTo('login');
    }

    /**
     * @param string $to
     */
    protected function redirectTo(string $to)
    {
        header("Location: " . $to); exit();
    }
}