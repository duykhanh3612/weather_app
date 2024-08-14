<form method="POST" action="{{ route('subscription.subscribe') }}">
    @csrf
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Subscribe</button>
</form>
