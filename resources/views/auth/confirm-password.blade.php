    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <input for="password" value="" />

            <input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <input  class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <button>
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
