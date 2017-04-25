# My Useful functions Alternatives PHP

### array_map_recursive [](#array_map_recursive)

```php

array array_map_recursive(callback|array $callback, array $array, bool $alsoTheKey=false)
```

**features:**

- Possible to use more than one callback (callback array);
- When set `$alsoTheKey = true`, it will be possible to use the callback function in the key.


#### parameters
**$callback**

Callback function (or multi callback function - array) to run for each element in each array.

**$array**

An array to run through the callback function.

**$alsoTheKey**
`TRUE` to run for each key also. `FALSE` default.