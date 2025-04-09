@extends('admin.layouts.layout')
@section('content')

@if (auth()->user()->role_id == '2' )
<main>
    @if (Auth::check())
        <!-- Main page content-->
        <div class="container-xl px-4 mt-5">
            <h1>Welcome , {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!</h1>
        </div>
    @else
        Please log in to access this page.
    @endif

</main>

@else
<main>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-5">
        <h1>Welcome Admin...</h1>
    </div>
</main>

@endif

@endsection

