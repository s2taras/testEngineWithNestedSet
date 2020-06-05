<?php

namespace Task3\Model;

use PDO;
use Task3\Helpers\DBConnection;

class ShopModel
{
    const DEFAULT_LIMIT = 10;

    /** @var PDO */
    protected $db;

    /**
     * ShopModel constructor.
     */
    public function __construct()
    {
        $this->db = DBConnection::getConnection();
    }

    /**
     * @param int $page
     * @return array
     */
    public function getProduct(int $page = 1): array
    {
        $page = $page <= 0 ? 1 : $page;
        $offset = ($page * self::DEFAULT_LIMIT) - self::DEFAULT_LIMIT;
        $pagination = $this->getPagination($offset, self::DEFAULT_LIMIT);

        return [
            'products'   => $this->getFullProduct($offset),
            'pagination' => $pagination
        ];
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getPagination(int $offset, int $limit): array
    {
        return [
            'totalPages'  => $this->getTotalPagesCount($limit),
            'currentPage' => $this->getCurrentPage($offset, $limit)
        ];
    }

    protected function getFullProduct(int $offset): array
    {
        $stm = $this->db->prepare($this->getProductSql());
        $stm->bindValue(":limit", self::DEFAULT_LIMIT, PDO::PARAM_INT);
        $stm->bindValue(":offset", $offset, PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as &$product) {
            $product['categories'] = $this->getCategories($product['id']);
            $product['tags'] = $this->getTags($product['id']);
        }

        return $result;
    }

    /**
     * @param int $productId
     * @return array
     */
    protected function getCategories(int $productId): array
    {
        $stm = $this->db->prepare($this->getCategorySql());
        $stm->bindValue(":productId", $productId, PDO::PARAM_INT);
        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * @param int $productId
     * @return array
     */
    protected function getTags(int $productId): array
    {
        $stm = $this->db->prepare($this->getTagSql());
        $stm->bindValue(":productId", $productId, PDO::PARAM_INT);
        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * @return string
     */
    protected function getProductSql(): string
    {
        return "SELECT p.id, p.title, p.price, r.title as region FROM product p
        INNER JOIN product_region pr ON p.id = pr.product_id
        INNER JOIN region r ON pr.region_id = r.id
        ORDER BY p.id DESC
        LIMIT :limit OFFSET :offset";
    }

    /**
     * @return string
     */
    protected function getCategorySql(): string
    {
        return "SELECT c.title FROM product_category pc 
                INNER JOIN category c ON pc.category_id = c.id
                WHERE pc.product_id = :productId";
    }

    /**
     * @return string
     */
    protected function getTagSql(): string
    {
        return "SELECT t.title FROM product_tag pt 
                INNER JOIN tag t ON pt.tag_id = t.id
                WHERE pt.product_id = :productId";
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return int
     */
    protected function getCurrentPage(int $offset, int $limit): int
    {
        if ($offset == 0) return 1;

        return ($offset / $limit) + 1;
    }

    /**
     * @param int $limit
     * @return int
     */
    protected function getTotalPagesCount(int $limit): int
    {
        $products = $this->getProductsCount();

        return ceil(($products / $limit));
    }

    /**
     * @return int
     */
    protected function getProductsCount(): int
    {
        $stm = $this->db->query('SELECT COUNT(id) FROM product');

        return (int)$stm->fetchColumn();
    }
}