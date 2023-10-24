## Datos para configurar la API:
- ID Comercio
- ID Client Public
- ID Client Secret


## Datos solictados al usuario
- Numero de cuenta del cliente que va a pagar
- Codigo postal
- CVV
- Fecha de Expiracion
- Tipo de cuenta (Credito o Debito)


- MerchantKey
- AccountType
- AccountNumber
- RoutingNumber
- EffectiveDate
- IsDefault
- ExpirationMonth
- ExpirationYear
- CustomerID
- CustomerName
- CustomerEmail
- CustomerAddress
- CustomerCity
- CustomerState
- ZipCode
- Amount
- Currency
- Tax
- Invoice
- Transaction_Detail
- HoldFunds (opcional)
- ExtData (opcional)

REQUEST:
array(
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

RESPONSE:
{
    "Account": "",
    "AccountToken": "",
    "IDTransaction": "-1",
    "BatchCode": "",
    "AcquirerName": "",
    "Status": "",
    "CardHolderName": "",
    "AuditNumber": null,
    "ResponseCode": "94",
    "DesicionResponseCode": "100",
    "Message": "Duplicate Transaction",
    "AuthNumber": null,
    "HostDate": "0708",
    "HostTime": "125021PM",
    "Reference_Code": null
}
{
    "Account": "424242XXXXXX4242",
    "AccountToken": "4290575ced7e089884795bffbf69e13faf557",
    "IDTransaction": "727519",
    "BatchCode": "2589",
    "AcquirerName": "BridgePay",
    "Status": "Aprobada - Pendiente Liquidacion",
    "CardHolderName": "Test User",
    "AuditNumber": null,
    "ResponseCode": "00",
    "DesicionResponseCode": "100",
    "Message": "Success-Approved",
    "AuthNumber": "OK9581",
    "HostDate": "0708",
    "HostTime": "125113PM",
    "Reference_Code": "7734261"
}