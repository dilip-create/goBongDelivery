<?php  

namespace App\Filament\Helper;

use Filament\Forms\Form;
use Filament\Pages\Auth\Login;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox; // ✅ add this

class CustomLogin extends Login
{
    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('phoneNumber')
                ->label(__('message.Phone Number'))
                ->required()
                ->tel()
                ->prefixIcon('heroicon-m-phone')   
                ->maxLength(12)
                ->autofocus(),

            TextInput::make('password')
                ->label(__('message.Password'))
                ->prefixIcon('heroicon-m-lock-closed')
                ->required()
                ->revealable()
                ->maxLength(8)
                ->password(),
            Checkbox::make('remember') // ✅ works now
                ->label(__('message.Remember me')),
        ]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'phoneNumber' => $data['phoneNumber'],
            'password' => $data['password'],
        ];
    }

    protected function getUsernameField(): string
    {
        return 'phoneNumber';
    }
}
