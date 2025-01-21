<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proposal Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">
                    <!-- Proposal Information -->
                    <div class="mb-8 border-b pb-4">
                        <h3 class="text-3xl font-bold text-gray-800">{{ $talkProposal->title }}</h3>
                        <p class="text-lg text-gray-700 mt-4" style="margin:0px 0px 10px 0px">{{ $talkProposal->description }}</p>
                    </div>

                    <!-- Tags -->
                    <div class="mb-8" style="margin:10px 0px">
                        <h4 class="text-xl font-semibold mb-2 text-gray-800">{{ __('Tags') }}</h4>
                        <div class="flex flex-wrap gap-2">
                            @forelse($talkProposal->tags as $tag)
                                    @php
                                        $tagName = json_decode($tag->name)->en ?? $tag->name; // Check for JSON and decode
                                    @endphp
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">{{ $tagName }}</span>
                            @empty
                                <p class="text-gray-500">{{ __('No tags available.') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- PDF File Link -->
                    <div class="mb-8" style="margin:10px 0px">
                        <h4 class="text-xl font-semibold mb-2 text-gray-800">{{ __('Proposal Document') }}</h4>
                        @if($talkProposal->file_path)
                            <a href="{{ asset('storage/' . $talkProposal->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ __('View Proposal PDF') }}
                            </a>
                        @else
                            <p class="text-red-500">{{ __('No PDF uploaded for this proposal.') }}</p>
                        @endif
                    </div>

                    <!-- Revision History -->
                    <div class="mb-8">
                        <h4 class="text-xl font-semibold mb-4 text-gray-800">{{ __('Revision History') }}</h4>
                        @if($talkProposal->revisions->isEmpty())
                            <p class="text-gray-500">{{ __('No revisions found.') }}</p>
                        @else
                            <table class="w-full border-collapse border border-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border px-4 py-2 text-left">{{ __('Version') }}</th>
                                        <th class="border px-4 py-2 text-left">{{ __('Date') }}</th>
                                        <th class="border px-4 py-2 text-left">{{ __('Changes') }}</th>
                                        <th class="border px-4 py-2 text-left">{{ __('Modify By') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($talkProposal->revisions as $key =>  $revision)
                                        <tr>
                                            <td class="border px-4 py-2">Version {{ $key + 1 }}</td>
                                            <td class="border px-4 py-2">{{ $revision->created_at->format('M d, Y') }}</td>
                                            <td class="border px-4 py-2">{{ $revision->changes }}</td>
                                            <td class="border px-4 py-2">{{ $revision->speaker->name   }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <!-- Reviews Section -->
                    <div>
                        <h4 class="text-xl font-semibold mb-4 text-gray-800">{{ __('Reviews') }}</h4>
                        @if($talkProposal->reviews->isEmpty())
                            <p class="text-gray-500">{{ __('No reviews yet.') }}</p>
                        @else
                            <div class="space-y-4">
                                @foreach($talkProposal->reviews as $review)
                                    <div class="bg-gray-100 p-4 rounded shadow-sm">
                                        <div class="flex items-center justify-between">
                                            <div class="font-bold text-gray-800">Reviewer Name: {{ $review->reviewer->name }}</div>
                                            <div class="text-sm text-gray-600">Date: {{ $review->created_at->format('M d, Y') }}</div>
                                            <div class="text-sm text-gray-600">Rating: {{ $review->rating }}</div>
                                        </div>
                                        <div class="mt-2 text-gray-700">{{ $review->comments }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
