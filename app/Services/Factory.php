<?php
namespace App\Services;

/**
 * Class Factory
 * @package App\Services
 */
class Factory
{
    /**
     * @var array
     */
    private $services;

    /**
     * @return ArticleService
     */
    public function getArticleService() {
        return $this->getService(ArticleService::class);
    }

    /**
     * @param string $className
     * @return object
     */
    private function getService($className) {
        if (!isset($this->services[$className])) {
            $this->services[$className] = new $className();
        }

        return $this->services[$className];
    }

}