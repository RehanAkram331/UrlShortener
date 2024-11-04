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
                    Redirecting in <span id="countdown">5</span> seconds...              
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        let url = "{{ $url }}";
        let countdown = 5; // Starting countdown in seconds

        // Update countdown every second
        let interval = setInterval(function() {
            countdown--;
            $('#countdown').text(countdown); // Update countdown display

            if (countdown <= 0) {
                clearInterval(interval); // Stop the interval
                window.location.href = url; // Redirect to the URL
            }
        }, 1000); // 1000 milliseconds = 1 second
    });
</script>