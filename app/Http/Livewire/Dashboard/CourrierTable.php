<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Courrier;
use App\Models\CourrierType;
use Livewire\Component;

class CourrierTable extends Component
{
    public $courrierGroups = [];
    protected $allCourriers;
    public $filters = [
        1 => 'Auccun',
        2 => 'Destinateur : A - Z',
        3 => 'Destinateur : Z - A',
        4 => 'Expediteur : A - Z',
        5 => 'Expediteur : Z - A',
        6 => 'Date d\'entrée',
        7 => 'Date : Ajourd\'huit',
        8 => 'Date : hier',
    ];
    public $filterVal = 'Filtres';

    public function mount()
    {
        $this->courrierGroups = CourrierType::with(['courriers' => function ($query)
        {
            $query->notClassified()
            // ->whereBetween('created_at', [
            //     now()->startOfWeek(),
            //     now()->endOfWeek()
            // ])
            ->orderBy('created_at','desc');
        }])->get();
    }

    public function render()
    {
        return view('livewire.dashboard.courrier-table');
    }

    public function filter($value)
    {
        $this->reset('courrierGroups');
        switch ($value) {
            case 2:
                $this->filterVal = 'Destinateur : A - Z';

                break;

            case 3:
                $this->filterVal = 'Destinateur : Z - A';
                break;

            case 4:
                $this->filterVal = 'Expediteur : A - Z';
                break;

            case 5:
                $this->filterVal = 'Expediteur : Z - A';
                break;

            case 6:
                $this->filterVal = 'Date d\'entrée';
                $this->courrierGroups = CourrierType::with(['courriers' => function ($query)
                {
                    $query->notClassified()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->orderBy('created_at','asc');
                }])->get();
                break;

            case 7:
                $this->filterVal = 'Date : Ajourd\'huit';
                $this->courrierGroups = CourrierType::with(['courriers' => function ($query)
                {
                    $query->notClassified()->whereDate('created_at', now()->today())->orderBy('created_at','desc');
                }])->get();
                break;

            case 8:
                $this->filterVal = 'Date : hier';
                $this->courrierGroups = CourrierType::with(['courriers' => function ($query)
                {
                    $query->notClassified()->whereDate('created_at', now()->yesterday())->orderBy('created_at','desc');
                }])->get();
                break;

            default:
                $this->filterVal = 'Filtres';
                $this->courrierGroups = CourrierType::with(['courriers' => function ($query)
                {
                    $query->notClassified()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                    ->orderBy('created_at','desc');
                }])->get();
                break;
        }
    }
}
