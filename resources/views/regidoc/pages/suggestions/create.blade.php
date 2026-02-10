@extends('regidoc.layouts.master')

@section('content')
<style>
    .suggestion-container {
        max-width: 800px;
        margin: 0 auto;
    }
    .suggestion-card {
        border-radius: 20px;
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .suggestion-header {
        background: linear-gradient(135deg, #4b7bec 0%, #3867d6 100%);
        padding: 40px;
        color: white;
        text-align: center;
    }
    .suggestion-header i {
        font-size: 3rem;
        margin-bottom: 15px;
        display: block;
        opacity: 0.9;
    }
    .suggestion-body {
        padding: 40px;
        background: white;
    }
    .form-label {
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        border-radius: 12px;
        padding: 12px 18px;
        border: 2px solid #f3f4f6;
        transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4b7bec;
        box-shadow: 0 0 0 4px rgba(75, 123, 236, 0.1);
    }
    .btn-submit {
        background: #4b7bec;
        border: none;
        border-radius: 12px;
        padding: 14px 30px;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        width: 100%;
        margin-top: 20px;
        color: white;
    }
    .btn-submit:hover {
        background: #3867d6;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(56, 103, 214, 0.3);
        color: white;
    }
    .file-upload-wrapper {
        position: relative;
        border: 2px dashed #e5e7eb;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        background: #f9fafb;
        transition: all 0.2s;
        cursor: pointer;
    }
    .file-upload-wrapper:hover {
        border-color: #4b7bec;
        background: #f0f4ff;
    }
    .file-upload-wrapper i {
        font-size: 2rem;
        color: #9ca3af;
        margin-bottom: 10px;
    }
    .file-upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .icon-badge {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }
</style>

<div class="suggestion-container mt-4 animate__animated animate__fadeIn">
    <div class="card shadow-lg suggestion-card">
        <div class="suggestion-header">
            <i class="fi fi-rr-comment-question"></i>
            <h2 class="fw-bold mb-2">Comment pouvons-nous vous aider ?</h2>
            <p class="mb-0 opacity-75">Votre avis nous aide à améliorer Maxidoc au quotidien.</p>
        </div>
        
        <div class="suggestion-body">
            @if(session('success'))
                <div class="alert alert-success border-0 rounded-4 p-3 mb-4 d-flex align-items-center">
                    <i class="fi fi-rr-check-circle me-3 fs-4"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <form action="{{ route('regidoc.suggestions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label for="type" class="form-label">Type de retour</label>
                        <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" required>
                            <option value="suggestion" {{ old('type') == 'suggestion' ? 'selected' : '' }}>Suggestion d'amélioration</option>
                            <option value="bug" {{ old('type') == 'bug' ? 'selected' : '' }}>Signalement de Bug / Problème technique</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-4">
                        <label for="objet" class="form-label">Objet de votre message</label>
                        <input type="text" class="form-control @error('objet') is-invalid @enderror" 
                               name="objet" id="objet" value="{{ old('objet') }}"
                               placeholder="Ex: Optimisation du tri des courriers..." required>
                        @error('objet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-4">
                        <label for="message" class="form-label">Description détaillée</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  name="message" id="message" rows="6" 
                                  placeholder="Expliquez-nous votre besoin ou décrivez les étapes pour reproduire le bug..." required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-4">
                        <label class="form-label">Capture d'écran ou document (Optionnel)</label>
                        <div class="file-upload-wrapper" id="file-drop-area">
                            <i class="fi fi-rr-cloud-upload"></i>
                            <p class="mb-1 text-dark fw-bold" id="file-name-display">Cliquez ou glissez un fichier ici</p>
                            <p class="small text-muted mb-0">Formats: JPG, PNG, GIF (Max 5Mo)</p>
                            <input type="file" class="file-upload-input" name="image" id="image" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-submit d-flex align-items-center justify-content-center">
                        <i class="fi fi-rr-paper-plane me-2"></i> Envoyer mon retour
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('regidoc.home') }}" class="text-muted text-decoration-none small">
            <i class="fi fi-rr-arrow-left me-1"></i> Retour à l'accueil
        </a>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(e) {
        let fileName = e.target.files[0] ? e.target.files[0].name : "Cliquez ou glissez un fichier ici";
        document.getElementById('file-name-display').textContent = fileName;
        document.getElementById('file-drop-area').style.borderColor = '#4b7bec';
        document.getElementById('file-drop-area').style.background = '#f0f4ff';
    });
</script>
@endsection
