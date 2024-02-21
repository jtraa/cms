<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
		<link href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

		<link rel="icon" type="image/png" href="images/favicons/cropped-Cirkel_met_beeldmerk_NK_blauw-32x32.png">

		<title>Kettlitz Gevel- en Dakadvies</title>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    </head>
    <body class="antialiased">

    {{ $slot}}

	    <script src="{{ asset('/js/app.js') }}"></script>
	    <script src="{{ asset('/js/main.js') }}"></script>

		<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/@shopify/draggable@1.0.0-beta.13/lib/draggable.bundle.legacy.js"></script>
        <script>
            AOS.init();
            var notyf = new Notyf({dismissible: true,duration:10000})
        </script>
        @if (session()->has('success'))
        <script>
            notyf.success('{{ session('success') }}')
        </script>
        @endif

        @if ($errors->any())
            @foreach($errors->all() as $error)

                <script>
                    notyf.error('{!! $error !!}')
                </script>

            @endforeach
        @endif
        <!--  SCRIPTS End  -->

    </body>
</html>
