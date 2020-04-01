<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('req')) {
    function req(){
        return  
        ' data-bv-notempty
          data-bv-notempty-message="Campo Obligatorio *" ';
    }
}
