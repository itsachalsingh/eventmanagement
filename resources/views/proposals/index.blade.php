<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Your Talk Proposals') }}
            </h2>
            <!-- Create Button -->
            <a href="{{ route('proposals.create') }}" class="inline-block bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                {{ __('Create Proposal') }}
            </a>
        </div>
    </x-slot>

    <!-- Search and Filter Section -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Search and Tag Filter Section -->
                    <div class="flex justify-between items-center mb-4">
                        <!-- Search Box -->
                        <input type="text" id="searchInput" placeholder="Search proposals..." class="border p-2 rounded w-1/3">

                        <!-- Tag Filter -->
                        <select id="tagFilter" class="border p-2 rounded w-1/3">
                            <option value="">Filter by Tags</option>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Proposals Table -->
                    <table id="proposalsTable" class="table-auto w-full border-collapse border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">Title</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Tags</th>
                                <th class="border px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposals as $proposal)
                                <tr>
                                    <td class="border px-4 py-2">{{ $proposal->title }}</td>
                                    <td class="border px-4 py-2">{{ ucfirst($proposal->status) }}</td>
                                    <td class="border px-4 py-2">
                                        @foreach($proposal->tags as $tag)
                                        @php
                                            $tagName = json_decode($tag->name)->en ?? $tag->name; // Check for JSON and decode
                                        @endphp
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $tagName }}</span>
                                        @endforeach
                                    </td>
                                    <td class="border px-4 py-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('proposals.show', $proposal) }}" class="text-green-600 hover:underline">View</a>

                                        <a href="{{ route('proposals.edit', $proposal) }}" class="text-blue-600 hover:underline">Edit</a>
                                            <!-- Delete Button -->
                                            <form action="{{ route('proposals.destroy', $proposal) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this proposal?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                            </form>



                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <!-- Include jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#proposalsTable').DataTable();

            // Custom search function
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Custom tag filter function
            $('#tagFilter').on('change', function() {
                var tag = this.value;
                table.column(2).search(tag).draw();
            });
        });
    </script>

</x-app-layout>
