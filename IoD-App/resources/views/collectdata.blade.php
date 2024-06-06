@extends('layouts.master')
@section('content')
<div class="container-fluid" id="url" data-url="{{env('APP_URL')}}">
  <div class="row justify-content-center">
      <div class="col-xs-8">
          <div class="card mx-5 pt-3 o-bg-card" style="text-align: center;border-radius:1rem; box-shadow: 0 1rem 1rem 0 rgba(0, 0, 0, 0.771);">
              <div class="card-body p-0">
                <div class="row">
                  <div class="col">
                    <button class="btn btn-success">Start Listening</button>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Distanza</label>
                      <input type="text" class="form-control" id="dist" aria-describedby="emailHelp" placeholder="Enter distance" onchange="updateDist()">
                    </div>
                    <p id="count"></p>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js" integrity="sha512-tWHlutFnuG0C6nQRlpvrEhE4QpkG1nn2MOUMWmUeRePl4e3Aki0VB6W1v3oLjFtd0hVOtRQ9PHpSfN6u6/QXkQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  var url = null;
  var dist = null;
  var count = 1;

  window.onload = function (){
    url = document.getElementById("url").getAttribute('data-url');
  }
  //Distanza su input text
    function updateDist(){
      dist = document.getElementById('dist').value;
      if(!dist){
        alert("Dist vuoto");
      }
      console.log(dist);
  }


    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('3353b346c4d43987a0cb', {
      cluster: 'eu'
    });
    var data_jsn = null
    var channel = pusher.subscribe('packetchannel');
    channel.bind('lat', function(data) {
      data_jsn = data;
      console.log(data);
      if(!dist){
        alert("No dist set");
      }else{
        document.getElementById('count').innerText = count;
        const body = {'data': data_jsn.pak.rxpk[0], 'dist': dist}
        console.log(body);
        $.ajax({ 
              type: "POST",
              url: url+'/api/write-single-packet',
              data: JSON.stringify(body),
              success: function(data){        
                console.log("Data send ok");
              },
              error: function(err){
                console.log(err);
              }
        });
        count++;
      }
    });

  
</script>