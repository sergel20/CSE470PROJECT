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

            <!-- Booking Requests Section -->
            @if($pendingBookings->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
                    <div class="flex items-center mb-6">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Booking Requests</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $pendingBookings->count() }} pending request(s)</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach($pendingBookings as $booking)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <!-- Booking Info -->
                                    <div class="flex-1">
                                        <div class="flex items-start gap-4">
                                            <!-- Listing Image -->
                                            <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
                                                @if($booking->listing->main_image)
                                                    <img src="{{ asset('storage/' . $booking->listing->main_image) }}" alt="{{ $booking->listing->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Details -->
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">{{ $booking->listing->title }}</h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                                    <span class="font-medium">Guest:</span> {{ $booking->guest->name }}
                                                </p>
                                                <div class="flex flex-wrap gap-2 text-xs">
                                                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">
                                                        📅 {{ \Carbon\Carbon::parse($booking->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }}
                                                    </span>
                                                    <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded">
                                                        🌙 {{ $booking->nights }} night(s)
                                                    </span>
                                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded font-semibold">
                                                        💰 ${{ number_format($booking->total_price, 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex gap-2 md:flex-col md:w-32">
                                        <form method="POST" action="{{ route('host.bookings.approve', $booking) }}" class="flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition text-sm font-medium">
                                                ✓ Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('host.bookings.decline', $booking) }}" class="flex-1">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm font-medium">
                                                ✕ Decline
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

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
                                                <div class="flex gap-2">
                                                    <span class="px-2 py-1 text-xs rounded {{ $listing->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' }}">
                                                        {{ ucfirst($listing->status) }}
                                                    </span>
                                                    <span class="px-2 py-1 text-xs rounded {{ $listing->is_active ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                                        {{ $listing->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex gap-2 text-sm mb-4">
                                                <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded">
                                                    {{ $listing->guest_capacity }} guests
                                                </span>
                                                <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded">
                                                    {{ $listing->bedrooms }} bed
                                                </span>
                                            </div>
                                            <div class="flex gap-2 mb-3">
                                                <a href="{{ route('listings.show', $listing) }}" class="flex-1 text-center px-3 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition text-sm">
                                                    View
                                                </a>
                                                <a href="{{ route('listings.edit', $listing) }}" class="flex-1 text-center px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition text-sm">
                                                    Edit
                                                </a>
                                            </div>
                                            <!-- Toggle Active/Inactive -->
                                            <form method="POST" action="{{ route('host.listings.toggle', $listing) }}" class="w-full">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-full px-3 py-2 text-sm rounded transition {{ $listing->is_active ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}">
                                                    {{ $listing->is_active ? '⏸ Deactivate' : '▶ Activate' }}
                                                </button>
                                            </form>
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
