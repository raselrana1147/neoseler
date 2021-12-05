@extends('layouts.front')
@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/datatable.css')}}">
@endsection
@section('content')

<section class="user-dashbord">
    <div class="container">
        <div class="row">
            @include('includes.user-dashboard-sidebar')
            <div class="col-lg-8">
                <div class="user-profile-details">
                    <div class="account-info">
                        <div class="header-area">
                            <h4 class="title">
                                Special Commission products
                            </h4>
                            <a href="{{URL::previous()}}" class="btn btn-primary"><i class="fas fa-long-arrow-alt-left"></i> Back</a>
                            @include('error.error')
                        </div>
                        <div class="edit-info-area">
       
                
                        <div class="body">
                            
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">Name</th>
                                <td scope="col">{{$product->name}}</td>
                              </tr>
                              <tr>
                                <th scope="col">Type</th>
                                <td scope="col">{{$product->type}}</td>
                              </tr>
                              <tr>
                                <th scope="col">Category</th>
                                <td scope="col">{{$product->category->name}}</td>
                              </tr>
                              <tr>
                                <th scope="col">Sub category</th>
                                <td scope="col">
                                  @if($product->subcategory !=null)
                                  {{$product->subcategory->name}}
                                  @else
                                    <span class="badge badge-danger">N\A</span>
                                  @endif
                                </td>
                              </tr>
                              <tr>
                                <th scope="col">Child category</th>
                                <td scope="col">
                                  @if($product->childcategory_id !=null)
                                  {{$product->childcategory->name}}
                                  @else
                                    <span class="badge badge-danger">N\A</span>
                                  @endif
                                </td>
                              </tr>
                              <tr>
                                <th scope="col">Size price</th>
                                <td scope="col">
                                  @if($product->size_price !=null)
                                  {{$product->size_price}}
                                  @else
                                    <span class="badge badge-danger">N\A</span>
                                  @endif
                                </td>
                              </tr>
                              <tr>
                                <th scope="col">Discount</th>
                                <td scope="col">
                                  @if($product->thum_discount !=null)
                                  {{$product->thum_discount}} %
                                  @else
                                    <span class="badge badge-danger">N\A</span>
                                  @endif
                                </td>
                              </tr>
                              <tr>
                                <th scope="col">Unit Price</th>
                                <td scope="col">
                                  {{$product->price}} Tk
                                </td>
                              </tr>

                              <tr>
                                <th scope="col">Previous price</th>
                                <td scope="col">
                                  @if($product->previous_price !=null)
                                  {{$product->previous_price}} Tk
                                  @else
                                    <span class="badge badge-danger">N\A</span>
                                  @endif
                                </td>
                              </tr>
                              <tr>
                                <th scope="col">Stock</th>
                                <td scope="col">
                                  @if($product->stock !=null)
                                  <span class="badge badge-success">Available</span>
                                  @else
                                    <span class="badge badge-danger">Not Available</span>
                                  @endif
                                </td>
                              </tr>
                              <tr>
                               
                                <th scope="col">Colors</th>
                                <td scope="col">
                                  @if($product->color !=null)
                                  @php
                                    $colors=array();;
                                    $colors=$product->color
                                  @endphp
                                  @foreach($colors as $color)
                                    
                                  <div style="width: 25px;height: 25px;background:<?php echo $color;?>;border-radius: 50%; display: inline-block;">
                                  </div>

                                    @endforeach
                                  @else
                                    <span class="badge badge-danger">Any color</span>
                                  @endif
                                </td>
                              </tr>
                              <tr>
                                <th scope="col">Condition</th>
                                <td scope="col">
                                  @if($product->priduct_condition==2)
                                  <span class="badge badge-success">New</span>
                                  @elseif($product->priduct_condition==1)
                                    <span class="badge badge-danger">Used</span>
                                    @else
                                    <span class="badge badge-warning">New and Used both of are available</span>
                                  @endif
                                </td>
                              </tr>
                              <tr>
                                <th scope="col">Special commission</th>
                                <td scope="col">
                                  @if($product->special_com !=null)
                                  <span class="badge badge-success">{{$product->special_com}} Tk</span>
                                  @else
                                    <span class="badge badge-danger">Not </span>
                                  @endif
                                </td>
                              </tr>
                              <tr>
                                <th scope="col">Image</th>
                                <td scope="col">
                                 <img class="img-fluid"
                                   src="{{ $product->photo ? asset('assets/images/thumbnails/'.$product->thumbnail):asset('assets/images/noimage.png') }}"
                                   alt="" style="width: 70px;">
                                </td>
                              </tr>
                              <tr>
                                <th scope="col">Special commission</th>
                                <td scope="col">
                                  @if($product->olq =0)
                                  <span class="badge badge-success">Unlimited</span>
                                  @else
                                    <span class="badge badge-danger">Only one item</span>
                                  @endif
                                </td>
                              </tr>
                              <tr>
                                <th scope="col">Shipping time</th>
                                <td scope="col">
                                  @if($product->ship !=null)
                                  <span class="">{{$product->ship}}</span>
                                  @else
                                    <span class="badge badge-danger">As soon as possible</span>
                                  @endif
                                </td>
                              </tr>
                              <tr>
                            </thead>
                            <tbody>
                              
                              
                              
                            </tbody>
                          </table>

                            
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Modal -->
<div class="modal fade" id="affiliteoder" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Affiliate order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
        <form action="{{route('affilate.order')}}" method="POST">
          
            {{csrf_field()}}
            <input type="hidden" name="productid" id="productid" value="">

                    <div class="form-group">
                      <input type="text" class="form-control" name="customer_name" placeholder="Customer name" required="" value="{{old("customer_name")}}">
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                     <input type="text" class="form-control" name="customer_city" placeholder="Customer city" required="" value="{{old("customer_city")}}">
                    </div>
                    <div class="form-group">
                     <input type="text" class="form-control" name="customer_phone" placeholder="Customer phone" required="" value="{{old("customer_phone")}}">
                    </div>

                    <div class="form-group">
                      <input type="text" class="form-control" name="customer_address" placeholder="Customer address" required="" value="{{old("customer_address")}}">
                    </div>
                   
                    <div class="form-group">
                      <small>comision: </small><small id="comision"></small>

                      <input type="number" class="form-control" name="price" min="0" placeholder="price" required="" value="{{old("price")}}" id="pprice" main="">

                    </div>
                     <div class="form-group">
                      <input type="number" class="form-control" name="quantity" min="1" placeholder="Quantity" step="1" required="" value="1" id="quantity">
                    </div>
                     <div class="form-group">
                      <label>Shipping Method</label><br>


                                    @php
                                      $shiptype=App\Shiptype::all();
                                    @endphp
                                    @foreach($shiptype as $type)
                                    <h5>{{$type->name}}</h5>
                                    @foreach($type->shipinfo as $info)
                                    <div class="radio-design" style="margin-left: 25px">
                                                     <input type="radio" class="shipping" id="" name="shipping" value="{{$info->price }}"
                                                     {{ ($info->id)==1 ? 'checked' : '' }}> 
                                      <span class="checkmark"></span>
                                      <label for="">
                                        <span>{{$info->location}}</span>
                                        <small>Cost: {{$info->price}} TK</small>
                                        <small>Delivery time : {{$info->duration}}</small>
                                        @if($info->note !=null)
                                         <small>Note : {{$info->note}}</small> 
                                        @endif
                                      </label>
                                    </div>
                                    @endforeach
                                    @endforeach


            
           

          <button type="submit" class="btn btn-primary">Make order</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')
  <script type="text/javascript" src="{{asset('assets/front/js/datatable.js')}}"></script>
  <script>
    function textreset(){

    }
    $(document).ready(function() {
        $('#allproduct').DataTable();

        //copy code

        $('.getafiliateurl').click(function (e) {
        e.preventDefault();
        var copyedid=$(this).attr('id');
        console.log(copyedid);

        var copyText = $(this).attr('href');

        document.addEventListener('copy', function(e) {
           e.clipboardData.setData('text/plain', copyText);
           e.preventDefault();
        }, true);

         document.execCommand('copy');
         $(this).text('Copied');

         setTimeout(function(){
           $('#'+copyedid).text('Get My Link');
         },5000);
        
      });
    } );
  </script>

  <script type="text/javascript">

    $(document).ready(function(){
      
        $('.pro_id').click(function(){
             var product=$(this).attr('product');
             var price=$(this).attr('price');

            $('#productid').attr('value',product)
            $('#pprice').attr('value',price);
            $('#pprice').attr('main',price);

            var com=(price*10)/100;

            $('#comision').text(com);

        });
        //===calculate comission=====

      $('#pprice').on('keyup change',function(){
          var price=$(this).val();
          var mp=$(this).attr('main');
          var mainprice=parseInt(mp);

          var comm=(mainprice*10)/100;
          

          
          if (price > mainprice) {
            var sellcom=price-mainprice;
            var totalcom=sellcom+comm;
            $('#comision').text(totalcom);
          }else{
            $('#comision').text(comm);
          }
       

      });

      //===calculate quantity

      // $('#quantity').on('keyup change',function(){
      //     var quantity=$(this).val();
      //     var mp=$('#pprice').attr('main');
      //     var price=$('#pprice').val();
      //     var mainprice=parseInt(mp);

      //     var comm=(mainprice*10)/100;
      //     var total=price*quantity;

        
      //       var sellcom=total-mainprice;
      //       var totalcom=sellcom+comm;
      //       $('#comision').text(totalcom);

      //       if (quantity > 1) {
      //         $('#pprice').val(total);
      //       }else{
      //         $('#pprice').val(mainprice);
      //       }
      // });



    });

  </script>

@endsection

