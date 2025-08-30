@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Choose a Plan</h2>
    <div class="row">
        @foreach($plans as $plan)
        <div class="col-md-4 mb-3">
            <div class="card p-3">
                <h4>{{ $plan->name }}</h4>
                <p>{{ $plan->description }}</p>
                <p><strong>₦{{ number_format($plan->price / 100, 2) }} / {{ $plan->interval }}</strong></p>
                <ul>
                    @foreach($plan->features ?? [] as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('subscribe', $plan) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
