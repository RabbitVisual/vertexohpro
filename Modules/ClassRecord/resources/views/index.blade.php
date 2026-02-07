<x-classrecord::layouts.master>
    <h1>Class Record Dashboard</h1>
    <div class="p-6">
        <div class="h-96">
            <x-classrecord::widgets.mapa-dificuldades :classId="1" />
        </div>

        <form action="{{ route('classrecord.email_report', 1) }}" method="POST">
            @csrf
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Send Report Card (Student 1)</button>
        </form>
    </div>
</x-classrecord::layouts.master>
