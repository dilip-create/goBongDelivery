<div>
     <!-- Vesitable Shop Start-->
        <div class="container-fluid vesitable">
            <div class="container py-3">
                <h1 class="mb-0 hidden">📌{{ __('message.Recommended shops') }}</h1>
                <div class="owl-carousel vegetable-carousel justify-content-center">

                    @if(!empty($shopLists))
                        @foreach($shopLists as $key => $row)
                            <div class="border border-primary rounded position-relative vesitable-item">
                                <div class="vesitable-img">
                                    <img src="{{ asset('storage/'.$row->stor_photo) ?? 'http://127.0.0.1:8000/website/assets/img/fruite-item-5.jpg' }}" class="promotion-img img-fluid w-100 rounded-top" alt="">
                                </div>
                                <div class="text-white bg-primary rounded position-absolute popular-promotion-trip" style="top: 10px; right: 10px;">Promotion</div>
                                <div class="p-4 rounded-bottom">
                                    <h4>{{!empty($row->translationValue->stor_name) ? ucwords($row->translationValue->stor_name) : ''}}</h4>
                                    <p>{{ $row->distance_from_office ? $row->distance_from_office . ' ' . __('message.km') : '' }}</p>
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <p class="text-dark fs-5 fw-bold mb-0">{{ $row->cuisine ? __('message.' . $row->cuisine) : '' }}</p>
                                        <p class="text-dark fs-5 fw-bold mb-0"><i class="fas fa-star text-warning"></i> 3.8</p>
                                        {{-- <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif 
                   
                   
                </div>
            </div>
        </div>
        <!-- Vesitable Shop End -->
</div>
