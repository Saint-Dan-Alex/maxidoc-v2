<form wire:submit.prevent="updatePassword">

    <div class="form-group row g-3">
        
        <div class="col-12 position-relative">
            <x-jet-input id="current_password" class="input-password" type="password" wire:model.defer="state.current_password" autocomplete="current-password"
                placeholder="{{ __('Current Password') }}"/>
            <i class="fi fi-rr-lock-alt position-absolute icon-form"></i>
            <div class="btn-show-password show-password" id="show-password">
                <div>
                    <i class="fi fi-rr-eye"></i>
                    <i class="fi fi-rr-eye-crossed"></i>
                </div>
                <div class="tooltip-team">
                    <span>Voir</span>
                    <span>Cacher</span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <x-jet-input-error for="current_password" class="message-input input-password"/>
        </div>

        <div class="col-12 position-relative">
            <x-jet-input id="password" class="input-password" type="password" wire:model.defer="state.password" autocomplete="new-password"
                placeholder="{{ __('New Password') }}"/>
            <i class="fi fi-rr-lock-alt position-absolute icon-form"></i>
            <div class="btn-show-password show-password" id="show-password">
                <div>
                    <i class="fi fi-rr-eye"></i>
                    <i class="fi fi-rr-eye-crossed"></i>
                </div>
                <div class="tooltip-team">
                    <span>Voir</span>
                    <span>Cacher</span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <x-jet-input-error for="password" class="message-input"/>
        </div>

        <div class="col-12 position-relative">
            <x-jet-input id="password_confirmation" class="input-password" type="password" wire:model.defer="state.password_confirmation" autocomplete="new-password"
                placeholder="{{ __('Confirm Password') }}"/>
            <i class="fi fi-rr-lock-alt position-absolute icon-form"></i>
            <div class="btn-show-password show-password" id="show-password">
                <div>
                    <i class="fi fi-rr-eye"></i>
                    <i class="fi fi-rr-eye-crossed"></i>
                </div>
                <div class="tooltip-team">
                    <span>Voir</span>
                    <span>Cacher</span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <x-jet-input-error for="password_confirmation" class="message-input"/>
        </div>
    </div>

    <div class="mt-2 col-12 d-flex">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button class="btn btn-valid disabled">
            {{ __('Save') }}
        </x-jet-button>
    </div>
</form>