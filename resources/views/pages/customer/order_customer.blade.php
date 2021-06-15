@extends('layout')
@section('content')
<div class="single-product-area">
    <div class="container">              
        <div class="row">
            <div class="col-md-12">
                <div class="card-header">
                    <strong class="card-title">Sản phẩm đã đặt</strong>
                </div>
                <div class="card-body">
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã đơn hàng</th>
                                <th>Tên sản phẩm</th>
                                <th>Người bán</th>
                                <th>Thời gian đặt</th>
                                <th>Số lượng đặt</th>
                                <th>Giá</th>
                                <th>Tình trạng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=0;
                            @endphp
                            @foreach($order_customer as $key => $order_cus)
                            @php
                            $i++;
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$order_cus->order_code}}</td>
                                <td>{{$order_cus->product_name}}</td>
                                <td>{{$order_cus->shop_name}}</td>
                                <td>{{$order_cus->create_at}}</td>
                                <td>{{$order_cus->product_sales_quantity}}</td>
                                <td>{{number_format($order_cus->product_price ,0,',','.')}}đ</td>
                                <td>
                                    @if($order_cus->order_status==1)
                                    <p style="color: red;">Đơn hàng mới</p>
                                    @elseif($order_cus->order_status==2)
                                    <p style="color: blue;">Đang vận chuyển</p>
                                    @elseif($order_cus->order_status==3)
                                    <p style="color: green;">Đã giao hàng</p>
                                    @endif
                                </td>
                            </tr>
                            @endforeach  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="product-pagination text-center">
                    <nav>
                      <ul class="pagination">
                        <li>
                          <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                      <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>                        
    </div>
</div>
</div>
</div>
</div>
@endsection