<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use QrCode;

class QrCodeController extends Controller
{
    public function index()
    {
        // $image = QrCode::size(200)->generate('https://www.facebook.com/vizzwebsolutions/photos/a.4800348883358860/4808672125859869');
        $image = QrCode::SMS('123-456-7890', 'Message Body');
        // return response($image)->header('Content-type','image/png');
        // $test = QrCode::generate("string");

        echo '<pre>';
        print_r($image);
        exit;
    }
}