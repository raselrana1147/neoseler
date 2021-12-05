                        @if(isset($orders))
                        <div class="tracking-steps-area">
                                    <div class="content" style="margin-left:300px">
                                         <h4>Status : {{$orders->status}}</h4>
                                        <p class="date">Order Date: {{ date('d-M-Y',strtotime($orders->updated_at)) }}</p>
                                        <p class="details">Order Amount: {{ $orders->pay_amount}} TK</p>
                                         <p class="details">Order commission: {{ $orders->affilate_charge}} TK</p>
                                    </div>
                            
                        </div>


                        @else
                        <h3 class="text-center">{{ $langg->lang775 }}</h3>
                        @endif