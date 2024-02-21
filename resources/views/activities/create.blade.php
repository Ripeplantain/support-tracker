<x-app-layout>

    @if($errors->any())
        <div 
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-4" role="alert">
            <ul class="text-center">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


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
                                <div>
                                    <x-input-label for="status" :value="__('Status')" />
                                    <select id="status" name="status" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                        <option value="pending">Pending</option>
                                        <option value="approved">Approved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
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