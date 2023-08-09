<?php
class AuthorizationRequest {
    public $MerchantKey;
    public $AccountType;
    public $AccountNumber;
    public $RoutingNumber;
    public $EffectiveDate;
    public $IsDefault;
    public $ExpirationMonth;
    public $ExpirationYear;
    public $CustomerID;
    public $CustomerName;
    public $CustomerEmail;
    public $CustomerAddress;
    public $CustomerCity;
    public $CustomerState;
    public $ZipCode;
    public $Amount;
    public $Currency;
    public $Tax;
    public $CVV;
    public $Invoice;
    public $Transaction_Detail;
    public $HoldFunds;
    public $ExtData;

    public function getData( ) {
        return array(
            'MerchantKey' => $this->MerchantKey,
            'AccountNumber' => $this->AccountNumber,
            'ExpirationMonth' => $this->ExpirationMonth,
            'ExpirationYear' => $this->ExpirationYear,
            'CustomerName' => "Test User",
            'CustomerID' => $this->CustomerID,
            'AccountType' => AccountType::Credit_Debit,
            'CustomerEmail' => "testuser@gmail.com",
            'ZipCode' => $this->ZipCode,
            'Amount' => $this->Amount,
            'Currency' => "840",
            'Tax' => "0",
            'Invoice' => "123465465",
            'Transaction_Detail' => "payment information detail",
            'CVV' => $this->CVV,
        );
    }

}
