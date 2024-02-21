<div class="height-radio-button relative unclicked" wire:ignore>
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    @if ($isInline())
        <x-slot name="labelSuffix">
            @endif

            <x-filament-support::grid
                :default="$getColumns('default')"
                :sm="$getColumns('sm')"
                :md="$getColumns('md')"
                :lg="$getColumns('lg')"
                :xl="$getColumns('xl')"
                :two-xl="$getColumns('2xl')"
                :is-grid="! $isInline()"
                :attributes="$attributes->merge($getExtraAttributes())->class([
            'filament-forms-radio-component',
            'flex flex-wrap gap-3 ' => $isInline(),
            'gap-2' => ! $isInline(),
        ])"
            >
                @php
                    $isDisabled = $isDisabled();
                @endphp



                <style>

                    .height-radio-button.unclicked {
                        max-height: 300px;
                        overflow-y: hidden;
                    }

                    .height-radio-button {
                        max-height: 500px;
                        overflow-y: scroll;
                    }

                    .custom, .custom:checked, .custom:hover, .custom:focus, .custom:focus-visible, [type=radio]:checked:focus {
                        width: 100%;
                        height: 100%;
                        border-radius: 0;
                        cursor: pointer;
                        pointer-events: all;
                        background: rgba(0, 0, 0, 0%);
                        background-color: rgba(0, 0, 0, 0) !important;
                        border: 0;
                        box-shadow: none;
                        transition: all ease .5s;
                    }

                    .custom:checked, .custom:active, .custom:hover, .custom:focus, .custom:focus-visible, [type=radio]:checked:focus  {
                        box-shadow: rgba(149, 157, 165, 0.2) 0px 3px 7px;
                    }
                    .custom:checked, .custom:active, .custom:focus, .custom:focus-visible, [type=radio]:checked:focus {
                        border: 2px solid #f59e0b;

                    }
                    fieldset.filament-forms-fieldset-component {
                        display:none;
                    }


                </style>
                @foreach ($getOptions() as $value => $label)
                    <div class="flex w-1/2 items-center cursor-pointer relative">

                            <input
                                name="{{ $getId() }}"
                                id="{{ $getId() }}-{{ $value }}"
                                class="absolute custom"
                                type="radio"
                                value="{{ $value }}"
                                dusk="filament.forms.{{ $getStatePath() }}"
                                wire:model="{{ $getStatePath() }}"
                        {{ $getExtraInputAttributeBag()->class([
                            'hidden peer',
                        ]) }}
                            {!! ($isDisabled || $isOptionDisabled($value, $label)) ? 'disabled' : null !!}

                            />

                            <label for="{{ $getId() }}-{{ $value }}"
                                   class="w-full bg-white rounded-lg hover:text-gray-600 hover:bg-gray-100" style="min-height: 250px;">
                                    <div class="w-full block text-center">
                                        <div class="w-full text-lg">
                                            {!! $label !!}
                                        </div>
                                        <div class="w-full">
                                            {{ $getDescription($value) }}
                                        </div>
                                    </div>
                                    <div class="hidden col-span-1 text-blue-600 peer-checked:bg-blue-100 peer-checked:flex">
                                    <svg aria-hidden="true" class="w-8 h-8 justify-center self-center mx-auto"
                                         fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14.0458 3.4856C14.3299 3.78703 14.3158 4.26169 14.0144 4.54579L6.08456 12.0197C5.74829 12.3366 5.22042 12.3269 4.89609 11.9977L2.21576 9.27737C1.92504 8.98231 1.92856 8.50745 2.22361 8.21674C2.51867 7.92602 2.99353 7.92954 3.28424 8.22459L5.51839 10.4921L12.9856 3.45421C13.287 3.17011 13.7617 3.18416 14.0458 3.4856Z"/>
                                    </svg>
                                </div>
                            </label>
                    </div>
                @endforeach
                <div class="flex w-full justify-center absolute bottom-0">
                    <a name="show" id="showall"
                       class="cursor-pointer filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action"
                       wire:ignore >
                        Show all
                    </a>
                </div>

                <script>
                    // Get a reference to the "Show All" button by its ID
                    const showAllButton = document.getElementById('showall');
                    showAllButton.addEventListener('click', function(event) {


                        // Your code here
                        showAllButton.style.display = 'none';
                        const radioButtons = document.querySelectorAll('.height-radio-button');
                        radioButtons.forEach((button) => {
                            button.classList.remove('unclicked');
                        });
                        event.stopPropagation();

                        return false; // Prevents the page from refreshing
                    });
                </script>
            </x-filament-support::grid>

            @if ($isInline())
        </x-slot>
    @endif
</x-dynamic-component>
</div>
