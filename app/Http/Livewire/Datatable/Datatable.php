<?php

namespace App\Http\Livewire\Datatable;

use Livewire\Component;
use stdClass;

class Datatable extends Component
{
    protected $model;
    protected $options;

    public $perPage = 10;
    public $search = '';

    public function mount($model, $options)
    {
        $this->model = $model;
        if(is_array($options)){
            $this->options = json_decode(json_encode($options));
        }elseif (is_string($options)) {
            $this->options = json_decode($options);
        }else {
            $this->options = $options;
        }
    }

    public function render()
    {
        return view('livewire.datatable.datatable')->with([
            'data' => $this->model::search($this->search, $this->options['search_columns'])->paginate($this->perPage)
        ]);
    }
}
