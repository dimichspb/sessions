<?php
namespace app\repositories;

use app\models\Location;

interface LocationRepositoryInterface
{
    /**
     * @param $ip
     * @return Location|null
     */
    public function get($ip);

    /**
     * @param $ip string
     * @param $country string
     * @param $city string
     * @return Location
     */
    public function create($ip, $country, $city);
}