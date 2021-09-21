<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($user->exists)
                {{ __('Edit User') }}
            @else
                {{ __('Add User') }}
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

                    @if($user->exists)
                        {{ __('Edit User') }}
                    @else
                        {{ __('Add User') }}
                    @endif

                        <form method="POST" action="{{ $user->exists ? route('users.update', ['user' => $user]) : route('users.store') }}">

                            @if($user->exists)
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
                                     value="{{ old('name') ?? $user->name }}"
                                     required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email"
                                     class="block mt-1 w-full"
                                     type="email"
                                     name="email"
                                     value="{{ old('email') ?? $user->email }}"
                                     required />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="password" :value="__('Password')" />

                            <x-input id="password" class="block mt-1 w-full"
                                     type="password"
                                     name="password"
                                     required
                                     autocomplete="new-password" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                     type="password"
                                     name="password_confirmation" required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                @if($user->exists)
                                    {{ __('Update User') }}
                                @else
                                    {{ __('Create User') }}
                                @endif
                            </x-button>
                        </div>
                    </form>

                    @if($user->exists)
                        <form method="POST" action="{{ route('users.destroy', ['user' => $user]) }}">
                            @method('DELETE')
                            @csrf
                            <x-button class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-sm">
                                {{ __('Delete User') }}
                            </x-button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
