<form method="post" action="{{route('connectToProductive')}}" >
    @csrf
    <input type="text" name="authToken" id="authToken">
    <input type="submit">
</form>
