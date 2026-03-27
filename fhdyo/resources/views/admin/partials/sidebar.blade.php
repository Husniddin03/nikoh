<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0">
    <div class="flex items-center justify-center h-16 bg-gray-800">
        <h1 class="text-white text-xl font-bold">Admin Panel</h1>
    </div>
    
    <nav class="mt-8">
        <div class="px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200">
                <i class="fas fa-home mr-3"></i>
                Bosh sahifa
            </a>
            
            <a href="{{ route('admin.couples') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200">
                <i class="fas fa-heart mr-3"></i>
                Juftliklar
            </a>
            
            <a href="{{ route('admin.results') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200">
                <i class="fas fa-chart-bar mr-3"></i>
                Test natijalari
            </a>
            
            <a href="{{ route('admin.units.index') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200">
                <i class="fas fa-folder mr-3"></i>
                Unitlar
            </a>
            
            <a href="{{ route('admin.admins.index') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors duration-200">
                <i class="fas fa-user-shield mr-3"></i>
                Adminlar
            </a>
        </div>

        <div class="px-4 py-4 border-t border-gray-700 mt-8">
            <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center space-x-3 px-4 py-2 text-red-400 rounded-lg hover:bg-red-900 hover:text-white w-full transition-colors duration-200">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Chiqish</span>
                </button>
            </form>
        </div>
    </nav>
</aside>

<!-- Mobile menu button -->
<div class="lg:hidden fixed top-4 left-4 z-50">
    <button onclick="toggleSidebar()" class="bg-white p-2 rounded-lg shadow-lg">
        <i class="fas fa-bars text-gray-700"></i>
    </button>
</div>
