@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tools</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('tools.create') }}" class="btn btn-primary">Add New Tool</a>
        <button id="fetchApiData" class="btn btn-info">Ralf

        </button>
        <div id="apiData" class="mt-3"></div>

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tools as $tool)
                    <tr>
                        <td>{{ $tool->title }}</td>
                        <td>{{ $tool->brand }}</td>
                        <td>{{ $tool->price }}</td>
                        <td><img src="{{ $tool->image }}" alt="{{ $tool->title }} Image" style="width: 100px;"></td>
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

@section('scripts')
<script>
document.getElementById('fetchApiData').addEventListener('click', function() {
    fetch("{{ url('/show-api') }}?name=Ralf")
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('apiData');
            container.innerHTML = ''; 
            data.data.forEach(tool => {
                container.innerHTML += `<div>
                    <h4>${tool.title}</h4>
                    <p>Brand: ${tool.brand}</p>
                    <p>Price: ${tool.price}</p>
                    <img src="${tool.image}" alt="${tool.title} Image" style="width:100px;">
                </div>`; 
            });
        })
        .catch(error => console.error('Error fetching the data:', error));
});
</script>
@endsection
