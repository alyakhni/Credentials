@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <passport-clients></passport-clients><br>
                    <passport-authorized-clients></passport-authorized-clients><br>
                    <passport-personal-access-tokens></passport-personal-access-tokens><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
