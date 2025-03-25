<?php

namespace App\Repository;

use App\Interface\MurojaatInterface;
use App\Models\Murojaat;

class MurojaatRepository implements MurojaatInterface
{

    public function findByPhoneNumber(string $phoneNumber)
    {
        return Murojaat::where('phone_number', $phoneNumber)->first();
    }

    public function create(array $data) : array
    {
        $referenceNumber = $this->generateReferenceNumber();

        $murojaat = Murojaat::create($data);

        if($murojaat)
        {
            $data = [
                'referenceNumber' => $referenceNumber
            ];
            return $data;
        }
        else
        {
            return [];
        }

    }

    public function check(string $referenceNumber)
    {
        $murojaat = Murojaat::where('a_number', $referenceNumber)->first();
        return $murojaat ? $murojaat->toArray() : null;
    }

    public function generateReferenceNumber(): string
    {
        $letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2);
        $numbers = random_int(1000, 9999);
        return $letters . $numbers;
    }
}
