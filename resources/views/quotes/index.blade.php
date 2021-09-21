<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quotes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Validation Errors -->
                    <x-validation-errors class="mb-4" :errors="$errors" />
                    <x-success-message class="mb-4" />

                    <div class="inline-block w-full">
                        <a href="{{ route('quotes.create') }}"
                           class="mb-5 px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm float-right">
                            Add New Quote
                        </a>
                    </div>

                    <div class="block mb-5">
                        <form action="{{ route('quotes.index') }}" method="GET" role="search">

                            @method('GET')
                            @csrf

                            <!-- Search -->
                            <div>
                                <x-label for="search" :value="__('Search')" />

                                <x-input id="name"
                                         class="block mt-1 w-full"
                                         type="text"
                                         name="search"
                                         placeholder="{{ __('Search ...') }}"
                                         autofocus />
                            </div>
                        </form>
                    </div>

                    <section class="container w-full">
                        <div class="w-full mb-8 overflow-hidden rounded-lg">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 border-b border-gray-600">
                                        <th class="px-4 py-3">ID</th>
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="">
                                    @foreach($quotes as $key => $quote)
                                    <tr class="text-gray-700 border">
                                        <td class="px-4 py-3 text-ms font-semibold border border-l">{{ $quote->id }}</td>
                                        <td class="px-4 py-3 border">
                                            <p class="font-semibold text-black">{{ $quote->name }}</p>
                                        </td>
                                        <td class="px-4 py-3 text-xs border">

                                            <a href="{{ route('quotes.edit', ['quote' => $quote ]) }}"
                                               class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                Edit Quote
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    {{ $quotes->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
