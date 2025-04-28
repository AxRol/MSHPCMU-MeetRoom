<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">

                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Formulaire de mise a jour de direction de conference') }}
                            </h2>
                        </header>

                        <form action="{{ route('directions.update', $direction->id) }}" method="POST" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT')
                        <!-- <form method="post" action="{{ route('directions.store') }}" class="mt-6 space-y-6"> -->
                            <div>
                                <x-input-label for="nom" :value="__('Nom de la direction')"/>
                                <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full"  :value="old('nom', $direction->nom)" required autofocus placeholder="Nom de la direction..."/>
                                <!-- <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" /> -->
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Description de la direction')"/>
                                <x-text-input name="description" id="description" class="mt-1 block w-full"  :value="old('description', $direction->description)" placeholder="Description de la direction..." />
                                <!-- <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" /> -->
                            </div>


                            <div class="flex items-center gap-4">
                                <x-primary-button type="submit">{{ __('Sauvegarder') }}</x-primary-button>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>





<!-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajout de direction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <h1>Création d'une nouvelle direction de conference</h1>
                <form action="{{ route('directions.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nom">Nom de la direction</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="capacité">capacité</label>
                        <input type="number" name="capacité" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Room</button>
                </form>
        </div>
    </div>
</x-app-layout> -->

