## Jazzcash client for PHP
This is the client library for consuming services of Jazzcash payment gateway****.

### Init client
```php
$client = new JazzClient([
    'apiBaseUrl' => 'https://sandbox.jazzcash.com.pk/',
    'merchantId' => 'xxxxxx',
    'password' => 'xxxxxx',
    'salt' => 'xxxxxx',
]);
```