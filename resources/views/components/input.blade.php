@props(['name', 'id', 'type' => 'text', 'label', 'placeholder', 'value', 'required' => false, 'error' => null])

@php
    $inputId = $id ?? $name;
@endphp

<div class="space-y-1">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $inputId }}"
        value="{{ $value ?? old($name) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-colors duration-200 ' . ($error ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : '')]) }}
    >

    @if($error)
        <p class="text-sm text-red-600">{{ $error }}</p>
    @endif

    @if($slot)
        <p class="text-sm text-gray-500">{{ $slot }}</p>
    @endif
</div>