<!DOCTYPE html>
<html ng-app>
  <head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.9/angular.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="styelsheet"> </head>
  <body>
  
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{ url('orders') }}">Adcash</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a href="{{ url('orders/create') }}" class="btn-add">+ Create New</a>
      </li>
    </ul>
  </div>
</nav>
  
  <div class="container">
   
	@yield('content')

	@if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div><br />
      @endif
	@if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
     @endif
	 
	
	<div class="edit-form  mt-4 mb-4 p-4 border">
    <form  action="{{ route('search') }}" method="get">
    <div class="row"> 
    <div class="col-md-3">
    <label for="filter_name">Search</label>
    <input value="{{request()->input('filter_name')}}" id="filter_name" name="filter_name" class="form-control">
    </div>
    <div class="col-md-3">
    <label for="by_date">Date</label>
    <select id="by_date" name="by_date" class="form-control">
    <option value="0"> All times</option>
    <option 
    @if (request()->input('by_date') == '7')
      selected
    @endif
    value="7"> Last 7 days</option>
    <option value="1" @if (request()->input('by_date') == '1')
      selected
    @endif> Today</option>
    </select>
    </div>
    <div class="col-md-3">
    <label for="limit">Limit</label>
    <select name="limit" id="limit" class="form-control">
    <option ng-repeat="x in [10,20,50,100,500]" value="@{{x}}">@{{x}}</option>
    </select>
    </div>
    <div class="col-md-3">
    <label>&nbsp;</label><input type="submit" value="Search" class="btn-block btn btn-primary">
    </div>
    </div>
    </form>
	</div>
	 
    <table class="table">
    <thead>
      <tr>
        <th>User</th>
        <th>Product</th>
        <th>Price</th>
        <th >Qty</th>
        <th >Total</th>
        <th >Date</th>
        <th colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($orders as $theOrder)
      <tr>
        <td at-attribute="name">{{$theOrder->name}}</td>
        <td at-attribute="name">{{$theOrder->product_name}}</td>
        <td class="text-muted">{{$theOrder->product_price}} EUR</td>
        <td>{{$theOrder->qty}}</td>
        <td class="text-dark"><b>
		@if ($theOrder->qty > 2 && $theOrder->product_id == 1)
			{{(($theOrder->qty * $theOrder->product_price * 80) / 100)}}
		@else
			{{($theOrder->qty * $theOrder->product_price)}}
		@endif
		</b>EUR</td>
		<td>{{$theOrder->created_at}}</td>
        <td><a href="{{action('OrdersController@edit', $theOrder->id)}}" class="d-inline badge badge-warning">Edit</a>
        </td><td>
          <form  onsubmit="return confirm('Do you really want to delete?');" action="{{action('OrdersController@destroy', $theOrder->id)}}" method="post">
            {{csrf_field()}}
            <input name="_method" type="hidden" value="DELETE">
            <button type="submit" class="d-inline badge badge-delete">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $orders->links() }}



  </div>
  
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script>
  $(function() {
  $("#filter_name").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("table > tbody > tr").filter(function() {      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
  </script>
  
  
  </body>
</html