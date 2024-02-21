<ul wire:sortable="updateTaskOrder">

@if (isset($tasks))
    @foreach ($tasks as $task)

        <li wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}">

            <h4 wire:sortable.handle>{{ $task->title }}</h4>

        </li>

    @endforeach
@else
    <p>No pages available.</p>
    @endif

    </ul>
{{--@livewireScripts--}}
{{--    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>--}}

