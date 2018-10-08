<?php
namespace app\services;

use app\models\Location;
use app\repositories\LocationRepositoryInterface;

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

    public function get($ip)
    {
        $location = $this->repository->get($ip);

        return $location;
    }

    public function create($ip, $country, $city)
    {
        $location = $this->repository->create($ip, $country, $city);

        return $location;
    }
}