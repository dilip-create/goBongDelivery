<?php
namespace App\Livewire\Website;
use Livewire\Component;

use App\Models\Language;

class Header extends Component
{
    public function render()
    {
        $languages=Language::where('status', '1')->orderBy('order', 'asc')->get();
     
        return view('livewire.website.header',compact('languages'));

    }
}
