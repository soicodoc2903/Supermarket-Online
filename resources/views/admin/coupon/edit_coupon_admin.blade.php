@extends('admin_layout')
@section('admin_content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong>Sửa mã khuyến mãi</strong>
        </div>
        <?php
            $message = Session::get('message');
            if ($message) {
                echo "<span class='alert alert-success'>".$message."</span>";
                Session::put('message',null);
            }
        ?>
        <div class="card-body card-block">
            @foreach($coupon_edit as $key => $coupon_e)
            <form action="{{URL::to('/update-coupon-admin/'.$coupon_e->coupon_id)}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                {{ csrf_field() }}
                <div class="row form-group">
                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tên mã khuyến mãi</label></div>
                    <div class="col-12 col-md-9"><input type="text" id="slug" name="coupon_name" class="form-control" value="{{ $coupon_e->coupon_name }}">
                    @if($errors->has('coupon_name'))
                        <p class="alert alert-danger">{{ $errors->first('coupon_name') }}</p>                  
                    @endif
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3"><label for="email-input" class=" form-control-label">Mã khuyến mãi</label></div>
                    <div class="col-12 col-md-9"><input type="text" name="coupon_code" value="{{ $coupon_e->coupon_code }}" class="form-control">
                     @if($errors->has('coupon_code'))
                        <p class="alert alert-danger">{{ $errors->first('coupon_code') }}</p>                  
                    @endif
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3"><label for="email-input" class=" form-control-label">Số tiền giảm</label></div>
                    <div class="col-12 col-md-9"><input type="text" name="coupon_number" value="{{ $coupon_e->coupon_number }}" class="form-control">
                     @if($errors->has('coupon_number'))
                        <p class="alert alert-danger">{{ $errors->first('coupon_number') }}</p>                  
                    @endif
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3"><label for="email-input" class=" form-control-label">Số lượng</label></div>
                    <div class="col-12 col-md-9"><input type="text" name="coupon_quantity" value="{{ $coupon_e->coupon_quantity }}" class="form-control">
                     @if($errors->has('coupon_quantity'))
                        <p class="alert alert-danger">{{ $errors->first('coupon_quantity') }}</p>                  
                    @endif
                    </div>
                </div>
                
                <div class="row form-group">
                    <input style="margin: 0px auto;" type="submit" name="" value="Cập nhập mã khuyến mãi" class="btn btn-primary btn-sm" onclick="return confirm('Bạn có chắc là muốn cập nhập mã khuyến này không ?')">
                </div>
            </form>
            @endforeach
        </div>
    </div>
    @endsection