<?php
namespace App\Livewire\Website;
use Livewire\Component;

use App\Models\Stor;

class ShopList extends Component
{
    public function render()
    {
        $shopLists=Stor::whereNull('deleted_at')->orderBy('openStatus', 'desc')->orderBy('id', 'desc')->get();
        // dd($shopLists);
        return view('livewire.website.shop-list',compact('shopLists'));
    }
}
