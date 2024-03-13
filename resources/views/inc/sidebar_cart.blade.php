<!-- Sidebar Menu -->

<div class="right-sidebar-menu">
        <div class="sidebar-logo-area d-flex justify-content-between align-items-center">
            <div class="right-sidebar-close-btn">
                <i class="bi bi-x"></i>
            </div>
            <h4>My Cart</h4>
        </div>
        <div class="sidebar-content-wrap">
            <div class="category-wrapper">
                @php
					$total = 0;
					$currency = SiteHelpers::getCurrencyPrice();
					@endphp
				
			  
					@if(!empty($voucherActivity))
					  @foreach($voucherActivity as $ap)
				  @php
          $total += $ap->totalprice;
		  $activityImg = SiteHelpers::getActivityImageName($ap->activity_id);
					@endphp

          <div class="row">
                    <div class="col-10">
                        <span class="cart-title font-size-21 text-dark">
                        {{$ap->activity_title}}
                        </span>
                    </div>
                    <div class="col-2  text-right">
                          <form id="delete-form-{{$ap->id}}" method="post" action="{{route('voucher.activity.delete',$ap->id)}}" style="display:none;">
                                      {{csrf_field()}}
                                      {{method_field('DELETE')}}
                                  </form>
                                  <small>
                                  <a class="btn btn-xs btn-danger border-round" title="delete" href="javascript:void(0)" onclick="
                                      if(confirm('Are you sure, You want to delete this?'))
                                      {
                                          event.preventDefault();
                                          document.getElementById('delete-form-{{$ap->id}}').submit();
                                      }
                                      else
                                      {
                                          event.preventDefault();
                                      }
                                  
                                  "><small><i class="bi bi-x"></i></small></a></small>
                    </div>
              </div>
             
                                  <div class="row"  style="margin-bottom: 10px;border-bottom: 1px #000 solid;">
				  <div class="col-md-3" style="padding: 5px 0px 5px 5px; ">
              <img src="{{asset('uploads/activities/'.$activityImg)}}" class="img-fluid" style="border-radius: 5px;" />
            </div>
			<div class="col-md-9">
              <ul class="list-unstyled" style="">
             
                <li>
                 {{$ap->variant_name}}
                </li>
				<li>
                  {{$ap->transfer_option}}
                </li>
                <li>
                   {{ $ap->tour_date ? date(config('app.date_format'),strtotime($ap->tour_date)) : null }}
                </li>
                <li>

                 <i class="fas fa-male color-grey" style="font-size:16px;" title="Adult"></i> <span class="color-black">{{$ap->adult}}</span> 
                 @if($ap->child > 0)
                 <i class="fas fa-child color-grey" title="Child"></i>  <span class="color-black">{{$ap->child}}</span>
                @endif
                  <span class="float-right " ><p class="" style="text-align: right;"><strong>{{$currency['code']}} {{$ap->totalprice*$currency['value']}}</strong></p></span>
                </li>
                
              </ul>
			   
            </div>
			
                </div>
              
              
			
				 @endforeach
                 @endif
             
            </div>
            
        </div>
        
        <div class="sidebar-bottom">
            <div class="row">
            <div class="col-md-12">
                @if($voucherActivityCount > 0)
                               <h5 class="col-md-12" style="width:100%; text-align: right;"></h5>
                            @endif
                </div>
                <div class="col-md-12">
                @if($voucherActivityCount > 0)
                               <h5 class="col-md-12" style="width:100%; text-align: right;">Total Amount : {{$currency['code']}} {{$total*$currency['value']}}</h5>
                            @endif
                </div>
                
            </div>
            
        </div>
        <div class="sidebar-bottom">
            <div class="row">
               
                <div class="col-md-12" style="text-align: center;">
                @if($voucherActivityCount > 0)
                                  <a href="{{ route('agent-vouchers.show',$voucher->id) }}" class="secondary-btn2" >
                                <i class="fas fa-shopping-cart"></i>
                                Checkout({{$voucherActivityCount}})
                            </a>
                            @endif
                </div>
            </div>
            
        </div>
    </div>

<!-- END CART VIEW -->


