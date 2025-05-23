<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Models\Image;
use App\Models\Service;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Request;

class ServiceController extends Controller
{
    use ResponseTrait;

    public function list()
    {
        try {
            $services = Service::query()
                    ->when(\request('type'), function ($q) {
                        return $q->where('type', \request('type'))
                    ->when(request('status'), function ($q) {
                        return $q->where('status', \request('status'));
                    });
                })->orderBy('created_at', 'desc')->get();

            return $this->responseSuccess($services);
        } catch (\Exception $exception){
            return $this->responseErrorWithCode(404, $exception->getMessage());
        }
    }

    public function create(ServiceRequest $request)
    {
        try {
           $service = Service::query()->create($request->except('image'));

           if($request->hasFile('image')){
               $image = $request->file('image');
               $path = $image->store('service', 'public');
               $service->image = $path;
               $service->save();
           }
           return $this->responseSuccess($service);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, 'Xatolik aniqlandi');
        }
    }

    public function edit($id, ServiceUpdateRequest  $request)
    {
        try {
            $service = Service::query()->findOrFail($id);
            $service->update($request->except('image'));

            if($request->hasFile('image')){
                $image = $request->file('image');
                $path = $image->store('service', 'public');
                $service->image = $path;
                $service->save();
            }
            return $this->responseSuccess($service);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, 'Xatolik aniqlandi');
        }
    }

    public function getOne($id)
    {
        try {
            $service = Service::query()->findOrFail($id);
            return $this->responseSuccess($service);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, 'Xatolik aniqlandi');
        }
    }

    public function changeStatus()
    {
        try {
           $service = Service::query()->findOrFail(request('id'));
           $service->update(['status' => !$service->status]);
           return $this->responseSuccess($service);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, 'Xatolik aniqlandi');
        }
    }

    public function delete($id)
    {
        try{
           $service = Service::query()->findOrFail($id);
           $service->delete();
           return $this->responseSuccess(null);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, 'Xatolik aniqlandi');
        }
    }

    public function imageDelete($id)
    {
        try {
            $image = Image::query()->findOrFail($id);
            $image->delete();
            return $this->responseSuccess('deleted');
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, 'Xatolik aniqlandi');
        }
    }
}
