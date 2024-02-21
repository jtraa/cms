
@extends ('components.app')


        @section('content')
        <div class="relative xl:block items-top justify-center min-h-screen bg-whitesmoke dark:bg-gray-900 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <!-- /// START NAVIGATION \\\ -->
			<section class="navigation w-full bg-darkseagreen">
				<div class="px-3 w-full">
					<div class="md:flex justify-around items-center w-full">
						<div class="flex-1 flex justify-between w-full" data-aos="zoom-in"  data-aos-duration="1000" data-aos-delay="500">
					        <a href="/" id="logo" class="flex items-center hover:no-underline">
					         	<img src="images/bob-looking.png" class="w-14" alt="LocalBob | Back-end server">
					         	<span class="mx-3 font-bold no-underline text-white">LocalBob</span>
					        </a>
					        <div class="md:hidden" id="hamburger">
								<div id="nav-icon4" class="m-3">
									<span></span>
									<span></span>
									<span></span>
								</div>
							</div>
						</div>

						<div class="md:flex-1 w-full block md:flex items-center justify-center">
							<div class="navbar w-3/4 navbar-expand-xl p-0 m-0">
								<nav class="w-full" id="nav">
									<ul class="p-0 m-0 md:flex items-center justify-between disappear">
										<li class="mr-2"><a class="text-white font-bold" href="">Home</a></li>
										<li class="mr-2"><a class="text-white" href="">Images</a></li>
										<li class="mr-2"><a class="text-white" href="">Documents</a></li>
										<li class="mr-2"><a class="text-white" href="">Pages</a></li>
										<li class=""><a class="text-white" href="">Issues</a></li>
									</ul>
								</nav>
							</div>
						</div>
						<div class="w-full hidden flex-1 md:flex items-center justify-end" data-aos="zoom-in"  data-aos-duration="1000" data-aos-delay="500">
							<button class="border-white font-bold border-2 py-2 px-3 rounded-sm hover:bg-white text-white hover:text-darkgreen transition" style="" type="button">Bobba</button>
						</div>
					</div>
				</div>
			</section>
            <!-- /// END NAVIGATION \\\ -->

            <!-- /// INTRO ALINEA \\\ -->
            <section class="py-12 md:py-48 bg-white" data-aos="fade-up" data-aos-duration="1000">
	            <div class="container">
					<div id="app">
					   <example-component></example-component>
					</div>
				</div>
			</section>
			<!-- /// INTRO ALINEA \\\ -->

		  @endsection

