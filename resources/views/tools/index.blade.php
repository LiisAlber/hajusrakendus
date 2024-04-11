
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tools</h1>
        <a href="{{ route('tools.create') }}" class="btn btn-primary">Add New Tool</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tools as $tool)
                    <tr>
                        <td>{{ $tool->title }}</td>
                        <td>{{ $tool->brand }}</td>
                        <td>{{ $tool->price }}</td>
                        <td>
                            <a href="{{ route('tools.edit', $tool) }}" class="btn btn-secondary">Edit</a>
                            <form action="{{ route('tools.destroy', $tool) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
