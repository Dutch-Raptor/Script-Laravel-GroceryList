<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
    </title>
    <link rel="stylesheet" href="/app.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap">
    @yield('include_head')
</head>

<body>
    <header>
        <div class="navbar">
            <div class="navbar__container container">
                <a href="{{ route('groceries.index') }}" class="navbar__container__branding">
                    Shopping List!
                </a>
                <div class="navigation">
                    <ul class="navigation__list">
                        <li class="navigation__list__item">
                            <a href="/groceries" class="navigation__list__item__link">
                                Groceries
                            </a>
                        </li>
                        <li class="navigation__list__item">
                            <a href="/groceries/create" class="navigation__list__item__link">
                                Create
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    @if ($errors->any())
        <div class="container alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
    @yield('content')

    @yield('include_js')
</body>

</html>
