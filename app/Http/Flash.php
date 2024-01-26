<?php

namespace App\Http;

class Flash {

public function message($type, $title, $message)
{
    session()->flash('flash_message', [
        'type'      => $type,
        'title'     => $title, 
        'message'   => $message
    ]);
}   
}



?>
