@extends('layouts.app')

@section('content')
<div class="bg-lightkiwigrad full-height py-4 row m-0 col-12">
    <div class="sidebar col-md-2 h-100 d-none d-md-block">
        <div id="accordion">
            <div class="card">
              <div class="card-header bg-navyblue p-0 pt-2" id="headingOne">
                <h5 class="mb-0">
                  <button class="btn btn-link bg-transparent text-lightkiwi" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    {{__("Ministries")}}
                  </button>
                </h5>
              </div>
          
              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body p-0">
                    <div class="list-group">
                        <a href="http://www.moh.gov.sy/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Ministry of Health")}} - {{__("Syria")}}</small></a>
                        <a href="https://www.moph.gov.lb/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Ministry of Health")}} - {{__("Lebanon")}}</small></a>
                        <a href="https://www.moh.gov.jo/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Ministry of Health")}} - {{__("Jordan")}}</small></a>
                        <a href="https://www.moh.gov.sa/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Ministry of Health")}} - {{__("Saudi Arabia")}}</small></a>
                      </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header bg-navyblue p-0 pt-2" id="headingTwo">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed bg-transparent text-lightkiwi" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    {{__("Syndicates")}}
                  </button>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body p-0">
                    <div class="list-group">
                        <a href="https://www.facebook.com/syrpharma/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Syndicate of Pharmacists")}} - {{__("Syria")}}</small></a>
                        <a href="https://www.facebook.com/Damas.Pharmacy" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Syndicate of Pharmacists")}} - {{__("Damascus")}}</small></a>
                        <a href="https://www.facebook.com/%D9%86%D9%82%D8%A7%D8%A8%D8%A9-%D8%B5%D9%8A%D8%A7%D8%AF%D9%84%D8%A9-%D8%B3%D9%88%D8%B1%D9%8A%D8%A7-%D9%81%D8%B1%D8%B9-%D8%B1%D9%8A%D9%81-%D8%AF%D9%85%D8%B4%D9%82-610221282340647/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Syndicate of Pharmacists")}} - {{__("Damascus Countryside")}}</small></a>
                        <a href="https://www.facebook.com/%D9%86%D9%82%D8%A7%D8%A8%D8%A9-%D8%A7%D9%84%D8%B5%D9%8A%D8%A7%D8%AF%D9%84%D8%A9-%D9%81%D8%B1%D8%B9-%D8%AD%D9%84%D8%A8-104914734179942/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Syndicate of Pharmacists")}} - {{__("Aleppo")}}</small></a>
                        <a href="https://www.facebook.com/HomsPharmacyAssociation" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Syndicate of Pharmacists")}} - {{__("Homs")}}</small></a>
                        <a href="https://www.facebook.com/sphlattakia/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Syndicate of Pharmacists")}} - {{__("Lattakia")}}</small></a>
                        <a href="https://www.facebook.com/sph.tartous/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Syndicate of Pharmacists")}} - {{__("Tartous")}}</small></a>
                        <a href="https://www.facebook.com/pharma.hama/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Syndicate of Pharmacists")}} - {{__("Hama")}}</small></a>
                        <a href="https://www.facebook.com/%D9%86%D9%82%D8%A7%D8%A8%D8%A9-%D8%A7%D9%84%D8%B5%D9%8A%D8%A7%D8%AF%D9%84%D8%A9-%D9%81%D9%8A-%D8%A7%D9%84%D8%B3%D9%88%D9%8A%D8%AF%D8%A7%D8%A1-1517051855196558/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Syndicate of Pharmacists")}} - {{__("Sweida")}}</small></a>
                        <a href="https://www.facebook.com/%D9%86%D9%82%D8%A7%D8%A8%D8%A9-%D8%A7%D9%84%D8%B5%D9%8A%D8%A7%D8%AF%D9%84%D9%87-%D9%81%D8%B1%D8%B9-%D8%AF%D8%B1%D8%B9%D8%A7-2281330465463220/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Syndicate of Pharmacists")}} - {{__("Daraa")}}</small></a>
                    </div>
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header bg-navyblue p-0 pt-2" id="headingThree">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed bg-transparent text-lightkiwi" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    {{__("Important Links")}}
                  </button>
                </h5>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body p-0">
                    <div class="list-group">
                        <a href="https://www.who.int/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("World Health Organization")}}</small></a>
                        <a href="https://www.drugs.com/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Drugs.com")}}</small></a>
                        <a href="https://www.fda.gov/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("Food & Drug Administration")}}</small></a>
                        <a href="https://www.nih.gov/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("National Institute of Health")}}</small></a>
                        <a href="https://www.nhs.uk/" target="_blank" class="list-group-item list-group-item-action p-0 p-1 pt-2"><small>{{__("National Health Service")}}</small></a>
                    </div>
                </div>
              </div>
            </div>
          </div>
    </div>
    {{-- <div class="col-md-2 bg-transparent text-lightkiwi h-100"><img src="..{{$ads->where('position',1)->first()->image_url}}" class="w-100 h-100"></div> --}}
    <div class="col-md-8 p-4">
        <div id="carouselE3lan" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                {{-- <div class="carousel-item active text-center p-4">
                     <p>lorem ipsum (imagine longer text)</p>
                </div> --}}
                @foreach ($ads as $ad)
                    <div class="carousel-item text-center p-4 @if ($loop->first) active @endif">
                        <p>{{$ad->text}}</p>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselE3lan" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselE3lan" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="container">
                    <div class="justify-content-center text-center">
                        <h2>موقع <b>صيدلي</b> زون</h2>
                        <br>
                        <h5>
                            <p class="">
                                    تطبيق لإدارة عمليات طلب الأدوية عبر الانترنت
                                    من قبل الصيدلي وإرسالها إلى الموزع ووكيل شركات الأدوية 
                                    بالإضافة إلى خدمات متنوعة تخدم الصيدلي في أعماله
                            </p>
                            <p>
                                    بإمكانكم الاشتراك في الموقع للحصول على كامل الميزات
                            </p>
                        </h5>
                        <br>
                        <a class="btn btn-outline-navyblue btn-lg mr-3" href="{{ route('register') }}" role="button" style="line-height: normal;">اشترك الآن</a>
                        {{-- <a class="btn btn-outline-navyblue btn-lg" href="#" role="button">تجربة الموقع</a> --}}
                    </div>
                </div>
            </div>
            
            {{-- <div class="col-md-4 py-4" id="mainNewsDiv">
            <h3><a href="{{ route('news') }}" class="btn btn-lg btn-outline-navyblue">{{__('News')}}</a></h3>
                <div id="mainNews" class="p-2">
                    @foreach ($posts as $post)
                <div class="card mb-3 NewsCard" onclick="window.location='/news/{{$post->id}}'">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                            <img src="{{ asset($post->author->logo_image) }}" class="card-img" style="padding: 10%;" alt="...">
                            </div>
                            <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{$post->author->f_name}}&nbsp;{{$post->author->s_name}}</h5>
                                <p class="card-text">{{$post->title}}</p>
                            <p class="card-text"><small class="text-muted">{{ __('Last updated') }} {{ $post->updated_at->diffForHumans() }}</small></p>
                            </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div> --}}
        </div>
    </div>
    <div class="col-md-2 h-100 d-none d-md-block">
        <div id="weather">
            <a class="weatherwidget-io" href="https://forecast7.com/ar/33d5136d28/damascus/" data-label_1="{{__("Damascus")}}" data-label_2="{{__("Weather")}}" data-icons="Climacons Animated" data-days="3" data-theme="original" data-basecolor="#000032" data-textcolor="#bce875" data-highcolor="#ffffff" data-lowcolor="#bce875" >{{__("Damascus")}} {{__("Weather")}}</a>
        </div>
    </div>
    {{-- <div class="col-md-2 bg-transparent text-lightkiwi h-100"><img src="..{{$ads->where('position',2)->first()->image_url}}" class="w-100 h-100"></div> --}}
    <div class="TickerNews default_theme_2 mt-4 d-none d-xl-block" id="T1">
        <div class="leftside">
            <a href="/news"><h4>{{__("News")}}</h4></a>
        </div>
        <div class="ti_wrapper">
            <div class="ti_slide">
                <div class="ti_content">
                    @foreach ($posts as $post)
                        <div class="ti_news"><a href="/news/{{$post->id}}"><span><b>{{$post->author->f_name}}&nbsp;{{$post->author->s_name}}&nbsp;-&nbsp;{{$post->title}}: </b></span> {{$post->content}} <img src="../images/SZlogo112.png" class="ml-2 newsimg"></a></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<link href="{{ asset('css/newsBar.css') }}" rel="stylesheet" />
<script src="{{ asset('js/jquery.newsBar.min.js') }}"></script>
<script type="text/javascript">
            $(function(){
                !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
	    		var timer = !1;
				_Ticker = $("#T1").newsTicker();
				_Ticker.on("mouseenter",function(){
					var __self = this;
					timer = setTimeout(function(){
						__self.pauseTicker();
					},200);
				});
				_Ticker.on("mouseleave",function(){
					clearTimeout(timer);
					if(!timer) return !1;
					this.startTicker();
                });
                $('.ti_wrapper').width($('#T1').width() - 120);
			});
</script>    
@endsection