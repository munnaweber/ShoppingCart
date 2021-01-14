<?php 
namespace Munna\ShoppingCart\Facades;

use Illuminate\Support\Facades\Facade;

class Cart extends Facade{

    public static function getFacadeAccessor(){
        return 'munna-shopping-cart';
    }

}