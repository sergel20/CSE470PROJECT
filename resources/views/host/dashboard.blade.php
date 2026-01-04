<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Host Dashboard') }}
            </h2>
            <a href="{{ route('listings.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                + Add Listing
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-indigo-600">{{ $listings->count() }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Total Listings</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-green-600">{{ $listings->sum(fn($l) => $l->bookings->count()) }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Total Bookings</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-3xl font-bold text-yellow-600">{{ $listings->sum(fn($l) => $l->blockedDates->count()) }}</div>
                    <div class="text-gray-600 dark:text-gray-400 mt-2">Blocked Dates</div>
                </div>
            </div>

            <!-- My Listings with Availability Calendar -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">My Listings</h3>

                    @if($listings->count() > 0)
                        <div class="space-y-8">
                            @foreach($listings as $listing)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                    <!-- Listing Card -->
                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6">
                                        <!-- Left: Image and Info -->
                                        <div class="lg:col-span-1">
                                            <div class="bg-gray-100 dark:bg-gray-700 h-48 flex items-center justify-center rounded-lg overflow-hidden mb-4">
                                                @if($listing->main_image)
                                                    <img src="{{ asset('storage/' . $listing->main_image) }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="text-gray-400">No Image</div>
                                                @endif
                                            </div>
                                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 truncate mb-1">{{ $listing->title }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $listing->city }}, {{ $listing->country }}</p>
                                            <div class="flex justify-between items-center mb-3">
                                                <span class="text-lg font-bold text-green-600">${{ number_format($listing->price_per_night, 2) }}/night</span>
                                                <span class="px-2 py-1 text-xs rounded {{ $listing->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($listing->status) }}
                                                </span>
                                            </div>
                                            <div class="flex gap-2 text-sm mb-4">
                                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">
                                                    {{ $listing->guest_capacity }} guests
                                                </span>
                                                <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded">
                                                    {{ $listing->bedrooms }} bed
                                                </span>
                                            </div>
                                            <div class="flex gap-2">
                                                <a href="{{ route('listings.show', $listing) }}" class="flex-1 text-center px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-sm">
                                                    View
                                                </a>
                                                <a href="{{ route('listings.edit', $listing) }}" class="flex-1 text-center px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition text-sm">
                                                    Edit
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Right: Calendar -->
                                        <div class="lg:col-span-2">
                                            <h5 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Availability Calendar</h5>
                                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                                <div id="calendar-{{ $listing->id }}" class="mb-4"></div>
                                                
                                                <!-- Block Date Form -->
                                                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                                                    <form id="block-form-{{ $listing->id }}" method="POST" action="{{ route('listings.block-date', $listing) }}" class="flex gap-2">
                                                        @csrf
                                                        <input type="date" name="blocked_date" id="block-date-{{ $listing->id }}" class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-lg text-sm" placeholder="Select date to block" required>
                                                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition">Block</button>
                                                    </form>
                                                    @if($errors->has("blocked_date.$listing->id"))
                                                        <p class="text-red-500 text-sm mt-1">{{ $errors->first("blocked_date.$listing->id") }}</p>
                                                    @endif
                                                </div>

                                                <!-- Blocked Dates Display -->
                                                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                                        Blocked Dates <span class="text-red-600">({{ $listing->blockedDates->count() }})</span>
                                                    </p>
                                                    @if($listing->blockedDates->count() > 0)
                                                        <div class="flex flex-wrap gap-2">
                                                            @foreach($listing->blockedDates as $blockedDate)
                                                                <div class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 px-3 py-2 rounded-lg flex items-center justify-between gap-2 text-sm">
                                                                    <span>{{ $blockedDate->blocked_date->format('M d, Y') }}</span>
                                                                    <form method="POST" action="{{ route('listings.unblock-date', [$listing, $blockedDate]) }}" style="display: inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:hover:text-red-400 font-bold" title="Unblock">×</button>
                                                                    </form>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-gray-500 dark:text-gray-400 text-sm">No blocked dates</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No listings yet</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding a new listing.</p>
                            <div class="mt-6">
                                <a href="{{ route('listings.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                    + Add Listing
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        // Initialize calendars for each listing
        @foreach($listings as $listing)
            initializeCalendar({{ $listing->id }}, {!! json_encode($listing->blockedDates->pluck('blocked_date')->map(fn($d) => $d->format('Y-m-d'))->toArray()) !!});
        @endforeach

        function initializeCalendar(listingId, blockedDates) {
            const calendarEl = document.getElementById('calendar-' + listingId);
            const blockDateInput = document.getElementById('block-date-' + listingId);
            
            if (!calendarEl || !blockDateInput) return;
            
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            let currentDate = new Date(today);
            
            renderCalendar();
            
            function renderCalendar() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                const prevLastDay = new Date(year, month, 0);
                
                let html = `
                    <div class="flex justify-between items-center mb-4">
                        <button type="button" class="prev-btn px-3 py-1 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-400">←</button>
                        <div class="text-center font-semibold text-gray-800 dark:text-gray-200">
                            ${currentDate.toLocaleString('default', { month: 'long', year: 'numeric' })}
                        </div>
                        <button type="button" class="next-btn px-3 py-1 bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded hover:bg-gray-400">→</button>
                    </div>
                    <div class="grid grid-cols-7 gap-1">
                        <div class="text-center text-xs font-semibold text-gray-600 dark:text-gray-400 py-1">Sun</div>
                        <div class="text-center text-xs font-semibold text-gray-600 dark:text-gray-400 py-1">Mon</div>
                        <div class="text-center text-xs font-semibold text-gray-600 dark:text-gray-400 py-1">Tue</div>
                        <div class="text-center text-xs font-semibold text-gray-600 dark:text-gray-400 py-1">Wed</div>
                        <div class="text-center text-xs font-semibold text-gray-600 dark:text-gray-400 py-1">Thu</div>
                        <div class="text-center text-xs font-semibold text-gray-600 dark:text-gray-400 py-1">Fri</div>
                        <div class="text-center text-xs font-semibold text-gray-600 dark:text-gray-400 py-1">Sat</div>
                `;
                
                // Previous month's days
                for (let i = prevLastDay.getDate() - firstDay.getDay() + 1; i <= prevLastDay.getDate(); i++) {
                    html += `<div class="text-center text-xs text-gray-400 py-2">${i}</div>`;
                }
                
                // Current month's days
                for (let i = 1; i <= lastDay.getDate(); i++) {
                    const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                    const cellDate = new Date(year, month, i);
                    const isBlocked = blockedDates.includes(dateStr);
                    const isPast = cellDate < today;
                    
                    let classes = 'text-center text-xs py-2 rounded transition ';
                    let clickable = false;
                    
                    if (isBlocked) {
                        classes += 'bg-red-500 text-white font-bold';
                    } else if (isPast) {
                        classes += 'bg-gray-200 dark:bg-gray-700 text-gray-400 cursor-not-allowed';
                    } else {
                        classes += 'bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 hover:bg-blue-100 dark:hover:bg-blue-900 cursor-pointer';
                        clickable = true;
                    }
                    
                    html += `<div class="${classes}" data-date="${dateStr}" data-clickable="${clickable}">${i}</div>`;
                }
                
                // Next month's days
                const remainingDays = 7 - ((lastDay.getDay() + 1) % 7);
                if (remainingDays < 7) {
                    for (let i = 1; i <= remainingDays; i++) {
                        html += `<div class="text-center text-xs text-gray-400 py-2">${i}</div>`;
                    }
                }
                
                html += `</div>`;
                calendarEl.innerHTML = html;
                
                // Add event listeners
                const prevBtn = calendarEl.querySelector('.prev-btn');
                const nextBtn = calendarEl.querySelector('.next-btn');
                
                if (prevBtn) {
                    prevBtn.addEventListener('click', () => {
                        currentDate.setMonth(currentDate.getMonth() - 1);
                        renderCalendar();
                    });
                }
                
                if (nextBtn) {
                    nextBtn.addEventListener('click', () => {
                        currentDate.setMonth(currentDate.getMonth() + 1);
                        renderCalendar();
                    });
                }
                
                // Add click event to date cells
                calendarEl.querySelectorAll('[data-date]').forEach(cell => {
                    if (cell.dataset.clickable === 'true') {
                        cell.addEventListener('click', () => {
                            blockDateInput.value = cell.dataset.date;
                        });
                    }
                });
            }
        }
    </script>
</x-app-layout>
