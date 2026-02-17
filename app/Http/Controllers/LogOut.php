<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use function redirect;
use function Session;

class LogOut
{

    public function logOut(){

        Auth::logout();
        return redirect('/login');

    }

    public function metronic($cosa)
    {
        switch ($cosa) {
            case 'dark':
                if (Auth::user()->getExtra('darkMode')) {
                    Auth::user()->setExtra(['darkMode' => false]);
                } else {
                    Auth::user()->setExtra(['darkMode' => true]);
                }
                return redirect()->back();

            case 'aside':
                if (Auth::user()->getExtra('aside') == 'off') {
                    Auth::user()->setExtra(['aside' => 'on']);
                } else {
                    Auth::user()->setExtra(['aside' => 'off']);
                }
                return ['success' => true];
        }
    }
}
