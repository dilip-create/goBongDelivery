<!-- Fruits Shop Start-->
        <div class="container-fluid fruite">
            <div class="container py-5">
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-4 text-start">
                            {{-- <h2>{{ __('message.Our Promotion') }}</h2> --}}
                            <h2>💯{{ __('message.great restaurants') }}</h2>
                        </div>
                        <div class="col-lg-8 text-end">
                            {{-- <ul class="nav nav-pills d-inline-flex text-center mb-5">
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                        <span class="text-dark" style="width: 130px;">All Products</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                        <span class="text-dark" style="width: 130px;">Vegetables</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                        <span class="text-dark" style="width: 130px;">Fruits</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-4">
                                        <span class="text-dark" style="width: 130px;">Bread</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-5">
                                        <span class="text-dark" style="width: 130px;">Meat</span>
                                    </a>
                                </li>
                            </ul> --}}
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 active">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">

                                        @if(!empty($shopLists))
                                            @foreach($shopLists as $key => $row)
                                                <div class="col-6 col-md-4 col-lg-2">
                                                    <div class="rounded position-relative fruite-item">
                                                        <div class="fruite-img">
                                                            <img src="{{ asset('storage/'.$row->stor_photo) ?? 'http://127.0.0.1:8000/website/assets/img/fruite-item-5.jpg' }}" class="promotion-img w-100 rounded-top" alt="">
                                                        </div>
                                                        <div class="text-white bg-secondary  rounded position-absolute promotion-trip" style="">Promotion</div>
                                                        <div class="p-2 border border-secondary border-top-0 rounded-bottom">
                                                           
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p class="text-dark  mb-0">{{ $row->distance_from_office ? $row->distance_from_office . ' ' . __('message.km') : '' }}</p>
                                                                <p class="text-dark  mb-0"><i class="fas fa-star text-warning"></i> 3.8</p>
                                                            </div>
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p><i class="fas fa-shipping-fast me-2 text-primary"></i>{{ $row->distance_from_office < 1 ? __('message.Free shipping') : '10 bhat'}}</p>
                                                                <p class="">{{ $row->cuisine ? __('message.' . $row->cuisine) : '' }}</p>
                                                            </div>
                                                            <p>{{ __('message.Opening hours') }}:
                                                                {{ $row->opentime ? \Carbon\Carbon::createFromFormat('H:i:s', $row->opentime)->format('h:i A') : '' }}
                                                                -
                                                                {{ $row->closetime ? \Carbon\Carbon::createFromFormat('H:i:s', $row->closetime)->format('h:i A') : '' }}
                                                            </p>


                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif 
                                        @if(!empty($shopLists))
                                            @foreach($shopLists as $key => $row)
                                                <div class="col-6 col-md-4 col-lg-2">
                                                    <div class="rounded position-relative fruite-item">
                                                        <div class="fruite-img">
                                                            <img src="{{ asset('storage/'.$row->stor_photo) ?? 'http://127.0.0.1:8000/website/assets/img/fruite-item-5.jpg' }}" class="promotion-img w-100 rounded-top" alt="">
                                                        </div>
                                                        <div class="text-white bg-secondary  rounded position-absolute promotion-trip" style="">Promotion</div>
                                                        <div class="p-2 border border-secondary border-top-0 rounded-bottom">
                                                           
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p class="text-dark  mb-0">{{ $row->distance_from_office ? $row->distance_from_office . ' ' . __('message.km') : '' }}</p>
                                                                <p class="text-dark  mb-0"><i class="fas fa-star text-warning"></i> 3.8</p>
                                                            </div>
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p><i class="fas fa-shipping-fast me-2 text-primary"></i>{{ $row->distance_from_office < 1 ? __('message.Free shipping') : '10 bhat'}}</p>
                                                                <p class="">{{ $row->cuisine ? __('message.' . $row->cuisine) : '' }}</p>
                                                            </div>
                                                            <p>{{ __('message.Opening hours') }}:
                                                                {{ $row->opentime ? \Carbon\Carbon::createFromFormat('H:i:s', $row->opentime)->format('h:i A') : '' }}
                                                                -
                                                                {{ $row->closetime ? \Carbon\Carbon::createFromFormat('H:i:s', $row->closetime)->format('h:i A') : '' }}
                                                            </p>


                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif 
                                        @if(!empty($shopLists))
                                            @foreach($shopLists as $key => $row)
                                                <div class="col-6 col-md-4 col-lg-2">
                                                    <div class="rounded position-relative fruite-item">
                                                        <div class="fruite-img">
                                                            <img src="{{ asset('storage/'.$row->stor_photo) ?? 'http://127.0.0.1:8000/website/assets/img/fruite-item-5.jpg' }}" class="promotion-img w-100 rounded-top" alt="">
                                                        </div>
                                                        <div class="text-white bg-secondary  rounded position-absolute promotion-trip" style="">Promotion</div>
                                                        <div class="p-2 border border-secondary border-top-0 rounded-bottom">
                                                           
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p class="text-dark  mb-0">{{ $row->distance_from_office ? $row->distance_from_office . ' ' . __('message.km') : '' }}</p>
                                                                <p class="text-dark  mb-0"><i class="fas fa-star text-warning"></i> 3.8</p>
                                                            </div>
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p><i class="fas fa-shipping-fast me-2 text-primary"></i>{{ $row->distance_from_office < 1 ? __('message.Free shipping') : '10 bhat'}}</p>
                                                                <p class="">{{ $row->cuisine ? __('message.' . $row->cuisine) : '' }}</p>
                                                            </div>
                                                            <p>{{ __('message.Opening hours') }}:
                                                                {{ $row->opentime ? \Carbon\Carbon::createFromFormat('H:i:s', $row->opentime)->format('h:i A') : '' }}
                                                                -
                                                                {{ $row->closetime ? \Carbon\Carbon::createFromFormat('H:i:s', $row->closetime)->format('h:i A') : '' }}
                                                            </p>


                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif 
                                        @if(!empty($shopLists))
                                            @foreach($shopLists as $key => $row)
                                                <div class="col-6 col-md-4 col-lg-2">
                                                    <div class="rounded position-relative fruite-item">
                                                        <div class="fruite-img">
                                                            <img src="{{ asset('storage/'.$row->stor_photo) ?? 'http://127.0.0.1:8000/website/assets/img/fruite-item-5.jpg' }}" class="promotion-img w-100 rounded-top" alt="">
                                                        </div>
                                                        <div class="text-white bg-secondary  rounded position-absolute promotion-trip" style="">Promotion</div>
                                                        <div class="p-2 border border-secondary border-top-0 rounded-bottom">
                                                           
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p class="text-dark  mb-0">{{ $row->distance_from_office ? $row->distance_from_office . ' ' . __('message.km') : '' }}</p>
                                                                <p class="text-dark  mb-0"><i class="fas fa-star text-warning"></i> 3.8</p>
                                                            </div>
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p><i class="fas fa-shipping-fast me-2 text-primary"></i>{{ $row->distance_from_office < 1 ? __('message.Free shipping') : '10 bhat'}}</p>
                                                                <p class="">{{ $row->cuisine ? __('message.' . $row->cuisine) : '' }}</p>
                                                            </div>
                                                            <p>{{ __('message.Opening hours') }}:
                                                                {{ $row->opentime ? \Carbon\Carbon::createFromFormat('H:i:s', $row->opentime)->format('h:i A') : '' }}
                                                                -
                                                                {{ $row->closetime ? \Carbon\Carbon::createFromFormat('H:i:s', $row->closetime)->format('h:i A') : '' }}
                                                            </p>


                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif 
                                       


                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
        <!-- Fruits Shop End-->