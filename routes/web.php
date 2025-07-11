<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Archives\ArchiveController;
use App\Http\Controllers\Archives\ClasseurController as ArchivesClasseurController;
use App\Http\Controllers\Archives\DocumentController as ArchivesDocumentController;
use App\Http\Controllers\Archives\DossierController as ArchivesDossierController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Chats\ChatController;
use App\Http\Controllers\Courriers\CourrierController;
use App\Http\Controllers\Documents\ClasseurController;
use App\Http\Controllers\Documents\DocumentController;
use App\Http\Controllers\Documents\DossierController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationSubscriptionController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RH\AssistanatController;
use App\Http\Controllers\RH\DirectionController;
use App\Http\Controllers\RH\DivisionController;
use App\Http\Controllers\RH\FonctionController;
use App\Http\Controllers\RH\GradeController;
use App\Http\Controllers\RH\LieuAffectationController;
use App\Http\Controllers\RH\LogSessionController;
use App\Http\Controllers\RH\PersonnelController;
use App\Http\Controllers\RH\SecretariatController;
use App\Http\Controllers\RH\SectionController;
use App\Http\Controllers\RH\ServiceController;
use App\Http\Controllers\Taches\TacheController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignaturesMail;
use Illuminate\Support\Str;
use App\Jobs\SendEmail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

