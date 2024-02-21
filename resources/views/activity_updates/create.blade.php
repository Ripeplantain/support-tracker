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
                        <div>
                            <h2 class="text-2xl text-green-800 font-bold mb-2">{{$activity->name}}</h2>
                        </div>
                        <h1 class="text-2xl font-bold text-center font-roboto">Add Activity Update</h1>
                    </div> 
                    <form action="{{ route('activity_updates.store', ['id' => $activity_id]) }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-4">

                            <div>
                                <x-input-label for="remarks" :value="__('Remarks')" />
                                <x-text-area id="remarks" class="block mt-1 w-full" type="text" name="remarks" :value="old('remarks')" required autofocus />
                                <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="activity_status" name="activity_status" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <div class="flex flex-col items-center gap-4">
                                <x-primary-button>
                                    Update Activity
                                </x-primary-button>
                                <x-secondary-button>
                                    <a href="{{route('activities.index')}}">
                                        Cancel
                                    </a>
                                </x-secondary-button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>