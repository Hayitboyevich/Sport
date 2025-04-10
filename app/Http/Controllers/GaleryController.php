<?php

namespace App\Http\Controllers;

use App\Http\Requests\GaleryRequest;
use App\Models\Galery;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class GaleryController extends Controller
{
    use ResponseTrait;

    public function list()
    {
        try {
           $galleries = Galery::query()->with('images')
               ->when(\request('type'), function ($query) {
                   return $query->where('type', \request('type'));
               })
               ->when(\request('status'), function ($query) {
                   return $query->where('status', \request('status'));
               })
               ->orderBy('created_at', 'desc')->get();
           return $this->responseSuccess($galleries);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, $exception->getMessage());
        }
    }

    public function create(GaleryRequest $request)
    {
        try {
            $gallery = Galery::query()->create($request->except('image', 'images'));

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = $image->store('galery', 'public');
                $gallery->image = $path;
                $gallery->save();
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key=>$image) {
                    $path = $image->store('gallery', 'public');
                    $gallery->images()->create(['url' => $path, 'order' => $key+1]);
                }
            }
            return $this->responseSuccess($gallery);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try{
            $gallery = Galery::query()->findOrFail($id);
            $gallery->delete();
            return $this->responseSuccess(null);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, 'Xatolik aniqlandi');
        }
    }

    public function changeStatus()
    {
        try {
            $gallery = Galery::query()->findOrFail(request('id'));
            $gallery->update(['status' => !$gallery->status]);
            return $this->responseSuccess($gallery);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, 'Xatolik aniqlandi');
        }
    }
}
