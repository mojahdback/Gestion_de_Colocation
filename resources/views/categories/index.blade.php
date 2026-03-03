@extends('layouts.app')

@section('content')

<h2 class="text-2xl mb-4">Categories</h2>

<form method="POST" action="/categories" class="mb-4">
    @csrf

    <input type="text" name="name" placeholder="New category" class="border p-2">

    <button class="bg-blue-500 text-white px-3 py-1 rounded">
        Add
    </button>
</form>

<div class="bg-white p-4 rounded shadow">

    <div class="flex justify-between border-b py-2">
        <span>Food</span>
        <button class="text-red-500">Delete</button>
    </div>

</div>

@endsection