<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select My Major</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1e293b;
        }

        header {
            background: #14213d;
            color: white;
            padding: 22px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h2 {
            font-size: 25px;
        }

        header a {
            color: white;
            text-decoration: none;
            background: #2563eb;
            padding: 11px 20px;
            border-radius: 6px;
        }

        .hero {
            text-align: center;
            padding: 90px 20px;
            background: #e8efff;
        }

        .hero h1 {
            font-size: 45px;
            color: #14213d;
            margin-bottom: 18px;
        }

        .hero p {
            font-size: 18px;
            color: #475569;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 7px;
            font-weight: bold;
        }

        .majors {
            padding: 55px 8%;
            text-align: center;
        }

        .majors h2 {
            font-size: 30px;
            margin-bottom: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 22px;
        }

        .card {
            background: white;
            padding: 30px 20px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.07);
        }

        .card h3 {
            margin-bottom: 12px;
            color: #1d4ed8;
        }

        .card p {
            color: #64748b;
            line-height: 1.6;
        }

        footer {
            background: #14213d;
            color: white;
            text-align: center;
            padding: 22px;
            margin-top: 30px;
        }
    </style>
</head>

<body>

<header>
    <h2>SELECT MY MAJOR</h2>
    <a href="{{ url('/majors') }}">Explore Majors</a>
</header>

<section class="hero">
    <h1>Know Before You Choose</h1>

    <p>
        Discover your future career path.
        Explore skills, courses, roadmaps and job opportunities.
    </p>

    <a href="{{ url('/majors') }}" class="btn">
        Explore All Majors
    </a>
</section>

<section class="majors">
    <h2>Explore Our Majors</h2>

    <div class="cards">

        <div class="card">
            <h3>Cyber Security</h3>
            <p>Learn about network security, ethical hacking and protecting digital systems.</p>
        </div>

        <div class="card">
            <h3>Robotics</h3>
            <p>Explore robotics, automation and intelligent machines.</p>
        </div>

        <div class="card">
            <h3>Software Testing</h3>
            <p>Understand software quality, testing methods and bug detection.</p>
        </div>

        <div class="card">
            <h3>Data Science</h3>
            <p>Explore data analysis, machine learning and data-driven decisions.</p>
        </div>

    </div>
</section>

<footer>
    <p>© 2026 SELECT MY MAJOR | Know Before You Choose</p>
</footer>

</body>
</html>