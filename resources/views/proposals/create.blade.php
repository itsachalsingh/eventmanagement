<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit Talk Proposal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('proposals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" required autofocus />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="5" required></textarea>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="tags" :value="__('Tags')" />
                            <x-text-input id="tags" class="block mt-1 w-full" type="text" name="tags" placeholder="e.g., Technology, Health" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="file" :value="__('Upload PDF')" />
                            <x-text-input id="file" class="block mt-1 w-full" type="file" name="file" accept=".pdf" />
                        </div>
                        <x-primary-button>
                            {{ __('Submit Proposal') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
