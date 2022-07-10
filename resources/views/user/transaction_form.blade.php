<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <ul>
                @foreach($errors->all() as $error)
                    <li class="error">{{$error}}</li>
                @endforeach
                </ul>

                <span class="trans-header">Transactions</span>
                <form method="POST" action="{{ route('createTransaction') }}">
                    @csrf
                    <div>
                        <label for="ref">
                            Transaction
                        </label>

                        <select id="transaction" class="block mt-2 w-full" name="transaction" value="income">
                            <option value="income" selected>income</option>
                            <option value="outcome">outcome</option>
                        </select>

                        <br />

                        <label for="ref">
                            Choose OR Create
                        </label>

                        <select id="cat_type" class="block mt-2 w-full" name="cat_type" value="cat_type">
                            <option value="create" selected>Create</option>
                            <option value="choose">Choose</option>
                        </select>

                        <br />

                        <div class="choose hide">
                            <label for="ref">
                                Choose Category
                            </label>

                            <select class="block mt-2 w-full" name="cat_option">
                                <option disabled></option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="create">
                            <label for="ref">
                                Create Category
                            </label>

                            <input type="text" class="block mt-2 w-full" name="cat" />
                        </div>

                        <br/>

                        <label for="ref">
                            Total
                        </label>

                        <input type="number" class="block mt-2 w-full" name="total" required />

                    </div>

                    <br/>

                    <x-button class="ml">
                        {{ __('Submit') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</div>
