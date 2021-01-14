<a href="https://github.com/MunnaAhmed/ShoppingCart/issues"><img src="https://img.shields.io/github/issues/MunnaAhmed/ShoppingCart"><a/>
<a href="https://github.com/MunnaAhmed/ShoppingCart/network/members"><img src="https://img.shields.io/github/forks/MunnaAhmed/ShoppingCart"><a/>
<a href="https://github.com/MunnaAhmed/ShoppingCart/stargazers"><img src="https://img.shields.io/github/stars/MunnaAhmed/ShoppingCart"><a/>
<a href="https://packagist.org/packages/munna/shopping-cart"><img src="https://img.shields.io/github/license/MunnaAhmed/ShoppingCart"><a/>


# Laravel Shopping Cart
More flexible and easy cart system compatible with Laravel version 5.6, 5.7, 5.8, 6, 7 and 8.

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

// 1st Example
$cart = new Cart('whishlist');
// Example 
return $cart->info();


// 2nd Example
Cart::init('whishlist');
// Example 
$cart = Cart::info();
return $cart;
```



## Add Cart 
### Cart::add() or $cart->add()

```php
// You must maintaince these parameter value

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
$cart->add($product_id, $product_name, $product_qty, $product_price, $product_weight = 0, $product_thumb = null, $discount = 0, $shipping_charge = 0, $tax = 0, $product_info = []);

// 2nd example
Cart::add($product_id, $product_name, $product_qty, $product_price, $product_weight = 0, $product_thumb = null, $discount = 0, $shipping_charge = 0, $tax = 0, $product_info = []);
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


## Update Cart 
### Cart::update() or $cart->update()

```php
// You must maintaince these parameter value

// Require Fields
$uid  = "You uid Id", // Required  // Like as something 82qdiieeqvl0wftwyv7b1cfhidi4ry6k
$quantity = 3; // Required

// 1st example
$cart = new Cart();
$cart->update($uid, $quantity);


// 2nd example
Cart::update($uid, $quantity);
```

After successful you will get this on return 

```json 
{
    "status": true,
    "message": "Product Has Been Updated",
    "instance": "shopping-cart",
    "uid": "82qdiieeqvl0wftwyv7b1cfhidi4ry6k"
}
```


## Remove Cart 
### Cart::remove() or $cart->remove()

```php
// You must maintaince these parameter value

// Require Fields
$uid  = "You uid Id", // Required  // Like as something m1ueddkrrayhkwi4prtjvxfyoytjmxpz

// 1st example
$cart = new Cart();
$cart->remove($uid);


// 2nd example
Cart::remove($uid);
```

After successful you will get this on return 

```json 
{
    "status": true,
    "message": "Product Has Been Removed",
    "instance": "shopping-cart",
    "uid": "82qdiieeqvl0wftwyv7b1cfhidi4ry6k"
}
```



## Search / Get Cart 
### Cart::search() or $cart->search() or Cart::get() or $cart->get()

```php
// You must maintaince these parameter value

// Require Fields
$uid  = "You uid Id", // Required  // Like as something m1ueddkrrayhkwi4prtjvxfyoytjmxpz

// 1st example
$cart = new Cart();
$cart->search($uid);
$cart->get($uid);


// 2nd example
Cart::search($uid);
Cart::get($uid);
```

After successful you will get this on return 

```json 
{
    "status": true,
    "message": "Product Item Found",
    "instance": "shopping-cart",
    "uid": "dsnufjalsd6cgohogi2aw3dyljb3y3kf",
    "product": 6,
    "name": "Product 6",
    "price": 80.5,
    "qty": 1,
    "weight": 0,
    "discount": 0,
    "tax": 0,
    "shipping": 0,
    "thumb": null,
    "options": [],
    "subtotal": "80.50",
    "total": "80.50",
    "created_at": "2021-01-14T22:44:33.411759Z",
    "updated_at": null
}
```


## Clear / Destroy
### Cart::clear() or $cart->clear()

```php
// 1st example
$cart = new Cart();
$cart->clear();

// 2nd example
Cart::clear();
```

After successful you will get this on return 

```json 
{
    "status": true,
    "message": "Cart items has been cleared"
}
```


# Calucation Part


## Cart Total
### Cart::total() or $cart->total()

```php
// 1st example
$cart = new Cart();
$cart->total();

// 2nd example
Cart::total();
```

## Cart Subtotal
### Cart::subtotal() or $cart->subtotal()

```php
// 1st example
$cart = new Cart();
$cart->subtotal();

// 2nd example
Cart::subtotal();
```


## Cart Discount
### Cart::discount() or $cart->discount()

```php
// 1st example
$cart = new Cart();
$cart->discount();

// 2nd example
Cart::discount();
```


