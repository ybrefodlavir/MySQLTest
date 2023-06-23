<!doctype html>
<html lang="en">

<head>
    <title>TESTING MYSQL</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

</head>

<body>
    <div class="w-screen h-screen bg-gray-800 flex flex-col place-content-center text-white">

        @foreach ($materials as $material)
            <a href="/material/{{ $material->id }}"
                class="w-1/2 h-32 bg-{{ $material->color }} place-self-center my-2 rounded-full text-center pt-12 text-black text-2xl font-medium">
                {{ $material->name }}
            </a>
        @endforeach
    </div>
</body>

</html>
