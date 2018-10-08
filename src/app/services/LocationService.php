<?php
namespace app\services;

use app\repositories\LocationRepositoryInterface;

/**
 * Class LocationService
 * @package app\services
 */
class LocationService
{
    /**
     * @var LocationRepositoryInterface
     */
    protected $repository;

    /**
     * LocationService constructor.
     * @param LocationRepositoryInterface $repository
     */
    public function __construct(LocationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get location by IP
     * @param $ip
     * @return \app\models\Location|null
     */
    public function get($ip)
    {
        $location = $this->repository->get($ip);

        return $location;
    }

    /**
     * Create Location by details
     * @param $ip
     * @param $country
     * @param $city
     * @return \app\models\Location
     */
    public function create($ip, $country, $city)
    {
        $location = $this->repository->create($ip, $country, $city);

        return $location;
    }
}