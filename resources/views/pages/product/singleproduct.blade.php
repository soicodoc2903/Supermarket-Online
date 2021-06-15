@extends('layout')
@section('content')   
<style type="text/css">
    li.active {
        border: 2px solid #5a88ca;
    }
    .ratings {
      list-style-type: none;
      margin: 0;
      padding: 0;
      width: 100%;
      direction: rtl;
      text-align: left;
  }

  .star {
      position: relative;
      line-height: 60px;
      display: inline-block;
      transition: color 0.2s ease;
      color: #ebebeb;
  }

  .star:before {
      content: '\2605';
      width: 60px;
      height: 60px;
      font-size: 60px;
  }

  .star:hover,
  .star.selected,
  .star:hover ~ .star,
  .star.selected ~ .star{
      transition: color 0.8s ease;
      color: yellow;
  }
</style>
<script type="text/javascript">
    $(function (){
      var star = '.star',
      selected = '.selected';
      
      $(star).on('click', function(){
        $(selected).each(function(){
          $(this).removeClass('selected');
      });
        $(this).addClass('selected');
    });
      
  });
</script>
<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container product-details">
        <div class="row">
            <div class="col-md-4">
                <div class="single-sidebar">
                    <h2 class="sidebar-title">Sản phẩm mới nhất</h2>
                    @foreach($related_product as $key => $related_pro)
                    <div class="thubmnail-recent">
                        <a href="{{URL::to('/chi-tiet-san-pham&'.$related_pro->product_slug.'&'.$related_pro->shop_id.'&dm='.$related_pro->category_id)}}">
                            <img src="{{('public/uploads/product/'.$related_pro->product_image)}}" class="recent-thumb" alt="">
                            <p>{{$related_pro->product_name}}</p>
                            <div class="product-sidebar-price">
                                <ins style="color: #da1821;">Giá : {{number_format($related_pro->product_price ,0,',','.')}}đ</ins>
                            </div>
                        </a>                             
                    </div>
                    @endforeach
                </div>
                <div class="single-sidebar">
                    <h2 class="sidebar-title">Thông tin cửa hàng</h2>
                    <div class="card" style="width: 18rem;">
                      <div class="card-body">
                        <h6 class="card-subtitle mb-2 text-muted">Được bán bởi</h6>
                        <h4 class="card-title">{{$shop->shop_name}}</h4>
                        <h5 class="card-title">Số điện thoại : <strong>{{$shop->shop_phone}}</strong></h5>
                        <h5 class="card-title">Địa chỉ : <strong>{{$shop->shop_address}}</strong></h5>
                        <a href="{{URL::to('/chi-tiet-shop&'.$shop->shop_id)}}">Đến gian hàng</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="product-content-right">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="product-images">
                            <ul id="imageGallery">
                                @foreach($gallery as $key => $gallery_val)
                                <li data-thumb="{{asset('public/uploads/gallery/'.$gallery_val->gallery_image)}}" data-src="{{asset('public/uploads/gallery/'.$gallery_val->gallery_image)}}">
                                    <img width="100%" src="{{asset('public/uploads/gallery/'.$gallery_val->gallery_image)}}" alt="{{$gallery_val->gallery_name}}" />
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-7">
                        <div class="product-inner">
                            <h2 class="product-name">{{$product_chitiet->product_name}}</h2>
                            <div class="product-inner-price">
                                <ins style="color: red;">{{number_format($product_chitiet->product_price ,0,',','.')}}đ</ins>
                            </div>    

                            <form class="cart">
                                @csrf
                                <input type="hidden" name="" value="{{$product_chitiet->product_id}}" class="cart_product_id_{{$product_chitiet->product_id}}">
                                <input type="hidden" name="" value="{{$product_chitiet->product_name}}" class="cart_product_name_{{$product_chitiet->product_id}}">
                                <input type="hidden" name="" value="{{$product_chitiet->product_image}}" class="cart_product_image_{{$product_chitiet->product_id}}">
                                <input type="hidden" name="" value="{{$product_chitiet->product_price}}" class="cart_product_price_{{$product_chitiet->product_id}}">
                                <input type="hidden" name="" value="{{$product_chitiet->shop_id}}" class="cart_product_shop_{{$product_chitiet->product_id}}">
                                <input type="hidden" name="" value="{{$product_chitiet->product_quantity}}" class="product_quantity_{{$product_chitiet->product_id}}">

                                <input type="hidden" name="" value="{{$product_chitiet->product_slug}}" class="cart_product_slug_{{$product_chitiet->product_id}}">
                                <input type="hidden" name="" value="{{$category}}" class="cart_product_category_{{$product_chitiet->product_id}}">
                                <div class="quantity">
                                    <input type="number" size="4" class="cart_product_qty_{{$product_chitiet->product_id}}" title="Qty" value="1" name="quantity" min="1" step="1">
                                </div>
                                <button type="button" data-id="{{$product_chitiet->product_id}}" class="btn btn-success add-to-cart" name="add-to-cart">Thêm vào giỏ hàng</button>
                            </form>   

                            <div class="product-inner-category">
                                <p>{{$product_chitiet->product_quantity}} sản phẩm có sẵn</a></p>
                                <p>Danh mục: <a href="{{URL::to('/danh-muc='.$category_by_id->category_slug_product)}}">{{$category_by_id->category_name}}</a></p>
                            </div> 

                            <div role="tabpanel">
                                <ul class="product-tab" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Mô tả</a></li>
                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Bình luận</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="home">
                                        <h2>MÔ TẢ SẢN PHẨM</h2>  
                                        <p>{!!$product_chitiet->product_desc!!}</p>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="profile">
                                        <h2>Bình luận</h2>
                                        <div class="submit-review">
                                            <p><label for="name">Name</label> <input name="name" type="text"></p>
                                            <p><label for="email">Email</label> <input name="email" type="email"></p>
                                            <div class="rating-chooser">
                                                <p>Your rating</p>

                                                <div>
                                                    <ul class="ratings">
                                                      <li class="star"></li>
                                                      <li class="star"></li>
                                                      <li class="star"></li>
                                                      <li class="star"></li>
                                                      <li class="star"></li>
                                                  </ul>
                                              </div>
                                          </div>
                                          <p><label for="review">Your review</label> <textarea name="review" id="" cols="30" rows="10"></textarea></p>
                                          <p><input type="submit" value="Submit"></p>
                                      </div>
                                  </div>
                              </div>
                          </div>

                      </div>
                  </div>
              </div>



          </div>                    
      </div>
  </div>
</div>
</div>

<div class="single-product-area product-relate">
    <div class="container product-details">
        <div class="row">
            <div class="col-md-12 product-hot">
                <div class="latest-product">
                    <h3 class="sidebar-title">Sản phẩm tương tự được mua nhiều nhất có thể bạn sẽ thích</h3>
                    <hr>
                    <div class="product-carousel">
                        @foreach($product_relate as $key => $pro_rela)
                        <div class="single-product">
                            <a href="{{url('/chi-tiet-san-pham&'.$pro_rela->product_slug.'&'.$pro_rela->shop_id.'&dm='.$pro_rela->category_id)}}">
                                <div class="product-f-image">
                                    <img src="{{('public/uploads/product/'.$pro_rela->product_image)}}" alt="">
                                </div>
                                <div class="product-name">
                                    <h2>{{$pro_rela->product_name}}</h2>
                                </div>
                                <div class="product-carousel-price">
                                    <ins style="color: #da1821;">{{number_format($pro_rela->product_price ,0,',','.')}}đ</ins>
                                </div> 
                            </a>
                        </div>                          
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection