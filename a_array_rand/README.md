### a_array_rand

*Alternative Array Rand*

base: [function.array-rand](http://php.net/manual/function.array-rand.php)

```php
array function a_array_rand(array $array , int $limit = 1 [ , bool $preserve_keys = false ] )
```

Pick one or more random entries out of an array. A number of repeats is less than array_rand.

**features:**

- Possibility preserve keys
- A number of repeats is less than `array_rand()` . In a loop of 1000, `array_rand()` has more repeats compared to `a_array_rand()`


#### parameters:
- **$array:** The Array

- **$limit:** Specifies how many entries should be picked.

- **$preserve_keys:** `TRUE` preserve keys. `FALSE` default.

#### examples:
```php
//array
$arr = [
	'type' => 2,
	5,
	6,
	154,
	39,
	'test' => 'Okay'
];



//example 1 (default)
a_array_rand($arr, 3);
//result
array (size=3)
  0 => int 6
  1 => int 39
  2 => string 'Okay' (length=4)


//example 2 (preserve keys)
a_array_rand($arr, 3, true);
//result
array (size=3)
  3 => int 39
  0 => int 5
  'type' => int 2
```
