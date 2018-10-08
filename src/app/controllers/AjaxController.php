<?php
namespace app\controllers;

use app\services\LocationService;
use ipinfo\ipinfo\IPinfo;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

    public function __construct(IPinfo $ipService, LocationService $locationService)
    {
        $this->ipService = $ipService;
        $this->locationService = $locationService;
    }

    public function actionIp(Request $request)
    {
        return new JsonResponse($this->ipService->getDetails());
    }

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