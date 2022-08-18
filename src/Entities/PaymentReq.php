<?php


namespace Brikmas\Jazzcash\Entities;



class PaymentReq extends BaseReq
{
    public $pp_Amount;
    public $pp_BankID;
    public $pp_BillReference;
    public $pp_Description;

    /**
     * CNIC Last 6-digits
     *
     * @var $pp_CNIC
     */
    public $pp_CNIC;

    public $pp_Language;
    public $pp_MobileNumber;
    public $pp_ProductID;
    public $pp_ReturnURL;
    public $pp_TxnCurrency;
    public $pp_TxnDateTime;
    public $pp_TxnExpiryDateTime;
    public $pp_TxnRefNo;
    public $pp_TxnType;
    public $pp_Version;
    public $pp_SubMerchantID;
    public $ppmpf_1;
    public $ppmpf_2;
    public $ppmpf_3;
    public $ppmpf_4;
    public $ppmpf_5;

    public function __construct()
    {
        $this->pp_TxnCurrency = 'PKR';
        $this->pp_Language = 'EN';
        $this->pp_TxnDateTime = date('YmdHis');
        $this->pp_TxnExpiryDateTime = date('YmdHis', strtotime("+30 Minutes"));
    }

    public function setAmount($value)
    {
        $this->pp_Amount = $value * 100;
    }

    public function setBillRefNumber($value)
    {
        $this->pp_BillReference = $value;
    }

    public function getBillRefNumber()
    {
        return $this->pp_BillReference;
    }

    public function setDescription($value)
    {
        $this->pp_Description = $value;
    }

    public function setCnic($value)
    {
        $this->pp_CNIC = substr($value, -6);
    }

    public function setLanguage($value)
    {
        $this->pp_Language = $value;
    }

    public function setMobileNumber($value)
    {
        $this->pp_MobileNumber = $value;
    }

    public function setCallbackUrl($value)
    {
        $this->pp_ReturnURL = $value;
    }

    public function getCallbackUrl()
    {
        return $this->pp_ReturnURL;
    }

    public function setTxnCurrency($value)
    {
        $this->pp_TxnCurrency = $value;
    }

    public function setTxnDateTime($value)
    {
        $this->pp_TxnDateTime = $value;
    }

    /**
     * Transaction expiry in minutes
     *
     * @param int $minutes Minutes
     */
    public function setTxnExpInMinutes($minutes)
    {
        $this->pp_TxnExpiryDateTime = date('YmdHis', strtotime("+{$minutes} Minutes"));
    }

    public function setTxnRefNumber($value)
    {
        $this->pp_TxnRefNo = $value;

        if (empty($this->getBillRefNumber())) {
            $this->setBillRefNumber($value);
        }
    }

    public function setTxnType($value)
    {
        $this->pp_TxnType = $value;
    }

    public function setVersion($value)
    {
        $this->pp_Version = $value;
    }

    public function customProperty($value)
    {
        if (empty($this->ppmpf_1)) {
            $this->ppmpf_1 = $value;
        }
        else if (empty($this->ppmpf_2)) {
            $this->ppmpf_2 = $value;
        }
        else if (empty($this->ppmpf_3)) {
            $this->ppmpf_3 = $value;
        }
        else if (empty($this->ppmpf_4)) {
            $this->ppmpf_4 = $value;
        }
        else {
            $this->ppmpf_5 = $value;
        }
    }
}