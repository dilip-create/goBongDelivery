<?php
namespace App\Livewire\Website;
use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        $title =   __('message.HomeTitle');
        return view('livewire.website.home-page')->title($title);
    }
}
