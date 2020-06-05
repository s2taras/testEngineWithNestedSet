<?php

namespace Task3\Controller;

use Predis\Client;
use Task3\Helpers\RedisConnection;
use Task3\Model\ShopModel;
use Task3\View\ShopPage;

class ShopController
{
    /** @var ShopModel */
    protected $model;

    /** @var ShopPage */
    protected $page;

    /** @var Client */
    protected $redis;

    /**
     * ShopController constructor.
     */
    public function __construct()
    {
        $this->model = new ShopModel();
        $this->page = new ShopPage();
        $this->redis = RedisConnection::getConnection();
    }

    /**
     * @param int $page
     */
    public function index(int $page)
    {
        if ($this->redis->exists(RedisConnection::REDIS_KEY . $page)) {
            $response = unserialize(base64_decode($this->redis->get(RedisConnection::REDIS_KEY . $page)));
            $this->page->view($response);

            return;
        }

        $response = $this->model->getProduct($page);

        $this->redis->setex(
            RedisConnection::REDIS_KEY . $page,
            RedisConnection::REDIS_TTL,
            base64_encode(serialize($response))
        );

        $this->page->view($response);
        return;
    }
}