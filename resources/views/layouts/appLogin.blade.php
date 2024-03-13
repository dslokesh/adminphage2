<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{asset('front/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/css/jquery-ui.css')}}" rel="stylesheet">
    <!-- Bootstrap Icon CSS -->
    <link href="{{asset('front/assets/css/bootstrap-icons.css')}}" rel="stylesheet">
    <!-- Fontawesome all CSS -->
    <link href="{{asset('front/assets/css/all.min.css')}}" rel="stylesheet">
    <!-- Animate CSS -->
    <link href="{{asset('front/assets/css/animate.min.css')}}" rel="stylesheet">
    <!-- FancyBox CSS -->
    <link href="{{asset('front/assets/css/jquery.fancybox.min.css')}}" rel="stylesheet">

    <!-- Fontawesome CSS -->
    <link href="{{asset('front/assets/css/fontawesome.min.css')}}" rel="stylesheet">
    <!-- Swiper slider CSS -->
       <link rel="stylesheet" href="{{asset('front/assets/css/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/daterangepicker.css')}}">
    <!-- Slick slider CSS -->
    <link rel="stylesheet" href="{{asset('front/assets/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/slick-theme.css')}}">
    <!-- BoxIcon  CSS -->
    <link href="{{asset('front/assets/css/boxicons.min.css')}}" rel="stylesheet">
    <!-- Select2  CSS -->
    <link href="{{asset('front/assets/css/select2.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/css/nice-select.css')}}" rel="stylesheet">
    <!--  Style CSS  -->
    <link rel="stylesheet" href="{{asset('front/assets/css/style.css')}}">
    <link href="{{asset('front/assets/css/custom.css')}}" rel="stylesheet">
    <!-- Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
	 <meta name="csrf-token" content="{{ csrf_token() }}" />
     <script src="{{asset('front/assets/js/jquery-3.7.1.min.js')}}"></script>
</head>

<body>
  <div id="loader-overlay">
  <div class="loader"></div>
</div>
   
    <div class="egns-preloader">
        
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-6">
                    <div class="circle-border">
                        <div class="moving-circle"></div>
                        <div class="moving-circle"></div>
                        <div class="moving-circle"></div>
                        <img src="{{asset('Abatera_logo.jpg')}}" style="width: 100px;margin: 20px 18px;" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Sidebar Menu -->

   
    <!-- Start header section -->
    <header class="header-area style-3">
        <div class="header-logo d-lg-none d-flex">
            <a href="/"><img alt="image" class="img-fluid" style="max-width:167; height:80px" src="{{asset('Abatera_logo.jpg')}}"></a>
        </div>
        <div class="company-logo d-lg-flex d-none">
            <a href="/"><img src="{{asset('Abatera_logo.jpg')}}" style="max-width:167; height:80px; margin: 10px 0px;" alt=""></a>
        </div>
        <div class="" style="width: 300px;">
        </div>
        <div class="main-menu nav-right  jsutify-content-end">
            <div class="mobile-logo-area d-lg-none d-flex justify-content-between align-items-center">
                <div class="mobile-logo-wrap">
                    <a href="/"><img alt="image" style="max-width:167; height:80px" src="{{asset('Abatera_logo.jpg')}}"></a>
                </div>
                <div class="menu-close-btn">
                    <i class="bi bi-x"></i>
                </div>
            </div>
			
            <ul class="menu-list icon-list">
			@if(auth()->check())
				@permission('agency.voucher.booking') 
                
                <li class="">
                    <a href="{{ route('agent-vouchers.create') }}" class="drop-down">Book Now</a>
                    
                </li>

                
				 @php
                $voucherActivityCount = 0;
				$currencyDD = SiteHelpers::getCurrencyAll();
				$userCR =  auth()->user()->currency_id;
				$currencyGet = SiteHelpers::getCurrencyPrice();
				@endphp
                <li class="">
                   
                  
                <img alt="image"  src="{{asset('front/assets/img/exchange.png')}}">
                        
                   <ul class="sub-menu">
                   @foreach($currencyDD as $currency)
                    @if($currencyGet['code'] == $currency->code)
                            <li><a href="{{ route('currency.change',['user_currency'=>$currency->code]) }}" style="font-weight:bold;">{{$currency->code}}</a></li>
                    @else
                    <li><a href="{{ route('currency.change',['user_currency'=>$currency->code]) }}">{{$currency->code}}</a></li>
                    @endif
                            @endforeach     
                        </ul>
                 
                   </li>
		

           
			    <li><a href="javascript:void(0);"><img alt="image"  src="{{asset('front/assets/img/wallet.png')}}"> </a>
                <ul class="sub-menu">
                    <li><a href="#">AED {{\Auth::user()->agent_amount_balance}}</a></li>
