@extends('master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Favorite repositories</div>

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
                                        <th scope="col">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($repositories as $repository)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $repository['name'] }}</td>
                                            <td>{{ $repository['owner'] }}</td>
                                            <td>{{ $repository['description'] }}</td>
                                            <td>{{ $repository['stargazers'] }}</td>
                                            <td>
                                                <a href="{{ $repository['url'] }}" rel="nofollow">{{ $repository['url'] }}</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('favorites.remove', $repository['id']) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger" style="min-width:85px;">Remove</button>
                                                </form>
                                            </td>
                                      </tr>
                                    @endforeach
                              </tbody>
                            </table>
                        @else
                            <p class="h5">
                                <strong>No repositories were added to favorites yet!</strong>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
