<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Home - AutoCorrect API</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

  
  @include('layouts.navbar')

  <main class="flex-grow container mx-auto px-4 py-12">
    <section class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
      <h2 class="text-xl font-semibold mb-4 text-gray-800">Check Your Text</h2>
      <p class="text-gray-600 mb-6">Paste your text below to check for corrections.</p>

      
      <form
        id="spellcheck-form"
        action="{{ route('spellcheck.check') }}"
        method="POST"
        class="flex flex-col"
      >
        @csrf
        <textarea
          name="text"
          rows="6"
          class="w-full p-4 border border-gray-300 rounded-md resize-none focus:outline-none focus:ring-2 focus:ring-blue-400"
          placeholder="Type or paste your text here..."
        ></textarea>

        <button
          type="submit"
          class="mt-4 self-end bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition"
        >
          Check Text
        </button>
      </form>

      
      <aside
        id="results"
        class="hidden bg-gray-50 p-4 rounded-lg mt-8"
      >
        <h3 class="font-semibold mb-2">Corrected Text</h3>
        <pre class="whitespace-pre-wrap text-gray-800"></pre>

        <h4 class="font-semibold mt-4 mb-2">Issues Found</h4>
        <ul class="space-y-2 text-sm text-red-600"></ul>
      </aside>
    </section>
  </main>

  <footer class="text-center text-gray-500 py-6 text-sm">
    &copy; 2025 AutoCorrect API. All rights reserved.
  </footer>

  
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const form   = document.getElementById('spellcheck-form');
      const panel  = document.getElementById('results');
      const output = panel.querySelector('pre');
      const list   = panel.querySelector('ul');

      form.addEventListener('submit', async e => {
        e.preventDefault();
        const text = form.text.value.trim();
        if (!text) return;

        panel.classList.remove('hidden');
        output.textContent = 'Checking…';
        list.innerHTML     = '';

        try {
          const res = await fetch(form.action, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
              'Accept': 'application/json'
            },
            body: JSON.stringify({ text })
          });

          const data = await res.json();
          if (res.ok) {
            output.textContent = data.corrected;
            data.errors.forEach(err => {
              const li = document.createElement('li');
              li.textContent = `${err.type}: ${err.message} → [${err.suggestions.join(', ')}]`;
              list.appendChild(li);
            });
          } else {
            output.textContent = data.error || 'Server error';
          }
        } catch (error) {
          console.error('Fetch error:', error);
          output.textContent = 'Request failed.';
        }
      });
    });
  </script>
</body>
</html>
