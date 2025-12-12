<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information, email, bio, and role.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                   class="mt-1 block w-full border rounded px-3 py-2">
            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                   class="mt-1 block w-full border rounded px-3 py-2">
            @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Bio -->
        <div>
            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
            <textarea id="bio" name="bio" rows="4"
                      class="mt-1 block w-full border rounded px-3 py-2">{{ old('bio', $user->bio) }}</textarea>
            @error('bio') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Role -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
            <select id="role" name="role" class="mt-1 block w-full border rounded px-3 py-2">
                @php $current = old('role', $user->role); @endphp
                <option value="guest" {{ $current === 'guest' ? 'selected' : '' }}>Guest</option>
                <option value="host" {{ $current === 'host' ? 'selected' : '' }}>Host</option>
                <option value="admin" {{ $current === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Photo -->
        <div>
            <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile Photo</label>
            <input id="photo" name="photo" type="file" accept="image/*"
                   class="mt-1 block w-full border rounded px-3 py-2">
            @error('photo') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            <a href="{{ url()->previous() }}" class="text-gray-600 underline">Cancel</a>
        </div>
    </form>
</section>