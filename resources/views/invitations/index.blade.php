@extends('layouts.app')

@section('content')

<h2 class="text-2xl mb-4">Invitations</h2>

<div class="bg-white p-4 rounded shadow">

    <div class="flex justify-between items-center border-b py-2">
        <div>
            <p>Email: test@mail.com</p>
            <p class="text-sm text-gray-500">Colocation: Casa</p>
        </div>

        <div class="flex gap-2">
            <button class="bg-green-500 text-white px-3 py-1 rounded">Accept</button>
            <button class="bg-red-500 text-white px-3 py-1 rounded">رفض</button>
        </div>
    </div>

</div>

@endsection