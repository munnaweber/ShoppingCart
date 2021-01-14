<?php
namespace Munna\ShoppingCart;
use Str;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Munna\ShoppingCart\Exceptions\ShoppingCartException;

class Cart{

    // instant
    public $instance = "shopping-cart";

    // cart items
    public $items;

    // initial shipping_chart
    public $shpping_charge = 0.00;

    // Initial Tax
    public $tax = 0.00;

    // Init Cart 
    public function __construct($instance = null){
        $this->instance = $instance ?: $this->instance;
    }
   
   
    // Init Cart Instanc
    public function init($instance = null){
        $this->instance = $instance ?: $this->instance;
    }

    // Init Cart Instance For Different Usase
    public function instance($instance = null){
        if(!$instance){
            $instance = $this->instance;
        }
        $cart_items = $this->cart_session($instance);
        $this->items = $cart_items;
        $cartInfo = $this->cartInfo($cart_items, $instance);
        return response()->json([
            "instance" => $cartInfo['instance'],
            "count" => $cartInfo['count'],
            "shipping" => $cartInfo['shipping'],
            "discount" => $cartInfo['discount'],
            "tax" => $cartInfo['tax'],
            "subtotal" => $cartInfo['subtotal'],
            "total" => $cartInfo['total'],
            'items' => $this->items
        ]);  
    }

    public function items($sortedBy = null){
        $instance = $this->instance;
        $cart_items = $this->cart_session($instance);
        $this->items = $cart_items;
        if($sortedBy){
            $sorted = array_values(Arr::sort($cart_items, function ($value)  use ($sortedBy) {
                return $value[$sortedBy];
            }));  
            return response()->json($sorted);
        }
        return response()->json($this->items);
        // return $this->items;
    }
   
    public function info($sortedBy = null){
        $instance = $this->instance;
        $cart_items = $this->cart_session($instance);
        $this->items = $cart_items;
        if($sortedBy){
            $sorted = array_values(Arr::sort($cart_items, function ($value)  use ($sortedBy) {
                return $value[$sortedBy];
            }));  
            return response()->json($sorted);
        }
        $cartInfo = $this->cartInfo($cart_items, $instance);
        return response()->json([
            "instance" => $cartInfo['instance'],
            "count" => $cartInfo['count'],
            "shipping" => $cartInfo['shipping'],
            "discount" => $cartInfo['discount'],
            "tax" => $cartInfo['tax'],
            "subtotal" => $cartInfo['subtotal'],
            "total" => $cartInfo['total'],
            'items' => $this->items
        ]);
        // return $this->items;
    }
    
    public function add($unique_id, $product_name, $product_qty, $product_price, $product_weight = 0, $product_thumb = null, $discount = 0, $shipping_charge = 0, $tax = 0, $product_info = []){
        if(!$unique_id || !$product_name || !$product_qty || !$product_price){
            throw new ShoppingCartException("Please provide all required fields");
        }
        $product_price = $this->number($product_price);
        $product_qty = $this->number($product_qty);
        $product_weight = $this->number($product_weight);
        $discount = $this->number($discount);
        $shipping_charge = $this->number($shipping_charge);
        $get_session = "munna_shopping_cart_".$this->instance;
        $cart = $this->cart_session($this->instance);
        $tax = $tax == 0 ? $this->tax : $tax;
        $shipping = $shipping_charge == 0 ? $this->shpping_charge : $shipping_charge;
        $oldfound = false;
        $cart_content = $cart;
        $new_cart_item = [];
        $uid = strtolower(Str::random(32));
        if(count($cart) > 0){
            $cart_content = [];
            foreach($cart as $item){
                $get_new_item = $item;
                if($item['product'] == $unique_id){
                    $uid = $item['uid'];
                    $newqty = round($item['qty'] + $product_qty);
                    $calc = $this->calculate_price($product_price, $newqty, $discount, $tax, $shipping);
                    $cart_array = [
                        'uid' => $item['uid'],
                        'product' => $unique_id,
                        'name' => $product_name,
                        'price' => $product_price,
                        'qty' => $newqty,
                        'weight' => $product_weight,
                        'discount' => $discount,
                        'tax' => $tax,
                        'shipping' => $shipping,
                        'thumb' => $product_thumb,
                        'options' => $product_info,
                        'subtotal' => $calc["subtotal"],
                        'total' => $calc["total"],
                        'created_at' => $item['created_at'],
                        'updated_at' => Carbon::now(),
                    ];
                    $new_cart_item = $cart_array;
                    $oldfound = true;
                    $get_new_item = $cart_array;
                }
                array_push($cart_content, $get_new_item);
            }
        }
        if($oldfound == false){
            $calc = $this->calculate_price($product_price, $product_qty, $discount, $tax, $shipping);
            $new_cart_item = [
                'uid' => $uid,
                'product' => $unique_id,
                'name' => $product_name,
                'price' => $product_price,
                'qty' => $product_qty,
                'weight' => $product_weight,
                'discount' => $discount,
                'tax' => $tax,
                'shipping' => $shipping,
                'thumb' => $product_thumb,
                'options' => $product_info,
                'subtotal' => $calc["subtotal"],
                'total' => $calc["total"],
                'created_at' => Carbon::now(),
                'updated_at' => null,
            ];
            array_push($cart_content, $new_cart_item);        
        }        
        Session::put($get_session, $cart_content);
        return response()->json([
            'status' => true,
            'message' => "Product Has Been Added To Shopping Cart",
            'instance' => $this->instance,
            'uid' => $uid
        ]);
    }
    
