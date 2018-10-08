<?php
namespace app\repositories;

use app\models\Location;
use Assert\Assertion;

/**
 * Class ActiveRecordLocationRepository
 * @package app\repositories
 */
class ActiveRecordLocationRepository implements LocationRepositoryInterface
{
    /**
     * @param $ip
     * @return Location|null
     */
    public function get($ip)
    {
        return Location::find_by_ip($ip);
    }

    /**
     * @param string $ip
     * @param string $country
     * @param string $city
     * @return Location
     * @throws \Assert\AssertionFailedException
     */
    public function create($ip, $country, $city)
    {
        Assertion::ip($ip);
        Assertion::string($country);
        Assertion::maxLength($country, 2);
        Assertion::string($city);
        Assertion::maxLength($city, 30);

        $location = new Location([
            'ip' => $ip,
            'country' => $country,
            'city' => $city,
        ]);
        $location->save();

        return $location;
    }

}