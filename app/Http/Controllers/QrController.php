<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    /**
     * Display QR code for the public menu page.
     */
    public function menu()
    {
        $ip = '192.168.0.113'; // Update if your machine's IP changes
        $url = "http://{$ip}:8000/menu";

        return view('public.qr.menu', [
            'qr' => QrCode::format('svg')->size(300)->margin(2)->generate($url),
            'link' => $url,
        ]);
    }

    /**
     * Generate and download QR code as SVG.
     */
    public function menuSvg()
    {
        $ip = '192.168.0.113'; // Match above
        $url = "http://{$ip}:8000/menu";

        $filename = 'menu-qr.svg';
        $path = public_path("qr/{$filename}");

        // Create folder if missing
        if (!is_dir(public_path('qr'))) {
            mkdir(public_path('qr'), 0755, true);
        }

        // Generate QR code SVG and save
        $svg = QrCode::format('svg')
            ->size(300)
            ->margin(2)
            ->generate($url);

        file_put_contents($path, $svg);

        return Response::download($path);
    }
}
