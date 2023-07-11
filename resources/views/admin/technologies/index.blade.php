@extends('admin.layouts.base')

@section('contents')

@if (session('delete_success'))
    @php $technology = session('delete_success') @endphp
    <div class="alert alert-danger">
        The Technology "{{ $technology->name }}" was deleted
    </div>
@endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($technologies as $technology)
                <tr>
                    <th scope="row">{{ $technology->name }}</th>
                    <td>{{ $technology->description }}</td>
                    
                    <td>
                        <a class="btn btn-primary" href="{{ route('admin.technology.show', ['technology' => $technology->id]) }}">View</a>
                        <a class="btn btn-warning" href="{{ route('admin.technology.edit', ['technology' => $technology->id]) }}">Edit</a>
                        <button technology="button" class="btn btn-danger js-delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $technology->id }}">
                        Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete confirmation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <form
                        action=""
                        data-template= "{{ route('admin.technology.destroy', ['technology' => '***']) }}"
                        method="post"
                        class="d-inline-block"
                        id="btn-confirm-delete"
                    >
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
