<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Talk Proposal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                @php
    // Decode tags if they are JSON-encoded or use a default value
    $tags = $talkProposal->tags->pluck('name')->map(function ($tag) {
        // Check if the tag is JSON encoded and decode it
        return json_decode($tag, true)['en'] ?? $tag;  // Decode 'en' from JSON if available
    })->join(', ');
@endphp

                    <form action="{{ route('proposals.update', $talkProposal->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- PUT method to update the resource -->

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title', $talkProposal->title) }}" required autofocus />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="5" required>{{ old('description', $talkProposal->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="tags" :value="__('Tags')" />
                            <x-text-input id="tags" class="block mt-1 w-full" type="text" name="tags" value="{{ old('tags', $tags) }}" placeholder="e.g., Technology, Health" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="file" :value="__('Upload PDF (Optional)')" />
                            <x-text-input id="file" class="block mt-1 w-full" type="file" name="file" accept=".pdf" />
                            @if($talkProposal->file_path)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $talkProposal->file_path) }}" target="_blank" class="text-blue-600 hover:underline">View current PDF</a>
                                </div>
                            @endif
                        </div>

                        <x-primary-button>
                            {{ __('Update Proposal') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
