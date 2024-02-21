<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col items-center py-12">
                        <h1 class="text-2xl font-bold text-center font-roboto">Add Activity</h1>
                        <form class="mt-4" method="POST" action="{{route('activities.store')}}">
                            @csrf
                            <div class="flex flex-col gap-4">
                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="remarks" :value="__('Remarks')" />
                                    <x-text-area id="remarks" class="block mt-1 w-full" type="text" name="remarks" :value="old('remarks')" required />
                                    <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                                </div>
                                <div class="flex flex-col items-center gap-4">
                                    <x-primary-button>
                                        Add Activity
                                    </x-primary-button>
                                    <x-secondary-button>
                                        <a href="{{route('activities.index')}}">
                                            Cancel
                                        </a>
                                    </x-secondary-button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>