@if(session('status'))
<div class="alert alert-success">
    {{session('status')}}
</div>
@endif

<form method="POST">
 @csrf
 <input type="hidden" name="id" value="{{$user->id}}"/>
 <input type="text" name="title" value="{{$user->title}}"/>
 <input type='text' name='description' value="{{$user->description}}"/>
 <input type='text' name='min_salary' value="{{$user->min_salary}}"/>
 <input type='text' name='max_salary' value="{{$user->max_salary}}"/>
 <input type="submit">
</form>

<a href="{{route('job')}}">Return</a>
