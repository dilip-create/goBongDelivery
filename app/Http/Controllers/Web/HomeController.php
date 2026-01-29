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

    public function getCategories()
    {
        // Your category data - replace with actual database query
        $categories = [
            [
                'id' => 1,
                'name' => 'All',
                'name_kh' => 'ទាំងអស់',
                'images' => [
                    '/website/assets/img/banners/arrived-store.png',
                    '/website/assets/img/banners/arrived-store.png',
                    '/website/assets/img/banners/arrived-store.png',
                ]
            ],
            [
                'id' => 2,
                'name' => 'Promotions',
                'name_kh' => 'ផ្តល់ជូនពិសេស',
                'images' => [
                    '/website/assets/img/banners/arrived-store.png',
                    '/website/assets/img/banners/arrived-store.png',
                ]
            ],
            [
                'id' => 3,
                'name' => 'Noodles',
                'name_kh' => 'គុយទាវ',
                'images' => [
                    '/website/assets/img/banners/arrived-store.png',
                    '/website/assets/img/banners/arrived-store.png',
                ]
            ],
            [
                'id' => 4,
                'name' => 'Fast Food',
                'name_kh' => 'ម្ហូបរហ័ស',
                'images' => [
                    '/website/assets/img/banners/arrived-store.png',
                    '/website/assets/img/banners/arrived-store.png',
                ]
            ],
            [
                'id' => 5,
                'name' => 'Drinks',
                'name_kh' => 'ភេសជ្ជៈ',
                'images' => [
                    '/website/assets/img/banners/arrived-store.png',
                    '/website/assets/img/banners/arrived-store.png',
                ]
            ],
            [
                'id' => 6,
                'name' => 'Restaurant',
                'name_kh' => 'ហាងបាយ',
                'images' => [
                    '/website/assets/img/banners/arrived-store.png',
                    '/website/assets/img/banners/arrived-store.png',
                ]
            ],
            [
                'id' => 7,
                'name' => 'Delivery',
                'name_kh' => 'ដឹកជញ្ជូន',
                'images' => [
                    '/website/assets/img/banners/arrived-store.png',
                    '/website/assets/img/banners/arrived-store.png',
                ]
            ],
            [
                'id' => 8,
                'name' => 'Admin',
                'name_kh' => 'គ្រប់គ្រង',
                'images' => [
                    '/website/assets/img/banners/arrived-store.png',
                ]
            ],
        ];

        return response()->json($categories);
    }

}
