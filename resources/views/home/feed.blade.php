<x-app>
    <div class="flex flex-col items-center justify-center">
        <div class="w-full max-w-md overflow-hidden rounded-lg px-2 dark:shadow-md sm:px-0">
            Welcome
            <x-home-menu></x-home-menu>

{{--            @auth--}}
{{--                <livewire:questions.create :toId="auth()->id()" />--}}
{{--            @endauth--}}

{{--            <livewire:home.feed />--}}
        </div>
    </div>
</x-app>
