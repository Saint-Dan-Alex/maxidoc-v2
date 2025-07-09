<div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    @foreach ($options->headers as $header)
                        <th>
                            <a href="javascript:void(0)" class="d-flex justify-content-between">
                                <span>{{ Str::{$options->header_case ?? 'lower'}($header) }}</span>
                                <i class="fi fi-angle-up-down"></i>
                            </a>
                        </th>
                    @endforeach
                </tr>
            </thead>
            {{-- @forelse ($options->headers as $header)
                <tr></tr>
            @empty

            @endforelse --}}
        </table>
    </div>

    <div class="d-flex justify-content-between">
        <div class="sort_date_section">
            Afficher
            <select name="perPage" id="" wire:model='perPage'>
                @foreach ($options->num_data_per_page ?? [] as $per_page)
                    <option value="{{ $per_page }}" @selected ($loop->first)>{{ $per_page }}</option>
                @endforeach
            </select>
            par pages
        </div>
        <div class="pagidation_section">
            {!! $data->links() !!}
        </div>
    </div>
</div>
