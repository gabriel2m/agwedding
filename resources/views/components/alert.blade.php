@props(['message', 'type' => 'info'])

@if ($message)
    <div x-data="{ open: true }">
        <div {{ $attributes->class([
            'my-4 w-full border-l-4',
            match ($type) {
                'success' => 'border-green-600 bg-green-200 p-4 hover:border-green-500',
                'error' => 'border-red-600 bg-red-200 p-4 hover:border-red-500',
                'warning' => 'border-yellow-600 bg-yellow-200 p-4 hover:border-yellow-500',
                'info' => 'border-blue-600 bg-blue-200 p-4 hover:border-blue-500',
            },
        ]) }}
            x-show="open" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
            <div @class([
                'flex justify-between items-center',
                match ($type) {
                    'success' => 'text-green-900',
                    'error' => 'text-red-900',
                    'warning' => 'text-yellow-900',
                    'info' => 'text-blue-900',
                },
            ])>
                <div>
                    {{ $message }}
                </div>
                <div class="cursor-pointer" @click="open = false">
                    <x-icons.x-mark class="h-5" />
                </div>
            </div>
        </div>
    </div>
@endif
