@extends('layout')
@section('content')

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row cart">   
            <div class="col-md-8">
                <?php
                $message_error = Session::get('message_error');
                $message = Session::get('message');
                if ($message) {
                    echo "<span class='alert alert-success'>$message</span>";
                    Session::put('message',null);
                }
                if ($message_error) {
                    echo "<span class='alert alert-danger'>$message_error</span>";
                    Session::put('message_error',null);
                }
                ?>
                <div class="single-sidebar">
                 <form method="post" action="{{URL::to('/update-cart')}}">
                    @csrf
                    <table cellspacing="0" class="table">
                        <thead>
                            <tr>                               
                                <th>&nbsp;</th>
                                <th>Tên sản phẩm</th>
                                <th class="product-price">Giá</th>
                                <th class="product-quantity">Số lượng</th>
                                <th class="product-subtotal">Tổng</th>
                                <th class="product-remove">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $total = 0;
                            @endphp
                            @foreach(Session::get('cart') as $key => $cart)
                            @php
                            $subtotal = $cart['product_price']*$cart['product_qty'];
                            $total+=$subtotal;
                            @endphp
                            <tr class="cart_item">                          
                                <td class="product-thumbnail">
                                    <a href="#"><img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="{{'public/uploads/product/'.$cart['product_image']}}"></a>
                                </td>

                                <td class="product-name">
                                    <a href="#">{{$cart['product_name']}}</a> 
                                </td>

                                <td class="product-price">
                                    <span class="amount" style="color: red;">{{number_format($cart['product_price'],0,',','.')}}đ</span> 
                                </td>
                                <td class="product-quantity">
                                    <div class="quantity buttons_added">
                                        <input type="number" size="4" class="cart_quantity_" value="{{$cart['product_qty']}}" name="cart_qty[{{$cart['session_id']}}]" min="1" step="1">
                                    </div>
                                </td>
                                <input type="hidden" name="product_qty_store[{{$cart['session_id']}}]" class="product_qty_store_" value="{{$cart['product_quantity_store']}}">
                                <td class="product-subtotal">
                                    <span class="amount">{{number_format($subtotal,0,',','.')}}đ</span> 
                                </td>
                                <td class="product-remove">
                                    <a title="Xóa sản phẩm này" class="remove" href="{{URL::to('delete-product-cart/'.$cart['session_id'])}}" onclick="return confirm('Bạn có chắc là muốn xóa sản phẩm này khỏi giỏ hàng không?')" class="btn btn-danger"><i class="fa fa-trash-o"></i></a> 
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6">
                                    <input type="submit" style="float: right;" class="btn btn-default btn-sm" value="Cập nhập" name="update_qty">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>   
        </div>

        <div class="col-md-4">
            <div class="cart-right">
                <div class="product-content-right">
                    <div class="woocommerce">
                        <div class="cart-collaterals">
                            <div class="sumary_header">
                                Nhập thông tin đặt hàng
                            </div>
                            <?php 
                            $message = Session::get('message');
                            if ($message) {
                                echo '<p class="alert alert-success">'.$message.'</p>';
                                Session::put('message',null);
                            }
                            ?>
                            <form method="post" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col-12 col-md-12"><input type="text" name="shipping_name" placeholder="Họ tên" class="form-control shipping_name">
                                        @if($errors->has('shipping_name'))
                                        <p class="alert alert-danger">{{ $errors->first('shipping_name') }}</p>
                                    @endif</div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-12 col-md-12"><input type="text" name="shipping_email" placeholder="Email" class="form-control  shipping_email">
                                        @if($errors->has('shipping_email'))
                                        <p class="alert alert-danger">{{ $errors->first('shipping_email') }}</p>
                                    @endif</div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-12 col-md-12"><input type="text" name="shipping_phone" placeholder="Số điện thoại" class="form-control shipping_phone">@if($errors->has('shipping_phone'))
                                        <p class="alert alert-danger">{{ $errors->first('shipping_phone') }}</p>
                                    @endif</div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-12 col-md-12"><input type="text" name="shipping_address" placeholder="Địa chỉ nhận hàng" class="form-control shipping_address">@if($errors->has('shipping_address'))
                                        <p class="alert alert-danger">{{ $errors->first('shipping_address') }}</p>
                                    @endif</div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-12 col-md-9">
                                        <label>Chọn hình thức thanh toán</label><br/>
                                        <select name="payment_select" class="payment_select">
                                            <option value="0">Tiền mặt</option>
                                            <option value="1">Chuyển khoản</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-12 col-md-12"><input type="button" name="send_order" class="btn btn-warning btn-block send_order" value="Xác nhận đơn hàng"></div>
                                </div>
                            </form>
                        </div>           
                    </div>
                </div>                 
            </div>
        </div>
    </div>
</div>
</div>
@endsection