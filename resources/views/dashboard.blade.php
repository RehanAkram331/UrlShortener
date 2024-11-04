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
                        <div class="flex mb-3">
                            <lable class="dark:bg-gray-700 bg-teal-400  
                                border border-gray-300 px-4 py-2 
                                rounded-l-md bg-white
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 
                                focus:border-indigo-500"  for="url">
                                Url
                            </lable>
                            <input type="text" 
                                class="form-input border  
                                px-3 py-2 
                                border-gray-300 dark:border-gray-700 
                                dark:bg-gray-900 dark:text-gray-300 
                                focus:border-indigo-500 dark:focus:border-indigo-600 
                                focus:ring-indigo-500 dark:focus:ring-indigo-600 
                                rounded-md shadow-sm block w-full" 
                                id="url"
                                type="url"
                                name="url">
                            <button class="storeUrl btn 
                                bg-[#2c87c5]
                                border border-gray-300 px-3 py-2 
                                rounded-r-md
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 
                                focus:border-indigo-500" 
                                type="button">
                                Short
                            </button>
                        </div> 
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
                                    <div class="flex mb-3">
                                        <lable class="dark:bg-gray-700 bg-teal-400  
                                            border border-gray-300 px-4 py-2 
                                            rounded-l-md bg-white
                                            focus:outline-none focus:ring-2 focus:ring-indigo-500 
                                            focus:border-indigo-500" >
                                            OriginalUrl:
                                        </lable>
                                        <input type="text" 
                                            class="originalUrl form-input border  
                                            px-3 py-2 
                                            border-gray-300 dark:border-gray-700 
                                            dark:bg-gray-900 dark:text-gray-300 
                                            focus:border-indigo-500 dark:focus:border-indigo-600 
                                            focus:ring-indigo-500 dark:focus:ring-indigo-600 
                                            rounded-md shadow-sm block w-full" 
                                            value="${data?.data?.original_url}"
                                            readonly>
                                        <button class="originalUrlCopy btn 
                                            bg-[#2c87c5]
                                            border border-gray-300 px-3 py-2 
                                            rounded-r-md
                                            focus:outline-none focus:ring-2 focus:ring-indigo-500 
                                            focus:border-indigo-500" 
                                            type="button">
                                            Copy
                                        </button>
                                    </div> 
                                    <div class="flex mb-3">
                                        <lable class="dark:bg-gray-700 bg-teal-400  
                                            border border-gray-300 px-4 py-2 
                                            rounded-l-md bg-white
                                            focus:outline-none focus:ring-2 focus:ring-indigo-500 
                                            focus:border-indigo-500" >
                                            ShortUrl:
                                        </lable>
                                        <input type="text" 
                                            class="shortUrl form-input border  
                                            px-3 py-2 
                                            border-gray-300 dark:border-gray-700 
                                            dark:bg-gray-900 dark:text-gray-300 
                                            focus:border-indigo-500 dark:focus:border-indigo-600 
                                            focus:ring-indigo-500 dark:focus:ring-indigo-600 
                                            rounded-md shadow-sm block w-full" 
                                            value="${host}/${data?.data?.short_url}"
                                            readonly>
                                        <button class="shortUrlCopy btn 
                                            bg-[#2c87c5]
                                            border border-gray-300 px-3 py-2 
                                            rounded-r-md
                                            focus:outline-none focus:ring-2 focus:ring-indigo-500 
                                            focus:border-indigo-500" 
                                            type="button">
                                            Copy
                                        </button>
                                    </div>  
                                    <div class="text-center">Number of Clicks: ${data?.data?.Number_of_clicks}</div>
                            </div>                        
                        `); 
                    }
                    $('#shortUrl').html(`<lable class="dark:bg-gray-700 bg-teal-400  
                                            border border-gray-300 px-4 py-2 
                                            rounded-l-md bg-white
                                            focus:outline-none focus:ring-2 focus:ring-indigo-500 
                                            focus:border-indigo-500" >
                                            ShortUrl:
                                        </lable>
                                        <input type="text" 
                                            class="form-input border  
                                            px-3 py-2 
                                            border-gray-300 dark:border-gray-700 
                                            dark:bg-gray-900 dark:text-gray-300 
                                            focus:border-indigo-500 dark:focus:border-indigo-600 
                                            focus:ring-indigo-500 dark:focus:ring-indigo-600 
                                            rounded-md shadow-sm block w-full" 
                                            value="${host}/${data?.data?.short_url}"
                                            readonly>
                                        <button class="shortUrlCopy btn 
                                            bg-[#2c87c5]
                                            border border-gray-300 px-3 py-2 
                                            rounded-r-md
                                            focus:outline-none focus:ring-2 focus:ring-indigo-500 
                                            focus:border-indigo-500" 
                                            type="button">
                                            Copy
                                        </button>`);
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
    
    $('#Urldata').on('click', '.originalUrlCopy', function() {
        let originalUrl = $(this).closest('div').find('.originalUrl').val();
        if (originalUrl) {
            navigator.clipboard.writeText(originalUrl).then(function() {
                alert("Original URL copied to clipboard!");
            }).catch(function(error) {
                console.error("Failed to copy text: ", error);
            });
        }
    });

    $('#Urldata').on('click', '.shortUrlCopy', function() {
        let shortUrl = $(this).closest('div').find('.shortUrl').val();
        if (shortUrl) {
            navigator.clipboard.writeText(shortUrl).then(function() {
                alert("Short URL copied to clipboard!");
            }).catch(function(error) {
                console.error("Failed to copy text: ", error);
            });
        }
    });
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
                    <div class="flex mb-3">
                        <lable class="dark:bg-gray-700 bg-teal-400  
                            border border-gray-300 px-4 py-2 
                            rounded-l-md bg-white
                            focus:outline-none focus:ring-2 focus:ring-indigo-500 
                            focus:border-indigo-500" >
                            OriginalUrl:
                        </lable>
                        <input type="text" 
                            class="form-input border  
                            px-3 py-2 
                            border-gray-300 dark:border-gray-700 
                            dark:bg-gray-900 dark:text-gray-300 
                            focus:border-indigo-500 dark:focus:border-indigo-600 
                            focus:ring-indigo-500 dark:focus:ring-indigo-600 
                            rounded-md shadow-sm block w-full" 
                            value="${x?.original_url}"
                            readonly>
                        <button class="originalUrlCopy btn 
                            bg-[#2c87c5]
                            border border-gray-300 px-3 py-2 
                            rounded-r-md
                            focus:outline-none focus:ring-2 focus:ring-indigo-500 
                            focus:border-indigo-500" 
                            type="button">
                            Copy
                        </button>
                    </div> 
                    <div class="flex mb-3">
                        <lable class="dark:bg-gray-700 bg-teal-400  
                            border border-gray-300 px-4 py-2 
                            rounded-l-md bg-white
                            focus:outline-none focus:ring-2 focus:ring-indigo-500 
                            focus:border-indigo-500" >
                            ShortUrl:
                        </lable>
                        <input type="text" 
                            class="form-input border  
                            px-3 py-2 
                            border-gray-300 dark:border-gray-700 
                            dark:bg-gray-900 dark:text-gray-300 
                            focus:border-indigo-500 dark:focus:border-indigo-600 
                            focus:ring-indigo-500 dark:focus:ring-indigo-600 
                            rounded-md shadow-sm block w-full" 
                            value="${host}/${x?.short_url}"
                            readonly>
                        <button class="shortUrlCopy btn 
                            bg-[#2c87c5]
                            border border-gray-300 px-3 py-2 
                            rounded-r-md
                            focus:outline-none focus:ring-2 focus:ring-indigo-500 
                            focus:border-indigo-500" 
                            type="button">
                            Copy
                        </button>
                    </div>  
                    <div class="text-center">Number of Clicks: ${x?.Number_of_clicks}</div>
               </div>`);
               $('#Urldata').append(UrlData);
           }else{
            $('#Urldata').append('<div>No data found</div>');
           } 
        }
    })
}

</script>