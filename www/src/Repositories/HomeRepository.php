<?php 

namespace App\Repositories;

class HomeRepository 
{ 
    public function message()
    {
        return [
            "author"  => "Eric Neves <github.com/ericneves>",
            "message" => "Welcome to the API. 🚀"
        ];
    }
}