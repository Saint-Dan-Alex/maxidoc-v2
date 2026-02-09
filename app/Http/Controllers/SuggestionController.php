<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SuggestionMail;

class SuggestionController extends Controller
{
    public function index()
    {
        // Seuls les admins voient tout
        if (!Auth::user()->hasRole('Super Admin') && !Auth::user()->hasRole('Administrateur système')) {
            abort(403);
        }

        $suggestions = Suggestion::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('regidoc.pages.suggestions.index', compact('suggestions'));
    }

    public function create()
    {
        return view('regidoc.pages.suggestions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'objet' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:suggestion,bug',
            'image' => 'nullable|image|max:5120', // 5MB max
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('suggestions', 'public');
        }

        $suggestion = Suggestion::create([
            'user_id' => Auth::id(),
            'objet' => $request->objet,
            'message' => $request->message,
            'type' => $request->type,
            'image_path' => $imagePath,
        ]);

        // Envoi de l'email
        try {
            Mail::to('maxidoc@newtech-rdc.net')->send(new SuggestionMail($suggestion));
        } catch (\Exception $e) {
            // On log l'erreur si besoin, mais on ne bloque pas l'utilisateur
            \Log::error('Erreur envoi email suggestion: ' . $e->getMessage());
        }

        return redirect()->route('regidoc.home')->with('success', 'Votre message a été envoyé avec succès.');
    }

    public function updateStatus(Request $request, Suggestion $suggestion)
    {
        if (!Auth::user()->hasRole('Super Admin') && !Auth::user()->hasRole('Administrateur système')) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:ouvert,en_cours,ferme',
        ]);

        $suggestion->update(['status' => $request->status]);

        return back()->with('success', 'Statut mis à jour.');
    }
}
