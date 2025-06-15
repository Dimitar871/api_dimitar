<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact - AutoCorrect API</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    @include('layouts.navbar')

    <main class="flex-grow container mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Contact Information</h2>
            <p class="text-gray-700 mb-4">
                If you have any questions, suggestions, or need support regarding the AutoCorrect API, feel free to reach out.
            </p>

            <div class="space-y-2">
                <p><span class="font-semibold text-gray-800">Name:</span> Dimitar Aleksadrov Yosifov</p>
                <p><span class="font-semibold text-gray-800">Email:</span> <a href="mailto:yosi0001@hz.nl" class="text-blue-600 hover:underline">yosi0001@hz.nl</a></p>
            </div>
        </div>
    </main>

    <footer class="text-center text-gray-500 py-6 text-sm">
        &copy; 2025 AutoCorrect API. All rights reserved.
    </footer>
</body>
</html>
