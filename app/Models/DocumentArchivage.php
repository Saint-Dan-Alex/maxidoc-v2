<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentArchivage extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public function user() {
    //     return $this->belongsTo(User::class);
    // }

    public function statut() {
        return $this->belongsTo(Statut::class);
    }

   public function dossier()
   {
       return $this->belongsTo(Dossier::class, 'dossier_id');
   }

   /**
    * Get the classeur that owns the Document
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function classeur()
   {
       return $this->belongsTo(Classeur::class, 'classeur_id');
   }

   public function personnel()
   {
       return $this->belongsTo(personel::class, 'created');
   }

   /**
    * Get the user that owns the Document
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function user()
   {
       return $this->belongsTo(User::class, 'created');
   }

   public function user_created()
   {
       return $this->belongsTo(User::class, 'created_file');
   }
   /**
    * Get the role associated with the Document
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function poste()
   {
       return $this->belongsTo(Role::class,'role');
   }
}
