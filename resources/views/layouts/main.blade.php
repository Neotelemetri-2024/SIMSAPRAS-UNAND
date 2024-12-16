<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>SIMSAPRAS Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
   @include('partials.navbar')

    <!-- Sidebar -->
  <!-- Enhanced Sidebar -->
   @include('partials.sidebar')
   <div class="p-4 sm:ml-64 pt-20">
       @yield('content')
</div>

 <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleSidebarMobile = document.getElementById('toggleSidebarMobile');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const pageContent = document.querySelector('.p-4.sm\\:ml-64');
        const dropdownButton = document.querySelector('[data-collapse-toggle="dropdown-example"]');
        const dropdownContent = document.getElementById('dropdown-example');
        
        function closeDropdown() {
            if (dropdownContent) {
                dropdownContent.classList.add('hidden');
                const arrow = dropdownButton.querySelector('svg:last-child');
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        function toggleSidebarView() {
            const isCollapsed = sidebar.classList.contains('w-16');
            
            if (isCollapsed) {
                // Expand sidebar
                sidebar.classList.remove('w-16');
                sidebar.classList.add('w-64');
                
                // Show text with fade effect
                document.querySelectorAll('#sidebar span').forEach(el => {
                    el.classList.remove('opacity-0');
                    el.classList.remove('hidden');
                });
                
                // Adjust main content
                pageContent.classList.remove('sm:ml-16');
                pageContent.classList.add('sm:ml-64');
            } else {
                // Collapse sidebar
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-16');
                
                // Hide text with fade effect
                document.querySelectorAll('#sidebar span').forEach(el => {
                    el.classList.add('opacity-0');
                    setTimeout(() => el.classList.add('hidden'), 200);
                });
                
                // Close any open dropdowns
                closeDropdown();
                
                // Adjust main content
                pageContent.classList.remove('sm:ml-64');
                pageContent.classList.add('sm:ml-16');
            }
        }
        
        // Enhanced dropdown functionality
        if (dropdownButton) {
            dropdownButton.addEventListener('click', function() {
                const arrow = this.querySelector('svg:last-child');
                if (dropdownContent.classList.contains('hidden')) {
                    dropdownContent.classList.remove('hidden');
                    arrow.style.transform = 'rotate(180deg)';
                } else {
                    dropdownContent.classList.add('hidden');
                    arrow.style.transform = 'rotate(0deg)';
                }
            });
        }
        
        // Toggle for desktop
        toggleSidebarMobile.addEventListener('click', function(e) {
            e.preventDefault();
            toggleSidebarView();
        });
        
        // Toggle for mobile
        toggleSidebar.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('-translate-x-full');
        });
        
        // Enhanced window resize handler
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 640) {
                sidebar.classList.remove('-translate-x-full');
            }
        });
    });
    </script>
</body>
</html>