<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>SIMSAPRAS - UNAND</title>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
      @vite(['resources/css/app.css','resources/js/app.js'])
   </head>
   <body>
      <!-- Navigation Bar -->
       @include('partials.navbar-user')

      @yield('content')

      <!-- Footer -->
       @include('partials.footer-user')

      <!-- Back to top button -->
      <button type="button" data-te-ripple-init data-te-ripple-color="light" id="btn-back-to-top" class="fixed hidden bottom-5 right-5 p-3 bg-green-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-green-700 hover:shadow-lg focus:bg-green-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-800 active:shadow-lg transition duration-150 ease-in-out">
         <svg aria-hidden="true" focusable="false" data-prefix="fas" class="w-4 h-4" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path fill="currentColor" d="M34.9 289.5l-22.2-22.2c-9.4-9.4-9.4-24.6 0-33.9L207 39c9.4-9.4 24.6-9.4 33.9 0l194.3 194.3c9.4 9.4 9.4 24.6 0 33.9L413 289.4c-9.5 9.5-25 9.3-34.3-.4L264 168.6V456c0 13.3-10.7 24-24 24h-32c-13.3 0-24-10.7-24-24V168.6L69.2 289.1c-9.3 9.8-24.8 10-34.3.4z"></path>
         </svg>
      </button>
      <!-- Initialize back to top button -->
      <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
      <script src="/js/notif.js"></script>
      @stack('scripts')
      <script>
         // Get the button
         const mybutton = document.getElementById("btn-back-to-top");
         
         // When the user scrolls down 20px from the top of the document, show the button
         window.onscroll = function () {
             scrollFunction();
         };
         
         function scrollFunction() {
             if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                 mybutton.classList.remove("hidden");
             } else {
                 mybutton.classList.add("hidden");
             }
         }
         
         // When the user clicks on the button, scroll to the top of the document
         mybutton.addEventListener("click", backToTop);
         
         function backToTop() {
             document.body.scrollTop = 0;
             document.documentElement.scrollTop = 0;
         }

      </script>
      <div id="notification-container" class="fixed bottom-5 right-5 z-50"></div>
   </body>
</html>