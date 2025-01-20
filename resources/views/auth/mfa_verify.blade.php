<form method="POST" action="{{ route('mfa.verify') }}">
    @csrf
    <input type="text" name="mfa_token" placeholder="Enter MFA Token" required>
    <button type="submit">Verify</button>
</form>
@if ($errors->any())
    <div>
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
