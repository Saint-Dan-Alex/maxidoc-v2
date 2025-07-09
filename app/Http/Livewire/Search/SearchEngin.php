<?php

namespace App\Http\Livewire\Search;

use App\Models\Courrier;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SearchEngin extends Component
{
    public $query;
    public $results;
    public $highlightIndex = 0;
    public $resultCount = 0;

    public function mount()
    {
        $this->resetAll();
    }

    public function resetAll()
    {
        $this->query = '';
        $this->results = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->results) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->results) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectContact()
    {
        $result = $this->results[$this->highlightIndex] ?? null;
        if ($result) {
            $this->redirect($result['url']);
        }
    }

    public function updatedQuery()
    {
        $this->results = [];
        $documents = Document::search($this->query)->get();
        $courriers = Courrier::search($this->query)->get();
        $datas = $documents->merge($courriers);

        foreach ($datas as $key => $data) {
            if (Auth::user()->can('view', $data)) {
                if ($data instanceof (new Document())) {
                    array_push($this->results, [
                        'id' => $data->id,
                        'title' => $data->libelle,
                        'categorie' => 'documents',
                        'url' => route('regidoc.documents.show', $data),
                    ]);
                } elseif ($data instanceof (new Courrier())) {
                    array_push($this->results, [
                        'id' => $data->id,
                        'title' => $data->title,
                        'categorie' => 'courriers',
                        'url' => route('regidoc.courriers.show', $data),
                    ]);
                }
            }
        }

        // $this->resultCount = $this->results->count();

        // dd($this->results);

        // $this->results = D::where('name', 'like', '%' . $this->query . '%')
        //     ->get()
        //     ->toArray();
    }

    public function render()
    {
        return view('livewire.search.search-engin');
        // ->with([
        //     'results' => $this->results
        // ]);
    }
}
