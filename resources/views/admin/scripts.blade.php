@section('scripts')
<script>
    $(document).ready(function(){
        alert('hi');
        $.ajax({
            url:'api/dashboard',
            type: 'post',
            headers: {"Authorization": "Bearer {{$jwt_token}}"},
            data:{},
            success:function(response){
                $("#user_total").html(response.user_total);
            },
            error:(function(error){

            })
        })
    })
</script>
