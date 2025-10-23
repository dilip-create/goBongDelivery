<?php
namespace App\Livewire\Website;
use Livewire\Component;

use App\Models\Stor;

class PopularShopList extends Component
{
    public function render()
    {
        $shopLists=Stor::whereNull('deleted_at')->orderBy('openStatus', 'desc')->orderBy('id', 'ASC')->get();
        // dd($shopLists);
        return view('livewire.website.popular-shop-list',compact('shopLists'));
    }
}
