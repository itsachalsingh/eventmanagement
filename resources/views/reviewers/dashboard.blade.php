<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reviewer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- DataTable -->
                    <table id="reviewer-table" class="table-auto w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">Title</th>
                                <th class="border px-4 py-2">Speaker</th>
                                <th class="border px-4 py-2">Date Submitted</th>
                                <th class="border px-4 py-2">Tags</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposals as $proposal)
                                <tr>
                                    <td class="border px-4 py-2">{{ $proposal->title }}</td>
                                    <td class="border px-4 py-2">{{ $proposal->speaker->name }}</td>
                                    <td class="border px-4 py-2">{{ $proposal->created_at->format('Y-m-d') }}</td>
                                    <td class="border px-4 py-2">
                                        @foreach($proposal->tags as $tag)
                                        @php
                                            $tagName = json_decode($tag->name)->en ?? $tag->name; // Check for JSON and decode
                                        @endphp
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $tagName }}</span>
                                        @endforeach
                                    </td>
                                    <td class="border px-4 py-2">{{ ucfirst($proposal->status) }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('reviews.create', $proposal) }}" class="text-green-600 hover:underline">Review</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function () {
            $('#reviewer-table').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                columnDefs: [
                    { orderable: false, targets: [3, 5] } // Disable ordering on Tags and Actions columns
                ]
            });
        });
    </script>
</x-app-layout>
