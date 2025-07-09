<?php

namespace App\Http\Livewire\Systems;

use App\Models\Direction;
use App\Models\Division;
use App\Models\Fonction;
use App\Models\Section;
use App\Models\Service;
use Livewire\Component;

class FonctionAdd extends Component
{
    public $titre;
    public $directions;
    public $divisions;
    public $services;
    public $sections;
    public $direction_id;
    public $division_id;
    public $service_id;
    public $section_id;
    public $description;

    public $isReadOnly = [
        'service' => true,
        'division' => true,
        'section' => true,
    ];

    public function mount()
    {
        $this->directions = Direction::select('id', 'titre')->get();
        $this->divisions = Division::select('id', 'libelle')->get();
        $this->services = Service::select('id', 'titre')->get();
        $this->sections = Section::select('id', 'titre')->get();
    }
    public function updatedDirectionId()
    {
        $this->isReadOnly['division'] = false;
        $this->divisions = Direction::findOrFail($this->direction_id)->divisions ?? collect();
    }

    public function updatedDivisionId()
    {
        $this->isReadOnly['service'] = false;
        $this->services = Division::findOrFail($this->division_id)->services ?? collect();
    }

    public function updatedServiceId()
    {
        $this->isReadOnly['section'] = false;
        $this->sections = Service::findOrFail($this->service_id)->sections ?? collect();
    }

    public function save()
    {
        try {
            Fonction::create([
                "titre" => $this->titre,
                "section_id" => $this->section_id ?? null,
                "service_id" => $this->service_id ?? null,
                "division_id" => $this->division_id ?? null,
                "direction_id" => $this->direction_id ?? null,
                "description" => $this->description ?? null,
            ]);

            $this->reset();
            $this->mount();
            $this->emit('reloadFonction');
            $this->emit('alert','success','Fonction ajoutée avec succès');

        } catch (\Throwable $th) {
            $this->emit('alert','error','Echec');
        }
    }
    public function render()
    {
        return view('livewire.systems.fonction-add');
    }

}
