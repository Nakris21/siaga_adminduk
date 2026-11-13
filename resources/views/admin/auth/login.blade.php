
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-12">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-gray-200 p-8">

        <div class="text-center mb-8">
            <div class="mx-auto w-14 h-14 rounded-xl bg-blue-700 text-white flex items-center justify-center text-xl font-bold">
                SA
            </div>

            <h1 class="mt-4 text-2xl font-bold text-gray-900">
                Login Admin
            </h1>

            <p class="mt-2 text-sm text-gray-500">
                SIAGA Adminduk Kabupaten Brebes
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-green-100 outline-none"
                    placeholder="Masukkan email admin"
                >
            </div>

            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    autocomplete="current-password"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-blue-600 focus:ring-2 focus:ring-green-100 outline-none"
                    placeholder="Masukkan password"
                >
            </div>

            <div class="flex items-center mb-6">
                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                    value="1"
                    class="rounded border-gray-300 text-green-700 focus:ring-green-600"
                >

                <label for="remember" class="ml-2 text-sm text-gray-600">
                    Ingat saya
                </label>
            </div>

            <button
                type="submit"
                class="w-full rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 transition"
            >
                Masuk
            </button>
        </form>

        <p class="mt-8 text-center text-xs text-gray-400">
            SIAGA Adminduk &copy; {{ date('Y') }}<br>
            Dinas Kependudukan dan Pencatatan Sipil Kabupaten Brebes
        </p>

    </div>
</div>
@endsection
