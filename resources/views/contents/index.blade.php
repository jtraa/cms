<x-layout>
    @foreach($tasks as $task)

    {{ $task['title'] }} <br />

        @endforeach
</x-layout>
