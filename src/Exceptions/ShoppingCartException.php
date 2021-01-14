<?php 

namespace Munna\ShoppingCart\Exceptions;
use Exception;

class ShoppingCartException extends Exception{

    // exception message 
    public $message;

    public function __construct($message){
        // Exception Message Init
        $this->message = $message;
    }

    public function report(){
        // Exception Report
    }

    public function render($report){
        // Rendering the message
        return response()->json(['status' => false, 'message' => $this->message]);
    }

}