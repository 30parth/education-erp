<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

new #[Layout('components.layouts.auth')] class extends Component {
    public $username = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            $user = Auth::user();

            return match ($user->role) {
                'admin' => redirect()->intended('/admin'),
                'teacher' => redirect()->intended('/teacher'),
                'student' => redirect()->intended('/student'),
                default => redirect()->intended('/'),
            };
        }

        $this->addError('email', 'The provided credentials do not match our records.');
    }
};
?>

<div
    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Welcome To Acedemic Hub
        </h1>
        <form class="space-y-4 md:space-y-6" wire:submit="login">
            <x-ui.form.input-with-label type="text" label="User Name" name="username" id="username"
                placeholder="name@company.com" required />
            <x-ui.form.input-with-label type="password" label="Password" name="password" id="password" required />

            <button type="submit"
                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none mt-3  focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Log
                in</button>
        </form>
    </div>
</div>
