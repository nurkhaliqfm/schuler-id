<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dasboard Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/dashboard', $data);
    }

    // PROGRAM KHUSUS
    public function super_camp_utbk()
    {
        $data = [
            'title' => 'Super Camp UTBK Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/program-khusus/super-camp-utbk', $data);
    }

    // MENU UTBK LATIHAN
    public function kerjakan_latihan()
    {
        $data = [
            'title' => 'Kerjakan Latihan Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/menu-utbk/latihan-utbk/kerjakan-latihan', $data);
    }
    public function hasil_latihan()
    {
        $data = [
            'title' => 'Hasil Latihan Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/menu-utbk/latihan-utbk/hasil-latihan', $data);
    }

    // MENU UTBK SIMULASI
    public function simulasi_gratis()
    {
        $data = [
            'title' => 'Simulasi Gratis Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/menu-utbk/simulasi-utbk/simulasi-gratis', $data);
    }
    public function simulasi_premium()
    {
        $data = [
            'title' => 'Simulasi Premium Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/menu-utbk/simulasi-utbk/simulasi-premium', $data);
    }
    public function hasil_simulasi()
    {
        $data = [
            'title' => 'Hasil Simulasi Schuler.id',
            'user_name' => 'codefm.my.id'
        ];

        return view('home/menu-utbk/simulasi-utbk/hasil-simulasi', $data);
    }
}
