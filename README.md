![Jazzcash](https://upload.wikimedia.org/wikipedia/en/b/b4/JazzCash_logo.png)
## Jazzcash payment gateway client for PHP
This client library provides access to the payment gateway web service interface of `Jazzcash`.

# Requirements

* PHP 5.4 or newer
* CURL, JSON
* Credential from `Jazzcash`

# Installation

The preferred method of installation is via [Composer](https://getcomposer.org/). Run the following command to install the package and add it as a requirement to your project's composer.json:

```
composer require brikmas/jazzcash-client-php
```

## Init client
Replace `sandbox` with `payments` for production environment along credentials.

```php
$client = new JazzClient([
    'apiBaseUrl' => 'https://sandbox.jazzcash.com.pk/',
    'merchantId' => 'xxxxxx',
    'password' => 'xxxxxx',
    'salt' => 'xxxxxx',
]);
```

## Voucher/OTC request
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

$response = $client->callVoucherService($request);
if ($response->pp_ResponseCode == 0) {
    // Handle success response
} 
else {
    // Handle fail response
}
```

## Testing
Check the `ClientTest` class add your credentials and run test in order to see the keys are working fine.
Make sure the keys are production, Unfortunately `Jazzcash` sandbox keys are not working as expected.
```bash
./vendor/bin/phpunit tests
```

## Bug
If you've found a bug please feel free to open a ticket using the issue tracker. 

## Credits
- [MasoodRehman](https://github.com/MasoodRehman)

## License
The MIT License (MIT). Please see [License](LICENSE) File for more information.