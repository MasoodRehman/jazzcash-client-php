## Jazzcash client for PHP
This is the client library for consuming web services of Jazzcash payment gateway.

### Init client
Replace `sandbox` with `payments` for production environment along credentials.

```php
$client = new JazzClient([
    'apiBaseUrl' => 'https://sandbox.jazzcash.com.pk/',
    'merchantId' => 'xxxxxx',
    'password' => 'xxxxxx',
    'salt' => 'xxxxxx',
]);
```

### OTC request
Make sure the `CallbackUrl` is same as given in the Jazzcash portal.

```php
$txn_ref_no = time();

$request = new VoucherReq();
$request->setAmount(10);
$request->setBillRefNumber($txn_ref_no);
$request->setDescription('Unit test case');
$request->setTxnRefNumber($txn_ref_no);
$request->setVersion('1.1');
$request->setTxnType('OTC');
$request->setCallbackUrl('http://localhost/gateway/jazzcash/callback');
$request->setCustomProperty('03331234567');

$response = $this->client->callVoucherService($request);
if ($response->pp_ResponseCode == 0) {
    // Handle success response
} 
else {
    // Handle fail response
}
```
