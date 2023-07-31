<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Select the option that describes best your situation.') }}
        </div>

        

        <form method="POST" action="{{ route('auth.register_user_type') }}">
            @csrf

            <!-- User type -->
            <div >
                <label for="type">I am a:</label>
                <select name="type" id="type">
                    <option value="owner">Owner</option>
                    <option value="tenant">Tenant</option>
                </select>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Submit') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
