<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (count($activities) === 0)
                        <div class="flex flex-col items-center py-12">
                            <img
                                class="mx-auto"
                                src="{{ URL('images/no-content.png')}}" alt="empty-box">
                            <h1 class="text-2xl font-bold text-center font-roboto">No activity has been added</h1>
                            <x-primary-button class="mt-4">
                                <a href="{{route('activities.create')}}">
                                    Add Activity
                                </a>
                            </x-primary-button>
                        </div>
                    @else
                        i am coming
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
