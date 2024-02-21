@if (filled($brand = config('filament.brand')))
{{--    <div @class([--}}
{{--        'filament-brand text-xl font-bold tracking-tight',--}}
{{--        'dark:text-white' => config('filament.dark_mode'),--}}
{{--    ])>--}}
{{--        {{ $brand }}--}}
{{--    </div>--}}
    <img src="{{ Storage::disk('uploads')->url('logo/kettlitz_esg_logo.webp') }}" alt="Logo" class="h-10">

@endif
