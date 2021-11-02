@if(session('status'))
<div class="alert alert-success">
    {{session('status')}}
</div>
@endif

<form method="POST">
 @csrf
 <input type="hidden" name="id" value="{{$user->id}}"/>
 <input type="text" name="name" value="{{$user->title}}"/>
 <input type="submit">
</form>

<a href="{{route('department')}}">Return</a>
