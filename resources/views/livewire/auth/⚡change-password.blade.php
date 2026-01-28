<?php

use Livewire\Component;

new class extends Component {
    public $current_password;
    public $new_password;
    public $confirm_password;

    public function changePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ]);

        if ($this->new_password != $this->confirm_password) {
            $this->addError('confirm_password', 'New password and confirm password do not match');
            return;
        }
        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'Current password is incorrect');
            return;
        }

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->current_password = '';
        $this->new_password = '';
        $this->confirm_password = '';
    }
};
?>

<div class="p-4">
    <form action="" wire:submit.prevent="changePassword">

        <x-ui.form.input-with-label id="current_password" name="current_password" label="Current Password"
            placeholder="Current Password" type="password" />

        <x-ui.form.input-with-label id="new_password" name="new_password" label="New Password" placeholder="New Password"
            type="password" />

        <x-ui.form.input-with-label id="confirm_password" name="confirm_password" label="Confirm Password"
            placeholder="Confirm Password" type="password" />

        <x-ui.button type="submit">Change Password</x-ui.button>


    </form>

    {{-- It always seems impossible until it is done. - Nelson Mandela --}}
</div>
