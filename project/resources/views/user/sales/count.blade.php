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
                                <span>Sales History </span><br>
                                <span id="countsales">Total Sales {{count($aorder)}} </span>
                            </h4>
                            <div>
                              <form action="{{route('sales.count')}}" method="post">
                                {{csrf_field()}}
                                <strong>Sort by</strong>  
                                <select id="salessort" name="salessort">
                                  <option value="alltime">All time</option>
                                  <option value="daily">Daily</option>
                                  <option value="weekly">Weekly</option>
                                  <option value="monthly">Monthly</option>
                                </select>
                                <button class="btn btn-success btn-sm" type="submit">Sort</button>
                              </form>
                                

                             
                            </div>
                            @include('error.error')
                        </div>
                        <div class="edit-info-area">
       
        <div class="body">
            
                              <table id="allsale" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                          <thead>
                        <tr>
                           <th width="10%">Date Time</th>
                           <th  width="10%">Total sales</th>
                           
                          
                            
                        </tr>
                          </thead>
                      {{-- ===body --}}
                      <tbody>
                      @foreach ($aorder as $sale)
                       
                       <tr>
                       {{--  @foreach($sales as $sale) --}}
                          <td>{{$sale->created_at}}</td>
                          <td>{{$sale->total}}</td>
                          
                       </tr>
                      {{-- @endforeach --}}
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
<div class="modal fade" id="salehistory" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Details Sales History</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <table class="table">
         
         <tbody id="tablecontant">
           
           
         </tbody>
       </table>
        
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
    $(document).ready(function() {
        $('#allsale').DataTable();
    } );
  </script>

  <script>
    $(document).ready(function(){
        $('#salessort').on('change',function(){
            var cat=$(this).val();

            $.get('http://localhost/oferri/sort/sales/'+cat,function(resposne){
                   //var data=JSON.parse(resposne);
                    console.log(resposne);
                   
              });

            
        });
    });
  </script>

  <script type="text/javascript">

    $(document).ready(function(){
      
        $('.orderid').click(function(){
             var order_id=$(this).attr('id');
            

             // $.ajax({
             //   method: "POST",
             //   url: "http://localhost/oferri/details/sales",
             //   data: {order_id:order_id},
             //   contentType:false,
             //   cache: false,
             //   success: function (data) {
             //     console.log(data);
             //   }

             // });

              var result='';
             $.get('http://localhost/oferri/details/sales/'+order_id,function(resposne){
                    var data=JSON.parse(resposne);
                      result+="<tr>"+"<th>"+data.customer_name+"<th>"+"</tr>";
                      result+="<tr>"+"<th>"+data.customer_phone+"<th>"+"</tr>";
                    
               });

              $("#tablecontant").html(result);
        });
        
     

    });

  </script>

@endsection

