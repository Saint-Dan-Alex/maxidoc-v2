<?php

namespace App\Http\Livewire\Systems;

use App\Models\Direction;
use App\Models\Division;
use App\Models\Section;
use App\Models\Service;
use Livewire\Component;

class FonctionEdit extends Component
{
    public $fonction;
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

    public function mount($fonction)
    {
        $this->directions = Direction::select('id', 'titre')->get();
        $this->divisions = Division::select('id', 'libelle')->get();
        $this->services = Service::select('id', 'titre')->get();
        $this->sections = Section::select('id', 'titre')->get();
        $this->fonction = $fonction;
        $this->titre = $fonction->titre;
        $this->direction_id = $fonction->direction_id;
        $this->division_id = $fonction->division_id;
        $this->service_id = $fonction->service_id;
        $this->section_id = $fonction->section_id;
        $this->description = $fonction->description;
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
            //code...
            $this->fonction->update([
                "titre" => $this->titre,
                "section_id" => $this->section_id ?? null,
                "service_id" => $this->service_id ?? null,
                "division_id" => $this->division_id ?? null,
                "direction_id" => $this->direction_id ?? null,
                "description" => $this->description ?? null,
            ]);

            $this->mount($this->fonction);
            $this->emit('reloadFonction');
            $this->emit('alert', 'success', 'Fonction modifiée avec succès');
        } catch (\Throwable $th) {
            //throw $th;
            $this->emit('alert', 'error', 'Echec');
        }

    }
    public function render()
    {
        return view('livewire.systems.fonction-edit');
    }

}