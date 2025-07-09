<div class="assignation-item">
    <div class="d-flex">
        <select class="form-select select2 select-assigne" aria-label="Default select example" name="{{ $name }}[]"
            required>
            <option selected disabled value="">Selectionner</option>
            @foreach ($objects as $object)
                <option value="{{ $object->id }}">
                    @if ($name == 'agent_id')
                        {{ $object->prenom }}
                        {{ $object->nom }}
                        {{ $object->post_nom }}
                    @else
                        {{ $object->{$title} }}
                    @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="mt-1 d-flex align-items-start position-relative">
        <div class="flex-grow-1 objectif-container">
            <div class="objectif-item">
                <input type="text" name="objects[][]" class="form-control tache-target"
                    placeholder="Tâche à réaliser">
            </div>

            <div class="objectif-item-append"></div>

            <div class="mt-1 objectif-item-template" style="display: none">
                <div class="mt-1 d-flex">
                    <input type="text" data-name="objects[][]" class="form-control flex-grow-1"
                        placeholder="Tâche à réaliser">
                    <a href="javascript:void(0)" class="p-0 m-1 btn text-danger d-block btn-remove-objectif">
                        <i class="fi fi-rr-trash"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="px-2 py-1 position-absolute " style="right: 3px; top: 3px;">
            <a href="javascript:void(0)" class="p-0 btn d-block btn-add-objectif" style="font-size:12px">
                <i class="fi fi-rr-plus"></i>
            </a>
        </div>
    </div>
</div>

<div class="assignation-item-append"></div>

<div class="assignation-item-template" style="display: none">
    <div class="mt-3 assignation-item">
        <div class="d-flex">
            <select class="form-select" aria-label="Default select example" data-name="{{ $name }}[]">
                <option selected disabled value="">Selectionner</option>
                @foreach ($objects as $object)
                    <option value="{{ $object->id }}">
                        @if ($name == 'agent_id')
                            {{ $object->prenom }}
                            {{ $object->nom }}
                            {{ $object->post_nom }}
                        @else
                            {{ $object->{$title} }}
                        @endif
                    </option>
                @endforeach
            </select>
            <a href="javascript:void(0)" class="p-0 m-1 btn text-danger d-block btn-remove-assignation">
                <i class="fi fi-rr-trash"></i>
            </a>
        </div>

        <div class="mt-1 d-flex align-items-start">
            <div class="flex-grow-1 objectif-container">
                <div class="objectif-item">
                    <input type="text" data-name="objects[][]" class="form-control" placeholder="Tâche à réaliser">
                </div>

                <div class="objectif-item-append"></div>

                <div class="mt-1 objectif-item-template" style="display: none">
                    <div class="mt-1 d-flex">
                        <input type="text" data-name="objects[][]" class="form-control flex-grow-1"
                            placeholder="Tâche à réaliser">
                        <a href="javascript:void(0)" class="p-0 m-1 btn text-danger d-block btn-remove-objectif">
                            <i class="fi fi-rr-trash"></i>
                        </a>
                    </div>
                </div>

            </div>
            <div class="px-2 py-1">
                <a href="javascript:void(0)" class="p-0 btn d-block btn-add-objectif">
                    <i class="fi fi-rr-plus"></i>
                </a>
            </div>
        </div>

    </div>
</div>
