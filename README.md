<a href="https://github.com/MunnaAhmed/ShoppingCart/issues"><img src="https://img.shields.io/github/issues/MunnaAhmed/ShoppingCart"><a/>
<a href="https://github.com/MunnaAhmed/ShoppingCart/network/members"><img src="https://img.shields.io/github/forks/MunnaAhmed/ShoppingCart"><a/>
<a href="https://github.com/MunnaAhmed/ShoppingCart/stargazers"><img src="https://img.shields.io/github/stars/MunnaAhmed/ShoppingCart"><a/>
<a href="https://packagist.org/packages/munna/shopping-cart"><img src="https://img.shields.io/github/license/MunnaAhmed/ShoppingCart"><a/>


# Laravel Shopping Cart
More flexible and easy cart system.

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
// you can use any of instances name as you like
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


### Second we check how to create a static class instance 

```php
// Use this as namespace
use Munna\ShoppingCart\Facades\Cart;

// init the cart class by calling init() method
// as a parameter we can pass the instance name into the init() method.
// default instance is = shopping-cart
// you can use any of instances name as you like

$cart = Cart::init();
// Example 
return Cart::info();

// If you want to use this globally as static class, then just add this line 
// at your config/app.php into aliases array
'Cart' => Munna\ShoppingCart\Facades\Cart::class,

// You will get all info about your default instance like as bellow
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


## How can we use instance 

```php
// default instance = shoppint-cart
$cart = Cart::init('whishlist');
// Example 
return Cart::info();
// Then all whishlist cart items you will be get. We discuss this matter below.
```



## Add Cart 
### Cart::add() or $cart->add()

```php
// You must main the parameter value
// Require Fields
$product_id  = "You product Id", // Required
$product_name = "Product Name", // Required
$product_qty = "Product Quantity", // Required
$product_price = "Product Price", // Required

// Optional Fields
$product_weight = 0, // Optional
$product_thumb = null, // Optional
$discount = 0, // Optional
$shipping_charge = 0, // Optional
$tax = 0, // Optional
$product_info = [];// Optional


// 1st example
$cart = new Cart();
$cart->add($unique_id, $product_name, $product_qty, $product_price, $product_weight = 0, $product_thumb = null, $discount = 0, $shipping_charge = 0, $tax = 0, $product_info = []);

// 2nd example
Cart::add($unique_id, $product_name, $product_qty, $product_price, $product_weight = 0, $product_thumb = null, $discount = 0, $shipping_charge = 0, $tax = 0, $product_info = []);
```

After successful you will get this on return 

```json 
{
    "status": true,
    "message": "Product Has Been Added To Shopping Cart",
    "instance": "shopping-cart",
    "uid": "82qdiieeqvl0wftwyv7b1cfhidi4ry6k"
}
```



## License
This package is open-sources and licensed under the [MIT license](https://opensource.org/licenses/MIT).
Thank you very much. Please give a star if you love it and suggest me better.