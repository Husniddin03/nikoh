@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <div class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-red-100">
                <svg class="h-12 w-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">404 - Sahifa topilmadi</h2>
            <p class="mt-2 text-sm text-gray-600">
                Siz so'ragan sahifa mavjud emas yoki ko'chirib olingan.
            </p>
        </div>
        
        <div class="mt-8 space-y-4">
            <p class="text-gray-500">
                Siz izlayotgan sahifa o'chirilgan, nomi o'zgartirilgan yoki vaqtincha mavjud bo'lmasligi mumkin.
            </p>
            
            <div class="flex flex-col space-y-3">
                <a href="{{ route('user.entry') }}" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Bosh sahifaga qaytish
                </a>
                
                @if(auth()->guard('admin')->check())
                    <a href="{{ route('admin.dashboard') }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Admin panelga o'tish
                    </a>
                @endif
            </div>
        </div>
        
        <div class="mt-6">
            <p class="text-xs text-gray-400">
                Xatolik kodi: 404 | Vaqt: {{ now()->format('d.m.Y H:i') }}
            </p>
        </div>
    </div>
</div>
@endsection
