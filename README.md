<a href="https://github.com/MunnaAhmed/ShoppingCart/issues"><img src="https://img.shields.io/github/issues/MunnaAhmed/ShoppingCart"><a/>
<a href="https://github.com/MunnaAhmed/ShoppingCart/network/members"><img src="https://img.shields.io/github/forks/MunnaAhmed/ShoppingCart"><a/>
<a href="https://github.com/MunnaAhmed/ShoppingCart/stargazers"><img src="https://img.shields.io/github/stars/MunnaAhmed/ShoppingCart"><a/>
<a href="https://packagist.org/packages/munna/shopping-cart"><img src="https://img.shields.io/github/license/MunnaAhmed/ShoppingCart"><a/>


# Laravel Shopping Cart
Tracking location info by ip address.

## Installing Shopping Cart

Next, run the Composer command to install the latest stable version:

```bash
composer require munna/shopping-cart
```

## Create A Class Instance

munna\shopping-cart provide two type of instances. You can call the Cart class directly as static class or you can create class object. 

### First we check how to create a class object instance 

```php
// Use this as namespace
use Munna\ShoppingCart\Cart;

// call the cart class
// as a parameter we can pass the instance name.
// default instance is = shopping-cart
// you can use any of instance as you like
$cart = new Cart();
// Example 
$info = $cart->info();
// You will get all info about your default instance like as bellow
return $info;
```
as a json return look like

```json
{
    "instance": "shopping-cart",
    "count": 0,
    "shipping": 0,
    "discount": 0,
    "tax": 0,
    "subtotal": 0,
    "total": 0,
    "items": []
}
```


## License
This package is open-sources and licensed under the [MIT license](https://opensource.org/licenses/MIT).
Thank you very much. Please give a star if you love it and suggest me better.