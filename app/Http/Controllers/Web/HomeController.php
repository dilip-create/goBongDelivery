<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Stor;
use App\Models\Popup;

class HomeController extends Controller
{
    public function index()
    {
        $recommendedstors = Stor::select('*')->where('openStatus', '1')->get();
        //  dd($recommendedstors);
        //100 great restaurants
        $stors = Stor::select('*')->orderBy('openStatus', 'desc')->get();
        $popups = Popup::select('*')->where('status', '1')->orderBy('ordering', 'asc')->get();
       
        return Inertia::render('Web/Home', [
            // 'translations' => __('message'),
            'recommendedstors' => $recommendedstors,
            'stors' => $stors,
            'popups' => $popups,
            
        ]);



    }

}
