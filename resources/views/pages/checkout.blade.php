@extends('layout')
@section('content')

<section id="cart_items">
		<div class="container">
			
			

			<div class="register-req">
				<p>Please use Register And Checkout to easily get access to your order history</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">
					
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p>Shipping details</p>
							<div class="form-one">
								<form action="{{url('/save-shipping-details')}}" method="post">
									{{ csrf_field()}}
									<input type="text" name="shipping_email" placeholder="Email*">
									<input type="text" name="shipping_first_name" placeholder="Name *">
									<input type="text" name="shipping_last_name" placeholder="Registration number *">
									<input type="text" name="shipping_department" placeholder="Department *">
									<input type="text" name="shipping_mobile_number" placeholder="Mobile Number *">
									<input type="submit" class="btn btn-warning" value="Done">
								</form>
							</div>
						</div>
					</div>				
				</div>
			</div>
@endsection