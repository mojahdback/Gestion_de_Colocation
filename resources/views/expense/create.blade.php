<x-app-layout>

<div class="max-w-xl mx-auto mt-10">

    <h2 class="text-xl font-bold mb-4">
        Add Expense
    </h2>

    <form method="POST" action="{{ route('expenses.store', $colocation) }}">
        @csrf

        <!-- Title -->
        <input type="text" name="title" placeholder="Title"
               class="border p-2 w-full mb-3">

        <!-- Amount -->
        <input type="number" step="0.01" name="amount"
               placeholder="Amount"
               class="border p-2 w-full mb-3">

        <!-- Date -->
        <input type="date" name="date"
               class="border p-2 w-full mb-3">

        <!-- Payer -->
        <select name="payer_id" class="border p-2 w-full mb-3">
            @foreach($members as $member)
                <option value="{{ $member->id }}">
                    {{ $member->name }}
                </option>
            @endforeach
        </select>

        <!-- Category -->
        <select name="category_id" class="border p-2 w-full mb-3">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Add
        </button>

    </form>

</div>

</x-app-layout>