@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Приятели, които може би познавате</div>
                <div class="panel-body">
                    <table class="table" id="users">
                        <thead>
                          <tr>
                            <th>Име</th>
                            <th>Email</th>
                            <th>Държава</th>
                            <th>Добави</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                          <tr>
                            <td>{{ $user->real_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->country_name }}</td>
                            <td><button class="btn btn-info">Добави в приятели</button></td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                      <br><br>
                      <button class="btn btn-warning btn-block" id="moreUsers">Зареди още приятели</button>
                      <hr>
                      <p>Страници</p>
                      {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_in_footer')
<script type="text/javascript">

$( document ).ready(function() {
    var nextPage = ({{ $users->currentPage() }} + 1);

    $( "#moreUsers" ).click(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            url: "{{ route('find-friends-suggestions', ['country_id' =>request('country_id')]) }}?page="+nextPage+"&ajax=1",
            data: '',
            success: function(result) {
              if(result){
                resultObj = eval (result);
                var tbody = $('#users tbody'),
                    props = ["real_name", "email", "country_name"];
                $.each(resultObj, function(i, field) {
                  var tr = $('<tr>');
                  $.each(props, function(i, prop) {
                    $('<td>').html(field[prop]).appendTo(tr);  
                  });
                  $('<td>').html('<button class="btn btn-info">Добави в приятели</button>').appendTo(tr); 
                  tbody.append(tr);
                });

                nextPage++;
              }else{
                alert("Error");
              }
            }
        });
    });
});
</script>
@endsection