    public function update($unique_id, $product_qty){
        if(!$unique_id || !$product_qty){
            throw new ShoppingCartException("Please provide all required fields");
        }        
        $product_qty = $this->number($product_qty);
        $get_session = "munna_shopping_cart_".$this->instance;
        $cart = Session::get($get_session) ?: [];        
        $cart_content = $cart;
        $find = false;

        if(count($cart) > 0){
            $cart_content = [];
            foreach($cart as $item){
                $get_new_item = $item;
                if($item['uid'] == $unique_id){
                    $find = true;
                    $newqty = $product_qty;
                    $product_weight = $item['weight'];
                    $discount = $item['discount'];
                    $tax = $item['tax'];
                    $shipping = $item['shipping'];
                    $price = $item['price'];
                    $calc = $this->calculate_price($price, $newqty, $discount, $tax, $shipping);
                    $cart_array = [
                        'uid' => $item['uid'],
                        'product' => $item['product'],
                        'name' => $item['name'],
                        'price' => $price,
                        'qty' => $newqty,
                        'weight' => $item['weight'],
                        'discount' => $item['discount'],
                        'tax' => $tax,
                        'shipping' => $shipping,
                        'thumb' => $item['thumb'],
                        'options' => $item['options'],
                        'subtotal' => $calc["subtotal"],
                        'total' => $calc["total"],
                        'created_at' => $item['created_at'],
                        'updated_at' => Carbon::now(),
                    ];
                    $get_new_item = $cart_array;
                }
                array_push($cart_content, $get_new_item);
            }
        }

        if($find == false){
            throw new ShoppingCartException($unique_id." is invalid or not found");
        }

        Session::put($get_session, $cart_content);
        return response()->json([
            'status' => true,
            'message' => "Product Has Been Updated",
            'instance' => $this->instance,
            'uid' => $unique_id
        ]);
    }


    public function remove($unique_id){
        if(!$unique_id){
            throw new ShoppingCartException("Please provide valid an unique_id");
        }
        $get_session = "munna_shopping_cart_".$this->instance;
        $cart = Session::get($get_session) ?: [];        
        $cart_content = $cart;
        $find = false;
        if(count($cart) > 0){
            $cart_content = [];
            foreach($cart as $item){
                $get_new_item = $item;
                if($item['uid'] == $unique_id){
                    $find = true;                    
                }else{
                    array_push($cart_content, $get_new_item);
                }
            }
        }
        if($find == false){
            throw new ShoppingCartException($unique_id." is invalid or not found");
        }
        Session::put($get_session, $cart_content);
        return response()->json([
            'status' => true,
            'message' => "Product Has Been Removed",
            'instance' => $this->instance,
            'uid' => $unique_id
        ]);
    }
    
    public function search($unique_id){
        if(!$unique_id){
            throw new ShoppingCartException("Please provide all required fields");
        } 
        $find = false;
        $cart_item = [];
        $get_session = "munna_shopping_cart_".$this->instance;
        $cart = Session::get($get_session) ?: [];
        if(count($cart) > 0){
            foreach($cart as $item){
                if($item['uid'] == $unique_id){
                    $find = true;
                    $cart_item = $item;
                    break;
                }
            }
        }
        if($find == false){
            throw new ShoppingCartException($unique_id." is invalid or not found");
        }
        $mssage = [
            'status' => true,
            'message' => "Product Item Found",
            'instance' => $this->instance,
        ];
        $new_array = array_merge($mssage, $cart_item);
        return response()->json($new_array);
    }
    
    public function get($unique_id){
        if(!$unique_id){
            throw new ShoppingCartException("Please provide all required fields");
        } 
        $find = false;
        $cart_item = [];
        $get_session = "munna_shopping_cart_".$this->instance;
        $cart = Session::get($get_session) ?: [];
        if(count($cart) > 0){
            foreach($cart as $item){
                if($item['uid'] == $unique_id){
                    $find = true;
                    $cart_item = $item;
                    break;
                }
            }
        }
        if($find == false){
            throw new ShoppingCartException($unique_id." is invalid or not found");
        }
        $mssage = [
            'status' => true,
            'message' => "Product Item Found",
            'instance' => $this->instance,
        ];
        $new_array = array_merge($mssage, $cart_item);
        return response()->json($new_array);
    }

