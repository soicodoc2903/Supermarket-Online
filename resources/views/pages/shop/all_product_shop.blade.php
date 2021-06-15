@extends('layout')
@section('content')
    <div class="single-product-area">
        <div class="container  product-relate">
            <div class="row all-product-index">
                <div class="card">
                <div class="card-header">
                    <div class="row form-group">
                        <strong style="padding-left: 30px;font-size: 20px;"><img src="public/frontend/images/account.png" height="35" width="35"> {{$shop->shop_name}}</strong>
                        <hr>
                    </div>
                </div>
                @foreach($product_shop as $key => $product_s)
                <div class="col-md-3 col-sm-6">
                <div class="single-product">
                                <a href="{{url('/chi-tiet-san-pham&'.$product_s->product_slug.'&'.$product_s->shop_id.'&'.'dm='.$product_s->category_id)}}">
                                <div class="product-f-image">
                                    <img src="{{('public/uploads/product/'.$product_s->product_image)}}" width="202" alt="">
                                </div>
                                <div class="product-name">
                                <h2>{{$product_s->product_name}}</h2>
                                </div>
                                <div class="product-carousel-price">
                                    <ins style="color: #da1821;">Giá : {{number_format($product_s->product_price ,0,',','.')}}đ</ins>
                                </div> 
                                </a>
                </div>
                </div>          
                @endforeach  
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