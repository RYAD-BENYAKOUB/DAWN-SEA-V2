<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('meta_description', 'Dawn & Sea — Découvrez l\'Algérie authentique. Tourisme de luxe, guides locaux, expériences inoubliables.')">

        <title>@yield('title', config('app.name', 'Dawn & Sea')) — Tourisme de Luxe en Algérie</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body>
        <!-- Navbar -->
        <nav class="ds-navbar" id="main-navbar">
            <div class="ds-navbar-inner">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="ds-navbar-logo" id="navbar-logo">
                    Dawn <span>&</span> Sea
                </a>

                <!-- Navigation Links -->
                <ul class="ds-navbar-links" id="navbar-links">
                    <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">{{ __('Accueil') }}</a></li>
                    <li><a href="{{ url('/programs') }}" class="{{ request()->is('programs*') ? 'active' : '' }}">{{ __('Programmes') }}</a></li>
                    <li><a href="{{ url('/guides') }}" class="{{ request()->is('guides*') ? 'active' : '' }}">{{ __('Guides') }}</a></li>
                    <li><a href="#destinations" class="{{ request()->is('destinations*') ? 'active' : '' }}">{{ __('Destinations') }}</a></li>
                    <li><a href="#contact">{{ __('Contact') }}</a></li>
                </ul>

                <!-- Auth Actions -->
                <div class="ds-navbar-actions">
                    @auth
                        <a href="{{ url('/profile') }}" class="ds-btn ds-btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ Auth::user()->name }}
                        </a>
                        @if(Auth::user()->isGuide())
                            <a href="{{ url('/dashboard') }}" class="ds-btn ds-btn-primary ds-btn-sm">{{ __('Dashboard') }}</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="ds-btn ds-btn-ghost ds-btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="ds-btn ds-btn-ghost">{{ __('Connexion') }}</a>
                        <a href="{{ route('register') }}" class="ds-btn ds-btn-primary ds-btn-sm">{{ __('S\'inscrire') }}</a>
                    @endauth
                </div>

                <!-- Mobile Toggle -->
                <button class="ds-mobile-toggle" id="mobile-menu-btn" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden" style="padding: 1rem 0; border-top: 1px solid rgba(168,155,138,0.15);">
                <a href="{{ url('/') }}" style="display:block; padding:0.75rem 1.5rem; color:var(--charcoal-soft); font-size:0.9rem;">{{ __('Accueil') }}</a>
                <a href="{{ url('/programs') }}" style="display:block; padding:0.75rem 1.5rem; color:var(--charcoal-soft); font-size:0.9rem;">{{ __('Programmes') }}</a>
                <a href="{{ url('/guides') }}" style="display:block; padding:0.75rem 1.5rem; color:var(--charcoal-soft); font-size:0.9rem;">{{ __('Guides') }}</a>
                <a href="#destinations" style="display:block; padding:0.75rem 1.5rem; color:var(--charcoal-soft); font-size:0.9rem;">{{ __('Destinations') }}</a>
                @auth
                    <a href="{{ url('/profile') }}" style="display:block; padding:0.75rem 1.5rem; color:var(--gold); font-weight:600; font-size:0.9rem;">{{ Auth::user()->name }}</a>
                @else
                    <a href="{{ route('login') }}" style="display:block; padding:0.75rem 1.5rem; color:var(--gold); font-weight:600; font-size:0.9rem;">{{ __('Connexion') }}</a>
                @endauth
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
            @isset($slot)
                {{ $slot }}
            @endisset
        </main>

        <!-- Footer -->
        @hasSection('hide_footer')
        @else
            <footer class="ds-footer">
                <div class="ds-container">
                    <div class="ds-footer-grid">
                        <div>
                            <span class="ds-footer-logo">Dawn <span>&</span> Sea</span>
                            <p style="font-size:0.9rem; line-height:1.7; color:rgba(255,255,255,0.5); max-width:320px;">
                                {{ __('Explorez les trésors cachés de l\'Algérie avec des guides locaux passionnés. Une expérience de voyage authentique et luxueuse.') }}
                            </p>
                        </div>
                        <div>
                            <h4>{{ __('Explorer') }}</h4>
                            <ul>
                                <li><a href="{{ url('/programs') }}">{{ __('Programmes') }}</a></li>
                                <li><a href="#destinations">{{ __('Destinations') }}</a></li>
                                <li><a href="#guides">{{ __('Nos Guides') }}</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4>{{ __('Informations') }}</h4>
                            <ul>
                                <li><a href="#">{{ __('À Propos') }}</a></li>
                                <li><a href="#">{{ __('Conditions') }}</a></li>
                                <li><a href="#">{{ __('Confidentialité') }}</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4>{{ __('Contact') }}</h4>
                            <ul>
                                <li><a href="mailto:contact@dawnsea.dz">contact@dawnsea.dz</a></li>
                                <li><a href="tel:+213555000000">+213 555 000 000</a></li>
                                <li><a href="#">Alger, Algérie</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="ds-footer-bottom">
                        <p>&copy; {{ date('Y') }} Dawn & Sea. {{ __('Tous droits réservés.') }}</p>
                    </div>
                </div>
            </footer>
        @endif

        <!-- Navbar Scroll Effect -->
        <script>
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('main-navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>
