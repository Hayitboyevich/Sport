<?php

namespace App\Http\Controllers;

use App\Service\MurojaatService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class MurojaatController extends Controller
{

    use ResponseTrait;
    protected $service;
    public function __construct(MurojaatService $service)
    {
        $this->service = $service;
    }
    public function createMurojaat(Request $request)
    {
        $data = $request->all();

        try {
            $murojaat = $this->service->createMurojaat($data);
            return $this->responseSuccess($murojaat);
        } catch (\Exception $e) {
            return $this->responseErrorWithCode($e->getCode());
        }
    }

    public function check(Request $request, $referenceNumber)
    {

        $murojaat = $this->service->checkMurojaat($referenceNumber);

        if ($murojaat) {
            return $this->responseSuccess($murojaat);
        }

       return $this->responseErrorWithCode(404);
    }
}
