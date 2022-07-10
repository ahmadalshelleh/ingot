<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @include('user.referrer_link')

    @include('user.referrer_users')

    @include('user.referrer_stats')

    @include('user.referrer_chart')

    @include('user.transaction_form')

    @include('user.wallet')

</x-app-layout>

<script>
    $( document ).ready(function() {
        $("#cat_type").change(function() {
            if(this.value == "create"){
                $(".create").addClass('show').removeClass('hide');
                $(".choose").addClass('hide').removeClass('show');
            }else if(this.value == "choose"){
                $(".create").addClass('hide').removeClass('show');
                $(".choose").addClass('show').removeClass('hide');
            }
        })
    });
</script>
