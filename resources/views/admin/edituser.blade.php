@if(session('status'))
<div class="alert alert-success">
    {{session('status')}}
</div>
@endif

<form method="POST">
 @csrf
 <input type="hidden" name="id" id="id" value="{{$user->id}}"/>
 <input type="text" name="name" id="id" value="{{$user->name}}"/>
 <input type='text' name='email' id='email' value="{{$user->email}}"/>
 <input type="submit">
</form>

<a href="{{route('user')}}">Return</a>
