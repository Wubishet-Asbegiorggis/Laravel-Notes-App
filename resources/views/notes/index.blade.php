@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Nunito', sans-serif;
        background-color: #f8fafc;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    }

    .container {
        width: 100%;
        padding: 20px; /* Add padding for spacing */
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        margin: 20px 0; /* Adjust margin for spacing */
    }

    .card-body {
        padding: 2rem;
        overflow-x: auto; /* Enable horizontal scrolling */
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 0.75rem;
        font-size: 0.875rem;
        width: 100%; /* Fill the width of its container */
        height: auto; /* Let the height adjust to content */
        resize: none; /* Prevent resizing */
        overflow: hidden; /* Hide overflow */
    }

    .description-text {
        white-space: pre-line; /* Preserve line breaks and spaces */
    }

    .mb-3 {
        margin-bottom: 1.5rem !important;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        padding: 0.5rem 1.5rem;
        font-size: 1rem;
        cursor: pointer;
    }

    .btn-link {
        font-size: 0.875rem;
        cursor: pointer;
    }

    .table {
        width: 100%;
        margin-top: 20px;
        overflow-x: auto; /* Enable horizontal scrolling */
    }

    .table th, .table td {
        padding: 0.75rem;
        text-align: left;
    }

    .table th {
        background-color: #f1f1f1;
    }

    /* Media Queries */
    @media (max-width: 768px) {
        .card {
            margin: 10px;
        }
    }
</style>

<div class="container">
    <a href="{{ route('notes.create') }}" class="btn btn-primary mb-3">Create New Note</a>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notes as $item)
                        <tr>
                            <td>{{ $item->Title }}</td>
                            <td>{{ $item->creator->name }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <a href="{{ route('notes.show', $item->id) }}" class="btn btn-link">Show</a>
                                @if ($item->user_id == Auth::id())
                                    <a href="{{ route('notes.edit', $item->id) }}" class="btn btn-link">Edit</a>
                                    <form method="POST" action="{{ route('notes.destroy', $item->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
    $('#notes_table').dataTable({
        "serverSide": true,
        "responsive": true,
        "ajax": "ajax/laravel"
    });
});
</script>
@endsection
