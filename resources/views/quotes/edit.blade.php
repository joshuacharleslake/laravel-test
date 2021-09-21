<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($quote->exists)
                {{ __('Edit Quote') }}
            @else
                {{ __('Add Quote') }}
            @endif
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-validation-errors class="mb-4" :errors="$errors" />
                    <x-success-message class="mb-4" />

                    <form method="POST" action="{{ $quote->exists ? route('quotes.update', ['quote' => $quote]) : route('quotes.store') }}">

                        @if($quote->exists)
                            @method('PUT')
                        @endif

                        @csrf

                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name"
                                     class="block mt-1 w-full"
                                     type="text"
                                     name="name"
                                     value="{{ old('name') ?? $quote->name }}"
                                     required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="description" :value="__('Description')" />

                            <x-input id="description"
                                     class="block mt-1 w-full"
                                     type="text"
                                     name="description"
                                     value="{{ old('email') ?? $quote->description }}"
                                     required />
                        </div>

                        <!-- Quote Builder -->
                        <div class="mt-4">
                            <x-label for="quote-builder" :value="__('Quote Builder')" />

                            <x-input id="quote-builder"
                                     class="js-quote-builder-input block mt-1 w-full"
                                     type="hidden"
                                     name="quote-builder"
                                     value="{{ old('email') ?? $quote->content }}"
                                     required />

                            <div id="js-quote-builder" class="rounded-md shadow-sm border mt-1"></div>

                            <a class="js-editor-save">>> Console Log Page Builder Content</a>

                            {{-- @TODO - Move temporary page builder styles to stylesheet --}}
                            <style>
                                .ce-block__content, .ce-toolbar__content { max-width:calc(100% - 80px) !important; } .cdx-block { max-width: 100% !important; }
                                .block-quote-title-page {
                                    border: 1px solid #f1f1f1;
                                    padding: 20px;
                                }
                                .ce-block__content h1 {
                                    font-size: 20px;
                                    color: red;
                                    font-weight:bold;
                                }
                            </style>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="js-quote-save-submit ml-4">
                                @if($quote->exists)
                                    {{ __('Update Quote') }}
                                @else
                                    {{ __('Create Quote') }}
                                @endif
                            </x-button>
                        </div>
                    </form>
                    @if($quote->exists)
                        <form method="POST" action="{{ route('quotes.destroy', ['quote' => $quote]) }}">
                            @method('DELETE')
                            @csrf
                            <x-button class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-sm">
                                {{ __('Delete Quote') }}
                            </x-button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
