<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($client_user->exists)
                {{ __('Edit Client User') }}
            @else
                {{ __('Add Client User') }}
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

                    <form method="POST" action="{{ $client_user->exists ? route('client-users.update', ['client_user' => $client_user]) : route('client-users.store') }}">

                        @if($client_user->exists)
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
                                     value="{{ old('name') ?? $client_user->name }}"
                                     required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email"
                                     class="block mt-1 w-full"
                                     type="email"
                                     name="email"
                                     value="{{ old('email') ?? $client_user->email }}"
                                     required />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />

                            <x-input id="password" class="block mt-1 w-full"
                                     type="password"
                                     name="password"
                                     required autocomplete="new-password" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                     type="password"
                                     name="password_confirmation" required />
                        </div>

                        <!-- Client -->
                        <div class="mt-4">
                            <x-label for="client_id" :value="__('Assign Client')" />

                            <div class="relative inline-block w-full text-gray-700">
                                <select class="w-full h-10 pl-3 pr-6 text-base placeholder-gray-600 border rounded-lg appearance-none focus:shadow-outline"
                                        id="client_id"
                                        name="client_id">
                                    <option disabled>{{ __('Please Select...') }}</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client['id'] }}"
                                                @if(request()->get('client_id') == $client['id'] || $client_user->client_id === $client['id'] )
                                                selected="selected"
                                                @endif>
                                            {{ $client['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                @if($client_user->exists)
                                    {{ __('Update Client User') }}
                                @else
                                    {{ __('Create Client User') }}
                                @endif
                            </x-button>
                        </div>
                    </form>



                    @if($client_user->exists)
                        <form method="POST" action="{{ route('client-users.destroy', ['client_user' => $client_user]) }}">
                            @method('DELETE')
                            @csrf
                            <x-button class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-sm">
                                {{ __('Delete Client User') }}
                            </x-button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
