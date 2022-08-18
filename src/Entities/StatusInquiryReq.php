<?php


namespace Brikmas\Jazzcash\Entities;



class StatusInquiryReq extends BaseReq
{
    public $pp_TxnRefNo;

    public function __construct($txnRefNumber = null)
    {
        $this->pp_TxnRefNo = $txnRefNumber;
    }

    public function setTxnRefNumber($value)
    {
        $this->pp_TxnRefNo = $value;
    }

    public function getTxnRefNumber()
    {
        return $this->pp_TxnRefNo;
    }
}