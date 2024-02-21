import { Draggable } from '@shopify/draggable';

document.addEventListener('DOMContentLoaded', () => {
    const draggablePage = document.querySelector('.draggable-page');
    if (draggablePage) {
        const draggable = new Draggable(draggablePage, {
            draggable: '.filament-resources-list-records-page',
        });

        draggable.on('drag:start', () => {
            console.log('Drag started');
        });

        draggable.on('drag:stop', () => {
            console.log('Drag stopped');
        });
    }
});
