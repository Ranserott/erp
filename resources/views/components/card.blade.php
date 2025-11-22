@props(['title' => null, 'actions' => null])

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    @if($title || $actions)
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            @if($title)
                <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
            @endif
            @if($actions)
                <div class="flex items-center space-x-3">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $title || $actions ? 'p-6' : 'p-6 pt-0' }}">
        {{ $slot }}
    </div>
</div>