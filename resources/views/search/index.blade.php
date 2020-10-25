@extends('master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Search for repositories in GitHub</div>

                    <div class="card-body">
                        <form action="{{ route('search.result') }}" method="get">
                            <div class="container">
                                @csrf
                                <div class="form-group">
                                    <label for="owner">From this owner</label>
                                    <input type="text" class="form-control" id="owner" name="owner" autocomplete="off" value="{{ old('owner') }}" placeholder="creepysynth">
                                    @error('owner')
                                        <small style="color:#ff0000;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name">In repository name</label>
                                    <input type="text" class="form-control" id="name" name="name" autocomplete="off" value="{{ old('name') }}" placeholder='greenice (matches repositories with "greenice" in their name)'>
                                    @error('name')
                                        <small style="color:red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">In repository description</label>
                                    <input type="text" class="form-control" id="description" name="description" autocomplete="off" value="{{ old('description') }}" placeholder='jquery (matches repositories with "jquery" in their description)'>
                                    @error('description')
                                        <small style="color:red;">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="language">Written in this language</label>
                                    <select class="form-control" id="language" name="language">
                                        <option value="" selected="selected">Any Language</option>
                                        <option value="cpp">C++</option>
                                        <option value="javascript">JavaScript</option>
                                        <option value="php">PHP</option>
                                        <option value="python">Python</option>
                                    </select>
                                    @error('language')
                                    <small style="color:red;">{{ $message }}</small>
                                 @enderror
                                </div>

                                <button type="submit" class="btn btn-primary mt-2">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
