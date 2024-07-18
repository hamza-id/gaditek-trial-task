<!DOCTYPE html>
<html>
<head>
    <title>Upload CSV</title>
</head>
<body>
    <h1>Upload CSV File</h1>

    @if ($errors->any())
        <div>
            <strong>Error!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div>
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div>
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif
    <br class="mt-4">
    <form action="{{ route('csv.sorted.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv_file" accept=".csv" >

        <label for="sort_column">Sort by (column name):</label>
        <input type="text" name="sort_column" id="sort_column" placeholder="Enter column name">

        <br>
        <h4>If no column is specified or an invalid column name is entered, the default sorting will be based on the "Price" column.</h4>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
