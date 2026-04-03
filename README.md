# DataGetterHelper
Type-safe helper for extracting and validating typed data from mixed sources in PHP.

## Installation

Install the package via Composer:

```bash
composer require marvin255/data-getter-helper
```

## Extract string value

```php
use Marvin255\DataGetterHelper\DataGetterHelper;

$data = [
    'user' => [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ],
];

// Extract with default value
$name = DataGetterHelper::string('user.name', $data);           // 'John Doe'
$phone = DataGetterHelper::string('user.phone', $data, '');     // ''

// Require the value (throws exception if not found)
$email = DataGetterHelper::requireString('user.email', $data);  // 'john@example.com'
```

## Extract numeric values

```php
use Marvin255\DataGetterHelper\DataGetterHelper;

$data = [
    'product' => [
        'id' => 123,
        'price' => 99.99,
        'quantity' => '5',
    ],
];

// Int extraction
$id = DataGetterHelper::int('product.id', $data);               // 123
$quantity = DataGetterHelper::int('product.quantity', $data);   // 5
$stock = DataGetterHelper::int('product.stock', $data, 0);      // 0

// Float extraction
$price = DataGetterHelper::float('product.price', $data);       // 99.99
$discount = DataGetterHelper::float('product.discount', $data, 0.0);  // 0.0

// Require numeric values
$productId = DataGetterHelper::requireInt('product.id', $data);
$productPrice = DataGetterHelper::requireFloat('product.price', $data);
```

## Extract boolean values

```php
use Marvin255\DataGetterHelper\DataGetterHelper;

$data = [
    'settings' => [
        'enabled' => true,
        'debug' => 1,
    ],
];

// Bool extraction
$enabled = DataGetterHelper::bool('settings.enabled', $data);      // true
$notify = DataGetterHelper::bool('settings.notify', $data, false); // false

// Require bool value
$debugMode = DataGetterHelper::requireBool('settings.debug', $data);
```

## Extract array values

```php
use Marvin255\DataGetterHelper\DataGetterHelper;

$data = [
    'users' => [
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob'],
    ],
    'tags' => [],
];

// Extract array
$users = DataGetterHelper::array('users', $data);        // [['id' => 1, ...], ...]
$tags = DataGetterHelper::array('tags', $data);          // []
$categories = DataGetterHelper::array('categories', $data, ['default']); // ['default']

// Map array values with callback
$userIds = DataGetterHelper::arrayOf('users', $data, fn($user) => $user['id']); // [1, 2]
```

## Extract object instances

```php
use Marvin255\DataGetterHelper\DataGetterHelper;

class User {
    public function __construct(public string $name) {}
}

$user = new User('John');
$data = ['current_user' => $user];

// Extract object of specific class
$currentUser = DataGetterHelper::objectOf('current_user', $data, User::class);
```

## Get mixed data

```php
use Marvin255\DataGetterHelper\DataGetterHelper;

$data = [
    'config' => [
        'settings' => [
            'theme' => 'dark',
            'version' => 2,
        ],
    ],
];

// Get any value
$theme = DataGetterHelper::get('config.settings.theme', $data);          // 'dark'
$unknown = DataGetterHelper::get('config.unknown', $data, 'fallback');   // 'fallback'
```

## Working with objects

All methods work with both arrays and objects:

```php
use Marvin255\DataGetterHelper\DataGetterHelper;

class Config {
    public array $database = ['host' => 'localhost'];
}

$config = new Config();

$host = DataGetterHelper::string('database.host', $config); // 'localhost'
```

## Error handling

Methods throw `DataGetterException` when:
- Required values are not found
- Values cannot be cast to the requested type (scalar methods)
- Values are not of the expected type (array, object methods)

```php
use Marvin255\DataGetterHelper\DataGetterHelper;
use Marvin255\DataGetterHelper\DataGetterException;

try {
    $value = DataGetterHelper::requireInt('user.age', []);
} catch (DataGetterException $e) {
    echo $e->getMessage(); // "Item isn't found by path user.age"
}
```
