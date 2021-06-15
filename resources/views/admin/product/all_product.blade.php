@extends('admin_layout')
@section('admin_content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-5">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Sản phẩm</h1>
                    </div>
                    <div class="page-title">
                        <?php
                        $message = Session::get('message');
                        if ($message) {
                            echo "<span class='alert alert-success'>$message</span>";
                            Session::put('message',null);
                        }
                        ?>
                    </div>

                </div>
            </div>
            <div class="col-sm-7">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="#">Dashboard</a></li>
                            <li><a href="#">Sản phẩm</a></li>
                            <li class="active">Liệt kê sản phẩm</li>
                        </ol>
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
                        <strong class="card-title">Liệt kê sản phẩm</strong>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng kho</th>
                                    <th>Danh mục</th>
                                    <th>Hình ảnh</th>
                                    <th>Giá</th>
                                    <th>Lượt xem</th>
                                    <th>Tình trạng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product as $key => $all_product)
                                <tr>
                                    <td>{{ $all_product->product_name }}</td>
                                    <td>{{ $all_product->product_quantity }}</td>
                                    <td>{{ $all_product->category_name }}</td>
                                    <td><img src="public/uploads/product/{{ $all_product->product_image }}" height="60" width="60">
                                        <a href="{{URL::to('/add-gallery-product-admin&'.$all_product->product_id)}}" class="btn btn-primary btn-sm">Thêm Gallery</a>
                                    </td>
                                    <td>{{number_format($all_product->product_price ,0,',','.')}}đ</td>
                                    <td>
                                        <?php
                                        $view = $all_product->product_view;
                                        if ($view!=NULL) {
                                            echo "".$view." lượt xem";
                                        }else{
                                            echo "0 lượt xem";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        @if($all_product->product_status==0)
                                        <p style="color: green;">Đang hiển thị</p>
                                        @else
                                        <p style="color: green;">Đang ẩn</p>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{URL::to('/edit-product-admin&'.$all_product->product_id)}}" class="btn btn-success">Sửa</a>
                                        <a href="{{URL::to('/delete-product-admin/'.$all_product->product_id)}}" onclick="return confirm('Bạn có chắc là muốn xóa sản phẩm này ko?')" class="btn btn-danger" >Xóa</a>
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