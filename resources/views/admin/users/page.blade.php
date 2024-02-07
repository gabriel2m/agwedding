@if ($users->isEmpty())
    <x-admin.table.row>
        <x-admin.table.cell
            class="text-center"
            colspan="all"
        >
            @lang('No users found')
        </x-admin.table.cell>
    </x-admin.table.row>
@else
    @foreach ($users as $user)
        <x-admin.table.row>
            <x-admin.table.cell
                :font_light="false"
                class="w-1/2"
            >
                {{ $user->name }}
            </x-admin.table.cell>
            <x-admin.table.cell class="w-1/2">
                {{ $user->email }}
            </x-admin.table.cell>
        </x-admin.table.row>
    @endforeach
    <x-admin.table.row>
        <x-admin.table.cell
            :font_light="false"
            colspan="all"
        >
            <div class="min-h-8">
                <div class="content flex w-full">
                    <div class="my-auto">
                        {{ $users->render() }}
                    </div>
                    @if ($users->hasMorePages())
                        <button
                            class="ml-auto h-min rounded border border-slate-200 px-6 py-1.5 text-xs uppercase text-slate-700 hover:bg-neutral-500 hover:bg-opacity-10"
                            hx-disabled-elt="this"
                            hx-get="{{ $users->nextPageUrl() }}"
                            hx-indicator="closest tr"
                            hx-swap="outerHTML"
                            hx-target="closest tr"
                            type="button"
                        >
                            @lang('Load more')
                        </button>
                    @endif
                </div>
                <x-admin.loading class="h-5" />
            </div>
        </x-admin.table.cell>
    </x-admin.table.row>
@endempty