</ul>
            </li>

                
				
				 <li class="menu-item-has-children">
                    <a href="{{ route('profile-edit',Auth::user()->id) }}" class="drop-down">{{\Auth::user()->company_name}}
              </a><i class="bi bi-plus chevron-icon"></i>
                    <ul class="sub-menu">
                    <li><a href="{{ route('profile-edit',Auth::user()->id) }}">Profile</a></li>
					 @permission('list.agent.ledger') 
                            <li>
                            <a href="{{ route('agentLedgerReportWithVat') }}" class="drop-down">Ledger</a>
                        </li>
						@endpermission

                        <li class=" ">
                    <a href="{{ route('agent-vouchers.index') }}" class="drop-down">My Booking</a>
                    
                </li>
                        
                        <li>
                            <a href="{{ route('change-password') }}">Change Password</a>
                        </li>
                       
                        <li>
                    <a href="{{ route('logout') }}" class="drop-down">Logout</a>
                </li>
                    </ul>
                </li>
                
                @endpermission
                @else
                <li class="">
                <a href="{{route('register')}}" class="sign-up-btn" style="text-align:left">Sign Up!</a>
                    
                </li>
				@endif
            </ul>
			
            
        </div>
        <div class="nav-right d-flex jsutify-content-end align-items-center">


        @if(auth()->check())
				@if(auth()->user()->role_id == '3')
				@php
                $voucherActivityCount = 0;
				$lastVoucher = SiteHelpers::getAgentlastVoucher();
				if(!empty($lastVoucher)){
				$voucherActivityCount = App\Models\VoucherActivity::where('voucher_id',$lastVoucher->id)->count();
				}
				
				$currentAction = \Route::currentRouteAction();		
				list($controller, $action) = explode('@', $currentAction);
				$controller = preg_replace('/.*\\\/', '', $controller);
				
				@endphp
				@if($controller == 'AgentVouchersController' and in_array($action,array('addActivityList','addActivityView')))
                
                @php
                $voucherActivityCount = App\Models\VoucherActivity::where('voucher_id',$vid)->count();
                @endphp
                @if($voucherActivityCount > 0)
               
                <ul class="icon-list">
                
                <li class="right-sidebar-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="M17 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M1 2v2h2l3.6 7.59l-1.36 2.45c-.15.28-.24.61-.24.96a2 2 0 0 0 2 2h12v-2H7.42a.25.25 0 0 1-.25-.25c0-.05.01-.09.03-.12L8.1 13h7.45c.75 0 1.41-.42 1.75-1.03l3.58-6.47c.07-.16.12-.33.12-.5a1 1 0 0 0-1-1H5.21l-.94-2M7 18c-1.11 0-2 .89-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2"/></svg>({{$voucherActivityCount}})
                </li>
                <script>
                    jQuery(window).on('load', function () {
		$( ".right-sidebar-button" ).trigger( "click" );
        setTimeout(function() {
            $( ".right-sidebar-close-btn" ).trigger( "click" ) }, 2000);
  
	});
                </script>
            </ul>
            @endif
				@endif
				@endif
				@endif

      
            <div class="hotline-area d-xl-flex d-none">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28">
                        <path
                            d="M27.2653 21.5995L21.598 17.8201C20.8788 17.3443 19.9147 17.5009 19.383 18.1798L17.7322 20.3024C17.6296 20.4377 17.4816 20.5314 17.3154 20.5664C17.1492 20.6014 16.9759 20.5752 16.8275 20.4928L16.5134 20.3196C15.4725 19.7522 14.1772 19.0458 11.5675 16.4352C8.95784 13.8246 8.25001 12.5284 7.6826 11.4893L7.51042 11.1753C7.42683 11.0269 7.39968 10.8532 7.43398 10.6864C7.46827 10.5195 7.56169 10.3707 7.69704 10.2673L9.81816 8.61693C10.4968 8.08517 10.6536 7.1214 10.1784 6.40198L6.39895 0.734676C5.91192 0.00208106 4.9348 -0.21784 4.18082 0.235398L1.81096 1.65898C1.06634 2.09672 0.520053 2.80571 0.286612 3.63733C-0.56677 6.74673 0.0752209 12.1131 7.98033 20.0191C14.2687 26.307 18.9501 27.9979 22.1677 27.9979C22.9083 28.0011 23.6459 27.9048 24.3608 27.7115C25.1925 27.4783 25.9016 26.932 26.3391 26.1871L27.7641 23.8187C28.218 23.0645 27.9982 22.0868 27.2653 21.5995ZM26.9601 23.3399L25.5384 25.7098C25.2242 26.2474 24.7142 26.6427 24.1152 26.8128C21.2447 27.6009 16.2298 26.9482 8.64053 19.3589C1.0513 11.7697 0.398595 6.75515 1.18669 3.88421C1.35709 3.28446 1.75283 2.77385 2.2911 2.45921L4.66096 1.03749C4.98811 0.840645 5.41221 0.93606 5.62354 1.25397L7.67659 4.3363L9.39976 6.92078C9.60612 7.23283 9.53831 7.65108 9.24392 7.88199L7.1223 9.53232C6.47665 10.026 6.29227 10.9193 6.68979 11.6283L6.85826 11.9344C7.45459 13.0281 8.19599 14.3887 10.9027 17.095C13.6095 19.8012 14.9696 20.5427 16.0628 21.139L16.3694 21.3079C17.0783 21.7053 17.9716 21.521 18.4653 20.8753L20.1157 18.7537C20.3466 18.4595 20.7647 18.3918 21.0769 18.5979L26.7437 22.3773C27.0618 22.5885 27.1572 23.0128 26.9601 23.3399ZM15.8658 4.66809C20.2446 4.67296 23.7931 8.22149 23.798 12.6003C23.798 12.858 24.0069 13.0669 24.2646 13.0669C24.5223 13.0669 24.7312 12.858 24.7312 12.6003C24.7257 7.7063 20.7598 3.74029 15.8658 3.73494C15.6081 3.73494 15.3992 3.94381 15.3992 4.20151C15.3992 4.45922 15.6081 4.66809 15.8658 4.66809Z" />
                        <path
                            d="M15.865 7.46746C18.6983 7.4708 20.9943 9.76678 20.9976 12.6001C20.9976 12.7238 21.0468 12.8425 21.1343 12.93C21.2218 13.0175 21.3404 13.0666 21.4642 13.0666C21.5879 13.0666 21.7066 13.0175 21.7941 12.93C21.8816 12.8425 21.9308 12.7238 21.9308 12.6001C21.9269 9.2516 19.2134 6.53813 15.865 6.5343C15.6073 6.5343 15.3984 6.74318 15.3984 7.00088C15.3984 7.25859 15.6073 7.46746 15.865 7.46746Z" />
                        <path
                            d="M15.865 10.267C17.1528 10.2686 18.1964 11.3122 18.198 12.6C18.198 12.7238 18.2472 12.8424 18.3347 12.9299C18.4222 13.0174 18.5409 13.0666 18.6646 13.0666C18.7883 13.0666 18.907 13.0174 18.9945 12.9299C19.082 12.8424 19.1312 12.7238 19.1312 12.6C19.1291 10.797 17.668 9.33589 15.865 9.33386C15.6073 9.33386 15.3984 9.54274 15.3984 9.80044C15.3984 10.0581 15.6073 10.267 15.865 10.267Z" />
                    </svg>
                </div>
                <div class="content">
                    <span>Contact Us</span>
                    <h6><a href="tel:+971 4 591 7098">+971 4 591 7098</a></h6>
                </div>
            </div>
            <div class="sidebar-button mobile-menu-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25">
                    <path
                        d="M0 4.46439C0 4.70119 0.0940685 4.92829 0.261511 5.09574C0.428955 5.26318 0.656057 5.35725 0.892857 5.35725H24.1071C24.3439 5.35725 24.571 5.26318 24.7385 5.09574C24.9059 4.92829 25 4.70119 25 4.46439C25 4.22759 24.9059 4.00049 24.7385 3.83305C24.571 3.6656 24.3439 3.57153 24.1071 3.57153H0.892857C0.656057 3.57153 0.428955 3.6656 0.261511 3.83305C0.0940685 4.00049 0 4.22759 0 4.46439ZM4.46429 11.6072H24.1071C24.3439 11.6072 24.571 11.7013 24.7385 11.8688C24.9059 12.0362 25 12.2633 25 12.5001C25 12.7369 24.9059 12.964 24.7385 13.1315C24.571 13.2989 24.3439 13.393 24.1071 13.393H4.46429C4.22749 13.393 4.00038 13.2989 3.83294 13.1315C3.6655 12.964 3.57143 12.7369 3.57143 12.5001C3.57143 12.2633 3.6655 12.0362 3.83294 11.8688C4.00038 11.7013 4.22749 11.6072 4.46429 11.6072ZM12.5 19.643H24.1071C24.3439 19.643 24.571 19.737 24.7385 19.9045C24.9059 20.0719 25 20.299 25 20.5358C25 20.7726 24.9059 20.9997 24.7385 21.1672C24.571 21.3346 24.3439 21.4287 24.1071 21.4287H12.5C12.2632 21.4287 12.0361 21.3346 11.8687 21.1672C11.7012 20.9997 11.6071 20.7726 11.6071 20.5358C11.6071 20.299 11.7012 20.0719 11.8687 19.9045C12.0361 19.737 12.2632 19.643 12.5 19.643Z" />
                </svg>
            </div>
        </div>
    </header>
    <!-- End header section -->



 @yield('content')

 <footer class="footer-section">
        <div class="container">
            <div class="footer-top">
                <div class="row g-lg-4 gy-5 justify-content-center">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-widget">
                        <img src="{{asset('Abatera_logo.jpg')}}" style="max-width:167; height:80px; margin: 10px 0px;" alt="">
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-lg-center justify-content-md-start">
                        <div class="footer-widget">
                            <div class="single-contact mb-30">
                                <div class="widget-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                        <g clip-path="url(#clip0_1139_225)">
                                            <path d="M17.5107 13.2102L14.9988 10.6982C14.1016 9.80111 12.5765 10.16 12.2177 11.3262C11.9485 12.1337 11.0514 12.5822 10.244 12.4028C8.44974 11.9542 6.0275 9.62168 5.57894 7.73772C5.3098 6.93027 5.84808 6.03314 6.65549 5.76404C7.82176 5.40519 8.18061 3.88007 7.28348 2.98295L4.77153 0.470991C4.05382 -0.156997 2.97727 -0.156997 2.34929 0.470991L0.644745 2.17553C-1.0598 3.96978 0.82417 8.72455 5.04066 12.941C9.25716 17.1575 14.0119 19.1313 15.8062 17.337L17.5107 15.6324C18.1387 14.9147 18.1387 13.8382 17.5107 13.2102Z"></path>
                                        </g>
                                    </svg>
                                    <h5>More Inquiry</h5>
                                </div>
                                <a href="tel:999858624984">+971 4 591 7098</a>
                            </div>
                            <div class="single-contact mb-35">
                                <div class="widget-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                        <g clip-path="url(#clip0_1139_218)">
                                            <path d="M6.56266 13.2091V16.6876C6.56324 16.8058 6.60099 16.9208 6.67058 17.0164C6.74017 17.112 6.83807 17.1832 6.9504 17.22C7.06274 17.2569 7.18382 17.2574 7.29648 17.2216C7.40915 17.1858 7.5077 17.1155 7.57817 17.0206L9.61292 14.2516L6.56266 13.2091ZM17.7639 0.104306C17.6794 0.044121 17.5799 0.00848417 17.4764 0.00133654C17.3729 -0.00581108 17.2694 0.015809 17.1774 0.0638058L0.302415 8.87631C0.205322 8.92762 0.125322 9.00617 0.0722333 9.1023C0.0191447 9.19844 -0.00472288 9.30798 0.00355981 9.41749C0.0118425 9.52699 0.0519151 9.6317 0.11886 9.71875C0.185804 9.80581 0.276708 9.87143 0.380415 9.90756L5.07166 11.5111L15.0624 2.96856L7.33141 12.2828L15.1937 14.9701C15.2717 14.9963 15.3545 15.0051 15.4363 14.996C15.5181 14.9868 15.5969 14.9599 15.6672 14.9171C15.7375 14.8743 15.7976 14.8167 15.8433 14.7482C15.8889 14.6798 15.9191 14.6021 15.9317 14.5208L17.9942 0.645806C18.0094 0.543093 17.996 0.438159 17.9554 0.342598C17.9147 0.247038 17.8485 0.164569 17.7639 0.104306Z"></path>
                                        </g>
                                    </svg>
                                    <h5>Send Mail</h5>
                                </div>
                                <a href="mailto:support@abaterab2b.com">support@abaterab2b.com</a>
                            </div>
                            <div class="single-contact">
                                <div class="widget-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                        <g clip-path="url(#clip0_1137_183)">
                                            <path d="M14.3281 3.08241C13.2357 1.19719 11.2954 0.0454395 9.13767 0.00142383C9.04556 -0.000474609 8.95285 -0.000474609 8.86071 0.00142383C6.70303 0.0454395 4.76268 1.19719 3.67024 3.08241C2.5536 5.0094 2.52305 7.32408 3.5885 9.27424L8.05204 17.4441C8.05405 17.4477 8.05605 17.4513 8.05812 17.4549C8.25451 17.7963 8.60632 18 8.99926 18C9.39216 18 9.74397 17.7962 9.94032 17.4549C9.94239 17.4513 9.9444 17.4477 9.9464 17.4441L14.4099 9.27424C15.4753 7.32408 15.4448 5.0094 14.3281 3.08241ZM8.99919 8.15627C7.60345 8.15627 6.46794 7.02076 6.46794 5.62502C6.46794 4.22928 7.60345 3.09377 8.99919 3.09377C10.3949 3.09377 11.5304 4.22928 11.5304 5.62502C11.5304 7.02076 10.395 8.15627 8.99919 8.15627Z"></path>
                                        </g>
                                    </svg>
                                    <h5>Address</h5>
                                </div>
                                <a href="#">302 Wasl Business Central,
Port Saeed , Deira, Dubai
PO BOX 117900
</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 d-flex justify-content-lg-end justify-content-sm-end">
                        <div class="footer-widget">
                            
                            <div class="payment-partner">
                                <div class="widget-title">
                                    <h5>Payment Partner</h5>
                                </div>
                                <div class="icons">
                                    <ul>
                                        <li><img src="assets/img/home1/icon/visa-logo.svg" alt=""></li>
                                        <li><img src="assets/img/home1/icon/stripe-logo.svg" alt=""></li>
                                        <li><img src="assets/img/home1/icon/paypal-logo.svg" alt=""></li>
                                        <li><img src="assets/img/home1/icon/woo-logo.svg" alt=""></li>
                                        <li><img src="assets/img/home1/icon/skrill-logo.svg" alt=""></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-lg-12 d-flex flex-md-row flex-column align-items-center justify-content-md-between justify-content-center flex-wrap gap-3">
                        <ul class="social-list">
                            <li>
                                <a href="https://www.facebook.com/"><i class="bx bxl-facebook"></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"></path>
                                  </svg></a>
                            </li>
                            <li>
                                <a href="https://www.pinterest.com/"><i class="bx bxl-pinterest-alt"></i></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/"><i class="bx bxl-instagram"></i></a>
                            </li>
                        </ul>
                        <p>©Copyright {!! config('app.name', 'newname') !!} <?php echo date('Y'); ?></p> 
                        <div class="footer-right">
                            <ul>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms &amp; Condition</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- End Footer Section -->


    

    <!--  Main jQuery  -->
   
    <script src="{{asset('front/assets/js/jquery-ui.js')}}"></script>
    <script src="{{asset('front/assets/js/moment.min.js')}}"></script>
    <script src="{{asset('front/assets/js/daterangepicker.min.js')}}"></script>
    <!-- Popper and Bootstrap JS -->
    <script src="{{asset('front/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('front/assets/js/popper.min.js')}}"></script>
    <!-- Swiper slider JS -->
    <script src="{{asset('front/assets/js/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('front/assets/js/slick.js')}}"></script>
    <!-- Waypoints JS -->
    <script src="{{asset('front/assets/js/waypoints.min.js')}}"></script>
    <!-- Counterup JS -->
    <script src="{{asset('front/assets/js/jquery.counterup.min.js')}}"></script>
    <!-- Isotope  JS -->
    <script src="{{asset('front/assets/js/isotope.pkgd.min.js')}}"></script>
    <!-- Magnific-popup  JS -->
    <script src="{{asset('front/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <!-- Marquee  JS -->
    <script src="{{asset('front/assets/js/jquery.marquee.min.js')}}"></script>
    <!-- Select2  JS -->
     <script src="{{asset('front/assets/js/jquery.nice-select.min.js')}}"></script>
    <!-- Select2  JS -->
    <!-- <script src="{{asset('front/assets/js/select2.min.js')}}"></script> -->
    <script src="{{asset('front/assets/js/range-slider.js')}}"></script>

    <script src="{{asset('front/assets/js/jquery.fancybox.min.js')}}"></script>
    <!-- Custom JS -->
    <script src="{{asset('front/assets/js/custom.js')}}"></script>


    <script>
	 $(function () {
  $("#loader-overlay").hide();
        $(".marquee_text").marquee({
            direction: "left",
            duration: 25000,
            gap: 50,
            delayBeforeStart: 0,
            duplicated: true,
            startVisible: true,
        });
        $(".marquee_text2").marquee({
            direction: "left",
            duration: 25000,
            gap: 50,
            delayBeforeStart: 0,
            duplicated: true,
            startVisible: true,
        });
		});
    </script>

 @yield('scripts')
</body>

</html>
