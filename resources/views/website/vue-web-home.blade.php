@extends('website.layouts.web-layouts')
@section('title', 'Nogor Solutions Limited')
@section('content')
    <div class="container mt-5 mb-5">
        <div class="shadow p-5 mt-5 mb-5 text-center">
            <h2>Website and CMS setup done</h2>
            <h5>For admin please click here <a href="{{ route('admin.nsl_admin') }}">Admin Login</a></h5>
        </div>
        <example></example>

    </div>
@endsection
