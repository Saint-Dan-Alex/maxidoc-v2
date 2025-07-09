<?php

namespace App\Http\Livewire\Admin\Agents;


use App\Models\Direction;
use App\Models\Division;
use App\Models\Fonction;
use App\Models\Grade;
use App\Models\LieuAffectation;
use App\Models\Section;
use App\Models\Service;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class CreatePersonnelForm extends Component
{
    use WithFileUploads;

    // public $direction_id;
    public $nom;
    public $prenom;
    public $post_nom;
    public $email;
    public $newMail;
    public $sexe;
    public $lieu_naiss;
    public $date_naiss;
    public $nationalite;
    public $province;
    public $ville;
    public $etat_civil;
    public $nbr_enfants;
    public $telephone;
    public $adresse;
    public $matricule;

    public $lieus;
    public $lieu_id;
    public $grades;
    public $directions;
    public $direction_id;
    public $divisions;
    public $division_id;
    public $services;
    public $service_id;
    public $fonctions;
    public $fonction;
    public $fonction_type;
    public $chef_type;
    public $sec_type;
    public $cd = false;
    public $sd = false;
    public $sdv = false;
    public $csv = false;
    public $csc = false;
    public $fonction_id = null;
    public $sections;
    public $section_id;

    public $isReadyOnly = [
        'direction' => true,
        'division' => true,
        'service' => true,
        'section' => true,
        'fonction' => true,
        'fonction_type' => true,
    ];


    public function mount()
    {
        $this->lieus = LieuAffectation::select('id', 'titre')->get();
        $this->grades = Grade::select('id', 'titre')->get();
        $this->directions = collect();
        $this->divisions = collect();
        $this->services = collect();
        $this->sections = collect();
        $this->fonctions = Fonction::select('id', 'titre')->get();
    }
    public function updatedLieuId()
    {
        $this->isReadyOnly['direction'] = false;
        $this->directions = LieuAffectation::findOrFail($this->lieu_id)->directions ?? collect();
    }
    public function updatedDirectionId()
    {
        $this->isReadyOnly['division'] = false;
        $this->divisions = Direction::findOrFail($this->direction_id)->divisions ?? collect();
        if ($this->divisions->count() == 0) {
            # code...
            $this->isReadyOnly['service'] = false;
        }
    }

    public function updatedDivisionId()
    {
        $this->isReadyOnly['service'] = false;
        $this->services = Division::findOrFail($this->division_id)->services ?? collect();
        if ($this->services->count() == 0) {
            # code...
            $this->isReadyOnly['section'] = false;
            $this->isReadyOnly['fonction_type'] = false;
        }
    }

    public function updatedServiceId()
    {
        $this->isReadyOnly['section'] = false;
        $this->isReadyOnly['fonction_type'] = false;
        $this->sections = Service::findOrFail($this->service_id)->sections ?? collect();
    }

    public function updatedFonctionType()
    {
        $this->isReadyOnly['fonction'] = false;
        // $this->sections = Service::findOrFail($this->service_id)->sections ?? collect();
    }

    public function updatedChefType()
    {
        // dd($this->chef_type);
        if ($this->chef_type == '1') {
            $this->cd = true;
            $this->csv = false;
            $this->csc = false;
        }
        if ($this->chef_type == '2') {
            $this->cd = false;
            $this->csv = true;
            $this->csc = false;
        }
        if ($this->chef_type == '3') {
            $this->cd = false;
            $this->csv = false;
            $this->csc = true;
        }
    }

    public function updatedSecType()
    {
        if ($this->sec_type == '1') {
            $this->sd = true;
            $this->sdv = false;
        }
        if ($this->sec_type == '2') {
            $this->sd = false;
            $this->sdv = true;
        }
    }
    public function updatedNom()
    {
        $this->updateNewMail();
    }

    public function updatedPostNom()
    {
        $this->updateNewMail();
    }

    private function removeAccents($string)
    {
        $string = str_replace(
            [
                'À', 'Á','Â','Ã','Ä','Å','à','á','â','ã','ä','å','Ç','ç','Ć',
                'ć','Ĉ','ĉ','Č','č','Ð','ð','È','É','Ê','Ë',
                'è',
                'é',
                'ê',
                'ë',
                'Ĝ',
                'ĝ',
                'Ĥ',
                'ĥ',
                'Ì',
                'Í',
                'Î',
                'Ï',
                'ì',
                'í',
                'î',
                'ï',
                'Ĵ',
                'ĵ',
                'Ķ',
                'ķ',
                'Ĺ',
                'ĺ',
                'Ľ',
                'ľ',
                'Ñ',
                'ñ',
                'Ń',
                'ń',
                'Ň',
                'ň',
                'Ò',
                'Ó',
                'Ô',
                'Õ',
                'Ö',
                'Ø',
                'ò',
                'ó',
                'ô',
                'õ',
                'ö',
                'ø',
                'Ŕ',
                'ŕ',
                'Ř',
                'ř',
                'Ś',
                'ś',
                'Ŝ',
                'ŝ',
                'Š',
                'š',
                'Ţ',
                'ţ',
                'Ť',
                'ť',
                'Ù',
                'Ú',
                'Û',
                'Ü',
                'ù',
                'ú',
                'û',
                'ü',
                'Ŵ',
                'ŵ',
                'Ý',
                'ý',
                'ÿ',
                'Ŷ',
                'ŷ',
                'Ž',
                'ž'
            ],
            [
                'A',
                'A',
                'A',
                'A',
                'A',
                'A',
                'a',
                'a',
                'a',
                'a',
                'a',
                'a',
                'C',
                'c',
                'C',
                'c',
                'C',
                'c',
                'C',
                'c',
                'D',
                'd',
                'E',
                'E',
                'E',
                'E',
                'e',
                'e',
                'e',
                'e',
                'G',
                'g',
                'H',
                'h',
                'I',
                'I',
                'I',
                'I',
                'i',
                'i',
                'i',
                'i',
                'J',
                'j',
                'K',
                'k',
                'L',
                'l',
                'L',
                'l',
                'N',
                'n',
                'N',
                'n',
                'N',
                'n',
                'O',
                'O',
                'O',
                'O',
                'O',
                'O',
                'o',
                'o',
                'o',
                'o',
                'o',
                'o',
                'R',
                'r',
                'R',
                'r',
                'S',
                's',
                'S',
                's',
                'S',
                's',
                'T',
                't',
                'T',
                't',
                'U',
                'U',
                'U',
                'U',
                'u',
                'u',
                'u',
                'u',
                'W',
                'w',
                'Y',
                'y',
                'y',
                'Y',
                'y',
                'Z',
                'z'
            ],
            $string
        );
        $string = str_replace(' ', '', $string);
        return Str::lower($string);
    }

    private function updateNewMail()
    {
        $nomSansAccents = $this->removeAccents($this->nom);
        $prenomSansAccents = $this->removeAccents($this->post_nom);
        $this->newMail = Str::lower($nomSansAccents) . '.' . Str::lower($prenomSansAccents) . '@regideso.cd';
    }



    public function render()
    {
        if ($this->direction_id) {
            # code...
            $this->isReadyOnly['fonction_type'] = false;
            $this->fonctions = Fonction::where('direction_id', $this->direction_id)->get();
        }
        return view('livewire.admin.agents.create-personnel-form');
    }


}