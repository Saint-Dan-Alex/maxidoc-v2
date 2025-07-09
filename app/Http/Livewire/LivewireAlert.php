<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LivewireAlert extends Component
{
    protected $listeners = ['alert'];
    /**
     * The alert type.
     *
     * @var string
     */
    public $type;

    /**
     * The alert message.
     *
     * @var string
     */
    public $message;

    /**
     * Create a new component instance.
     *
     * @return void
     */

    // public function mount($type, $message)
    // {
    //     $this->type = $type;
    //     $this->message = $message;
    // }

    public function render()
    {
        return view('livewire.livewire-alert');
    }

    public function alert($type, $message)
    {
        $this->type = $type;
        $this->message = $message;

        $this->dispatchBrowserEvent('alert', ['type' => $type, 'message' => $message]);
    }
}
