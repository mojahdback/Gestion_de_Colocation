<h2>You are invited!</h2>

<p>Click below:</p>

<a href="{{ route('invitations.accept' ,$invitation->token) }}">Accept</a>
<p>{{ route('invitations.accept',$invitation->token) }}</p>
<br><br>
<a href="{{ route('invitations.refuse',$invitation->token) }}">Refuse</a>