@extends('orders/index')

@section('content')
   
  <h5 class="mt-4">CREATE NEW ORDER</h5>
    <form method="post" action="{{ route('add') }}" class="edit-form p-4 border mt-4 mb-4"  id="formorders">
    
    {{csrf_field()}}
    <input name="_method" type="hidden" value="POST">
        <div class="row">
          <div class="form-group col-xs-12 col-sm-6 col-md-4">
            <label for="name">Product:</label>
            <select class="form-control" name="product_id">
			@foreach($products as $product)
			<option value="{{$product->id}}"
			>{{$product->product_name}}</option>
			@endforeach
			</select>
          </div>
          <div class="form-group col-xs-12 col-sm-6 col-md-4">
            <label for="name">User:</label>
			 <select class="form-control" name="user_id">
           @foreach($users as $user)
			<option 
			value="{{$user->id}}">{{$user->name}}</option>
			@endforeach
			</select>
          </div>
        
        
          <div class="form-group col-xs-12 col-sm-6 col-md-4">
            <label for="name">Qty:</label>
            <input type="text" class="form-control" name="qty" value="1">
          </div>
        
        
          
          <div class="form-group col-xs-12 col-sm-12 col-md-4">
            <button type="submit" class="btn btn-success">Add New</button>
          </div>
        </div>
      </form>
    <div id="toast-container" class="toast-top-right">
    </div>
@stop