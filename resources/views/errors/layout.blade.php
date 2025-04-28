<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - SIMSAPRAS UNAND</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <style>
        :root {
            --primary: #16a34a;
            --primary-dark: #15803d;
            --text-dark: #111827;
            --text-medium: #4b5563;
            --text-light: #9ca3af;
            --bg-light: #f9fafb;
            --white: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
        }
        
        .container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        
        /* Background Pattern */
        .bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.03;
            background-image: linear-gradient(#16a34a 1px, transparent 1px), linear-gradient(to right, #16a34a 1px, transparent 1px);
            background-size: 20px 20px;
            z-index: -1;
        }
        
        .error-card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 3rem;
            width: 90%;
            max-width: 650px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .accent-border {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), #34d399);
        }
        
        .error-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 1.5rem;
            background-color: rgba(22, 163, 74, 0.1);
            border-radius: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-icon i {
            font-size: 3.5rem;
            color: var(--primary);
        }
        
        .error-code {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }
        
        .error-message {
            font-size: 1rem;
            color: var(--text-medium);
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(22, 163, 74, 0.2);
        }
        
        .btn-outline {
            border: 1px solid var(--text-light);
            color: var(--text-medium);
        }
        
        .btn-outline:hover {
            border-color: var(--text-medium);
            color: var(--text-dark);
            transform: translateY(-2px);
        }
        
        /* Animated elements */
        .shape {
            position: absolute;
            z-index: -1;
            opacity: 0.1;
        }
        
        .shape-1 {
            width: 100px;
            height: 100px;
            border-radius: 20px;
            background-color: var(--primary);
            top: -30px;
            right: -30px;
            transform: rotate(20deg);
        }
        
        .shape-2 {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 15px solid var(--primary);
            bottom: -30px;
            left: -20px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .error-card {
                padding: 2rem;
            }
            
            .error-icon {
                width: 90px;
                height: 90px;
            }
            
            .error-icon i {
                font-size: 2.5rem;
            }
            
            .error-code {
                font-size: 2rem;
            }
            
            .error-title {
                font-size: 1.25rem;
            }
            
            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="bg-pattern"></div>
        <div class="error-card">
            <div class="accent-border"></div>
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            
            <div class="error-icon">
                <!-- Dynamic icon based on error type -->
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            
            <div class="error-code">@yield('code')</div>
            <div class="error-title">@yield('title')</div>
            <div class="error-message">@yield('message')</div>
            
            <div class="buttons">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
                <a href="#" onclick="history.back(); return false;" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Halaman Sebelumnya
                </a>
            </div>
        </div>
    </div>
    
    <script>
        // Logic to display different icons based on error code
        document.addEventListener('DOMContentLoaded', function() {
            const errorCode = document.querySelector('.error-code').textContent.trim();
            const iconElement = document.querySelector('.error-icon i');
            
            switch(errorCode) {
                case '404':
                    iconElement.className = 'fas fa-search';
                    break;
                case '500':
                    iconElement.className = 'fas fa-server';
                    break;
                case '403':
                    iconElement.className = 'fas fa-lock';
                    break;
                case '401':
                    iconElement.className = 'fas fa-user-lock';
                    break;
                case '503':
                    iconElement.className = 'fas fa-tools';
                    break;
                default:
                    iconElement.className = 'fas fa-exclamation-triangle';
            }
        });
    </script>
</body>
</html>