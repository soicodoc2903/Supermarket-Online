@extends('admin_layout')
@section('admin_content')
<div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-12">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Danh sách mã khuyến mãi</h1>
                                <?php
                                $message = Session::get('message');
                                if ($message) {
                                    echo "<span class='alert alert-success'>".$message."</span>";
                                    Session::put('message',null);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Liệt kê danh sách mã khuyến mãi</strong>
                            </div>
                            <div class="card-body">
                                <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên mã khuyến mãi</th>
                                            <th>Mã khuyến mãi</th>
                                            <th>Số tiền giảm</th>
                                            <th>Số lượng</th>
                                            <th>Ngày bắt đầu</th>
                                            <th>Ngày kết thúc</th>
                                            <th>Tình trạng</th>
                                            <th style="width: 100px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    		$stt=0;
                                    	?>
                                        @foreach($coupon as $key => $coupon_a)
                                        <?php
                                        	$stt++;
                                        ?>
                                        <tr>
                                        	<td>{{ $stt }}</td>
                                            <td>{{ $coupon_a->coupon_name }}</td>
                                            <td>{{ $coupon_a->coupon_code }}</td>
                                            <td>{{ number_format($coupon_a->coupon_number ,0,',','.') }}đ</td>
                                            <td>{{ $coupon_a->coupon_quantity }}</td>
                                            <td>{{ $coupon_a->coupon_date_start }}</td>
                                            <td>{{ $coupon_a->coupon_date_end }}</td>
                                            <td>
                                                <?php
                                                    if ($coupon_a->coupon_status==1) {
                                                ?>
                                                    <p class="text text-success">Đang áp dụng</p>
                                                <?php
                                                    }else{
                                                ?>
                                                    <p class="text text-danger">Đã khóa</p>
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="{{URL::to('/edit-coupon-admin&'.$coupon_a->coupon_id)}}" class="btn btn-success btn-block">Sửa</a>
                                                <a href="{{URL::to('/delete-coupon-admin&'.$coupon_a->coupon_id)}}" class="btn btn-danger btn-block" onclick="return confirm('Bạn có chắc là muốn xóa mã khuyến mãi này không?')">Xóa</a>
                                                <a href="{{URL::to('send-coupon-vip')}}" class="btn btn-primary btn-block" onclick="return confirm('Bạn có muốn gửi mã khuyến mãi cho khách vip không?')">Gửi khách vip</a>
                                            </td>
                                        </tr>
                                        @endforeach    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


        <div class="clearfix"></div>
@endsection
