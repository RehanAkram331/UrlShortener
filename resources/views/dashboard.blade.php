<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mt-4">
                        @csrf
                        <x-input-label for="url" :value="__('Url')" />
                        <x-text-input id="url" class="block mt-1 w-full"
                                    type="url"
                                    name="url"
                                    />
                    </div>
                    <div class="flex items-start justify-start mt-4" id="shortUrl">

                    </div>
                    <div class="flex items-center justify-center mt-4">
                        <x-primary-button type="button" class="ms-3 storeUrl">
                                        {{ __('Short') }}
                                    </x-primary-button>
                    </div>
                   
                                    
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                       <div id="Urldata"></div>      
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
    let host=window.location.origin;
$(document).ready(function() {
    showData();
    $('.storeUrl').click(function(){
        let url = $('#url').val();
        $.ajax({
            url:"{{ route('short-urls.store') }}",
            type: 'POST',
            dataType:'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{url:url},
            success:function(data, textStatus, jqXHR){
                if(data?.success){
                    const status = jqXHR.status;
                    if(status == 201){
                       $('#Urldata').append(`
                        <div class="mt-4 p-2 flex rounded-lg h-full dark:bg-gray-700 bg-teal-400 flex-col">
                           <div class="w-full text-wrap overflow-hidden ">
                                <x-input-label :value="__('Original Url:')" />
                                <x-text-input class="block mt-1 w-full"
                                    value="${data?.data?.original_url}"
                                    readonly
                                />
                            </div> 
                            <div class="w-full text-wrap overflow-hidden ">
                                <x-input-label :value="__('Short Url:')" />
                                <x-text-input class="block mt-1 w-full"
                                        value="${host}/${data?.data?.short_url}"
                                        readonly
                                    />
                                </div> 
                            <div>Number of Clicks: ${data?.data?.Number_of_clicks}</div>
                        </div>`); 
                    }
                    $('#shortUrl').html(`<a href="${host}/${data?.data?.short_url}" target="_blank">${host}/${data?.data?.short_url}</a>`);
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: data.message,
                        timer: 1500
                    });
                }
            }
        })
    })    
})
function showData() {
    $('#Urldata').empty();
    $.ajax({
        url:"{{ route('short-urls.index') }}",
        type: 'GET',
        dataType:'json',
        success:function(data){
           if(data?.data?.length > 0){
               let UrlData = data?.data?.map(x=>`
               <div class="mt-4 p-2 flex rounded-lg h-full dark:bg-gray-700 bg-teal-400 flex-col">
                   <div class="w-full text-wrap overflow-hidden ">
                        <x-input-label :value="__('Original Url:')" />
                        <x-text-input class="block mt-1 w-full"
                            value="${x?.original_url}"
                            readonly
                        />
                    </div> 
                   <div  class="w-full text-wrap overflow-hidden ">
                    <x-input-label :value="__('Short Url:')" />
                    <x-text-input class="block mt-1 w-full"
                            value="${host}/${x?.short_url}"
                            readonly
                        />
                    </div> 
                   <div>Number of Clicks: ${x?.Number_of_clicks}</div>
               </div>`);
               $('#Urldata').append(UrlData);
           }else{
            $('#Urldata').append('<div>No data found</div>');
           } 
        }
    })
}

</script>