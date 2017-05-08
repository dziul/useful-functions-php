# array_map_r
*Array Map Recursive*

base: [function.array-map](http://php.net/manual/function.array-map.php)

```php
array array_map_r(callback|array $callback, array $array, bool $alsoTheKey = false)
```

**features:**

- Possible to use more than one callback (array);
- When set `$alsoTheKey = true`, it will be possible to use the callback function in the key.


#### parameters:
- **$callback:** Callback function (or multi callback function - array) to run for each element in each array.

- **$array:** An array to run through the callback function.

- **$alsoTheKey:**`TRUE` to run for each key also. `FALSE` default.

#### example:
```php
//base array for test
$arr = [
	' test ' =>5,
	' test2 ' => 6,
	5 => [
		' test ',
		' xdebug ' => [
			'mXs' => 'whereON',
			66
		]
	],
	8,
	7954
];
```

```php
var_dump(array_map_r(['strtoupper','trim'], $arr));
//result:
array (size=5)
  ' test ' => string '5' (length=1)
  ' test2 ' => string '6' (length=1)
  5 => 
    array (size=2)
      0 => string 'TEST' (length=4)
      ' xdebug ' => 
        array (size=2)
          'mXs' => string 'WHEREON' (length=7)
          0 => string '66' (length=2)
  6 => string '8' (length=1)
  7 => string '7954' (length=4)
```

#### example (run also in key):
```php
var_dump(array_map_r(['strtoupper','trim'], $arr, true));// run also in key

//result:
array (size=5)
  'TEST' => string '5' (length=1)
  'TEST2' => string '6' (length=1)
  5 => 
    array (size=2)
      0 => string 'TEST' (length=4)
      'XDEBUG' => 
        array (size=2)
          'MXS' => string 'WHEREON' (length=7)
          0 => string '66' (length=2)
  6 => string '8' (length=1)
  7 => string '7954' (length=4)
  ```
