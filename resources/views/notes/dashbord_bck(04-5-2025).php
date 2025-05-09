<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Notes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/2.5.0/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/dashbord.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::guard('web')->user();
        $profilePhoto = $user && $user->avatar ? 'storage/' . $user->avatar : 'images/default-profile.png';
        $initials = $user ? strtoupper(substr($user->name, 0, 2)) : 'GU';
    @endphp

    <!-- Custom Cursor -->
    <div class="custom-cursor" id="customCursor"></div>

    <!-- Skip link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader"></div>
    </div>

    <!-- Welcome Overlay -->
    <div class="welcome-overlay" id="welcomeOverlay">
        <div class="welcome-content">
            <h2 class="welcome-title">Welcome to Google Notes!</h2>
            <p class="welcome-subtitle">Here's what's new in our latest update:</p>
            <div class="welcome-features">
                <div class="feature-item">
                    <span class="feature-icon"><i class="ri-pushpin-fill"></i></span>
                    <div>
                        <h3>Pin Important Notes</h3>
                        <p>Keep your priority notes at the top</p>
                    </div>
                </div>
                <div class="feature-item">
                    <span class="feature-icon"><i class="ri-price-tag-3-fill"></i></span>
                    <div>
                        <h3>Smart Tags</h3>
                        <p>Organize your notes with custom tags</p>
                    </div>
                </div>
                <div class="feature-item">
                    <span class="feature-icon"><i class="ri-calendar-fill"></i></span>
                    <div>
                        <h3>Calendar View</h3>
                        <p>See your notes organized by date</p>
                    </div>
                </div>
            </div>
            <button class="welcome-btn" onclick="closeWelcomeOverlay()">Get Started</button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-content">
            <div class="mobile-menu-header">
                <h2 class="text-indigo-600 font-bold">Google Notes</h2>
                <button onclick="toggleMobileMenu()"><i class="ri-close-fill"></i></button>
            </div>
            <nav class="mobile-menu-nav">
                <button class="nav-item" data-tab="notes"><i class="ri-search-line"></i> Notes</button>
                <button class="nav-item" data-tab="reminders"><i class="ri-time-line"></i> Reminders</button>
                <button class="nav-item" data-tab="tags"><i class="ri-price-tag-3-line"></i> Tags</button>
                <button class="nav-item" data-tab="archive"><i class="ri-archive-line"></i> Archive</button>
                <button class="nav-item" data-tab="trash"><i class="ri-delete-bin-line"></i> Trash</button>
            </nav>
            <button class="theme-toggle-mobile" onclick="toggleTheme()">
                <i class="ri-moon-line" id="themeIconMobile"></i> <span id="themeTextMobile">Dark Mode</span>
            </button>
        </div>
    </div>

    <!-- Settings Overlay -->
    <div class="settings-overlay" id="settingsOverlay" onclick="toggleSettings()"></div>
    <div class="settings-panel" id="settingsPanel">
        <div class="settings-header">
            <h2>Settings</h2>
            <button onclick="toggleSettings()"><i class="ri-close-fill"></i></button>
        </div>
        <div class="settings-content">
            <section>
                <h3>Appearance</h3>
                <div class="setting-item">
                    <span>Dark Mode</span>
                    <button class="toggle-switch" id="darkModeToggle" onclick="toggleTheme()">
                        <span class="toggle-knob"></span>
                    </button>
                </div>
                <div class="setting-item">
                    <span>Compact View</span>
                    <button class="toggle-switch">
                        <span class="toggle-knob"></span>
                    </button>
                </div>
            </section>
            <section>
                <h3>Notifications</h3>
                <div class="setting-item">
                    <span>Enable Reminders</span>
                    <button class="toggle-switch active">
                        <span class="toggle-knob"></span>
                    </button>
                </div>
                <div class="setting-item">
                    <span>Sound Effects</span>
                    <button class="toggle-switch">
                        <span class="toggle-knob"></span>
                    </button>
                </div>
            </section>
            <section>
                <h3>Account</h3>
                <div class="account-info">
                    <div class="profile-circle">{{ $initials }}</div>
                    <div>
                        <div class="account-name">{{ $user ? $user->name : 'Guest' }}</div>
                        <div class="account-email">{{ $user ? $user->email : 'guest@example.com' }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="sign-out-btn">Sign Out</button>
                </form>
            </section>
            <section>
                <h3>Data & Privacy</h3>
                <button class="export-btn">Export All Notes</button>
                <button class="delete-account-btn">Delete Account</button>
            </section>
        </div>
    </div>

    <div class="container" id="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <button class="menu-btn" onclick="toggleMobileMenu()"><i class="ri-menu-line"></i></button>
                <div class="logo-container">
                    <div class="profile-circle">{{ $initials }}</div>
                    <h1>Google Notes</h1>
                </div>
            </div>
            <div class="search-bar">
                <i class="ri-search-line"></i>
                <input type="text" id="searchInput" placeholder="Search notes..." aria-label="Search notes">
                <button class="clear-btn" onclick="clearSearch()" aria-label="Clear search"><i
                        class="ri-close-line"></i></button>
            </div>
            <div class="header-actions">
                <button class="action-btn"><i class="ri-notification-3-line"></i></button>
                <button class="action-btn" onclick="toggleSettings()"><i class="ri-settings-4-line"></i></button>
            </div>
        </header>

        <!-- Main Layout -->
        <div class="main-layout">
            <!-- Sidebar -->
            <aside class="sidebar">
                <nav class="sidebar-nav">
                    <button class="nav-item active" data-tab="notes"><i class="ri-search-line"></i> Notes</button>
                    <button class="nav-item" data-tab="reminders"><i class="ri-time-line"></i> Reminders</button>
                    <button class="nav-item" data-tab="tags"><i class="ri-price-tag-3-line"></i> Tags</button>
                    <button class="nav-item" data-tab="archive"><i class="ri-archive-line"></i> Archive</button>
                    <button class="nav-item" data-tab="trash"><i class="ri-delete-bin-line"></i> Trash</button>
                </nav>
                <div class="tags-section">
                    <h3>Tags</h3>
                    <button class="tag-item"><span class="tag-color work"></span> Work</button>
                    <button class="tag-item"><span class="tag-color personal"></span> Personal</button>
                    <button class="tag-item"><span class="tag-color ideas"></span> Ideas</button>
                    <button class="tag-item"><span class="tag-color todo"></span> To-do</button>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="main-content">
                <!-- Note Input -->
                <div class="note-input">
                    <form id="noteForm" action="{{ route('note.store') }}" method="POST"
                        onsubmit="addNote(event)">
                        @csrf
                        <textarea id="noteContent" name="content" placeholder="Take a note..." aria-label="Note content" required></textarea>
                        <div class="input-controls">
                            <button type="button" class="input-action"><i class="ri-image-line"></i></button>
                            <button type="button" class="input-action"><i class="ri-price-tag-3-line"></i></button>
                            <select id="noteCategory" name="category" aria-label="Note category">
                                <option value="personal">Personal</option>
                                <option value="work">Work</option>
                                <option value="ideas">Ideas</option>
                                <option value="others">Others</option>
                            </select>
                            <div class="color-picker" id="colorPicker">
                                <div class="color-option selected" style="background: #ffffff" data-color="#ffffff">
                                </div>
                                <div class="color-option" style="background: #ffcccb" data-color="#ffcccb"></div>
                                <div class="color-option" style="background: #b3e5fc" data-color="#b3e5fc"></div>
                                <div class="color-option" style="background: #c8e6c9" data-color="#c8e6c9"></div>
                            </div>
                            <input type="hidden" name="color" id="noteColor" value="#ffffff">
                            <button name="submit" id="btn" type="submit">Add Note</button>
                        </div>
                    </form>
                </div>

                <!-- Notes Grid -->
                <div class="notes-grid" id="notesGrid">
                    <div class="notes-section">
                        <h2>Pinned</h2>
                        <div class="notes-list" id="pinnedNotes"></div>
                    </div>
                    <div class="notes-section">
                        <h2>Others</h2>
                        <div class="notes-list" id="otherNotes"></div>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="remindersTab" style="display: none;">
                    <div class="empty-state">
                        <i class="ri-time-line"></i>
                        <h3>No reminders yet</h3>
                        <p>Create a note with a reminder to see it here</p>
                        <button class="create-btn">Create Reminder</button>
                    </div>
                </div>
                <div class="tab-content" id="tagsTab" style="display: none;">
                    <div class="tags-grid"></div>
                </div>
                <div class="tab-content" id="archiveTab" style="display: none;">
                    <div class="empty-state">
                        <i class="ri-archive-line"></i>
                        <h3>Your archive is empty</h3>
                        <p>Archive notes to find them here</p>
                    </div>
                </div>
                <div class="tab-content" id="trashTab" style="display: none;">
                    <div class="empty-state">
                        <i class="ri-delete-bin-line"></i>
                        <h3>Trash is empty</h3>
                        <p>Deleted notes will appear here</p>
                        <p>Notes are permanently deleted after 30 days</p>
                    </div>
                </div>
            </main>
        </div>

        <!-- Floating Action Button (Mobile) -->
        <button class="fab" onclick="document.getElementById('noteContent').focus()">
            <i class="ri-add-line"></i>
        </button>
    </div>

    <script>
        // Initialize state
        let notes = [];
        let firstVisit = !localStorage.getItem('hasVisited');
        let deletedNote = null;
        let deletedIndex = null;
        let activeTab = 'notes';

        // Add note
        // Add note
        function addNote(event) {
            event.preventDefault();

            const content = document.getElementById('noteContent').value.trim();
            const category = document.getElementById('noteCategory').value || 'others';
            const color = document.querySelector('.color-option.selected')?.dataset.color || '#ffffff';

            if (!content) {
                showToast('Note content cannot be empty', 'error');
                return;
            }

            document.getElementById('noteContent').disabled = true;
            document.querySelector('.note-input button[type="submit"]').innerHTML =
                '<div class="loader" style="width: 20px; height: 20px; border-width: 3px;"></div>';

            // Create FormData instead of JSON
            const formData = new FormData();
            formData.append('content', content);
            formData.append('category', category);
            formData.append('color', color);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            fetch('/note', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                        // Don't set Content-Type when using FormData - browser will set it properly with boundary
                    },
                    body: formData // Use FormData instead of JSON.stringify
                })
                .then(response => {
                    console.log('Response Status:', response.status);
                    console.log('Response Headers:', response.headers);

                    // First check if response is ok
                    if (!response.ok) {
                        // If it's not a JSON response, handle it specially
                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            return response.text().then(text => {
                                throw new Error(
                                    `Server returned ${response.status}: ${text.substring(0, 100)}...`);
                            });
                        }
                        return response.json().then(data => {
                            throw new Error(data.message || `Server returned ${response.status}`);
                        });
                    }

                    // Only try to parse JSON if we got an OK response
                    return response.json();
                })
                .then(data => {
                    console.log('Response Data:', data);

                    notes.push({
                        content,
                        category,
                        id: data.id || Date.now(),
                        color
                    });

                    // Update UI
                    document.getElementById('noteContent').value = '';
                    document.getElementById('noteContent').disabled = false;
                    document.querySelector('.note-input button[type="submit"]').innerHTML = 'Add Note';

                    // Refresh notes display
                    renderNotes();
                    showToast('Note added successfully');
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    showToast('Error adding note: ' + error.message, 'error');
                    document.getElementById('noteContent').disabled = false;
                    document.querySelector('.note-input button[type="submit"]').innerHTML = 'Add Note';
                });
        }

        // Page loader
        window.addEventListener('load', () => {
            setTimeout(() => {
                const loader = document.getElementById('pageLoader');
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.visibility = 'hidden';
                    if (firstVisit) {
                        setTimeout(() => {
                            document.getElementById('welcomeOverlay').classList.add('show');
                            localStorage.setItem('hasVisited', 'true');
                        }, 500);
                    }
                }, 500);
            }, 800);
        });

        // Close welcome overlay
        function closeWelcomeOverlay() {
            document.getElementById('welcomeOverlay').classList.remove('show');
        }

        // Toggle mobile menu
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('show');
        }

        // Toggle settings panel
        function toggleSettings() {
            const settingsPanel = document.getElementById('settingsPanel');
            const overlay = document.getElementById('settingsOverlay');
            settingsPanel.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        // Theme toggle
        const systemDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
        const savedTheme = localStorage.getItem('theme');
        const themeToggle = document.getElementById('darkModeToggle');
        const themeIconMobile = document.getElementById('themeIconMobile');
        const themeTextMobile = document.getElementById('themeTextMobile');

        function applyTheme(isDark) {
            document.documentElement.style.setProperty('--background-color', isDark ? '#212121' : '#fafafa');
            document.documentElement.style.setProperty('--card-background', isDark ? '#424242' : '#ffffff');
            document.documentElement.style.setProperty('--text-color', isDark ? '#e0e0e0' : '#212121');
            document.documentElement.style.setProperty('--text-secondary', isDark ? '#b0b0b0' : '#757575');
            document.body.style.background = isDark ? '#212121' : '#fafafa';
            themeToggle.classList.toggle('active', isDark);
            themeIconMobile.className = isDark ? 'ri-sun-line' : 'ri-moon-line';
            themeTextMobile.textContent = isDark ? 'Light Mode' : 'Dark Mode';
        }

        if (savedTheme) {
            applyTheme(savedTheme === 'dark');
        } else {
            applyTheme(systemDarkMode.matches);
        }

        systemDarkMode.addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                applyTheme(e.matches);
            }
        });

        function toggleTheme() {
            const isDark = document.documentElement.style.getPropertyValue('--background-color') === '#212121';
            const newTheme = !isDark ? 'dark' : 'light';
            localStorage.setItem('theme', newTheme);
            applyTheme(!isDark);
        }

        // Show toast notification
        function showToast(message, type = 'success', undoCallback = null) {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.innerHTML = `
                <span class="message">${message}</span>
                ${undoCallback ? '<button class="undo-btn" onclick="undoDelete()">Undo</button>' : ''}
            `;
            document.body.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Fetch notes from server

        // Fixed fetchNotes function
        function fetchNotes(filter = '') {
            fetch('/note', {
                    method: 'GET', // Explicitly set method to GET
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        // Handle non-OK responses
                        const contentType = response.headers.get('content-type');
                        if (!contentType || !contentType.includes('application/json')) {
                            return response.text().then(text => {
                                throw new Error(
                                    `Server returned ${response.status}: ${text.substring(0, 100)}...`);
                            });
                        }
                        return response.json().then(data => {
                            throw new Error(data.message || `Server returned ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Notes data received:', data);
                    notes = data.notes || [];
                    renderNotes(filter);
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    showToast('Failed to fetch notes: ' + error.message, 'error');
                    // Show empty state on error
                    const otherNotes = document.getElementById('otherNotes');
                    otherNotes.innerHTML = '';
                    const emptyState = document.createElement('div');
                    emptyState.className = 'empty-state';
                    emptyState.innerHTML = `
                <i class="ri-error-warning-line"></i>
                <h3>Could not load notes</h3>
                <p>Please try again later or check the console for errors</p>
            `;
                    otherNotes.appendChild(emptyState);
                });
        }

        // Render notes
        function renderNotes(filter = '') {
            const pinnedNotes = document.getElementById('pinnedNotes');
            const otherNotes = document.getElementById('otherNotes');
            pinnedNotes.innerHTML = '';
            otherNotes.innerHTML = '';

            const filteredNotes = notes.filter(note =>
                note.message.toLowerCase().includes(filter.toLowerCase()) ||
                note.category.toLowerCase().includes(filter.toLowerCase())
            );

            if (filteredNotes.length === 0 && activeTab === 'notes') {
                const emptyState = document.createElement('div');
                emptyState.className = 'empty-state';
                emptyState.innerHTML = `
                    <i class="ri-sticky-note-line"></i>
                    <h3>${filter ? 'No matching notes found' : 'No notes yet'}</h3>
                    <p>${filter ? 'Try a different search term' : 'Add your first note to get started!'}</p>
                `;
                otherNotes.appendChild(emptyState);
                return;
            }

            filteredNotes.forEach((note, index) => {
                const noteCard = document.createElement('div');
                noteCard.className = 'note-card';
                noteCard.style.backgroundColor = note.color || '#ffffff';
                noteCard.innerHTML = `
                    ${note.is_pinned ? '<i class="ri-pushpin-fill pin-icon"></i>' : ''}
                    <div class="category">
                        <span class="category-dot ${note.category.toLowerCase()}"></span>
                        ${note.category.charAt(0).toUpperCase() + note.category.slice(1)}
                    </div>
                    <div class="content">${note.message}</div>
                    <div class="actions">
                        <button onclick="togglePin(${note.id})" aria-label="${note.is_pinned ? 'Unpin' : 'Pin'} note">
                            <i class="${note.is_pinned ? 'ri-pushpin-fill' : 'ri-pushpin-line'}"></i>
                        </button>
                        <button onclick="editNote(${note.id})" aria-label="Edit note"><i class="ri-edit-line"></i></button>
                        <button onclick="deleteNote(${note.id})" aria-label="Delete note"><i class="ri-delete-bin-line"></i></button>
                    </div>
                `;
                if (note.is_pinned) {
                    pinnedNotes.appendChild(noteCard);
                } else {
                    otherNotes.appendChild(noteCard);
                }
            });

            document.querySelector('.notes-section:first-child').style.display = pinnedNotes.children.length ? 'block' :
                'none';
        }

        // Edit note
        function editNote(id) {
            const note = notes.find(n => n.id === id);
            const newContent = prompt('Edit note:', note.message);
            if (newContent !== null && newContent.trim()) {
                fetch(`/notes/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            content: newContent.trim()
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            fetchNotes();
                            showToast('Note updated successfully');
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => showToast('Error updating note: ' + error.message, 'error'));
            }
        }

        // Delete note
        function deleteNote(id) {
            if (confirm('Are you sure you want to delete this note?')) {
                fetch(`/notes/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            deletedNote = notes.find(n => n.id === id);
                            deletedIndex = notes.findIndex(n => n.id === id);
                            fetchNotes();
                            showToast('Note deleted', 'success', true);
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => showToast('Error deleting note: ' + error.message, 'error'));
            }
        }

        // Toggle pin
        function togglePin(id) {
            fetch(`/notes/${id}/pin`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        is_pinned: !notes.find(n => n.id === id).is_pinned
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchNotes();
                        showToast(data.message, 'success');
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => showToast('Error updating note: ' + error.message, 'error'));
        }

        // Undo delete
        function undoDelete() {
            if (deletedNote && deletedIndex !== null) {
                fetch('/notes/restore', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(deletedNote)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            fetchNotes();
                            deletedNote = null;
                            deletedIndex = null;
                            showToast('Note restored');
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(error => showToast('Error restoring note: ' + error.message, 'error'));
            }
        }

        // Clear search
        function clearSearch() {
            document.getElementById('searchInput').value = '';
            fetchNotes();
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', (e) => {
            fetchNotes(e.target.value);
        });

        // Tab navigation
        document.querySelectorAll('.nav-item').forEach(button => {
            button.addEventListener('click', () => {
                activeTab = button.dataset.tab;
                document.querySelectorAll('.nav-item').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                document.querySelectorAll('.notes-grid, .tab-content').forEach(el => el.style.display =
                    'none');
                document.getElementById(activeTab + 'Tab').style.display = 'block';
                if (activeTab === 'notes') {
                    document.getElementById('notesGrid').style.display = 'block';
                    fetchNotes();
                }
                toggleMobileMenu();
            });
        });

        // Color picker
        document.querySelectorAll('.color-option').forEach(option => {
            option.addEventListener('click', () => {
                document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
                option.classList.add('selected');
                document.getElementById('noteColor').value = option.dataset.color;
            });
        });

        // Render tags
        function renderTags() {
            const tagsGrid = document.querySelector('.tags-grid');
            tagsGrid.innerHTML = '';
            const tags = ['Work', 'Personal', 'Ideas', 'To-do', 'Important', 'Later'];
            tags.forEach(tag => {
                const tagCard = document.createElement('div');
                tagCard.className = 'tag-card';
                tagCard.innerHTML = `
                    <div class="tag-info">
                        <span class="tag-color ${tag.toLowerCase()}"></span>
                        ${tag}
                    </div>
                    <span class="tag-count">12 notes</span>
                `;
                tagsGrid.appendChild(tagCard);
            });
        }

        // Initial render
        fetchNotes();
        renderTags();

        // Add note on Enter key
        document.getElementById('noteContent').addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('noteForm').dispatchEvent(new Event('submit'));
            }
        });
    </script>
</body>

</html>
