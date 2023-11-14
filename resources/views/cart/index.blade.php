<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mon panier') }}
        </h2>
    </x-slot>

    <shopping-cart></shopping-cart>
</x-app-layout>
