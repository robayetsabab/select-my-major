
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select My Major</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            margin: 0;
            padding: 0;
        }

        header {
            background: #172554;
            color: white;
            text-align: center;
            padding: 25px;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .major-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .card h2 {
            color: #1d4ed8;
        }

        .card p {
            color: #555;
            line-height: 1.6;
        }
    </style>
</head>

<body>

    <header>
        <h1>Select My Major</h1>
        <p>Know Before You Choose</p>
    </header>

    <div class="container">
        <h2>Explore Your Majors</h2>

        <div class="major-list">
            @foreach($majors as $major)
                <div class="card">
                    <a href="{{ url('/majors/' . $major->slug) }}">
    <h2>{{ $major->name }}</h2>
</a>
                    <p>{{ $major->description }}</p>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>
