<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{ Storage::disk('uploads')->url('favicons/favicon.pngs') }}" sizes="32x32" />
    @vite('resources/js/app.js')
    @inertiaHead
</head>
<body>
    <div id="website"></div>
</body>
</html>
