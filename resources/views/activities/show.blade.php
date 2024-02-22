<x-app-layout>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg">{{$activity->name}}</h2>
                    <div class="flex gap-1 items-center mb-1">
                        <p class="text-xs text-gray-500">Assigned To:</p>
                        <p class="text-xs text-gray-500">{{$activity->assignedTo->name}}</p>
                    </div>
                    <div class="flex gap-1 items-center mb-1">
                        <p class="text-xs text-gray-500">Assigned By:</p>
                        <p class="text-xs text-gray-500">{{$activity->user->name}}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <p class="text-xs text-gray-500">Created at: {{$activity->created_at->format('M d, Y')}}</p>
                            <p class="text-xs text-gray-500 ml-4">Updated at: {{$activity->updated_at->format('M d, Y')}}</p>
                        </div>
                        <div class="flex items-center">
                            <a href="{{route('activities.edit', $activity->id)}}" class="text-xs text-gray-500 hover:text-gray-700">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto sm:px-6 lg:px-8 my-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                {{-- start of date filter --}}
                <form
                    class="flex items-center justify-center gap-3"
                    method="get" action="{{ route('activities.show', ['id' => $activity->id]) }}">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date">
            
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date">
            
                    <x-primary-button type="submit">Generate Report</x-primary-button>
                </form>
                {{-- end of date filter --}}

                <h2 class="text-lg py-4">Updates History</h2>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Activity
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Remarks
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($updates as $update)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$update->activity->name}}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{$update->created_at->format('M d, Y')}}
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($update->activity_status == 'in-progress')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100">
                                                    {{$update->activity_status}}
                                                </span>
                                            @elseif ($update->activity_status == 'completed')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-blue-700 dark:text-blue-100">
                                                    {{$update->activity_status}}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            {{$update->remarks}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>