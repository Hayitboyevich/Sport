<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkRequest;
use App\Http\Requests\LinkUpdateRequest;
use App\Models\Link;
use App\Traits\ResponseTrait;

class LinkController extends Controller
{
    use ResponseTrait;

    public function list()
    {
        try {
            $links = Link::query()->orderBy('created_at', 'desc')->get();
            return  $this->responseSuccess($links);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404,$exception->getMessage());
        }
    }

    public function create(LinkRequest $request)
    {
        try {
            $link = Link::query()->create($request->except('image'));
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $path = $image->store('links', 'public');
                    $link->image = $path;
                    $link->save();
                }

            }
            return $this->responseSuccess($link);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, $exception->getMessage());
        }
    }

    public function edit($id, LinkUpdateRequest $request)
    {
        try {
            $link = Link::query()->findOrFail($id);
            $link->update($request->except('image'));

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $path = $image->store('links', 'public');
                    $link->image = $path;
                    $link->save();
                }

            }
            return $this->responseSuccess($link);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $partner = Link::query()->findOrFail($id);
            $partner->delete();
            return $this->responseSuccess();
        } catch (\Exception $exception) {
            return $this->responseErrorWithCode(404, 'Not Found');
        }
    }

    public function getOne($id)
    {
        try {
          $link = Link::query()->findOrFail($id);
          return $this->responseSuccess($link);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, $exception->getMessage());
        }
    }
}
