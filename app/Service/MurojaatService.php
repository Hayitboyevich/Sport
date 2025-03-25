<?php

namespace App\Service;

use App\Exceptions\CustomException;
use App\Interface\MurojaatInterface;
use App\Models\Murojaat;
use App\Repository\MurojaatRepository;
use App\Traits\ResponseTrait;

class MurojaatService
{

    use ResponseTrait;
    protected $repository;
    protected $repositoryMurojaat;
    public function __construct(MurojaatInterface $repository, MurojaatRepository $repositoryMurojaat)
    {
        $this->repository = $repository;
        $this->repositoryMurojaat = $repositoryMurojaat;
    }

    public function createMurojaat(array $data)
    {

        $existingMurojaat = $this->repository->findByPhoneNumber($data['phone_number']);
        if ($existingMurojaat && $existingMurojaat->status == 0) {
             return throw new CustomException(409);
        }

        $referenceNumber = $this->repositoryMurojaat->generateReferenceNumber();
        $data['a_number'] = $referenceNumber;

        return $this->repository->create($data);
    }

    public function checkMurojaat(string $referenceNumber)
    {
        return $this->repository->check($referenceNumber);
    }

}
