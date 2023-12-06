<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<div class="container">
        <div class="col-md-12 p-2">
            <div class="card text-center">
                <div class="card-header">
                    <h5 class="text-left">{{ $marksheet->user->name }} <span style="font-size: 15px"></span></h5>
                </div>
                <div class="card-body p-3 text-left">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Subject name</th>
                                <th scope="col">Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Bio</td>
                                @if ($marksheet->bio <= 25)
                                    <td><span class="text-danger">{{ $marksheet->bio }}</span></td>
                                @else
                                    <td>{{ $marksheet->bio }}</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Mathematics</td>
                                @if ($marksheet->mathematics <= 25)
                                    <td><span class="text-danger">{{ $marksheet->mathematics }}</span></td>
                                @else
                                    <td>{{ $marksheet->mathematics }}</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Science</td>
                                @if ($marksheet->science <= 25)
                                    <td><span class="text-danger">{{ $marksheet->science }}</span></td>
                                @else
                                    <td>{{ $marksheet->science }}</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">4</th>
                                <td>Social Science</td>
                                @if ($marksheet->socialscience <= 25)
                                    <td><span class="text-danger">{{ $marksheet->socialscience }}</span></td>
                                @else
                                    <td>{{ $marksheet->socialscience }}</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">5</th>
                                <td>English</td>
                                @if ($marksheet->english <= 25)
                                    <td><span class="text-danger">{{ $marksheet->english }}</span></td>
                                @else
                                    <td>{{ $marksheet->english }}</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">6</th>
                                <td>Gujarati</td>
                                @if ($marksheet->gujarati <= 25)
                                    <td><span class="text-danger">{{ $marksheet->gujarati }}</span></td>
                                @else
                                    <td>{{ $marksheet->gujarati }}</td>
                                @endif
                            </tr>
                            <tr>
                                <th scope="row">7</th>
                                <td>Hindi</td>
                                @if ($marksheet->hindi <= 25)
                                    <td><span class="text-danger">{{ $marksheet->hindi }}</span></td>
                                @else
                                    <td>{{ $marksheet->hindi }}</td>
                                @endif
                            </tr>
                            <!-- Add more subjects in a similar format -->
                        </tbody>
                    </table>

                    <div>
                        <p>Total: {{ $marksheet->total }}</p>
                        <p>Percentage: {{ $marksheet->percentage }}%</p>
                    </div>

                    <div>
                        @if ($marksheet->status == 0)
                            <p class="text-danger">Fail</p>
                        @else
                            <p class="text-success">Pass</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</div>

</body>
</html>
