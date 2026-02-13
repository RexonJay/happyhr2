<?php

namespace App\Controllers;

use Endroid\QrCode\Builder\Builder;
use CodeIgniter\HTTP\ResponseInterface;

class Qrcode extends BaseController
{

    public function getIndex($QRCodeText = null)
    {
        // Accept text either as a URI segment or a GET param named 'text'
        // $QRCodeText = func_num_args() ? func_get_arg(0) : null;
        // $QRCodeText = 1234;
        if (empty($QRCodeText)) {
            $QRCodeText = $this->request->getGet('text');
        }

        if (empty($QRCodeText)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('No QR text provided');
        }

        // Make sure QR text is properly formatted
        $text = 'http://hrmdo.gensantos.gov.ph/index.php/LeaveValidation/check/' . $QRCodeText;

        // Build QR code using endroid/qr-code
        $result = Builder::create()
            ->data($text)
            ->size(300)
            ->margin(10)
            ->build();

        // Return PNG bytes with proper content type
        return $this->response->setStatusCode(ResponseInterface::HTTP_OK)
            ->setHeader('Content-Type', 'image/png')
            ->setBody($result->getString());
    }

}