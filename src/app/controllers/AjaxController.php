<?php
namespace app\controllers;

use app\services\LocationService;
use ipinfo\ipinfo\IPinfo;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AjaxController
 * @package app\controllers
 */
class AjaxController
{
    /**
     * @var IPinfo
     */
    protected $ipService;

    /**
     * @var LocationService
     */
    protected $locationService;

    /**
     * AjaxController constructor.
     * @param IPinfo $ipService
     * @param LocationService $locationService
     */
    public function __construct(IPinfo $ipService, LocationService $locationService)
    {
        $this->ipService = $ipService;
        $this->locationService = $locationService;
    }

    /**
     * Returns IP of the user
     * @param Request $request
     * @return JsonResponse
     */
    public function actionIp(Request $request)
    {
        return new JsonResponse($this->ipService->getDetails());
    }

    /**
     * Returns details by IP
     * @param Request $request
     * @return JsonResponse
     */
    public function actionLocation(Request $request)
    {
        $location = $this->locationService->get($request->get('ip'));

        if (!$location) {
            $details = $this->ipService->getDetails($request->get('ip'));
            $location = $this->locationService->create($details->ip, $details->country, $details->city);
        }


        return new JsonResponse([
            'ip' => $location->ip,
            'country' => $location->country,
            'city' => $location->city,
        ]);
    }
}