<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

        {!! SEOMeta::generate() !!}
        {!! OpenGraph::generate() !!}
        {!! Twitter::generate() !!}

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="/uploads/favicons/favicon.png" sizes="32x32" />
</head>
<body>
@switch(true)

    @case(!empty($data))
    <div id="app">
        <App :pages="{{ $data['pages'] }}" :sections="{{ $data['page']->sections }}" :services="{{ $data['services'] }}" :employees="{{ $data['employees'] }}" :articles="{{$data['articles']}}" :articles="{{$data['articles']}}" :settings="{{$data['settings']}}"></App>
    </div>
    @break

    @case(!empty($employeeData))
    <div id="app">
        <App :employee="{{ $employeeData['employee'] }}" :pages="{{ $employeeData['pages'] }}" :services="{{ $employeeData['services'] }}" :settings="{{$employeeData['settings']}}"></App>
    </div>
    @break

    @case(!empty($serviceData))
    <div id="app">
        <App :service="{{ $serviceData['service'] }}" :sections="{{ $serviceData['service']->sections }}"  :pages="{{ $serviceData['pages'] }}" :services="{{ $serviceData['services'] }}" :settings="{{$serviceData['settings']}}"></App>
    </div>
    @break

    @case(!empty($articleData))
    <div id="app">
        <App :article="{{ $articleData['article'] }}" :sections="{{ $articleData['article']->sections }}" :pages="{{ $articleData['pages'] }}" :services="{{ $articleData['services'] }}" :settings="{{$articleData['settings']}}"></App>
    </div>
    @break

    @default
    Page not found
@endswitch
    @vite('resources/js/app.js')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</body>
</html>
