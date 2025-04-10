<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatisticRequest;
use App\Http\Requests\StatisticUpdateRequest;
use App\Models\Statistic;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    use ResponseTrait;

    public function list()
    {
        try {
            $statistics = Statistic::query()->when(\request('status'), function ($query, $status) {
                return $query->where('status', $status);
            })->orderBy('created_at', 'desc')->get();
            return $this->responseSuccess($statistics);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, $exception->getMessage());
        }
    }

    public function create(StatisticRequest $request)
    {
        try {
            $statistic =  Statistic::query()->create($request->validated());
            return $this->responseSuccess($statistic);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, $exception->getMessage());
        }
    }

    public function edit($id, StatisticUpdateRequest  $request)
    {
        try {
            $statistic =  Statistic::query()->findOrFail($id);
            $statistic->update($request->validated());
            return $this->responseSuccess($statistic);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, $exception->getMessage());
        }
    }

    public function changeStatus()
    {
        try {
           $statistic = Statistic::query()->findOrFail(request('id'));
           $statistic->update(['status' => !$statistic->status]);
           return $this->responseSuccess($statistic);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try{
            $service = Statistic::query()->findOrFail($id);
            $service->delete();
            return $this->responseSuccess(null);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, 'Xatolik aniqlandi');
        }
    }
}
