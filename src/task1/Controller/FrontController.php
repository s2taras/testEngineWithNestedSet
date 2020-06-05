<?php

namespace Task1\Controller;

class FrontController
{
    /** @var LoginController */
    protected $controller;

    /**
     * FrontController constructor.
     */
    public function __construct()
    {
        $this->controller = new LoginController;
    }

    /**
     * @param array $parameters
     */
    public function run(array $parameters)
    {
        switch ($parameters['request_uri']) {
            case '/logout':
            case '/logout?':
                $this->controller->logout($parameters);
                break;
            case '/account':
                $this->controller->account($parameters);
                break;
            default:
                $this->controller->login($parameters);
                break;
        }
    }
}