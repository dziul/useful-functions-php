### in_array_recursive

base: [function.in-array](http://php.net/manual/function.in-array.php)

```php
bool function in_array_recursive(mixed $needle, array $haystack [ , bool $caseInsensitive = false, bool $strict = false ])
```

Check recursively if a value exists in an array.

**features:**

- Possibility to check a group (array) of `$needle` in `$haytack`
- When set `$caseInsensitive = true` Check case-insensitive string comparison;
- When set `$strict = true`  check the `$needle` type in `$haystack`.


#### parameters:
- **$needle:** The searched value or group (array) of value

- **$haystack:** The Array

- **$caseInsensitive:** `TRUE` Check case-insensitive string comparison. `FALSE` default.

- **$strict:** `TRUE` check the type of *$needle* in *$haystack*. `FALSE` default.

#### examples:
```php
//array
$arr = [
  'one' => [
    'subone' => ['ok', 'not'],
    'list'
  ],
  'two' => 154,
  'three' => 'ok'
];


//example 1 (default)
in_array_recursive('Ok', $arr) //result false
in_array_recursive(['Ok', 'list'], $arr) //result false

//example 2 (Check case-insensitive string comparison)
in_array_recursive(['Ok', '154'], $arr,true) //result true
in_array_recursive('Ok', $arr,true) //result true

//example 3 (Check case-insensitive string comparison and check the value type)
in_array_recursive(['Ok', '154'], $arr, true, true) //result false  .  Because the $needle = (string) '154' is different than (number)154 found.

//example 4 (check the value type)
in_array_recursive(['Ok', 154], $arr, false, true) //result false  .  Because the $needle = (string)'Ok' is different than (string)'ok' found. 

//example 4 (check the value type)
in_array_recursive(154, $arr, false, true) //result true
```
