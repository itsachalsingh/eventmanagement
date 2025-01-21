<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Talk Proposal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">{{ $proposal->title }}</h3>
                    <p class="mt-2 text-gray-700"><strong>Description:</strong> {{ $proposal->description }}</p>
                    @if($proposal->file_path)
                        <p class="mt-2"><strong>File:</strong> <a href="{{ asset('storage/' . $proposal->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Download</a></p>
                    @endif
                    <form action="{{ route('reviews.store', $proposal) }}" method="POST" class="mt-4">
                        @csrf

                        <!-- Comments Field -->
                        <div class="mb-4">
                            <x-input-label for="comments" :value="__('Comments')" />
                            <textarea
                                id="comments"
                                name="comments"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                rows="5"
                                required></textarea>
                        </div>

                        <!-- Rating Field -->
                        <div class="mb-4">
                            <x-input-label for="rating" :value="__('Rating')" />
                            <x-text-input
                                id="rating"
                                class="block mt-1 w-full"
                                type="number"
                                name="rating"
                                step="0.1"
                                min="0"
                                max="5"
                                required
                               />
                        </div>

                        <!-- Submit Button -->
                        <x-primary-button>
                            {{ __('Submit Review') }}
                        </x-primary-button>
                    </form>

                    <!-- Reviews Section -->
                    <div class="mt-6">
                        <h4 class="font-semibold text-lg">{{ __('Reviews') }}</h4>
                        @forelse($proposal->reviews as $review)
                            <div class="border-t border-gray-200 mt-4 pt-4">
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold">{{ $review->reviewer->name }}</span>
                                    <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="mt-2">
                                    <p class="text-gray-700">{{ $review->comments }}</p>
                                    <p class="mt-2 text-yellow-500">
                                        @for ($i = 0; $i < $review->rating; $i++)
                                            ★
                                        @endfor

                                        @if($review->rating != 4.90)
                                        @for ($i = $review->rating; $i < 5; $i++)
                                            ☆
                                        @endfor
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="mt-4 text-gray-500">{{ __('No reviews yet.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
