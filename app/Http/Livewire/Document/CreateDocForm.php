<?php

namespace App\Http\Livewire\Document;

use App\Models\Agent;
use App\Models\Brouillon;
use App\Models\BrouillonCommentaire;
use App\Models\DocumentTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class CreateDocForm extends Component
{
    public $template;
    public $destination;
    public $copies;
    public $isConfidentiel;
    public $dg;
    public $categories;
    public $traitements;
    public $dossier_id;
    public $modele;
    public $reference = ' ';
    public $copie;
    public $lieu_copie;
    public $dest;
    public $ville;
    public $lieu_date;
    public $concerne;
    public $exp_fonction;
    public $exp_name;
    public $dest_fonction;
    public $dest_name;
    public $body;
    public $rue;
    public $num;
    public $bp;
    public $idnat;
    public $phone;
    public $email;
    public $impot;
    public $bon;
    public $fournisseur;
    public $date;
    public $location;
    public $dest_mat;
    public $deste_poste;
    public $direction;
    public $division;
    public $section;
    public $directeur;
    public $agents;
    public $agent_id;
    public $complete = false;
    public $cosignataires = [];
    public $doc_type;
    public $participants = [];
    public $participant_id;
    public $brouillon;
    public $comment;

    protected $listeners = [
        'refreshBrouillon' => 'refreshBrouillon',
    ];

    public function refreshBrouillon()
    {
        $this->mount($this->doc_type, $this->brouillon->id);
    }
    public function mount($doc_type, $brouillon = null)
    {
        $this->doc_type = $doc_type;
        $this->modele = DocumentTemplate::find($doc_type)->modele;
        $this->template = DocumentTemplate::find($doc_type)->titre;
        $this->agents = Agent::select('id', 'nom', 'prenom')->get();
        if ($brouillon != null) {
            $this->brouillon = Brouillon::findOrfail($brouillon);
            $content = json_decode($this->brouillon->content);
            if ($doc_type == 1) { 
                $this->reference = $content->reference;
                $this->lieu_copie = $content->lieu_copie;
                $this->dest = $content->dest;
                $this->ville = $content->ville;
                $this->lieu_date = $content->lieu_date;
                $this->exp_fonction = $content->exp_fonction;
                $this->exp_name = $content->exp_name;
                $this->concerne = $content->concerne;
                $this->body = $content->body;
                $this->cosignataires = $content->cosignataires;
                $this->selectOptions($content->copies);
                session(['reference' => $this->reference]);
                session(['copie' => $content->copies]);
                session(['lieu_copie' => $this->lieu_copie]);
                session(['ville' => $this->ville]);
                session(['lieu_date' => $this->lieu_date]);
                session(['exp_fonction' => $this->exp_fonction]);
                session(['exp_name' => $this->exp_name]);
                session(['concerne' => $this->concerne]);
                session(['body' => $this->body]);
                session(['cosignataires' => $this->cosignataires]);
            }
        }
    }

    public function updatedAgentId()
    {
        if ($this->agent_id != '') {
            # code...
            $agent = Agent::find($this->agent_id);
            $nom = Str::upper($agent->nom . ' ' . $agent->post_nom);
            if ($this->modele == 'template-1') {
                # code...
                $this->dest = $agent->sexe == 'M' ? "Monsieur " . $nom : "Madame " . $nom;
                $this->dest_mat = $agent->matricule;
                $this->deste_poste = $agent->poste?->titre;
                $this->updatedDest();
                $this->updatedDestMat();
                $this->updatedDestePoste();
            }
            if ($this->modele == 'template-7') {
                # code...
                $this->dest = $nom . ', Matricule : ' . $agent->matricule;
                $this->dest_mat = $agent->grade?->titre;
                $this->deste_poste = $agent->poste?->titre;
                $this->updatedDest();
                $this->updatedDestMat();
                $this->updatedDestePoste();
            }
        }
    }

    public function updatedReference()
    {
        $this->emit('changeReference', $this->reference);
    }

    public function updatedCopie()
    {
        $this->emit('changeCopie', $this->copie);
    }

    public function updatedLieuCopie()
    {
        $this->emit('changeLieuCopie', $this->lieu_copie);
    }

    public function updatedDest()
    {
        $this->emit('changeDest', $this->dest);
    }

    public function updatedVille()
    {
        $this->emit('changeVille', $this->ville);
    }

    public function updatedLieuDate()
    {
        $this->emit('changeLieuDate', $this->lieu_date);
    }

    public function updatedConcerne()
    {
        $this->emit('changeConcerne', $this->concerne);
    }

    public function updatedRue()
    {
        $this->emit('changeRue', $this->rue);
    }
    public function updatedNum()
    {
        $this->emit('changeNum', $this->num);
    }
    public function updatedBp()
    {
        $this->emit('changeBp', $this->bp);
    }
    public function updatedIdnat()
    {
        $this->emit('changeIdnat', $this->idnat);
    }
    public function updatedPhone()
    {
        $this->emit('changePhone', $this->phone);
    }
    public function updatedEmail()
    {
        $this->emit('changeEmail', $this->email);
    }
    public function updatedImpot()
    {
        $this->emit('changeImpot', $this->impot);
    }
    public function updatedBon()
    {
        $this->emit('changeBon', $this->bon);
    }
    public function updatedDate()
    {
        $this->emit('changeDate', $this->date);
    }
    public function updatedLocation()
    {
        $this->emit('changeLocation', $this->location);
    }
    public function updatedFournisseur()
    {
        $this->emit('changeFournisseur', $this->fournisseur);
    }
    public function updatedExpFonction()
    {
        $this->emit('changeExpFonction', $this->exp_fonction);
    }
    public function updatedExpName()
    {
        $this->emit('changeExpName', $this->exp_name);
    }
    public function updatedDestFonction()
    {
        $this->emit('changeDestFonction', $this->dest_fonction);
    }
    public function updatedDestName()
    {
        $this->emit('changeDestName', $this->dest_name);
    }
    public function updatedDestMat()
    {
        $this->emit('changeDestMat', $this->dest_mat);
    }

    public function updatedDestePoste()
    {
        $this->emit('changeDestePoste', $this->deste_poste);
    }

    public function updatedDirection()
    {
        $this->emit('changeDirection', $this->direction);
    }

    public function updatedDivision()
    {
        $this->emit('changeDivision', $this->division);
    }

    public function updatedSection()
    {
        $this->emit('changeSection', $this->section);
    }

    public function updatedDirecteur()
    {
        $this->emit('changeDirecteur', $this->directeur);
    }

    public function updatedCosignataires()
    {
        $this->emit('changeCosignataire', $this->cosignataires);
    }
    public function addCosignataire()
    {
        array_push($this->cosignataires, ['dest_fonction' => '', 'dest_name' => '']);
        $this->emit('signateurAdded');
    }

    public function updatedBody()
    {
        
        $this->emit('updateBody', $this->body);
        // dd($this->body);
    }

    public function removeCosignataire($index)
    {
        unset($this->cosignataires[$index]);
        $this->cosignataires = array_values($this->cosignataires);
        $this->emit('changeCosignataire', $this->cosignataires);
    }

    // public function generatePDF()
    // {
    //     if ($this->modele == 'template-2') {
    //         $this->emit('downloadLetterPDF');
    //     } elseif ($this->modele == 'template-3' || $this->modele == 'template-4') {
    //         $this->emit('downloadPDF');
    //     } else {
            
    //         $this->emit('downloadFooterPDF');
    //     }
    // }

    public function saveComment()
    {
        if ($this->comment != '') {
            # code...
            BrouillonCommentaire::create([
                'message' => $this->comment,
                'brouillon_id' => $this->brouillon->id,
                'user_id' => Auth::id(),
            ]);
            $this->emit('alert', 'success', 'Vous avez ajouté un nouveau Commentaire pour ce document');
            $this->emit('refreshBrouillon');
            $this->comment = '';
        }

    }
    public function saveBrouillon()
    {
        if ($this->doc_type == 1) {
            if ($this->brouillon) {
                $this->brouillon->update([
                    'content' => json_encode([
                        'reference' => $this->reference,
                        'copies' => json_encode($this->copie),
                        'lieu_copie' => $this->lieu_copie,
                        'dest' => $this->dest,
                        'ville' => $this->ville,
                        'lieu_date' => $this->lieu_date,
                        'exp_fonction' => $this->exp_fonction,
                        'exp_name' => $this->exp_name,
                        'concerne' => $this->concerne,
                        'body' => $this->body,
                        'cosignataires' => $this->cosignataires,
                    ]),
                ]);
            } else {
                # code...
                $brouillon = Brouillon::firstOrCreate(
                    [
                        'nom' => 'Br' . Auth::id() . date('dmHis'),
                        'type' => 1,
                    ],
                    [
                        'content' => json_encode([
                            'reference' => $this->reference,
                            'copies' => json_encode($this->copie),
                            'lieu_copie' => $this->lieu_copie,
                            'dest' => $this->dest,
                            'ville' => $this->ville,
                            'lieu_date' => $this->lieu_date,
                            'exp_fonction' => $this->exp_fonction,
                            'exp_name' => $this->exp_name,
                            'concerne' => $this->concerne,
                            'body' => $this->body,
                            'cosignataires' => $this->cosignataires,
                        ]),
                        'user_id' => Auth::id(),
                    ]
                );
                $this->brouillon = $brouillon;
            }
        }
    }

    public function sendBrouillon()
    {
        if ($this->doc_type == 1) {
            $this->brouillon->update(
                [
                    'content' => json_encode([
                        'reference' => $this->reference,
                        'copies' => $this->copie,
                        'lieu_copie' => $this->lieu_copie,
                        'dest' => $this->dest,
                        'ville' => $this->ville,
                        'lieu_date' => $this->lieu_date,
                        'exp_fonction' => $this->exp_fonction,
                        'exp_name' => $this->exp_name,
                        'concerne' => $this->concerne,
                        'body' => $this->body,
                        'cosignataires' => $this->cosignataires,
                    ]),
                ]
            );

            $existingParticipants = json_decode($this->brouillon->participants) ?? [];
            $participantExists = in_array($this->participant_id, $existingParticipants);

            if (!$participantExists) {
                $existingParticipants[] = $this->participant_id;
                $this->brouillon->participants = json_encode($existingParticipants);
                $this->brouillon->save();
                $this->brouillon->agents()->sync($existingParticipants);
            }
            $this->emit('alert', 'success', 'Document partagé avec succès');
            return redirect()->route('regidoc.home');
        }
    }

    public function selectOptions($options)
    {
        $this->copie = $options;
        $this->dispatchBrowserEvent('selectOptions', $options);
    }

    public function setComplete($doc_type)
    {
        if ($doc_type == 1) {
            $this->complete = !empty($this->copie) && !empty($this->lieu_copie) && !empty($this->dest) && !empty($this->lieu_date) && !empty($this->concerne) && !empty($this->body);
        }
        if ($doc_type == 2) {
            if(!empty($this->date) && !empty($this->fournisseur) && !empty($this->bon) && !empty($this->location)){
                $this->complete = true;
            } 
        }
        if ($doc_type == 3) {
            $this->complete = true;
        }
        if ($doc_type == 4) {
            if(!empty($this->agent_id) && !empty($this->direction) && !empty($this->division) && !empty($this->section) && !empty($this->directeur) && !empty($this->concerne) && !empty($this->body) && !empty($this->lieu_date)){
                $this->complete = true;
            } 
        }
        if ($doc_type == 5) {

            if(!empty($this->copie) && !empty($this->concerne) && !empty($this->body) && !empty($this->lieu_date) && !empty($this->exp_fonction) && !empty($this->exp_name)){
                $this->complete = true;
            }
        }
        if ($doc_type == 6) {
            if(!empty($this->direction) && !empty($this->lieu_date) && !empty($this->body) && !empty($this->exp_fonction) && !empty($this->exp_name)){
                $this->complete = true;
            }
        }
        if ($doc_type == 7) {
           if(!empty($this->agent_id) && !empty($this->concerne) && !empty($this->body) && !empty($this->direction) && !empty($this->date) && !empty($this->location) && !empty($this->exp_fonction) && !empty($this->exp_name) && !empty($this->lieu_date)){
                $this->complete = true;
            }
        }
        if ($doc_type == 8) {
           if(!empty($this->copie) && !empty($this->concerne) && !empty($this->body) && !empty($this->dest_fonction) && !empty($this->dest_name) && !empty($this->location) && !empty($this->exp_fonction) && !empty($this->exp_name) && !empty($this->lieu_date)){
                $this->complete = true;
            }
        }
    }

    public function generatePDF()
    {
        set_time_limit(120);
        if ($this->modele == 'template-2') {
        $data = [
            'reference' => $this->reference,
            'copies' => $this->copies,
            'lieu_copie' => $this->lieu_copie,
            'dest' => $this->dest,
            'ville' => $this->ville,
            'lieu_date' => $this->lieu_date,
            'concerne' => $this->concerne,
            'exp_fonction' => $this->exp_fonction,
            'exp_name' => $this->exp_name,
            'dest_fonction' => $this->dest_fonction,
            'dest_name' => $this->dest_name,
            'body' => $this->body,
            'cosignataires' => $this->cosignataires,
        ];
    
        $pdf = Pdf::loadView('livewire.document.document-modele-letter', $data);
        // return $pdf->download('Unikho.pdf');
        // Télécharge le PDF
        } elseif($this->modele == 'template-3' || $this->modele == 'template-4'){
            $data = [
                'reference' => $this->reference,
                'copies' => $this->copies,
                'lieu_copie' => $this->lieu_copie,
                'dest' => $this->dest,
                'ville' => $this->ville,
                'lieu_date' => $this->lieu_date,
                'concerne' => $this->concerne,
                'exp_fonction' => $this->exp_fonction,
                'exp_name' => $this->exp_name,
                'dest_fonction' => $this->dest_fonction,
                'dest_name' => $this->dest_name,
                'body' => $this->body,
                'cosignataires' => $this->cosignataires,
            ];

            //     public $rue;
            //     public $num;
            //     public $bp;
            //     public $idnat;
            //     public $phone;
            //     public $email;
            //     public $impot;
            //     public $bon;
            //     public $fournisseur;
            //     public $date;
            //     public $location;
            //     public $exp_fonction;
            //     public $exp_name;
            
            //     public $cosignataires = [];
            
            // ];
        }
        // dd($pdf);
         return response()->streamDownload(
             fn () => print($pdf->output()),
             "document_{$this->reference}.pdf"
         );
    }

    public function render()
    {
        // $this->agent_id;
        $this->setComplete($this->doc_type);
        return view('livewire.document.create-doc-form');
    }
}
