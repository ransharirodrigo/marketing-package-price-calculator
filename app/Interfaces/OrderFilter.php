<?php

namespace App\Interfaces;

interface OrderFilter {

    function apply($query , $value);

}