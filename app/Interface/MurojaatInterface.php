<?php

namespace App\Interface;

interface MurojaatInterface
{

    public function findByPhoneNumber(string $phoneNumber);
    public function create(array $data) : array;

    public function check(string $referenceNumber);
}
