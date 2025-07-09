<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use App\Models\Chat;
class Content extends Component
{
    public $chats,$users,$idreceve;
    public $content;

    public function send(){
        $userSend = Chat::create([
            'user_send'=>auth()->user()->id,
            'user_receve' =>$this->idreceve,
            'content'=> $this->content,

        ]);
        $this->content = '';
    }

    public function mount($ids){
        $this->idreceve = $ids;
        $this->users = User :: all();

        // return view('pages.courriers.chat',compact('users','chats','idreceve'));
    }

    public function render()
    {
        $this->chats = Chat::where('user_send',$this->idreceve)->orwhere('user_receve',$this->idreceve)->get();
        $this->users;

        return view('livewire.chat.content');
    }
}
