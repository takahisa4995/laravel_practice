@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Practice').'『'.$drill->title.'」'}}</div>
          <div class="card-body text-center">
            <p>{{ $drill->problem1}}</p>
            <p>{{ $drill->problem2}}</p>
            <p>{{ $drill->problem3}}</p>
            <div id="app">
              <example-component
                title="{{ __('Practice'.'?'.$drill->title.'?') }}"
                :drill="{{$drill}}"
              ></example-component>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection