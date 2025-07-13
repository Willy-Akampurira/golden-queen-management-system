@props([
    'icon' => '',
    'label' => '',
    'value' => '',
    'color' => 'gray'
])

<div class="bg-white rounded-lg shadow p-4 flex items-center gap-4">
    <div class="p-2 rounded-full text-xl bg-{{ $color }}-100 text-{{ $color }}-600">
        {{ $icon }}
    </div>
    <div>
        <div class="text-lg font-semibold">{{ $value }}</div>
        <div class="text-sm text-gray-500">{{ $label }}</div>
    </div>
</div>