    protected function calculate_price($product_price, $product_qty, $discount, $tax, $shipping){
        $subtotal = bcmul($product_price, $product_qty, 2);
        $withdiscount = bcadd($subtotal, $discount, 4);
        $withtax = bcadd($withdiscount, $tax, 4);
        $withshipping= bcadd($withtax, $shipping, 4);
        $total= bcadd($withshipping, 0, 2);
        return [
            'total' => $total,
            'subtotal' => $subtotal,
        ];
    }

    protected function number($value){
        $gettype = gettype($value);
        if($gettype == "integer" || $gettype == "double"){
            return $value;
        }elseif($gettype == "string"){
            if(is_numeric($value)){
                return (float) $value;                
            }else{
                throw new ShoppingCartException("Please use a valid number not string");
            }
        }else{
            throw new ShoppingCartException("Please use a valid number.");
        }
    }

    protected function cart_session($instance){
        $get_session = "munna_shopping_cart_".$instance;
        $cart = Session::get($get_session);
        // Session::forget($get_session);
        // return;
        if(!$cart){
            Session::put("munna_shopping_cart", time());
            Session::put($get_session);
        }
        $cart = Session::get($get_session) ?: [];
        return $cart;
    }

    public function clear(){
        $instance = $this->instance;
        $get_session = "munna_shopping_cart_".$instance;
        $cart = Session::get($get_session);
        if($cart){
            Session::forget($get_session);
            $message = "Cart items has been cleared";
        }else{
            $message = "You've no items into the cart";
        }
        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function sortBy($sortedBy){
        if(!$sortedBy){
            throw new ShoppingCartException("Please provide sorted by value");
        }
        $cart_items = $this->cart_session($this->instance);
        $sorted = array_values(Arr::sort($cart_items, function ($value)  use ($sortedBy) {
            return $value[$sortedBy];
        }));
        return response()->json($sorted);
    }
   
    public function total(){
        $cart_items = $this->cart_session($this->instance);
        // $onlyprice = Arr::pluck($cart_items, 'price');
        // $total = array_sum($onlyprice);
        $total = 0;
        foreach($cart_items as $show){
            $total = bcadd($total, $show['total'], 2);
        }
        return $total;
    }
    
    public function cartInfo($cart, $instance){
        $total = 0;
        $tax = 0;
        $shipping = 0;
        $subtotal = 0;
        $discount = 0;

        foreach($cart as $show){
            $total = bcadd($total, $show['total'], 2);
            $tax = bcadd($tax, $show['tax'], 2);
            $shipping = bcadd($shipping, $show['shipping'], 2);
            $subtotal = bcadd($subtotal, $show['subtotal'], 2);
            $discount = bcadd($discount, $show['discount'], 2);
        }

        return [
            "instance" => $instance,
            "count" => count($cart),
            "shipping" => $shipping,
            "discount" => $discount,
            "tax" => $tax,
            "subtotal" => $subtotal,
            "total" => $total,
        ];
    }
    
    public function subtotal(){
        $cart_items = $this->cart_session($this->instance);
        // $onlyprice = Arr::pluck($cart_items, 'price');
        // $total = array_sum($onlyprice);
        $total = 0;
        foreach($cart_items as $show){
            $total = bcadd($total, $show['subtotal'], 2);
        }
        return $total;
    }
    
    public function tax(){
        $cart_items = $this->cart_session($this->instance);
        // $onlyprice = Arr::pluck($cart_items, 'price');
        // $total = array_sum($onlyprice);
        $total = 0;
        foreach($cart_items as $show){
            $total = bcadd($total, $show['tax'], 2);
        }
        return $total;
    }
   
    public function shipping(){
        $cart_items = $this->cart_session($this->instance);
        // $onlyprice = Arr::pluck($cart_items, 'price');
        // $total = array_sum($onlyprice);
        $total = 0;
        foreach($cart_items as $show){
            $total = bcadd($total, $show['shipping'], 2);
        }
        return $total;
    }
    
    public function discount(){
        $cart_items = $this->cart_session($this->instance);
        // $onlyprice = Arr::pluck($cart_items, 'price');
        // $total = array_sum($onlyprice);
        $total = 0;
        foreach($cart_items as $show){
            $total = bcadd($total, $show['discount'], 2);
        }
        return $total;
    }
    
    public function count(){
        $cart_items = $this->cart_session($this->instance);
        return count($cart_items);
    }
}