//config('jetstream.auth_session')
Route::post('/authentification/connexion', [AuthController::class, 'login'])->name('auth.login');
Route::get('/authentification/mot-de-passe/oublie', [AuthController::class, 'forgotpassword'])->name('auth.forgot.password');
Route::post('/authentification/mot-de-passe/code/confirmation', [AuthController::class, 'confirmationpassword'])->name('auth.confirmation.code');
Route::post('/authentification/mot-de-passe/code/verification', [AuthController::class, 'verificationcode'])->name('auth.verification.code');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/authentication/reset-password', function () {
        return view('auth.reset-password');
    })->name('update.password');

    Route::middleware('isFirstUse')->group(function () {
        Route::group(['as' => 'regidoc.'], function () {
            Route::get('/', HomeController::class)->name('home');

            // Documents
            Route::resource('documents', DocumentController::class);
            Route::get('system/documents/show/task', [DocumentController::class, 'showDoc'])->name('documents.showDoc');
            Route::get('system/documents/sign/task', [DocumentController::class, 'sign'])->name('documents.sign');
            Route::get('system/documents/new/doc', [DocumentController::class, 'createNew'])->name('documents.createNew');
            Route::post('documents/to/arches', [DocumentController::class, 'archive'])->name('documents.archive');
            Route::post('documents/desarchiver/from/arches', [DocumentController::class, 'desarchiver'])->name('documents.desarchiver');
            Route::resource('documents/classeurs', ClasseurController::class);
            Route::resource('documents/classeurs.dossiers', DossierController::class);
            Route::resource('documents/dossiers', DossierController::class);
            Route::post('documents/dossiers/access', [DossierController::class, 'access'])->name('dossiers.access');
            Route::post('documents/dossiers/access', [DossierController::class, 'access'])->name('dossiers.access');

            
       


            // Archivage  
            Route::resource('archivages', ArchiveController::class);
            Route::resource('archive-classeurs', ArchivesClasseurController::class)->except('index');
            Route::get('archive-classeurs/list/{annee}', [ArchivesClasseurController::class, 'index'])->name('archive-classeurs.index');
            Route::resource('archive-classeurs.archive-dossiers', ArchivesDossierController::class);
            Route::resource('archivages/directions.dossiers', ArchivesDossierController::class);
            Route::get('archive-documents/{document}', [ArchivesDocumentController::class, 'show'])->name('archive-documents.show');


            Route::resource('archivages/dossier', ArchivesDossierController::class);

            Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
            Route::get('/chats/{id}', [ChatController::class, 'chats'])->name('chats');

            Route::get('/mon-profil', [ProfilController::class, 'index'])->name('profil.index');
            Route::put('/mon-profil/avatar', [ProfilController::class, 'updateAvatar'])->name('profil.updateAvatar');
            Route::post('/mon-profil/delegues/save', [ProfilController::class, 'delegueSave'])->name('profil.delegueSave');
            Route::get('/mon-profil/delegues/remove', [ProfilController::class, 'delegueRemove'])->name('profil.delegueRemove');

            // Ressources humaines / Personnels / Planning
            Route::post('/ressources-humaines/personnels/planning/update', [App\Http\Controllers\Rh\PersonnelController::class, 'updateplanning'])->name('rh.user.planning.update');
            // Ressources humaines / Contrats
            // Route::get('/ressources-humaines/contrat/{id}/{value}', [App\Http\Controllers\Rh\ContratController::class, 'contrat'])->name('rh.user.contrat');
            // Route::get('/ressources-humaines/contrats', [App\Http\Controllers\Rh\ContratController::class, 'index'])->name('rh.contrat.index');
            // Route::post('/ressources-humaines/contrat/store', [App\Http\Controllers\Rh\ContratController::class, 'store'])->name('rh.user.contrat.store');
            // Route::post('/ressources-humaines/contrat/update', [App\Http\Controllers\Rh\ContratController::class, 'update'])->name('rh.user.contrat.update');
            // Route::post('/ressources-humaines/contrat/document/store', [App\Http\Controllers\Rh\ContratController::class, 'documentstore'])->name('rh.user.document.store');
            // Route::get('/ressources-humaines/contrat/delete/{id}', [App\Http\Controllers\Rh\ContratController::class, 'destroy'])->name('rh.contrat.destroy');
            // Ressources humaines / Types Contrats
            // Route::get('/ressources-humaines/types-contrats', [App\Http\Controllers\Rh\TypeContratController::class, 'index'])->name('rh.typecontrat.index');
            // Route::post('/ressources-humaines/types-contrat/store', [App\Http\Controllers\Rh\TypeContratController::class, 'store'])->name('rh.typecontrat.store');
            // Route::post('/ressources-humaines/types-contrat/update', [App\Http\Controllers\Rh\TypeContratController::class, 'update'])->name('rh.typecontrat.update');
            // Route::get('/ressources-humaines/types-contrat/delete/{id}', [App\Http\Controllers\Rh\TypeContratController::class, 'destroy'])->name('rh.typecontrat.destroy');
            // // Ressources humaines / Congés
            // Route::get('/ressources-humaines/conges', [App\Http\Controllers\Rh\CongeController::class, 'index'])->name('rh.conges.index');
            // Route::post('/ressources-humaines/conges/store', [App\Http\Controllers\Rh\CongeController::class, 'store'])->name('rh.conges.store');
            // Route::post('/ressources-humaines/conges/update', [App\Http\Controllers\Rh\CongeController::class, 'update'])->name('rh.conges.update');
            // Route::get('/ressources-humaines/conge/delete/{id}', [App\Http\Controllers\Rh\CongeController::class, 'destroy'])->name('rh.conges.destroy');
            // // Ressources humaines / Absences
            // Route::get('/ressources-humaines/absences', [App\Http\Controllers\Rh\AbsenceController::class, 'index'])->name('rh.absences.index');
            // Route::post('/ressources-humaines/absences/store', [App\Http\Controllers\Rh\AbsenceController::class, 'store'])->name('rh.absences.store');
            // Route::post('/ressources-humaines/absences/update', [App\Http\Controllers\Rh\AbsenceController::class, 'update'])->name('rh.absences.update');
            // Route::get('/ressources-humaines/absence/delete/{id}', [App\Http\Controllers\Rh\AbsenceController::class, 'destroy'])->name('rh.absences.destroy');
            // // Ressources humaines / Type d'absences
            // Route::post('/ressources-humaines/type-absences/store', [App\Http\Controllers\Rh\TypeAbsenceController::class, 'store'])->name('rh.types.absences.store');
            // Route::post('/ressources-humaines/type-absences/update', [App\Http\Controllers\Rh\TypeAbsenceController::class, 'update'])->name('rh.types.absences.update');
            // Route::get('/ressources-humaines/type-absence/delete/{id}', [App\Http\Controllers\Rh\TypeAbsenceController::class, 'destroy'])->name('rh.types.absences.destroy');
            // // Ressources humaines / Personnels / Conges
            // Route::post('/ressources-humaines/personnels/conge/store', [App\Http\Controllers\Rh\PivotUserCongeController::class, 'store'])->name('rh.user.conges.store');
            // Route::post('/ressources-humaines/personnels/conge/update', [App\Http\Controllers\Rh\PivotUserCongeController::class, 'update'])->name('rh.user.conges.update');
            // Route::get('/ressources-humaines/personnels/conge/delete/{id}', [App\Http\Controllers\Rh\PivotUserCongeController::class, 'destroy'])->name('rh.user.conges.destroy');
            // Ressources humaines / Services
            Route::get('/ressources-humaines/services', [App\Http\Controllers\Rh\ServiceController::class, 'index'])->name('rh.services.index');
            Route::post('/ressources-humaines/services/store', [App\Http\Controllers\Rh\ServiceController::class, 'store'])->name('rh.services.store');
            Route::post('/ressources-humaines/services/update', [App\Http\Controllers\Rh\ServiceController::class, 'update'])->name('rh.services.update');
            Route::get('/ressources-humaines/service/delete/{id}', [App\Http\Controllers\Rh\ServiceController::class, 'destroy'])->name('rh.services.destroy');
            // // Ressources humaines / Plannings
            // Route::get('/ressources-humaines/plannings', [App\Http\Controllers\Rh\PlanningController::class, 'index'])->name('rh.plannings.index');
            // Route::post('/ressources-humaines/plannings/store', [App\Http\Controllers\Rh\PlanningController::class, 'store'])->name('rh.plannings.store');
            // Route::post('/ressources-humaines/plannings/update', [App\Http\Controllers\Rh\PlanningController::class, 'update'])->name('rh.plannings.update');
            // Route::get('/ressources-humaines/planning/delete/{id}', [App\Http\Controllers\Rh\PlanningController::class, 'destroy'])->name('rh.plannings.destroy');
            // // Ressources humaines / Pointages
            // Route::get('/ressources-humaines/pointages', [App\Http\Controllers\Rh\PointageController::class, 'index'])->name('rh.pointages.index');
            // Route::post('/ressources-humaines/pointages/store', [App\Http\Controllers\Rh\PointageController::class, 'store'])->name('rh.pointages.store');
            // Route::post('/ressources-humaines/pointages/update', [App\Http\Controllers\Rh\PointageController::class, 'update'])->name('rh.pointages.update');
            // Route::get('/ressources-humaines/pointage/delete/{id}', [App\Http\Controllers\Rh\PointageController::class, 'destroy'])->name('rh.pointages.destroy');
            // Ressources humaines / Postes
            Route::get('/ressources-humaines/postes', [App\Http\Controllers\Rh\PosteController::class, 'index'])->name('rh.postes.index');
            Route::post('/ressources-humaines/postes/store', [App\Http\Controllers\Rh\PosteController::class, 'store'])->name('rh.postes.store');
            Route::post('/ressources-humaines/postes/update', [App\Http\Controllers\Rh\PosteController::class, 'update'])->name('rh.postes.update');
            Route::get('/ressources-humaines/poste/delete/{id}', [App\Http\Controllers\Rh\PosteController::class, 'destroy'])->name('rh.postes.destroy');
            // Ressources humaines / Catégories de Poste
            Route::post('/ressources-humaines/postes/categories/store', [App\Http\Controllers\Rh\PosteCategorieController::class, 'store'])->name('rh.poste.categories.store');
            Route::post('/ressources-humaines/postes/categories/update', [App\Http\Controllers\Rh\PosteCategorieController::class, 'update'])->name('rh.poste.categories.update');
            Route::get('/ressources-humaines/postes/categorie/delete/{id}', [App\Http\Controllers\Rh\PosteCategorieController::class, 'destroy'])->name('rh.poste.categories.destroy');
            // Ressources humaines / Classifications de Poste
            Route::post('/ressources-humaines/postes/classifications/store', [App\Http\Controllers\Rh\PosteClassificationController::class, 'store'])->name('rh.poste.classifications.store');
            Route::post('/ressources-humaines/postes/classifications/update', [App\Http\Controllers\Rh\PosteClassificationController::class, 'update'])->name('rh.poste.classifications.update');
            Route::get('/ressources-humaines/postes/classification/delete/{id}', [App\Http\Controllers\Rh\PosteClassificationController::class, 'destroy'])->name('rh.poste.classifications.destroy');

            // personnels
            Route::resource('/ressources-humaines/personnels', PersonnelController::class);
            Route::post('/ressources-humaines/infos-personnels/update', [PersonnelController::class, 'updateperso'])->name('rh.user.perso.update');
            Route::put('/ressources-humaines/personnels/password/update/auth', [PersonnelController::class, 'updateAuth'])->name('rh.user.update.auth');
            Route::put('/ressources-humaines/personnels/update/permissions', [PersonnelController::class, 'permissions'])->name('rh.user.permissions');
            Route::post('/ressources-humaines/personnels/password/update', [PersonnelController::class, 'updatepassword'])->name('rh.user.update.password');
            Route::get('/ressources-humaines/personnels/{agent}/suspendre/contrat', [PersonnelController::class, 'suspension'])->name('rh.contrat.suspension');
            Route::get('/ressources-humaines/personnels/{agent}/renouveler/contrat', [PersonnelController::class, 'activate'])->name('rh.contrat.activate');
            Route::get('/ressources-humaines/personnels/{agent}/{doc}/archived', [PersonnelController::class, 'archived'])->name('rh.agent.archived');
            Route::get('/ressources-humaines/personnels/{agent}/{doc}/desarchived', [PersonnelController::class, 'desarchived'])->name('rh.agent.desarchived');
            // End RH

            Route::get('push/key', [NotificationSubscriptionController::class, 'key']);
            // Route::post('push/subscribe', [NotificationSubscriptionController::class, 'register']);

            Route::post('/notifications/subscribe', [NotificationSubscriptionController::class, 'subscribe']);
            Route::post('/notifications/unsubscribe', [NotificationSubscriptionController::class, 'unsubscribe']);

            // Taches
            Route::resource('taches', TacheController::class);
            Route::get('/taches/finish/{id}', [TacheController::class, 'finish'])->name('taches.finish');
            Route::get('/taches/remettre/encours/{id}', [TacheController::class, 'remettreEncours'])->name('taches.remettreEncours');
            Route::post('/taches/fichier/store', [TacheController::class, 'storefichier'])->name('fichier.store');


            // Courriers
            
            Route::resource('courriers', CourrierController::class);
            Route::get('courriers/{id}/destroy', [CourrierController::class, 'destroy'])->name('my.courriers.destroy');
            Route::get('courriers/classify/{id}', [CourrierController::class, 'classify'])->name('courriers.classify');
            Route::get('courriers/signer/{id}', [CourrierController::class, 'signer'])->name('courriers.signer');


            Route::prefix('courriers')->group(function () {
                Route::post('partages', [CourrierController::class, 'partages'])->name('courriers.partages');
                Route::get('/receptions', [CourrierController::class, 'receivedMails'])->name('courriers.received');
                Route::get('/envoyes', [CourrierController::class, 'sendMails'])->name('courriers.sent');
                Route::get('/nouveau', [CourrierController::class, 'create'])->name('courriers.add');
                Route::post('/save/signature', [CourrierController::class, 'saveSignature'])->name('courriers.saveSignature');
                Route::post('{id}/save/traitement', [CourrierController::class, 'saveTraitement'])->name('courriers.saveTraitement');
                Route::get('{id}/relance', [CourrierController::class, 'relance'])->name('courriers.relance');
                Route::get('{id}/traitement', [CourrierController::class, 'traitement'])->name('courriers.traitement');
                Route::get('{id}/confidentiel', [CourrierController::class, 'confidentiel'])->name('courriers.confidentiel');
                Route::get('{id}/nonconfidentiel', [CourrierController::class, 'nonconfidentiel'])->name('courriers.nonconfidentiel');
                // Route::get('/finish/{id}', [CourrierController::class, 'finish'])->name('courriers.finish');
            });

            Route::post('/upload', [UploadController::class, 'store']);
            Route::post('/courriers/upload-scan', [App\Http\Controllers\Courriers\CourrierController::class, 'handleScanUpload'])
    ->name('courriers.uploadScan');


            Route::prefix('systemes')->group(function () {
                Route::resource('sections', SectionController::class)->only('index', 'store', 'update', 'destroy');
                Route::resource('logs', LogSessionController::class)->only('index');
                Route::resource('directions', DirectionController::class)->only('index', 'store', 'update', 'destroy');
                Route::resource('divisions', DivisionController::class)->only('index', 'store', 'update', 'destroy');
                Route::resource('services', ServiceController::class)->only('index', 'store', 'update', 'destroy');
                Route::resource('fonctions', FonctionController::class)->only('index', 'store', 'update', 'destroy');
                Route::resource('secretariats', SecretariatController::class)->only('index', 'store', 'update', 'destroy');
                Route::resource('assistants', AssistanatController::class)->only('index', 'store', 'update', 'destroy');
                Route::resource('grades', GradeController::class)->only('index', 'store', 'update', 'destroy');
                Route::resource('lieux', LieuAffectationController::class)->only('index', 'store', 'update', 'destroy');
                Route::get('/sessions/logs/session', [LogSessionController::class, 'index'])->name('session');
            });

            Route::prefix('ajax')->group(function () {
                Route::get('types/courriers', [AjaxController::class, 'typescourriers'])->name('ajax.typescourriers'); 
                Route::get('/priorites', [AjaxController::class, 'priorites'])->name('ajax.priorites');
                Route::get('types/get/all/agents', [DirectionController::class, 'getAgents'])->name('ajax.getAgents');
                Route::get('categories/courriers', [AjaxController::class, 'categorycourriers'])->name('ajax.categorycourriers');
                Route::post('categories/courriers/save', [AjaxController::class, 'categoryCourriersSave'])->name('ajax.categorycourriers.save');
                Route::get('natures/courriers', [AjaxController::class, 'naturecourriers'])->name('ajax.naturecourriers');
                Route::post('natures/courriers/save', [AjaxController::class, 'natureCourriersSave'])->name('ajax.naturecourriers.save');
                Route::get('expediteurs/courriers', [AjaxController::class, 'expediteurcourriers'])->name('ajax.expediteurcourriers');
                Route::post('expediteurs/courriers/save', [AjaxController::class, 'expediteurCourriersSave'])->name('ajax.expediteurcourriers.save');
                Route::get('destinataires/courriers', [AjaxController::class, 'destinatairecourriers'])->name('ajax.destinatairecourriers');
                Route::post('destinataires/courriers/save', [AjaxController::class, 'destinatairecourriersSave'])->name('ajax.destinatairecourriers.save');

                Route::get('signatures/get/user/image', [AjaxController::class, 'getUserSignature'])->name('ajax.signature');
                Route::post('signatures/save/user/image', [AjaxController::class, 'saveUserSignature'])->name('ajax.signature.save');

                Route::get('signatures/get/user/tampon/image', [AjaxController::class, 'getUserTampon'])->name('ajax.tampon');
                Route::post('signatures/save/user/tampon/image', [AjaxController::class, 'saveUserTampon'])->name('ajax.tampon.save');

                Route::get('signatures/get/user/paraphe/image', [AjaxController::class, 'getUserParaphe'])->name('ajax.paraphe');
                Route::post('signatures/save/user/paraphe/image', [AjaxController::class, 'saveUserParaphe'])->name('ajax.paraphe.save');

                // Route::post('signatures/save', [AjaxController::class, 'storeFile'])->name('ajax.document.save');
                Route::post('validations/save', [AjaxController::class, 'validations'])->name('ajax.validations.save');
                Route::post('rejets/save', [AjaxController::class, 'rejets'])->name('ajax.rejets.save');

                Route::post('/taches/save/signature', [TacheController::class, 'saveSignature'])->name('taches.saveSignature');
            });
        });
    });
});
Route::post('courriers/scan', [CourrierController::class, 'scan'])->name('courriers.scan');
Route::post('documents/save-pdf', [DocumentController::class, 'storeNew'])->name('documents.storeNew'); 
Route::post('documents/save-as-doc', [DocumentController::class, 'saveDoc'])->name('documents.saveDoc');


