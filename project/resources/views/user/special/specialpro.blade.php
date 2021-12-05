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
                            @include('error.error')
                        </div>
                        <div class="edit-info-area">
        @php
          $ausername=App\AffiliateM::where('user_id',Auth::user()->id)->first();
         //echo $ausername->username;
        @endphp
                
        <div class="body">
            
                              <table id="allproduct" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                          <thead>
                        <tr>
                           
                           <th  width="10%">Name</th>
                           <th width="10%">Status</th>
                           <th  width="10%">Special Commissiom</th>
                           <th  width="10%">View</th>
                           <th  width="10%">Action</th>
                           
                        </tr>
                          </thead>
                      {{-- ===body --}}
                      <tbody>
                      @foreach ($datas as $product)
                        {{-- expr --}}
                     
                       <tr>
                          
                          <td>{{$product->name}}</td>
                          <td>
                            @if($product->stock !=null)
                              <span class="badge badge-success">In stock</span>
                            @else
                                <span class="badge badge-danger">N\A</span>
                            @endif
                          </td>
                          <td>{{$product->special_com}} TK</td>
                          <td title="View details">
                            <a href="{{route('special.product.details',$product->id)}}"><i class="far fa-eye"></i>Product</a>
                          </td>
                          <td>
                            @if (!is_null($ausername))
                             <a class="btn btn-primary btn-sm getafiliateurl" href="{{config('app.url')}}/item/{{ $product->slug }}/{{$ausername->username ? $ausername->username : ''}}"  id="text{{$product->id}}">Get My Link</a>

                            
                             {{-- <button type="button" class="btn btn-success btn-sm pro_id" product="{{$product->id}}" data-target="#affiliteoder" data-toggle="modal" price="{{$product->price}}">Order</button> --}}
                             @else
                             <span>N/A</span>
                            @endif
                           

                
                          </td>
                         
                       </tr>

                     
                     @endforeach
                      </tbody>
                        <tfoot></tfoot>
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

