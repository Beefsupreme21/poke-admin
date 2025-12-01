<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Action;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

class Login extends BaseLogin
{
    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),
            $this->getDemoLoginAction(),
        ];
    }
    
    protected function getDemoLoginAction(): Action
    {
        return Action::make('demo')
            ->label('Log in as demo user')
            ->color('gray')
            ->action(function () {
                $credentials = [
                    'email' => 'admin@test.com',
                    'password' => 'password',
                ];
                
                if (Auth::attempt($credentials, true)) {
                    return redirect()->intended(Filament::getUrl());
                }
            });
    }
}