// Route::get('documents/pdf-preview', [DocumentController::class, 'showPDFPreview'])->name('regidoc.documents.previewPDF');

Route::get('/document/create', [DocumentController::class, 'createDoc'])->name('document.creation');
Route::post('/document/generate-pdf', [DocumentController::class, 'generatePDF'])->name('generate.pdf');
Route::get('document/preview', [DocumentController::class, 'previewDocument'])->name('regidoc.document.preview');
Route::post('documents/savePDF', [DocumentController::class, 'saveNew'])->name('documents.savePDF');
Route::post('document/deleteTemp',[DocumentController::class,'deleteTempDocument'])->name('documents.deleteTemp');
// Route::get();
// Route::post('/generate-pdf', function () {
//     $data = request()->all();

//     $pdf = Pdf::loadView('regidoc.pages.documents.preview.pdf-documentLetter', $data);

//     return $pdf->download('document.pdf');
// })->name('generate.pdf');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/recherche', function () {
    return view('regidoc.pages.courriers.recherche');
});
Route::get('/parametres', function () {
    return view('regidoc.pages.parametres.index');
});
Route::get('/parametres/organigramme', function () {
    return view('regidoc.pages.parametres.organigramme');
});
Route::get('/new-file', function () {
    return view('regidoc.pages.courriers.new-file');
});
Route::get('/test', function () {
    return view('regidoc.pages.test');
});
Route::get('/template/1', function () {
    return view('regidoc.pages.templates.template-1');
})->name('template-1');
Route::get('/template/letter', function () {
    return view('regidoc.pages.templates.templateLetter');
})->name('template-2');
Route::get('/template/demande-achat', function () {
    return view('regidoc.pages.templates.demande-achat');
})->name('template-3');
Route::get('/template/bon-commande', function () {
    return view('regidoc.pages.templates.bonDeCommande');
})->name('template-4');
Route::get('/template/message-email', function () {
    return view('regidoc.pages.templates.message-email');
})->name('template-5');
Route::get('/template/note_de_service', function () {
    return view('regidoc.pages.templates.note-service');
})->name('template-6');
// Route::get('/template/lettre_interne', function () {
//     return view('regidoc.pages.templates.lettreInterne');
// })->name('template-7');
Route::get('/template/ordre-de-mission', function () {
    return view('regidoc.pages.templates.ordreMission');
})->name('template-7');
Route::get('/template/note-circulaire', function () {
    return view('regidoc.pages.templates.note-circulaire');
})->name('template-8');

