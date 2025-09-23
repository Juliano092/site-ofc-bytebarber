<!-- Theme Toggle Component -->
<div class="relative inline-block">
    <button onclick="toggleTheme()"
        class="group inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl dark:text-yellow-400 text-slate-700 dark:bg-gradient-to-r dark:from-gray-800 dark:to-slate-800 bg-gradient-to-r from-slate-50 to-gray-100 hover:dark:text-yellow-300 hover:text-slate-800 dark:hover:from-gray-700 dark:hover:to-slate-700 hover:from-slate-100 hover:to-gray-200 focus:outline-none transition-all ease-in-out duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 border-2 dark:border-yellow-400/30 border-teal-600/30 hover:dark:border-yellow-400 hover:border-emerald-500"
        title="Alternar tema">

        <!-- Sun Icon (Light Mode) -->
        <div class="dark:hidden flex items-center">
            <i
                class="fas fa-sun text-amber-600 text-lg mr-2 group-hover:rotate-180 transition-transform duration-500"></i>
            <span class="hidden sm:inline font-semibold">Light</span>
        </div>

        <!-- Moon Icon (Dark Mode) -->
        <div class="hidden dark:flex items-center">
            <i
                class="fas fa-moon text-yellow-400 text-lg mr-2 group-hover:scale-110 transition-transform duration-300"></i>
            <span class="hidden sm:inline font-semibold">Dark</span>
        </div>

        <!-- Mobile Only Icons -->
        <div class="sm:hidden">
            <i
                class="fas fa-sun dark:hidden text-amber-600 group-hover:rotate-180 transition-transform duration-500"></i>
            <i
                class="fas fa-moon hidden dark:inline text-yellow-400 group-hover:scale-110 transition-transform duration-300"></i>
        </div>
    </button>

    <!-- Tooltip -->
    <div
        class="absolute invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-300 bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-1 text-xs font-medium text-white dark:bg-gray-800 bg-gray-700 rounded-lg shadow-lg whitespace-nowrap">
        <span class="dark:hidden">Mudar para modo escuro</span>
        <span class="hidden dark:inline">Mudar para modo claro</span>
        <div
            class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent dark:border-t-gray-800 border-t-gray-700">
        </div>
    </div>
</div>

<script>
    // Enhanced theme toggle function
    function toggleTheme() {
        const html = document.documentElement;
        const isDark = html.classList.contains('dark');

        // Add transition effect
        html.style.transition = 'all 0.3s ease-in-out';

        if (isDark) {
            html.classList.remove('dark');
            html.classList.add('light');
            localStorage.theme = 'light';

            // Show light mode toast
            showThemeToast('☀️ Modo Claro Ativado');
        } else {
            html.classList.remove('light');
            html.classList.add('dark');
            localStorage.theme = 'dark';

            // Show dark mode toast
            showThemeToast('🌙 Modo Escuro Ativado');
        }

        // Remove transition after animation
        setTimeout(() => {
            html.style.transition = '';
        }, 300);
    }

    // Toast notification function
    function showThemeToast(message) {
        // Remove existing toast if any
        const existingToast = document.getElementById('theme-toast');
        if (existingToast) {
            existingToast.remove();
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.id = 'theme-toast';
        toast.className = 'fixed top-20 right-4 z-50 px-4 py-2 rounded-lg shadow-lg transform translate-x-full transition-all duration-300 dark:bg-gray-800 bg-white dark:text-white text-gray-800 border dark:border-yellow-400 border-blue-400';
        toast.innerHTML = `
        <div class="flex items-center space-x-2">
            <span class="text-sm font-medium">${message}</span>
        </div>
    `;

        // Add to DOM
        document.body.appendChild(toast);

        // Trigger animation
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
            toast.classList.add('translate-x-0');
        }, 10);

        // Auto remove after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }

    // Initialize theme on page load
    document.addEventListener('DOMContentLoaded', function () {
        // Check for saved theme preference or default to dark
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        if (savedTheme === 'light' || (!savedTheme && !prefersDark)) {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        } else {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        }
    });
</script>