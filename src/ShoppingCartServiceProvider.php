<?php 

namespace Munna\ShoppingCart;

use Illuminate\Support\ServiceProvider;

class ShoppingCartServiceProvider extends ServiceProvider{

    public function register(){
        $this->app->bind('munna-shopping-cart', function($app){
            return new Cart();
        });
    }

    public function boot(){

    }
}