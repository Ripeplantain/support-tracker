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
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Activities
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Status Change
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Assigned to
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activities as $activity)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{$activity->name}}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{$activity->created_at->format('M d, Y')}}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if (!$activity->status_changed)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                                                        pending
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100">
                                                        changed
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$activity->assignedTo->name}}
                                            </td>
                                            @if ($activity->status_changed)
                                                <td class="px-6 py-4 flex justify-center gap-1">
                                                    <a 
                                                        href="{{route('activities.show', ['id' => $activity->id])}}" 
                                                        class="font-medium text-xs bg-gray-700 text-white px-2 py-1 rounded-full">View Updates</a>
                                                </td>
                                            @else
                                                <td class="px-6 py-4 flex justify-center">
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-100">
                                                        no updates
                                                    </span>
                                                </td>
                                            @endif
                                            <td class="px-6 py-4 text-right ">
                                                <a href="{{route('activities.edit', ['id' => $activity->id])}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <a href="{{route('activity_updates.create', ['id' => $activity->id])}}" class="font-medium text-green-600 dark:text-green-500 hover:underline ps-4">Update Status</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="p-4">
                                @if ($activities->nextPageUrl())
                                    {{$activities->links()}}
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
