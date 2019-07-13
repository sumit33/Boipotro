@extends('layout')
@section('content')

<section id="cart_items">
		<div class="container col-sm-12">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Shopping Cart</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				<?php

				$contents=Cart::getContent();
				$total = Cart::getTotal();

				?>

				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Image</td>
							<td class="description">Name</td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>

						<?php foreach($contents as $v_contents){?>
						<tr>
							<td class="cart_product">
								<a href=""><img src="{{URL::to($v_contents->attributes->image)}}" height="80px" width="80px" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">{{$v_contents->name}}</a></h4>
								
							</td>
							<td class="cart_price">
								<p>{{$v_contents->price}} Tk</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<form action="{{url('/update-cart')}}" method="post">
									{{ csrf_field()}}
									<input class="cart_quantity_input" type="text" name="quantity" value="{{$v_contents->quantity}}" autocomplete="off" size="2">
									<input  type="hidden" name="id" value="{{$v_contents->id}}">
									<input type="submit" name="submit" value="update" class="btn btn-sm btn-default">
								</form>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">{{$v_contents->price*$v_contents->quantity}}</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_contents->id)}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<?php } ?>
						
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->

			
				<div class="col-sm-12">
					<div class="total_area">
						<ul>
							<li>Cart Sub Total <span>{{$total}} Tk </span></li>
							<li>Eco Tax <span>0 Tk</span></li>
							<li>Shipping Cost <span>Free</span></li>
							<li>Total <span>{{$total}}</span></li>
						</ul>
							<a class="btn btn-default update" href="">Update</a><br>
							<?php $customer_id=Session::get('customer_id');?>
							<?php if($customer_id!=NULL){ ?>
                                <li><a href="{{URL::to('/checkout')}}"><i class="btn btn-default"> Checkout</i></a></li>
                            <?php }else{ ?>
                                 <li><a class="btn btn-default check_out" href="{{URL::to('/login-check')}}">Check Out</a></li>
                            <?php } ?>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->


@endsection