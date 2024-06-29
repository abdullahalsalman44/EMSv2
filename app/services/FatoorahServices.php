<?php

namespace app\services;

use App\Models\Reservation;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;

class FatoorahServices
{


    public function sendPayment($reservation_id, $totalBill, $myConfig)
    {
        $reservation = Reservation::query()->find($reservation_id);

        $clientName = $reservation->clients->name;
        $clentEmail = $reservation->clients->email;

        $invoiceData = [
            'CustomerReference' => $reservation->id, //  رقم  فريد  لل  فاتورة
            'InvoiceValue' => $totalBill,
            'CustomerName' => $clientName,
            'CustomerEmail' => $clentEmail,
            'NotificationOption' => 'Lnk',
            'CallBackUrl' => route('myfatoorah.callback')
            //  ...  مُ  لء  ال  attributes  الأخرى  ...
        ];
        $mfObj   = new MyFatoorahPayment($myConfig);
        $paymentUrl = $mfObj->getInvoiceURL($invoiceData);

        return $paymentUrl;
    }



}
