<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerRequest;
use App\Http\Requests\PartnerUpdateRequest;
use App\Models\Partner;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    use ResponseTrait;

    public function list()
    {
        try {
            $query = Partner::query()
                ->get();
            return $this->responseSuccess($query);
        } catch (\Exception $exception) {
            return $this->responseErrorWithCode(404, 'Not Found');
        }
    }

    public function create(PartnerRequest $request)
    {
        DB::beginTransaction();
        try {
            $partner = Partner::query()->create($request->except('image'));
            if ($request->hasFile('image')) {
                    $path = $request->file('image')->store('partners', 'public');
                    $partner->image = $path;
                    $partner->save();
            }
            DB::commit();
            return $this->responseSuccess($partner);
        }catch (\Exception $exception){
            DB::rollBack();
            return $this->responseErrorWithCode(404, 'Not Found');
        }
    }

    public function edit($id, PartnerUpdateRequest $request)
    {
        try {
            $partner = Partner::query()->findOrFail($id);
            $partner->update($request->except('image'));
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('partners', 'public');
                $partner->image = $path;
                $partner->save();
            }

            return $this->responseSuccess($partner);

        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, $exception->getMessage());
        }
    }

    public function getPartner($id)
    {
        try {
            $partner = Partner::query()->findOrFail($id);
            return $this->responseSuccess($partner);
        }catch (\Exception $exception){
            return $this->responseErrorWithCode(404, 'Not Found');
        }
    }

    public function delete($id)
    {
        try {
            $partner = Partner::query()->findOrFail($id);
            $partner->delete();
            return $this->responseSuccess();
        } catch (\Exception $exception) {
            return $this->responseErrorWithCode(404, 'Not Found');
        }
    }
}
