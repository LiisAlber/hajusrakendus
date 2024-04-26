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
        <button class="btn btn-info fetchApiData" data-name="Karel">Karel</button>
        <button class="btn btn-info fetchApiData" data-name="Mari-Liis">Mari-Liis</button>
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
                                <button type="submit" class="btn btn-danger"style="background-color: #dc3545; color: white; border: none;">Delete</button>
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
let lastClicked = null; 

document.querySelectorAll('.fetchApiData').forEach(button => {
    button.addEventListener('click', function() {
        const currentName = this.getAttribute('data-name');
        
        const container = document.getElementById('apiData');
        
        if (lastClicked === currentName && container.style.display !== 'none') {
            container.style.display = 'none';
            lastClicked = null; 
        } else {
            container.style.display = 'block'; 
            lastClicked = currentName; 

            fetch(`{{ url('/show-api') }}?name=` + currentName)
                .then(response => response.json())
                .then(data => {
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
                .catch(error => {
                    console.error('Error fetching the data:', error);
                    container.innerHTML = '<p>Error loading data.</p>'; 
                });
        }
    });
});
</script>
@endsection


