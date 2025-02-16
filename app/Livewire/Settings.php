<?php

namespace App\Livewire;

use Livewire\Component;
use Native\Laravel\Dialog;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Native\Laravel\Facades\Window;
use Native\Laravel\Facades\Notification;
use App\Helpers\SettingsHelper;

class Settings extends Component
{
    use WithFileUploads;

    #[Validate('required', message: 'Please provide a lockfile path')]
    public $lockFilePath;
    public function mount()
    {
        $this->lockFilePath = SettingsHelper::get('lockfile_path');
    }
    public function save()
    {
        if ($this->lockFilePath && file_exists($this->lockFilePath)) {
            SettingsHelper::set('lockfile_path', $this->lockFilePath);
        }

        Notification::title('Settings')->message('Settings saved successfully')->show();

    }

    public function selectLockFilePath(){
        $this->lockFilePath = Dialog::new()->asSheet("settings")->defaultPath('/Users/username/Desktop')->open();
    }

    public function close()
    {
        Window::close('settings');
    }
    public function render()
    {
        return view('livewire.settings');
    }
}
