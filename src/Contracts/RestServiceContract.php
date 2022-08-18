<?php


namespace Brikmas\Jazzcash\Contracts;


interface RestServiceContract
{
    public function setMerchantId($value);
    public function setPassword($value);
    public function setSecureHash($value);
}