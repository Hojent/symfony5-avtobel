<?php

namespace App\Message;

final class ClearBadUserMessage
{
    /*
     * Add whatever properties and methods you need
     * to hold the data for this message class.
     */

     private $email;

     public function __construct(string $email)
     {
         $this->email = $email;
     }

    public function getEmail(): string
    {
        return $this->email;
    }
}
