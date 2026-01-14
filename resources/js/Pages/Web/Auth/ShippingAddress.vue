<script setup>
    import { router, usePage  } from '@inertiajs/vue3'
    const page = usePage()
    const t = (key, fallback = key) => {
        return page.props.translations?.[key] ?? fallback
    }

    const props = defineProps({
    storData: Array,
    foodLists: Array,
    summary: Array,
   
    })
   


    // Onclick Delete Item code START
        // import Swal from 'sweetalert2';
        // const deleteInCartFun = async (cartId) => {
        
        //     Swal.fire({
        //         title: t('Are you sure?'),
        //         text: t('This item will be deleted'),
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#dc3545',
        //         cancelButtonColor: '#6c757d',
        //         confirmButtonText: t('Yes, delete it')
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             axios.delete(`/cart/${cartId}`)
        //                 .then(() => {
        //                     Swal.fire(
        //                         t('Deleted!'),
        //                         t('Item deleted'),
        //                         'success'
        //                     )
        //                     // refresh the page without reload reload whole page
        //                     router.reload();
                            
        //                 })
        //         }
        //     })
        // }
    // Onclick Delete Item code START


    // const capitalizeFirst = (text) => {
    // if (!text) return ''
    //     return text.charAt(0).toUpperCase() + text.slice(1)
    // }
    // function base64Encode(value) {
    //     return window.btoa(String(value));
    // }
</script>

<template>
    <Head :title="`- ${$page.props.translations['Shipping Address']}`" />
         
    <!-- Fruits Shop Start--><br/><br/>
        <div class="container-fluid fruite py-5">
            <div class="container py-5 bg-light">
                <div class="order-header d-flex align-items-center">
                    <!-- Back button -->
                        <Link :href="route('/')"><button class="btn back-btn me-3"><i class="fas fa-arrow-left"></i></button></Link>
                    <div class="text-center flex-grow-1">
                        <h5 class="mb-0 text-white fw-semibold">
                             {{ $page.props.translations['Address'] }}
                        </h5>
                       
                    </div>
                </div><br/>
                <div class="tab-class text-center">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                        id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="true">{{ $page.props.translations['All'] }}</button>
                                    <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                        id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                        aria-controls="nav-mission" aria-selected="false">{{ $page.props.translations['Add Address'] }}</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    <p>The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic words etc. 
                                        Susp endisse ultricies nisi vel quam suscipit </p>
                                    <p>Sabertooth peacock flounder; chain pickerel hatchetfish, pencilfish snailfish filefish Antarctic 
                                        icefish goldeye aholehole trumpetfish pilot fish airbreathing catfish, electric ray sweeper.</p>
                                    <div class="px-2">
                                        <div class="row g-4">
                                            <div class="col-6">
                                                <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Weight</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">1 kg</p>
                                                    </div>
                                                </div>
                                                <div class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Country of Origin</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">Agro Farm</p>
                                                    </div>
                                                </div>
                                                <div class="row bg-light text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Quality</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">Organic</p>
                                                    </div>
                                                </div>
                                                <div class="row text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Сheck</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">Healthy</p>
                                                    </div>
                                                </div>
                                                <div class="row bg-light text-center align-items-center justify-content-center py-2">
                                                    <div class="col-6">
                                                        <p class="mb-0">Min Weight</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="mb-0">250 Kg</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                    <div class="d-flex">
                                      
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Jason Smith</h5>
                                                <div class="d-flex mb-3">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p>The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic 
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        
                                        <div class="">
                                            <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                            <div class="d-flex justify-content-between">
                                                <h5>Sam Peters</h5>
                                                <div class="d-flex mb-3">
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star text-secondary"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <p class="text-dark">The generated Lorem Ipsum is therefore always free from repetition injected humour, or non-characteristic 
                                                words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="nav-vision" role="tabpanel">
                                    <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor sit. Aliqu diam
                                        amet diam et eos labore. 3</p>
                                    <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos labore.
                                        Clita erat ipsum et lorem et sit</p>
                                </div>
                            </div>
                        </div>
                    </div>

                
                </div>      
            </div>
        </div>
        <!-- Fruits Shop End-->


        
 
      
</template>



