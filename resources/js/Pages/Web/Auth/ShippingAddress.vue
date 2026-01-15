<script setup>
import { router } from '@inertiajs/vue3'
import { useForm, usePage } from '@inertiajs/vue3'
import TextInput from '../../Components/TextInput.vue'
import Textarea from '../../Components/Textarea.vue'


/** TAB LABEL change code START */
import { ref, computed } from 'vue'
const activeTab = ref('all')        // all | form
const isEditMode = ref(false)       // true when editing
const t = (key, fallback = key) => {
        return page.props.translations?.[key] ?? fallback
    }
const tabLabel = computed(() =>
    isEditMode.value ? t('Update Address') : t('Add Address')
)
/** TAB LABEL change code END */

const props = defineProps({
    addressLists: Array,
})
const page = usePage()

const form = useForm({
    id: null,
    address: '',
    landmark: '',
})

/** SUBMIT (CREATE + UPDATE) */
const submit = () => {
    form.post(route('shipping.address.save'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            isEditMode.value = false
            activeTab.value = 'all'
        },
    })
}


/** EDIT */
const editAddress = (record) => {
    isEditMode.value = true
    activeTab.value = 'form'

    form.id = record.id
    form.address = record.address
    form.landmark = record.landmark
}

/** Delete */
const deleteAddress = (id) => {
    
    router.delete(route('shipping.address.delete', id), {
        preserveScroll: true,
    })
}
</script>



<template>
    <Head :title="`- ${$page.props.translations['Shipping Address']}`" />
         
    <!-- Fruits Shop Start--><br/><br/>
        <div class="container-fluid fruite py-5">
            <div class="container py-5 bg-light">
                <div class="order-header d-flex align-items-center">
                    <!-- Back button -->
                    <Link :href="route('cart')"><button class="btn back-btn me-3"><i class="fas fa-arrow-left"></i></button></Link>
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
                                    <button class="nav-link border-white border-bottom-0" :class="{ active: activeTab === 'all' }" @click="activeTab = 'all'" type="button" role="tab"
                                        id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                        aria-controls="nav-about" aria-selected="true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $page.props.translations['All'] }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                    
                                        <button class="nav-link border-white border-bottom-0" :class="{ active: activeTab === 'form' }" @click="activeTab = 'form'; isEditMode = false; form.reset()" type="button" role="tab"
                                        id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                        aria-controls="nav-mission" aria-selected="false"> {{ tabLabel }}</button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div v-if="activeTab === 'all'" class="tab-pane" :class="{ active: activeTab === 'all' }" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    
                                    <div v-for="records in props.addressLists" :key="records.id" class="d-flex p-4 rounded mb-4 bg-white">
                                        <i class="fas fa-map-marker-alt fa-2x me-4" :class="records.status === 1 ? 'text-success' : 'text-danger'"></i>

                                        <div class="flex-grow-1">
                                            <h5>
                                                {{ records.address }}
                                                <span v-if="records.status === 1" class="badge bg-success ms-2">
                                                    Default
                                                </span>
                                            </h5>
                                            <small>{{ records.landmark }}</small>
                                        </div>

                                        <button @click="editAddress(records)" class="rounded-circle bg-light border"><i class="fa fa-edit text-danger"></i></button>
                                        <button @click="deleteAddress(records.id)" class="rounded-circle bg-light border"><i class="fa fa-times text-danger"></i></button>

                                    </div>


                                </div>
                                <div v-if="activeTab === 'form'" class="tab-pane" :class="{ active: activeTab === 'form' }" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                    
                                    <!-- Contact Start -->
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="h-100 rounded">
                                                <iframe class="rounded w-100" 
                                                style="height: 200px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387191.33750346623!2d-73.97968099999999!3d40.6974881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1694259649153!5m2!1sen!2sbd" 
                                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            
                                            <form @submit.prevent="submit">
                                                <TextInput v-model="form.address" :message="form.errors.address" :placeholder="$page.props.translations['Add Address']"/>

                                        
                                                <Textarea v-model="form.landmark" :message="form.errors.landmark" :rows="5" :cols="10" :placeholder="$page.props.translations['House number, group, building / village name, alley, road']" />


                                                <button class="w-100 btn border-secondary py-3 bg-white text-primary" :disabled="form.processing">{{ tabLabel }}
                                                    <i class="fa fa-arrow-right"></i>
                                                </button>
                                            </form>

                                        </div>
                                        <div class="col-lg-5">
                                            <div class="d-flex p-4 rounded mb-4 bg-white">
                                                <i class="fas fa-map-marker-alt fa-2x text-danger me-4"></i>
                                                <div>
                                                    <h4>{{ $page.props.translations['Address'] }}</h4>
                                                    <p class="mb-2">123 Street New York.USA</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Contact End -->
                                   
                                </div>
                                
                            </div>
                        </div>
                    </div>

                
                </div>      
            </div>
        </div>
        <!-- Fruits Shop End-->


        
 
      
</template>



