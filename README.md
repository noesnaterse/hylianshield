# Hylian Shield

The Hylian Shield between your application and input data.

## The Hylian Shield in action

### Validators

```php
<?php
use \HylianShield\Validator;

// Check if a file exists.
$fileExists = new Validator\File\Exists;
var_dump("{$fileExists}", __FILE__, $fileExists(__FILE__));
// 'file_exists:0,0', README.md, true

// Check if a data type is a string of at least 5 characters and at most 12 characters.
$checkString = new Validator\String(5, 12);
var_dump(
  $checkString('Heya'),
  $checkString(120000),
  $checkString(11),
  $checkString('HylianShield'),
  $checkString('Shield')
);
// false, false, false, true, true

var_dump($checkString->validate('HylianShield'));
// true

var_dump("{$checkString}");
// string:5,12

var_dump($checkString->type());
// string

// A stricter version \HylianShield\Validator\Url\Webpage is in the making.
// This one will also match file paths and is way too forgiving for most applications.
$url = new Validator\Url;
var_dump($url('https://github.com/johmanx10/hylianshield'));
// true

// This will become \HylianShield\Validator\Date\Mysql in the near future.
$mysqlDate = new Validator\Regexp('/^\d{4}\-\d{2}\-\d{2}$/');

var_dump($mysqlDate('2013-12-12'));
// true

var_dump($mysqlDate('2013-012-12'));
// false
```

### Serializers

```php
<?php
$serializer = "\HylianShield\Serializer\JsonConf";

$json = '{ "shield": { "origin": "Hylian", "rupees": 70 } }';

$data = $serializer::unserialize($json);

var_dump($data['shield']['origin']); // 'Hylian'
// Check the
var_dump($data['shield']['rupees']); // 70

$json = $serializer::serialize($data);

// The output is optimized for editing as a configuration.
var_dump($json);

// {
//   "shield": {
//     "origin": "Hylian",
//     "rupees": 70
//   }
// }

```

### Configurations

```php
<?php

use \HylianShield\Validator;

$configuration = \HylianShield\Configuration\Factory::getFromJsonFile('shield.json');
// OR: new \HylianShield\Configuration(array('origin' => 'Hylian'));
// OR: new \HylianShield\Configuration combined with setSerializer and unserialize
// OR: new \HylianShield\Configuration combined with setStorage and loadStorage

// We assume the following was in our JSON storage:
// {
//   "origin": "Hylian",
//   "rupees": 70
// }

$configuration->setValidator(new Validator\String(5, 12), 'origin');
$configuration->setValidator(new Validator\Integer(1, 4), 'price');

$configuration->setValidationRules('origin', array('origin'));
$configuration->setValidationRules('rupees', array('price'));

var_dump($configuration->validate()); // true

$configuration->store(); // Won't do anything as the configuration is not dirty.

$configuration['origin'] = array('12');

var_dump($configuration->validate()); // false
var_dump($configuration->validate(true));
// array(
//   'origin' => array(
//     'value' => '(array) array(0 => \'12\')',
//     'failed' => array(0 => 'string:5,12')
//   )
// )

$configuration->store(); // Will throw an exception because the configuration is invalid.

$configuration['origin'] = 'Hylian';

$configuration->store(); // Stores in shield.json, because it is dirty.

var_dump($configuration->serialize());
// {
//   "origin": "Hylian",
//   "rupees": 70
// }

// Some magic implementations:
echo $configuration; // Outputs a serialized version of the configuration.
unset($configuration); // Implicitly calls store when the configuration is dirty.

```

The configuration model has a protected property required which holds the properties you ought to be required by your configuration. Since that list can't be altered, it is suggested that you make a new configuration model for each configuration you want to test. By doing that, you can set validators and validation rules in the construct and be done with them. This makes for a highly re-usable configuration.

![Hylian Shield](http://fc00.deviantart.net/fs70/f/2011/258/3/9/hylian_shield_vector_by_reptiletc-d49y46o.png)
