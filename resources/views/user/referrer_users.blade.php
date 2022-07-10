<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <span class="trans-header">Referrer Users</span>
                <table>
                    <thead>
                    <tr>
                        <th class="column-padding ref-header">
                            id
                        </th>
                        <th class="column-padding ref-header">
                            name
                        </th>
                        <th class="column-padding ref-header">
                            email
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users_referrer as $user)
                        <tr style="border-top: 1px solid lightgray">
                            <td class="column-padding">{{$user->user->id}}</td>
                            <td class="column-padding">{{$user->user->name}}</td>
                            <td class="column-padding">{{$user->user->email}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
