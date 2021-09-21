@props(['errors'])

@if (session('message'))
    <div {{ $attributes }}>
        <div class="font-medium text-green-600">
            {{ __('Success') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-green-600">

            <li>{{ session('message') }}</li>

        </ul>
    </div>
@endif
