<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Biolink System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-600 to-blue-600 min-h-screen flex items-center justify-center px-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Biolink Admin</h1>
            <p class="text-gray-600">Sign in to manage your biolinks</p>
        </div>
        
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ $errors->first() }}
        </div>
        @endif
        
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-blue-800 font-semibold mb-2">Test Credentials:</p>
            <div class="text-xs text-blue-700 space-y-1">
                <p><strong>Email:</strong> admin@biolink.com | <strong>Password:</strong> admin123</p>
                <p><strong>Email:</strong> manager@biolink.com | <strong>Password:</strong> manager123</p>
                <p><strong>Email:</strong> editor@biolink.com | <strong>Password:</strong> editor123</p>
            </div>
        </div>
        
        <form action="/admin/login" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500" 
                       placeholder="admin@biolink.com" required>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500" 
                       placeholder="Enter your password" required>
            </div>
            
            <button type="submit" 
                    class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold py-3 rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-300 shadow-lg">
                Sign In
            </button>
        </form>
        
        <div class="mt-6 text-center text-sm text-gray-600">
            <p>Multi-domain Biolink Management System</p>
        </div>
    </div>
</body>
</html>
