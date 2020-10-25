<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>
<body class="font-sans antialiased">

<div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Search</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Favorites</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
{{--            @yield('content')--}}

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Search result</div>

                            <div class="card-body">
                                @if(! empty($repositories))
                                    <table class="table table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Owner</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Stargazers</th>
                                                <th scope="col">URL</th>
                                                <th scope="col">Favorites</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($repositories as $repository)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $repository['full_name'] }}</td>
                                                    <td>{{ $repository['owner']['login'] }}</td>
                                                    <td>{{ $repository['description'] }}</td>
                                                    <td>{{ $repository['stargazers_count'] }}</td>
                                                    <td>
                                                        <a href="{{ $repository['html_url'] }}" rel="nofollow">{{ $repository['html_url'] }}</a>
                                                    </td>
                                                    <td>
                                                        @if ($repository['in_favorites'])
                                                            <form action="{{ route('search.remove', $repository['id']) }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger" style="min-width:85px;">Remove</button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('search.add', $repository['id']) }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary" style="min-width:85px;">Add</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                              </tr>
                                            @endforeach
                                      </tbody>
                                    </table>
                                @else
                                    <p class="h5">
                                        <strong>The listed users and repositories cannot be searched either because the resources do not exist or you do not have permission to view them.</strong>
                                    </p>
                                    <a class="btn btn-primary mt-3" href="{{ route('search.index') }}" role="button">Back</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</body>
</html>
<script>
    import Input from "@/Jetstream/Input";
    export default {
        components: {Input}
    }
</script>
