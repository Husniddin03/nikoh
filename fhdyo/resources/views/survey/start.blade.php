@extends('layouts.app')

@section('title', 'Nikohga Sorovnoma - Boshlanish')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Nikohga Sorovnoma
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Iltimos, o'zingiz va juftingizning JSHSHIR raqamlarini kiriting
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('survey.start') }}" method="POST">
            @csrf
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label for="jshshir" class="block text-sm font-medium text-gray-700">
                        Sizning JSHSHIR raqamingiz
                    </label>
                    <input id="jshshir" name="jshshir" type="text" required
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="14 xonali raqam" maxlength="14">
                </div>

                <div>
                    <label for="partner_jshshir" class="block text-sm font-medium text-gray-700">
                        Juftingizning JSHSHIR raqami
                    </label>
                    <input id="partner_jshshir" name="partner_jshshir" type="text" required
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                           placeholder="14 xonali raqam" maxlength="14">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Testni boshlash
                </button>
            </div>
            
        </form>
    </div>
</div>

<script>
document.getElementById('jshshir').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});

document.getElementById('partner_jshshir').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
@endsection
