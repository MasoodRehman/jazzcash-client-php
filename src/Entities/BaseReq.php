<?php


namespace Brikmas\Jazzcash\Entities;


use Brikmas\Jazzcash\Contracts\RestServiceContract;

class BaseReq implements RestServiceContract
{
    public $pp_MerchantID;
    public $pp_Password;
    public $pp_SecureHash;

    public function setMerchantId($value)
    {
        $this->pp_MerchantID = $value;
    }

    public function setPassword($value)
    {
        $this->pp_Password = $value;
    }

    public function setSecureHash($value)
    {
        $this->pp_SecureHash = $value;
    }
}