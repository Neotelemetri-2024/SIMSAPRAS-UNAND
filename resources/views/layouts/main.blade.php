<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>SIMSAPRAS Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

    <!-- Di bagian head layout -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@push('styles')
<style>
.fc-event {
    cursor: pointer;
}
.fc-toolbar-title {
    font-size: 1.2em !important;
}
.fc-header-toolbar {
    margin-bottom: 1em !important;
    font-size: 0.8em !important;
}
</style>
@endpush
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
<script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
<script src="/js/notif.js"></script>
 <script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleSidebarMobile = document.getElementById('toggleSidebarMobile');
    const toggleSidebar = document.getElementById('toggleSidebar');
    const pageContent = document.querySelector('.p-4.sm\\:ml-64');
    const dropdownButtons = document.querySelectorAll('[data-collapse-toggle]');
    
    function closeAllDropdowns() {
        document.querySelectorAll('[data-collapse-toggle]').forEach(button => {
            const targetId = button.getAttribute('data-collapse-toggle');
            const dropdownContent = document.getElementById(targetId);
            if (dropdownContent) {
                dropdownContent.classList.add('hidden');
                const arrow = button.querySelector('svg:last-child');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
        });
    }

    function handleDropdownClick(e) {
        // Prevent dropdown toggle when sidebar is collapsed
        if (sidebar.classList.contains('w-16')) {
            e.preventDefault();
            return;
        }

        const targetId = this.getAttribute('data-collapse-toggle');
        const dropdownContent = document.getElementById(targetId);
        const arrow = this.querySelector('svg:last-child');

        if (dropdownContent) {
            if (dropdownContent.classList.contains('hidden')) {
                dropdownContent.classList.remove('hidden');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            } else {
                dropdownContent.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
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

            // Re-enable dropdown buttons
            dropdownButtons.forEach(button => {
                button.style.pointerEvents = 'auto';
            });
        } else {
            // Collapse sidebar
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-16');

            // Hide text with fade effect
            document.querySelectorAll('#sidebar span').forEach(el => {
                el.classList.add('opacity-0');
                setTimeout(() => el.classList.add('hidden'), 200);
            });

            // Close all dropdowns
            closeAllDropdowns();

            // Adjust main content
            pageContent.classList.remove('sm:ml-64');
            pageContent.classList.add('sm:ml-16');

            // Disable dropdown buttons
            dropdownButtons.forEach(button => {
                button.style.pointerEvents = 'none';
            });
        }
    }

    // Add click event listeners to all dropdown buttons
    dropdownButtons.forEach(button => {
        button.addEventListener('click', handleDropdownClick);
    });

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>
