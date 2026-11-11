<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $major->name }} - Select My Major</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            margin: 0;
        }

        header {
            background: #172554;
            color: white;
            text-align: center;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
        }

        .section {
            background: white;
            padding: 22px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.06);
        }

        h2 {
            color: #1d4ed8;
        }

        h3 {
            color: #334155;
            margin-top: 18px;
        }

        p {
            line-height: 1.6;
        }

        li {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .back {
            display: inline-block;
            margin-top: 15px;
            margin-bottom: 20px;
            color: #1d4ed8;
            text-decoration: none;
            font-weight: bold;
        }

        .back:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <header>
        <h1>{{ $major->name }}</h1>
        <p>Know Before You Choose</p>
    </header>

    <div class="container">

        <!-- About This Major -->
        <div class="section">
            <h2>About This Major</h2>
            <p>{{ $major->description }}</p>
        </div>

        <!-- Required Skills -->
        <div class="section">
            <h2>Required Skills</h2>
            <ul>
                @foreach($details['skills'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Prerequisites -->
        <div class="section">
            <h2>Prerequisites</h2>
            <ul>
                @foreach($details['prerequisites'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Recommended Courses -->
        <div class="section">
            <h2>Recommended Courses</h2>
            <ul>
                @foreach($details['courses'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Learning Roadmap -->
        <div class="section">
            <h2>Step-by-Step Learning Roadmap</h2>
            <ol>
                @foreach($details['roadmap'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ol>
        </div>

        <!-- Career Opportunities -->
        <div class="section">
            <h2>Career Opportunities</h2>
            <ul>
                @foreach($details['career_roles'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Job Market Information -->
        <div class="section">
            <h2>Job Market Information</h2>
            <p>{{ $details['job_market'] }}</p>
        </div>

        <!-- Salary Information -->
        <div class="section">
            <h2>Salary Information</h2>

            <h3>Bangladesh Salary (Monthly)</h3>
            <p>{{ $details['salary_bd'] }}</p>

            <h3>International Salary (Yearly)</h3>
            <p>{{ $details['salary_international'] }}</p>

            <p>
                <small>
                    Note: Salary figures are indicative estimates.
                    Actual salaries depend on experience, skills,
                    location and organization.
                </small>
            </p>
        </div>

        <!-- Related Industries -->
        <div class="section">
            <h2>Related Industries</h2>
            <ul>
                @foreach($details['industries'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <!-- Back Button -->
        <a href="{{ url('/majors') }}" class="back">
            ← Back to All Majors
        </a>

    </div>

</body>
</html>
