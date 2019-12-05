@extends('orders/index')

@section('content')
   
<h5 class="mt-4">EDIT AN ORDER</h5>
    <form method="post" action="{{ route('update') }}" class="bg-white edit-form p-4 border mt-4 mb-4" id="formorders">
    {{csrf_field()}}
    <input name="_method" type="hidden" value="POST">
    <input name="order_id" type="hidden" value="{{$id}}">
        <div class="row">
          <div class="form-group col-md-3">
            <label for="name">Product:</label>
            <select class="form-control" name="product_id">
			@foreach($products as $product)
			<option value="{{$product->id}}"
			@if ($the_order->product_id == $product->id)
				selected
			@endif
			>{{$product->product_name}}</option>
			@endforeach
			</select>
          </div>
          <div class="form-group col-md-3">
            <label for="name">User:</label>
			 <select class="form-control" name="user_id">
           @foreach($users as $user)
			<option 
			@if ($the_order->user_id == $user->id)
				selected
			@endif
			value="{{$user->id}}">{{$user->name}}</option>
			@endforeach
			</select>
          </div>
      
          <div class="form-group col-md-3">
            <label for="name">Qty:</label>
            <input type="text" class="form-control" name="qty" value="{{$the_order->qty}}">
          </div>
        
          
          <div class="form-group col-md-3">
            <label>&nbsp;</label><button type="submit" class="btn-block btn btn-primary">Update</button>
          </div>
        </div>
      </form>
    <div id="toast-container" class="toast-top-right">
    </div>
@stop