Route::get('/dashboard/non-lus', function(){
    return view('regidoc.pages.dashboard.notviewed');
})->name('dashboard.notviewed');
Route::get('/dashboard/en-cours', function(){
    return view('regidoc.pages.dashboard.running');
})->name('dashboard.running');
Route::get('/dashboard/en-retard', function(){
    return view('regidoc.pages.dashboard.late');
})->name('dashboard.late');
Route::get('/dashboard/nouvelles-taches', function(){
    return view('regidoc.pages.dashboard.newtasks');
})->name('dashboard.newtasks');
Route::get('/dashboard/traite', function(){
    return view('regidoc.pages.dashboard.treated');
})->name('dashboard.treated');

// Route::get('/test-email', function() {
//     $to_email = 'merlinhovekams@gmail.com';

//     try {
//         // Mail::raw('Ceci est un email de test.', function ($message) use ($to_email) {
//         //     $message->to($to_email)
//         //             ->subject('Test d\'envoi d\'email');
//         // });
   
//         $password = Str::random(6); 

//         // Mail::to("merlinhovekams@gmail.com")->send(new SignaturesMail($password));
//         SendEmail::dispatch('merlinhovekams@gmail.com', new SignaturesMail($password));

//         return 'Email de test envoyé avec succès.';
//     } catch (\Exception $e) {
//         return 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage();
//     }
// });