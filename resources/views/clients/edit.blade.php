<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if($client->exists)
                {{ __('Edit Client') }}
            @else
                {{ __('Add Client') }}
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


                        <form method="POST" action="{{ $client->exists ? route('clients.update', ['client' => $client]) : route('clients.store') }}">

                            @if($client->exists)
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
                                     value="{{ old('name') ?? $client->name }}"
                                     required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="description" :value="__('Description')" />

                            <x-input id="description"
                                     class="block mt-1 w-full"
                                     type="text"
                                     name="description"
                                     value="{{ old('email') ?? $client->description }}"
                                     required />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                @if($client->exists)
                                    {{ __('Update Client') }}
                                @else
                                    {{ __('Create Client') }}
                                @endif
                            </x-button>
                        </div>
                    </form>

                    @if($client->exists)
                        <form method="POST" action="{{ route('clients.destroy', ['client' => $client]) }}">
                            @method('DELETE')
                            @csrf
                            <x-button class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-sm">
                                {{ __('Delete Client') }}
                            </x-button>
                        </form>
                    @endif



                    <!-- Client Users -->
                    @if($client->exists && $client->users()->count() > 0)
                    <section class="container w-full">
                        <div class="w-full mb-8 overflow-hidden rounded-lg">
                            <h3>Client Users</h3>
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
                                    @foreach($client->users()->paginate(2) as $key => $client_user)
                                        <tr class="text-gray-700 border">
                                            <td class="px-4 py-3 text-ms font-semibold border border-l">{{ $client_user->id }}</td>
                                            <td class="px-4 py-3 border">
                                                <div class="flex items-center text-sm">
                                                    <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                                        <img class="object-cover w-full h-full rounded-full" src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260" alt="" loading="lazy" />
                                                        <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-black">{{ $client_user->name }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-xs border">

                                                <a href="{{ route('client-users.edit', ['client_user' => $client_user ]) }}"
                                                   class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                    Edit Client User
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                    {{ $client->users()->paginate(2)->links() }}
                    @elseif($client->exists)
                        <h2 class="font-semibold mt-5 mb-3 text-2xl">Client Users</h2>
                        <p class="mb-5">Client currently has no client users assigned.</p>
                        <a href="{{ route('client-users.create', ['client_id' => $client->id]) }}"
                           class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                            Add Client Users
                        </a>
                    @endif



                </div>
            </div>
        </div>
    </div>
</x-app-layout>
