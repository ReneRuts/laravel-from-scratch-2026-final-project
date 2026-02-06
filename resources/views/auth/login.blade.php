<x-layout>
    <x-form title="{{ __('app.page-title') }}" description="{{ __('app.sub-title') }}">
        <form action="/login" method="POST" class="mt-10 space-y-4">
            @csrf

            <x-form.field label="{{ __('app.email-label') }}" name="email" type="email"/>
            <x-form.field label="{{ __('app.password-label') }}" name="password" type="password"/>

            <button type="submit" class="btn mt-2 h-10 w-full" data-test="login-button">{{ __('app.sign-in-button') }}</button>
        </form>
    </x-form>
</x-layout>