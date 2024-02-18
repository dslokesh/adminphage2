<!DOCTYPE html>
<html lang="en" data-x="html" data-x-toggle="html-overflow-hidden">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
   <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" integrity="sha256-yMjaV542P+q1RnH6XByCPDfUFhmOafWbeLPmqKh11zo=" crossorigin="anonymous" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
  <!-- Stylesheets -->
  <link rel="stylesheet" href="{{asset('front/css/vendors.css')}}">
   <link rel="stylesheet" href="{{asset('front/css/main.css')}}">
   <link href="{{asset('dist/css/owl.carousel.min.css')}}" rel="stylesheet">
	<link href="{{asset('dist/css/owl.theme.default.min.css')}}" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
  <link href="{{asset('dist/css/custom.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('front/css/style.css')}}">
   <title>{{ config('app.name', 'Laravel') }}</title>
   <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
  <div class="preloader js-preloader">
    <div class="preloader__wrap">
      <div class="preloader__icon">
        <svg width="41" height="31" viewBox="0 0 41 31" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M39.9246 6.45422C38.6506 6.53101 37.3919 6.77205 36.1796 7.17136C34.9471 7.51728 33.7473 7.97054 32.594 8.52594C31.4296 9.02494 30.3322 9.66736 29.327 10.4383C28.3008 11.1471 27.3408 11.9472 26.4585 12.8287C25.5696 13.7546 24.7443 14.7396 23.9884 15.7769C23.2751 16.8197 22.6361 17.9114 22.076 19.0439C21.5552 20.2118 21.1029 21.409 20.7215 22.6295C20.4058 23.862 20.1663 25.1127 20.0043 26.3745C19.9199 25.1015 19.6791 23.8437 19.2872 22.6295C18.9413 21.397 18.488 20.1972 17.9326 19.0439C17.4336 17.8795 16.7912 16.7821 16.0203 15.7769C15.2919 14.7406 14.4932 13.7555 13.6298 12.8287C12.703 11.9653 11.7179 11.1666 10.6816 10.4383C9.67646 9.66736 8.579 9.02494 7.41468 8.52594C6.27257 7.9447 5.07016 7.49046 3.82902 7.17136C2.61677 6.77205 1.35801 6.53101 0.0840036 6.45422C0.0840036 7.17136 0.0043223 7.88849 0.0043223 8.60562C-0.0264515 10.0767 0.107179 11.5467 0.402729 12.9881C0.551182 13.7144 0.737357 14.4325 0.960498 15.1395C1.12782 15.8528 1.36813 16.5471 1.67763 17.2112C1.93625 17.8895 2.22878 18.5543 2.55412 19.2032L3.66966 21.1156L5.02424 22.8686L6.45851 24.4622L8.05213 25.9761L9.80512 27.251C10.4426 27.7291 11.08 28.0478 11.7175 28.4463L13.7095 29.4024L15.7015 30.1196L17.8529 30.6773L20.0043 30.9961L22.1557 30.6773L24.3071 30.1196L26.3788 29.4024L28.3709 28.4463L30.2035 27.251L31.9565 25.9761C32.5257 25.513 33.0584 25.0069 33.5501 24.4622C34.0948 23.9705 34.6009 23.4377 35.0641 22.8686L36.339 21.1156C36.7374 20.4781 37.1358 19.8407 37.4545 19.2032L38.4107 17.2112L39.1278 15.1395C39.3251 14.4313 39.4847 13.7132 39.6059 12.9881C39.7511 12.2773 39.8575 11.5591 39.9246 10.8367C40.0321 10.0981 40.0588 9.35 40.0043 8.60562C40.0175 7.88757 39.9909 7.16933 39.9246 6.45422Z" fill="url(#paint0_linear_433_3831)" />
          <path d="M25.0244 5.0996C25.0405 5.44685 25.0138 5.79477 24.9447 6.13546C24.875 6.49094 24.7681 6.83813 24.626 7.17131L24.1479 8.04781L23.5104 8.84462L22.7136 9.48207L21.7574 9.96016L20.8013 10.2789H18.7295L17.6937 9.96016L16.8172 9.48207L16.0204 8.84462L15.3033 8.04781L14.8252 7.17131L14.5064 6.13546C14.5064 5.81673 14.4268 5.49801 14.4268 5.0996C14.4268 4.7012 14.5064 4.46215 14.5064 4.14343C14.5064 3.8247 14.7455 3.42629 14.8252 3.10757L15.3033 2.23108L16.0204 1.43426C16.249 1.17933 16.5183 0.963939 16.8172 0.796813L17.6937 0.318725L18.7295 0H20.8013L21.7574 0.318725L22.7136 0.796813L23.5104 1.43426L24.1479 2.23108L24.626 3.10757C24.7789 3.43673 24.8861 3.78523 24.9447 4.14343C25.0105 4.45766 25.0372 4.77881 25.0244 5.0996Z" fill="#EB662B" />
          <defs>
            <linearGradient id="paint0_linear_433_3831" x1="6.50516" y1="10.1354" x2="23.3076" y2="35.2211" gradientUnits="userSpaceOnUse">
              <stop stop-color="#EB662B" />
              <stop offset="1" stop-color="#F28555" />
            </linearGradient>
          </defs>
        </svg>
      </div>
    </div>

    <div class="preloader__title">Viatours</div>
  </div>

  <div class="tourPagesSidebar" data-x="tourPagesSidebar" data-x-toggle="-is-active">
    <div class="tourPagesSidebar__overlay"></div>
    <div class="tourPagesSidebar__content">
      <div class="tourPagesSidebar__header d-flex items-center justify-between">
        <div class="text-20 fw-500">All filters</div>

        <button class="button -dark-1 size-40 rounded-full bg-light-1" data-x-click="tourPagesSidebar">
          <i class="icon-cross text-10"></i>
        </button>
      </div>


    </div>
  </div>

  <button class="toTopButton js-top-button">
    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
      <g clip-path="url(#clip0_83_4004)">
        <path d="M17.8783 0H4.12177C3.59388 0 3.16602 0.42786 3.16602 0.955755C3.16602 1.48365 3.59388 1.91151 4.12177 1.91151H17.8783C18.4062 1.91151 18.834 1.48365 18.834 0.955755C18.834 0.42786 18.4062 0 17.8783 0Z" />
        <path d="M11.6759 4.67546C11.3026 4.30219 10.6975 4.30219 10.3242 4.67546L6.04107 8.95863C5.66779 9.3319 5.66779 9.937 6.04107 10.3103C6.41434 10.6837 7.01955 10.6836 7.39272 10.3103L10.0444 7.6587V21.0443C10.0444 21.5722 10.4723 22 11.0002 22C11.5281 22 11.9559 21.5722 11.9559 21.0443V7.65859L14.6076 10.3102C14.7942 10.4969 15.0389 10.5901 15.2834 10.5901C15.528 10.5901 15.7726 10.4968 15.9593 10.3102C16.3325 9.9369 16.3325 9.3318 15.9593 8.95852L11.6759 4.67546Z" />
      </g>
      <defs>
        <clipPath id="clip0_83_4004">
          <rect width="22" height="22" fill="white" />
        </clipPath>
      </defs>
    </svg>
  </button>

  <main>


    <header class="header -type-1 -secondary js-header">
      <div data-anim="fade delay-3" class="header__container container">
        <!--<div class="headerMobile__left">
          <button class="header__menuBtn js-menu-button">
            <i class="icon-main-menu"></i>
          </button>
        </div>-->

        <div class="header__logo">
          <a href="/" class="header__logo">
            <img src="{{asset('Abatera_logo.jpg')}}" style="max-width:167; height:80px" alt="logo icon">
          </a>

         
        </div>

        <div class="header__right">
		@if(auth()->check())
			@permission('agency.voucher.booking') 
          <a href="{{ route('agent-vouchers.index') }}" class="ml-30">
            My Booking
          </a>
		   <a href="{{ route('agent-vouchers.create') }}" class="ml-30">
           Book Now
          </a>
		  @endpermission
		  @permission('list.agent.ledger') 
		   <a href="{{ route('agentLedgerReportWithVat') }}" class="ml-30">
           Ledger
          </a>
		@endpermission
		
		  <div class="headerDropdown  js-form-dd">
            <div class="headerDropdown__button button -sm -dark-1 bg-accent-2 rounded-200 text-white ml-30" data-x-click="header-currency">
              {{\Auth::user()->company_name}} (<i class="fa fa-wallet" aria-hidden="true"></i>&nbsp;AED  {{\Auth::user()->agent_amount_balance}})
              <i class="icon-chevron-down text-18"></i>
            </div>

            <div class="headerDropdown__content" data-x="header-currency" data-x-toggle="is-active">
              <div class="headerDropdown">
                <div class="headerDropdown__container">

                  <div class="headerDropdown__item">
                   <a href="{{ route('profile-edit',Auth::user()->id) }}" class="">Profile</a>
                  </div>

                  <div class="headerDropdown__item">
                    <a href="{{ route('change-password') }}" class="">Change Password</a>
                  </div>

                </div>
              </div>
            </div>
          </div>
		
		  
          <a href="{{route('logout')}}" class="button -sm -dark-1 bg-accent-1 rounded-200 text-white ml-30">
            Logout
          </a>
		  
		 @else
			  <a href="{{route('register')}}" class="">
            Sign up
          </a>

          <a href="{{route('login')}}" class="button -sm -dark-1 bg-accent-1 rounded-200 text-white ml-30">
            Log in
          </a>
		@endif
          <!--<button class="header__menuBtn ml-30 js-menu-button">
            <i class="icon-main-menu"></i>
          </button>-->
        </div>
      </div>
    </header>

    <!--<div class="menu js-menu">
      <div class="menu__overlay js-menu-button"></div>

      <div class="menu__container">
        <div class="menu__header">
          <h4>Main Menu</h4>

          <button class="js-menu-button"><i class="icon-cross text-10"></i></button>
        </div>

        <div class="menu__content">
          <ul class="menuNav js-navList">
            <li class="menuNav__item -has-submenu js-has-submenu">
              <a>
                Home
                <i class="icon-chevron-right"></i>
              </a>

              <ul class="submenu">
                <li class="submenu__item js-nav-list-back">
                  <a>Back</a>
                </li>


                <li class="submenu__item">
                  <a href="index.html">Home 01</a>
                </li>

                <li class="submenu__item">
                  <a href="home-2.html">Home 02</a>
                </li>

                <li class="submenu__item">
                  <a href="home-3.html">Home 03</a>
                </li>

                <li class="submenu__item">
                  <a href="home-4.html">Home 04</a>
                </li>

                <li class="submenu__item">
                  <a href="home-5.html">Home 05</a>
                </li>

                <li class="submenu__item">
                  <a href="home-6.html">Home 06</a>
                </li>

                <li class="submenu__item">
                  <a href="home-7.html">Home 07</a>
                </li>

                <li class="submenu__item">
                  <a href="home-8.html">Home 08</a>
                </li>

                <li class="submenu__item">
                  <a href="home-9.html">Home 09</a>
                </li>

                <li class="submenu__item">
                  <a href="home-10.html">Home 10</a>
                </li>

              </ul>
            </li>

           
            <li class="menuNav__item">
              <a href="contact.html">Contact</a>
            </li>
          </ul>
        </div>


        <div class="menu__footer">
          <i class="icon-headphone text-50"></i>

          <div class="text-20 lh-12 fw-500 mt-20">
            <div>Speak to our expert at</div>
            <div class="text-accent-1">1-800-453-6744</div>
          </div>

          <div class="d-flex items-center x-gap-10 pt-30">

            <div>
              <a class="d-block">
                <i class="icon-facebook"></i>
              </a>
            </div>

            <div>
              <a class="d-block">
                <i class="icon-twitter"></i>
              </a>
            </div>

            <div>
              <a class="d-block">
                <i class="icon-instagram"></i>
              </a>
            </div>

            <div>
              <a class="d-block">
                <i class="icon-linkedin"></i>
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>-->
	
 @yield('content')

<footer class="footer -type-1">
      <div class="footer__main">
        <div class="footer__bg">
          <img src="{{asset('front/img/footer/1/bg.svg')}}" alt="image">
        </div>

        <div class="container">
          <div class="footer__info">
            <div class="row y-gap-20 justify-between">
              <div class="col-auto">
                <div class="row y-gap-20 items-center">
                  <div class="col-auto">
                    <i class="icon-headphone text-50"></i>
                  </div>

                  <div class="col-auto">
                    <div class="text-20 fw-500">
                      Speak to our expert at
                      <span class="text-accent-1">+971 4 591 7098</span>
                    </div>
                  </div>
                </div>
              </div>

             
            </div>
          </div>

         
        </div>
      </div>


      <div class="container">
        <div class="footer__bottom">
          <div class="row y-gap-5 justify-between items-center">
            <div class="col-auto">
              <div>© Copyright  {!! config('app.name', 'newname') !!} <?php echo date('Y'); ?></div>
            </div>

           
          </div>
        </div>
      </div>
    </footer>


  </main>

  <!-- JavaScript -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAz77U5XQuEME6TpftaMdX0bBelQxXRlM"></script>
  <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script src="{{asset('front/js/vendors.js')}}"></script>
<script src="{{asset('front/js/main.js')}}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha256-5YmaxAwMjIpMrVlK84Y/+NjCpKnFYa8bWWBbUHSBGfU=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
 $(document).ready(function () {
    $('.datepickerAgent').datepicker({
        weekStart: 1,
        minDate: 0,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
        dateFormat: 'dd-mm-yy'
    });
	
	$('.datepicker').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
		dateFormat: 'dd-mm-yy'
    });
	$('.datepickerdmy').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
		dateFormat: 'dd-mm-yy'
    });
});
 </script>
 @yield('scripts')
</body>

</html>
