<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use QrCode;
use Validator;
use Session;
use DB;
use Auth;

class QrCodeController extends Controller
{
    public $UserObj;

    public function __construct()
    {
        $this->UserObj = new User();
    }
    public function GenerateQrcode()
    {
        $slug = substr(md5(time()), 0, 16);
        $link = url('scan-qrcode/'.$slug);
        $qr_code = QrCode::size(200)->generate($link);
        // $image = QrCode::SMS('123-456-7890', 'Message Body');
        // return response($image)->header('Content-type','image/png');
        // $test = QrCode::generate("string");

        $posted_data = array();
        $posted_data['update_id'] = Auth::user()->id;
        $posted_data['slug'] = $slug;
        $this->UserObj->saveUpdateUser($posted_data);

        // echo '<pre>';
        // print_r($qr_code);
        // print_r($link);
        // exit;
        return view('generate_qrcode', compact('qr_code'), compact('link'));
    }


    public function GenerateQrcodewhatsapp($id = 0)
    {

        if($id == 0){
            $phone_no = Auth::user()->phone_no;
        }else{
            $posted_data = array();
            $posted_data['id'] = $id;
            $posted_data['detail'] = true;
            $user_detail = $this->UserObj->getUser($posted_data);
            $phone_no = $user_detail->phone_no;
        }

        // $url = "https://messages-sandbox.nexmo.com/v0.1/messages";
        // $params = ["to" => ["type" => "whatsapp", "number" => '03475155411'],
        //     "from" => ["type" => "whatsapp", "number" => "03475155411"],
        //     "message" => [
        //         "content" => [
        //             "type" => "text",
        //             "text" => "Hello from Vonage and Laravel :) Please reply to this message with a number between 1 and 100"
        //         ]
        //     ]
        // ];
        // // $headers = ["Authorization" => "Basic " . base64_encode(env('NEXMO_API_KEY') . ":" . env('NEXMO_API_SECRET'))];
        // $headers = ["Authorization" => "Basic " . base64_encode('c3102bb3' . ":" . 'eS6ZORRhGmUIH8Vm')];

        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('POST', $url, ["headers" => $headers, "json" => $params]);
        // $data = $response->getBody();
        // Log::Info($data);

        // return view('thanks');
        // exit;
        
        $type       = 'png';
        $headers    = array('Content-Type' => ['png']);
        // $image = QrCode::format($type)->SMS($phone_no, 'Hi');
        // $image = QrCode::size(200)->SMS($phone_no, 'Hi');
        // $image = QrCode::size(200)->generate('https://wa.me/+92-304-6599894');
        // $image = QrCode::size(200)->generate('https://wa.me/+49-30-261755895');
        $image = QrCode::size(200)->generate('https://wa.me/'.$phone_no.'?text=Hi');

        $imageName = 'qr-code';

        \Storage::disk('public')->put($imageName, $image);

        // $link = $_SERVER['REQUEST_URI'];
        // $link = $link.'/storage/'.$imageName;
            $base_url = public_path();
        $link = $base_url.'/storage/'.$imageName;

        // echo '<pre>';
        // print_r($link);
        // exit;
        return response()->download($link, $imageName, $headers);
        // return response()->download('storage/'.$imageName, $imageName, $headers);
        // return response()->download('storage/'.$imageName, $imageName.'.'.$type, $headers);

        // exit;
        // $qr_code = QrCode::SMS('123-456-7890', 'Message Body');
        // return response($qr_code)->header('Content-type','image/png');

        // echo '<pre>';
        // print_r($qr_code);
        // exit;
    }

    
    public function ScanQrcode($slug)
    {
        $posted_data = array();
        $posted_data['slug'] = $slug;
        $posted_data['detail'] = true;
        $user_detail = $this->UserObj->getUser($posted_data);

        // if($user_detail){
        //     echo 'Qr code is correct';
        // }else{
        //     echo 'Qr code has been expired';
        // }
        return view('scan_qrcode', compact('user_detail'));
        // echo '<pre>';
        // print_r($slug);
        // exit;
    }

    
}