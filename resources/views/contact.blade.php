<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Contact - Dennis Snellenberg</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    <link rel="stylesheet" href="{{ asset('asset/css/contact.css') }}">
</head>

<body class="bg-[#1c1c23] min-h-screen px-4 sm:px-6 md:px-8 flex items-center justify-center text-[#dbdadb] antialiased">
    <main class="w-full max-w-5xl mx-auto py-12 md:py-20">
        <div class="flex flex-col md:flex-row gap-12 md:gap-8">
            <section class="flex-1 flex flex-col justify-center">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight mb-6" data-aos="fade-up" data-aos-duration="600">Contact</h1>
                <p class="text-base sm:text-lg md:text-xl max-w-lg text-[#8a8c94] mb-8" data-aos="fade-up" data-aos-delay="100" data-aos-duration="600">
                    Feel free to reach out via email or schedule a call. I currently work at a software company in India and collaborate with clients from around the world.
                </p>
                <div class="space-y-5 text-base md:text-lg" data-aos="fade-up" data-aos-delay="200" data-aos-duration="600">
                    <div>
                        <span class="block text-[#717073] mb-1">EMAIL</span>
                        <a href="mailto:jitchangdar@gmail.com" class="animated-underline text-[#dbdadb] hover:text-[#8c9696] transition duration-200" aria-label="Email">
                            jitchangdar@gmail.com
                            <span class="underline-effect" style="background: #dbdadb;"></span>
                        </a>
                    </div>
                    <div>
                        <span class="block text-[#717073] mb-1">LOCATION</span>
                        <span class="text-[#dbdadb]">Kolkata / Software Developer</span>
                    </div>
                    <div class="pt-3">
                        <button id="lets-talk-btn" class="animated-underline animated-btn inline-block bg-[#dbdadb] text-[#1c1c23] px-6 sm:px-8 py-3 mt-3 rounded-full font-semibold shadow-[0_4px_24px_rgba(26,26,32,0.15)] transition-all duration-200 outline-none focus:ring-2 focus:ring-[#8c9696] relative hover:shadow-[0_6px_32px_rgba(26,26,32,0.25)]" aria-label="Open contact form" type="button">
                            Let's Talk
                            <span class="underline-effect"></span>
                        </button>
                    </div>
                </div>
            </section>
            <section class="flex-1 flex items-center justify-center relative" data-aos="fade-up" data-aos-delay="300" data-aos-duration="600">
                <div class="relative w-64 sm:w-72 md:w-80 h-64 sm:h-72 md:h-80 hidden md:block">
                    <img src="https://via.placeholder.com/320?text=Dennis+Snellenberg" srcset="https://via.placeholder.com/320?text=Dennis+Snellenberg 1x, https://via.placeholder.com/640?text=Dennis+Snellenberg 2x" alt="Portrait" class="w-full h-full object-cover object-center rounded-3xl border-2 border-[#343c3c] shadow-lg" loading="lazy" decoding="async" />
                    <img src="https://via.placeholder.com/112x112?text=Contact+Shape" class="absolute -bottom-8 -right-12 w-24 sm:w-28 opacity-90" alt="Decorative contact shape" loading="lazy" decoding="async" />
                </div>
            </section>
        </div>
    </main>

    <!-- Modal for Contact Form with Loader -->
    <div id="calendly-modal" class="modal-bg fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="modal-content bg-[#1c1c23] rounded-2xl shadow-lg p-6 max-w-xl w-full relative border border-[#343c3c]">
            <button onclick="closeModal()" class="absolute top-3 right-5 text-[#dbdadb] bg-transparent border-none text-3xl font-bold focus:outline-none hover:text-[#8c9696] transition" aria-label="Close form">×</button>
            <form id="contact-form" action="{{ route('contact.store') }}" method="POST" class="space-y-6" data-aos="fade-up" data-aos-duration="600">
                @csrf
                <h2 class="text-2xl font-bold mb-4 text-[#dbdadb]">Get in Touch</h2>
                <div class="form-group">
                    <label for="name" class="block text-sm font-medium text-[#8a8c94]">Name</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-600 bg-[#2a2a33] text-[#dbdadb] p-2 focus:ring-[#8c9696] focus:border-[#8c9696]" placeholder="Your Name" required />
                    <span class="error-message">Please enter a name with at least 2 characters.</span>
                </div>
                <div class="form-group">
                    <label for="email" class="block text-sm font-medium text-[#8a8c94]">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-600 bg-[#2a2a33] text-[#dbdadb] p-2 focus:ring-[#8c9696] focus:border-[#8c9696]" placeholder="your@email.com" required />
                    <span class="error-message">Please enter a valid email address.</span>
                </div>
                <div class="form-group">
                    <label for="message" class="block text-sm font-medium text-[#8a8c94]">Message</label>
                    <textarea id="message" name="message" rows="4" class="mt-1 block w-full rounded-md border-gray-600 bg-[#2a2a33] text-[#dbdadb] p-2 focus:ring-[#8c9696] focus:border-[#8c9696]" placeholder="Your message here..." required></textarea>
                    <span class="error-message">Please enter a message with at least 10 characters.</span>
                </div>
                <div id="form-message" class="text-sm text-red-500 hidden"></div>
                <div id="loader" class="hidden flex justify-center items-center">
                    <div class="w-6 h-6 border-4 border-t-[#dbdadb] border-[#2a2a33] rounded-full animate-spin"></div>
                </div>
                <button type="submit" class="w-full bg-[#dbdadb] text-[#1c1c23] px-4 py-2 rounded-full font-semibold hover:bg-[#c0c0c5] transition duration-200 shadow-md hover:shadow-lg focus:ring-2 focus:ring-[#8c9696]" id="submit-btn">Send Message</button>
            </form>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast" class="toast">
        <svg class="success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span id="toast-message"></span>
    </div>

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize AOS animations
            try {
                AOS.init({
                    once: true,
                    duration: 600,
                    offset: 50,
                    easing: 'ease-out-cubic'
                });
            } catch (error) {
                console.error('AOS error:', error);
            }

            // Modal and Loader logic
            const openBtn = document.getElementById('lets-talk-btn');
            const modal = document.getElementById('calendly-modal');
            const form = document.getElementById('contact-form');
            const formMessage = document.getElementById('form-message');
            const submitBtn = document.getElementById('submit-btn');
            const loader = document.getElementById('loader');
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');

            const closeModal = () => {
                modal.classList.add('hidden');
                form.reset();
                formMessage.classList.add('hidden');
                loader.classList.add('hidden');
                document.querySelectorAll('.form-group').forEach(group => group.classList.remove('invalid'));
                AOS.refreshHard();
            };
            window.closeModal = closeModal;

            openBtn && openBtn.addEventListener('click', (e) => {
                e.preventDefault();
                modal.classList.remove('hidden');
                loader.classList.remove('hidden'); // Show loader when modal opens
                setTimeout(() => loader.classList.add('hidden'), 1000); // Hide loader after 1 second (simulated loading)
                AOS.refreshHard();
            });

            modal && modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            // Trap focus inside modal
            const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];

            modal && modal.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeModal();
                if (e.key === 'Tab') {
                    if (e.shiftKey && document.activeElement === firstFocusable) {
                        e.preventDefault();
                        lastFocusable.focus();
                    } else if (!e.shiftKey && document.activeElement === lastFocusable) {
                        e.preventDefault();
                        firstFocusable.focus();
                    }
                }
            });

            // Real-time form validation
            const validateName = (value) => value.trim().length >= 2;
            const validateEmail = (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            const validateMessage = (value) => value.trim().length >= 10;

            const inputs = {
                name: document.getElementById('name'),
                email: document.getElementById('email'),
                message: document.getElementById('message')
            };

            Object.keys(inputs).forEach((key) => {
                inputs[key].addEventListener('input', () => {
                    const group = inputs[key].closest('.form-group');
                    let isValid = false;

                    if (key === 'name') isValid = validateName(inputs[key].value);
                    if (key === 'email') isValid = validateEmail(inputs[key].value);
                    if (key === 'message') isValid = validateMessage(inputs[key].value);

                    group.classList.toggle('invalid', !isValid);
                });
            });

            // Form submission with loader and toast notification
            form && form.addEventListener('submit', async (e) => {
                e.preventDefault();
                let hasError = false;

                // Validate all fields before submission
                if (!validateName(inputs.name.value)) {
                    inputs.name.closest('.form-group').classList.add('invalid');
                    hasError = true;
                }
                if (!validateEmail(inputs.email.value)) {
                    inputs.email.closest('.form-group').classList.add('invalid');
                    hasError = true;
                }
                if (!validateMessage(inputs.message.value)) {
                    inputs.message.closest('.form-group').classList.add('invalid');
                    hasError = true;
                }

                if (hasError) {
                    formMessage.classList.remove('hidden');
                    formMessage.classList.add('text-red-500');
                    formMessage.textContent = 'Please correct the errors above.';
                    return;
                }

                submitBtn.disabled = true;
                formMessage.classList.add('hidden');
                loader.classList.remove('hidden'); // Show loader on submit

                const formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // Display toast notification with the success message
                        toastMessage.textContent = result.success || 'Your message has been sent successfully!';
                        toast.classList.remove('error');
                        toast.classList.add('success');
                        toast.style.display = 'flex';
                        setTimeout(() => {
                            toast.style.display = 'none';
                        }, 5000); // Hide after 5 seconds

                        form.reset();
                        setTimeout(closeModal, 2000); // Close modal after 2 seconds
                    } else {
                        // Display error toast
                        toastMessage.textContent = result.error || 'Failed to send message. Please try again.';
                        toast.classList.remove('success');
                        toast.classList.add('error');
                        toast.style.display = 'flex';
                        setTimeout(() => {
                            toast.style.display = 'none';
                        }, 5000);

                        formMessage.classList.remove('hidden');
                        formMessage.classList.add('text-red-500');
                        formMessage.textContent = result.error || 'Failed to send message. Please try again.';
                    }
                } catch (error) {
                    // Display error toast
                    toastMessage.textContent = 'An error occurred: ' + error.message;
                    toast.classList.remove('success');
                    toast.classList.add('error');
                    toast.style.display = 'flex';
                    setTimeout(() => {
                        toast.style.display = 'none';
                    }, 5000);

                    formMessage.classList.remove('hidden');
                    formMessage.classList.add('text-red-500');
                    formMessage.textContent = 'An error occurred: ' + error.message;
                } finally {
                    loader.classList.add('hidden'); // Hide loader after response
                    submitBtn.disabled = false;
                }
            });
        });
    </script>
</body>

</html>