## Cart shipping
### Cart::shipping() or $cart->shipping()

```php
// 1st example
$cart = new Cart();
$cart->shipping();

// 2nd example
Cart::shipping();
```


## Cart tax
### Cart::tax() or $cart->tax()

```php
// 1st example
$cart = new Cart();
$cart->tax();

// 2nd example
Cart::tax();
```


## Cart count
### Cart::count() or $cart->count()

```php
// 1st example
$cart = new Cart();
$cart->count();

// 2nd example
Cart::count();
```


## Cart Items
### Cart::items() or $cart->items()

```php
// 1st example
$cart = new Cart();
$cart->items();

// 2nd example
Cart::items();

// items() methos support a parameter that can able to sorted your cart item by ascending
// You can sort your item by price, total, subtotal, product name or any key that exists.

// Example

Cart::item('price');
// or
Cart::item('name');
// or
Cart::item('qty');
// or 
Cart::item('total')  //etc
```

Look like as

```json
[
    {
        "uid": "h6zc3duk5cqu69y5tcof0u01iwx47tyy",
        "product": 6,
        "name": "Product 6",
        "price": 80.5,
        "qty": 1,
        "weight": 0,
        "discount": 0,
        "tax": 0,
        "shipping": 0,
        "thumb": null,
        "options": [],
        "subtotal": "80.50",
        "total": "80.50",
        "created_at": "2021-01-14T23:00:14.590324Z",
        "updated_at": null
    },
    {
        "uid": "iafu81ochafwyeehpkviy5s7dwdsogbf",
        "product": 1,
        "name": "Product 1",
        "price": 80.5,
        "qty": 1,
        "weight": 0,
        "discount": 0,
        "tax": 0,
        "shipping": 0,
        "thumb": null,
        "options": [],
        "subtotal": "80.50",
        "total": "80.50",
        "created_at": "2021-01-14T23:00:23.505786Z",
        "updated_at": null
    },
    {
        "uid": "hrkzcpyxxkjup4hxz1td86yhhbyyq71g",
        "product": 2,
        "name": "Product 2",
        "price": 100,
        "qty": 3,
        "weight": 0,
        "discount": 0,
        "tax": 0,
        "shipping": 0,
        "thumb": null,
        "options": [],
        "subtotal": "300.00",
        "total": "300.00",
        "created_at": "2021-01-14T23:00:34.813746Z",
        "updated_at": null
    }
]
```



## Cart Info
### Cart::info() or $cart->info()
### Provide all qurey like total(), subtotal(), tax(), discount(), count() and others

```php
// 1st example
$cart = new Cart();
$cart->info();

// 2nd example
Cart::info();

// info() methos support a parameter that can able to sorted your cart item by ascending
// You can sort your item by price, total, subtotal, product name or any key that exists.

// Example
Cart::info('price');
// or
Cart::info('name');
// or
Cart::info('qty');
// or 
Cart::info('total')  //etc
```

Like as

```json
{
    "instance": "shopping-cart",
    "count": 3,
    "shipping": "0.00",
    "discount": "0.00",
    "tax": "0.00",
    "subtotal": "461.00",
    "total": "461.00",
    "items": [
        {
            "uid": "h6zc3duk5cqu69y5tcof0u01iwx47tyy",
            "product": 6,
            "name": "Product 6",
            "price": 80.5,
            "qty": 1,
            "weight": 0,
            "discount": 0,
            "tax": 0,
            "shipping": 0,
            "thumb": null,
            "options": [],
            "subtotal": "80.50",
            "total": "80.50",
            "created_at": "2021-01-14T23:00:14.590324Z",
            "updated_at": null
        },
        {
            "uid": "iafu81ochafwyeehpkviy5s7dwdsogbf",
            "product": 1,
            "name": "Product 1",
            "price": 80.5,
            "qty": 1,
            "weight": 0,
            "discount": 0,
            "tax": 0,
            "shipping": 0,
            "thumb": null,
            "options": [],
            "subtotal": "80.50",
            "total": "80.50",
            "created_at": "2021-01-14T23:00:23.505786Z",
            "updated_at": null
        },
        {
            "uid": "hrkzcpyxxkjup4hxz1td86yhhbyyq71g",
            "product": 2,
            "name": "Product 2",
            "price": 100,
            "qty": 3,
            "weight": 0,
            "discount": 0,
            "tax": 0,
            "shipping": 0,
            "thumb": null,
            "options": [],
            "subtotal": "300.00",
            "total": "300.00",
            "created_at": "2021-01-14T23:00:34.813746Z",
            "updated_at": null
        }
    ]
}
```


## License
This package is open-sources and licensed under the [MIT license](https://opensource.org/licenses/MIT).
Thank you very much. Please give a star if you love it and suggest me better.