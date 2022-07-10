<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in! Admin
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="p-6 bg-white border-b border-gray-200">
                    <thead>
                    <tr>
                        <th class="column-padding ref-header">Name</th>
                        <th class="column-padding ref-header">Email</th>
                        <th class="column-padding ref-header">Registered Date</th>
                        <th class="column-padding ref-header"># Referred Users</th>
                        <th class="column-padding ref-header">Expenses</th>
                        <th class="column-padding ref-header">Income</th>
                        <th class="column-padding ref-header">Balance</th>
                    </tr>
                    </thead>
                    <tbod>
                        @foreach($users as $user)
                            <tr>
                                <td class="column-padding">{{$user->user_name}}</td>
                                <td class="column-padding">{{$user->user_email}}</td>
                                <td class="column-padding">{{$user->registered_date}}</td>
                                <td class="column-padding">{{$user->ref_number}}</td>
                                <td class="column-padding">{{$user->total_balance}}</td>
                                <td class="column-padding">{{$user->total_outcome}}</td>
                                <td class="column-padding">{{$user->total_income}}</td>
                            </tr>
                        @endforeach
                    </tbod>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
