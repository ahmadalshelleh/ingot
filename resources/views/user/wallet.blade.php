<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <span class="trans-header">Wallet Transactions</span>
                <table>
                    <thead>
                    <tr>
                        <th class="column-padding ref-header">
                            Total Balance
                        </th>
                        <th class="column-padding ref-header">
                            Total Income
                        </th>
                        <th class="column-padding ref-header">
                            Total Outcome
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr style="border-top: 1px solid lightgray">
                        <td class="column-padding">{{$total_transactions['total_balance']}}</td>
                        <td class="column-padding">{{$total_transactions['total_income']}}</td>
                        <td class="column-padding">{{$total_transactions['total_outcome']}}</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
