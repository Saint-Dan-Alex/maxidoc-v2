<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\ArchivePermission;
use App\Models\Classeur;
use App\Models\Courrier;
use App\Models\Direction;
use App\Models\Division;
use App\Models\Document;
use App\Models\Dossier;
// use App\Models\Permission;
// use App\Models\Permition;
use App\Models\Service;
use App\Models\User;
use App\Policies\ClasseurPolicy;
use App\Policies\CourrierPolicy;
use App\Policies\DirectionPolicy;
use App\Policies\DivisionPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\DossierPolicy;
use App\Policies\ServicePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Courrier::class => CourrierPolicy::class,
        // Classeur::class => ClasseurPolicy::class,
        // Dossier::class => DossierPolicy::class,
        // Document::class => DocumentPolicy::class,
        // Direction::class => DirectionPolicy::class,
        // Division::class => DivisionPolicy::class,
        // Service::class => ServicePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('view', function ($user, $courrier) {
        //     $isDestinateur = $courrier->destinateurs->where('id', $user->agent->id)->count();
        // $isFollower = $courrier->followers->where('id', $user->agent->id)->count();

        // // dd($isDestinateur, $isFollower);
        // return $isDestinateur || $courrier->author->is($user->agent) || $user->agent->isDG() || $isFollower;
        // });

        // // $role = Role::create(['name' => 'Admin']);
        // $permission = Permission::create(['name' => 'Voir les courriers', 'module_id' => 2]);

        // $role->givePermissionTo($permission);

        // User::find(1)->assignRole($role);

        // foreach (Permission::all() as $permission) {
        //     Gate::define($permission->key, function (User $user) use ($permission) {
        //         return in_array($permission->id, $user->permissions->pluck('id')->toArray());
        //     });
        // }

        // foreach (ArchivePermission::all() as $permition) {
        //     Gate::define($permition->key, function (User $user, $type) use ($permition) {
        //         $typeId = $type->id;
        //         $type = get_class($type);

        //         return $user->agent?->permissions->where('permissionable_type', $type)
        //             ->where('permissionable_id', $typeId)
        //             ->where('key', $permition->key)->first() != null;
        //     });
        // }
    }
}