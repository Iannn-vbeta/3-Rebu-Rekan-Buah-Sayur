<x-guest-layout>


    <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
        <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
            <div class="mt-12 flex flex-col items-center">
                <h1 class="text-5xl xl:text-4xl font-medium text-green-800">
                    3-REBU
                </h1>
                @if (session('status'))
                    <div class="mb-4 text-green-600 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 text-sm text-red-600">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="w-full flex-1 mt-8">
                    <form class="mx-auto max-w-xs" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="relative mt-8">
                            <input type="text" name="username" id="username" placeholder=" "
                                class="block w-full appearance-none bg-transparent border-0 border-b-2 border-green-300 focus:border-green-600 focus:ring-0 text-lg px-0 py-2 transition-all duration-200 peer"
                                autocomplete="username" required />
                            <label for="username"
                                class="absolute left-0 top-2 text-green-700 text-base duration-200 transform -translate-y-6 scale-75 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 pointer-events-none">
                                <svg class="inline-block w-5 h-5 mr-1 text-green-600" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                                Username
                            </label>
                        </div>
                        <div class="relative mt-8">
                            <input type="password" name="password" id="password" placeholder=" "
                                class="block w-full appearance-none bg-transparent border-0 border-b-2 border-green-300 focus:border-green-600 focus:ring-0 text-lg px-0 py-2 transition-all duration-200 peer"
                                autocomplete="current-password" required />
                            <label for="password"
                                class="absolute left-0 top-2 text-green-700 text-base duration-200 transform -translate-y-6 scale-75 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 pointer-events-none">
                                <svg class="inline-block w-5 h-5 mr-1 text-green-600" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 17a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm6-2a6 6 0 1 1-12 0 6 6 0 0 1 12 0z" />
                                </svg>
                                Password
                            </label>
                        </div>
                        <div class="mt-10 flex flex-col gap-4">
                            <button type="submit"
                                class="w-full py-3 px-6 rounded-md bg-green-700 text-white font-semibold hover:bg-green-800 transition-colors">
                                Login
                            </button>
                            <a href="{{ route('register') }}"
                                class="w-full py-3 px-6 rounded-md border border-green-700 text-green-700 font-semibold bg-white hover:bg-green-50 transition-colors text-center">
                                Register
                            </a>
                            <div class="text-center">
                                <a href="{{ route('password.request') }}"
                                    class="text-green-700 hover:text-green-900 text-sm underline">
                                    Forgot your password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="flex-1 text-center hidden lg:flex">
            <div class="m-0 w-full h-full"
                style="background-image: url('{{ asset('img/55e1ff46a46dd858d17062d036fead24.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100%;">
            </div>
        </div>
    </div>
</x-guest-layout>
