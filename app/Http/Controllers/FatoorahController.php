<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\services\FatoorahServices;


class FatoorahController extends Controller
{
  public $fatoorahServices;
    public function __construct(FatoorahServices $fatoorahServices) {
        $this->fatoorahServices = $fatoorahServices;
        $mfConfig = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
    }

    public function paymentCallback()
    {
        dd(request());
    //  $data=[];
    //  $data['key']=$request->paymentId;
    //  $data['keyType']='paymentId';

    //  $this->fatoorahServices->getPaymentStatus($data);
    }
}
