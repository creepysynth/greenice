@extends('master')

@section('content')
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
@endsection
