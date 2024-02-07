<x-admin.content title="Users">
    <form
        action="{{ route('admin.users.index') }}"
        hx-boost="true"
        hx-headers-merge="{{ '{"X-HX-Page": true}' }}"
        hx-swap="innerHTML show:no-scroll"
        hx-target="find tbody"
        hx-trigger="input changed delay:400ms from:[name]"
    >
        <x-admin.table id="users-table">
            <x-slot:head>
                <x-admin.table.header.text-filter
                    class="w-1/2"
                    filter="name"
                    label="Name"
                />
                <x-admin.table.header.text-filter
                    class="w-1/2"
                    filter="email"
                    label="Email"
                />
            </x-slot>
            <x-slot:body>
                @include('admin.users.page')
            </x-slot>
        </x-admin.table>
    </form>
</x-admin.content>