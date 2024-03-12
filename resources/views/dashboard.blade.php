<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <iframe title="test" width="1140" height="541.25" src="https://app.powerbi.com/reportEmbed?reportId=eef2dad8-4b50-4cca-9874-f573799072fa&autoAuth=true&ctid=447080b4-b9c6-4b0b-92fd-b543a68b4e97" frameborder="0" allowFullScreen="true"></iframe>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
