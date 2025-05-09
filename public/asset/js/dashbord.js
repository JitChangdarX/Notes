let firstVisit = !localStorage.getItem('hasVisited');
let activeTab = 'notes';


window.addEventListener('load', () => {
    try {
        setTimeout(() => {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.visibility = 'hidden';
                    if (firstVisit) {
                        setTimeout(() => {
                            const welcomeOverlay = document.getElementById(
                                'welcomeOverlay');
                            if (welcomeOverlay) {
                                welcomeOverlay.classList.add('show');
                                localStorage.setItem('hasVisited', 'true');
                            }
                        }, 500);
                    }
                }, 500);
            }
        }, 800);
    } catch (error) {
        console.error('Page loader error:', error);
    }
});

function closeWelcomeOverlay() {
    try {
        const welcomeOverlay = document.getElementById('welcomeOverlay');
        if (welcomeOverlay) {
            welcomeOverlay.classList.remove('show');
        }
    } catch (error) {
        console.error('Close welcome overlay error:', error);
    }
}


function toggleMobileMenu() {
    try {
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenu) {
            mobileMenu.classList.toggle('show');
        }
    } catch (error) {
        console.error('Toggle mobile menu error:', error);
    }
}


function toggleSettings() {
    try {
        const settingsPanel = document.getElementById('settingsPanel');
        const overlay = document.getElementById('settingsOverlay');
        if (settingsPanel && overlay) {
            settingsPanel.classList.toggle('show');
            overlay.classList.toggle('show');
        }
    } catch (error) {
        console.error('Toggle settings error:', error);
    }
}


const systemDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
const savedTheme = localStorage.getItem('theme');
const themeToggle = document.getElementById('darkModeToggle');
const themeIconMobile = document.getElementById('themeIconMobile');
const themeTextMobile = document.getElementById('themeTextMobile');

function applyTheme(isDark) {
    try {
        document.documentElement.style.setProperty('--background-color', isDark ? '#212121' : '#fafafa');
        document.documentElement.style.setProperty('--card-background', isDark ? '#424242' : '#ffffff');
        document.documentElement.style.setProperty('--text-color', isDark ? '#e0e0e0' : '#212121');
        document.documentElement.style.setProperty('--text-secondary', isDark ? '#b0b0b0' : '#757575');
        document.body.style.background = isDark ? '#212121' : '#fafafa';
        if (themeToggle) {
            themeToggle.classList.toggle('active', isDark);
        }
        if (themeIconMobile && themeTextMobile) {
            themeIconMobile.className = isDark ? 'ri-sun-line' : 'ri-moon-line';
            themeTextMobile.textContent = isDark ? 'Light Mode' : 'Dark Mode';
        }
    } catch (error) {
        console.error('Apply theme error:', error);
    }
}

function toggleTheme() {
    try {
        const isDark = document.documentElement.style.getPropertyValue('--background-color') === '#212121';
        const newTheme = !isDark ? 'dark' : 'light';
        localStorage.setItem('theme', newTheme);
        applyTheme(!isDark);
    } catch (error) {
        console.error('Toggle theme error:', error);
    }
}


try {
    if (savedTheme) {
        applyTheme(savedTheme === 'dark');
    } else {
        applyTheme(systemDarkMode.matches);
    }
} catch (error) {
    console.error('Initialize theme error:', error);
}

systemDarkMode.addEventListener('change', e => {
    try {
        if (!localStorage.getItem('theme')) {
            applyTheme(e.matches);
        }
    } catch (error) {
        console.error('System theme change error:', error);
    }
});

// Show toast notification
function showToast(message, type = 'success') {
    try {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `<span class="message">${message}</span>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    } catch (error) {
        console.error('Show toast error:', error);
    }
}

// Add note
function addNote(event) {
    try {
        event.preventDefault();
        const noteForm = document.getElementById('noteForm');
        const nameInput = document.getElementById('noteName');
        const messageInput = document.getElementById('noteMessage');
        if (!noteForm || !nameInput || !messageInput) {
            console.error('Form or inputs not found');
            showToast('Error: Form not found', 'error');
            return;
        }
        if (!nameInput.value.trim() || !messageInput.value.trim()) {
            showToast('Name and message cannot be empty', 'error');
            return;
        }
        noteForm.submit();
    } catch (error) {
        console.error('Add note error:', error);
        showToast('Error adding note', 'error');
    }
}

// Edit note
function editNote(id) {
    try {
        const name = prompt('Edit note name:');
        const message = prompt('Edit note message:');
        if (name !== null && message !== null && name.trim() && message.trim()) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/notes/${id}`;
            form.innerHTML = `
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                    <input type="hidden" name="name" value="${name.trim()}">
                    <input type="hidden" name="message" value="${message.trim()}">
                `;
            document.body.appendChild(form);
            form.submit();
        }
    } catch (error) {
        console.error('Edit note error:', error);
        showToast('Error editing note', 'error');
    }
}

// Delete note
function deleteNote(id) {
    try {
        if (confirm('Are you sure you want to delete this note?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/notes/${id}`;
            form.innerHTML = `
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                `;
            document.body.appendChild(form);
            form.submit();
        }
    } catch (error) {
        console.error('Delete note error:', error);
        showToast('Error deleting note', 'error');
    }
}

// Toggle pin
function togglePin(id) {
    try {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/notes/${id}/pin`;
        form.innerHTML = `
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
            `;
        document.body.appendChild(form);
        form.submit();
    } catch (error) {
        console.error('Toggle pin error:', error);
        showToast('Error toggling pin', 'error');
    }
}

// Clear search
function clearSearch() {
    try {
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.value = '';
            const form = document.getElementById('searchForm');
            if (form) {
                form.submit();
            } else {
                console.error('Search form not found');
                showToast('Error: Search form not found', 'error');
            }
        }
    } catch (error) {
        console.error('Clear search error:', error);
        showToast('Error clearing search', 'error');
    }
}

// Color picker
try {
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', () => {
            document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove(
                'selected'));
            option.classList.add('selected');
            const noteColor = document.getElementById('noteColor');
            if (noteColor) {
                noteColor.value = option.dataset.color;
            }
        });
    });
} catch (error) {
    console.error('Color picker error:', error);
}

// Custom cursor
try {
    const customCursor = document.getElementById('customCursor');
    if (customCursor) {
        document.addEventListener('mousemove', (e) => {
            customCursor.style.left = `${e.clientX}px`;
            customCursor.style.top = `${e.clientY}px`;
        });

        document.addEventListener('mouseover', (e) => {
            if (e.target.closest('.note-card, button, a, .color-option')) {
                customCursor.classList.add('hover');
            }
        });

        document.addEventListener('mouseout', (e) => {
            if (e.target.closest('.note-card, button, a, .color-option')) {
                customCursor.classList.remove('hover');
            }
        });
    }
} catch (error) {
    console.error('Custom cursor error:', error);
}

// Tab navigation
try {
    document.querySelectorAll('.nav-item').forEach(button => {
        button.addEventListener('click', () => {
            activeTab = button.dataset.tab;
            document.querySelectorAll('.nav-item').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            document.querySelectorAll('.notes-grid, .tab-content').forEach(el => el.style.display =
                'none');
            const tabContent = document.getElementById(activeTab + 'Tab');
            if (tabContent) {
                tabContent.style.display = 'block';
            }
            if (activeTab === 'notes') {
                const notesGrid = document.getElementById('notesGrid');
                if (notesGrid) {
                    notesGrid.style.display = 'block';
                }
            }
            toggleMobileMenu();
        });
    });
} catch (error) {
    console.error('Tab navigation error:', error);
}

// Render tags
function renderTags() {
    try {
        const tagsGrid = document.querySelector('.tags-grid');
        if (tagsGrid) {
            tagsGrid.innerHTML = '';
            const tags = ['Work', 'Personal', 'Ideas', 'To-do'];
            tags.forEach(tag => {
                const tagCard = document.createElement('div');
                tagCard.className = 'tag-card';
                tagCard.innerHTML = `
                        <div class="tag-info">
                            <span class="tag-color ${tag.toLowerCase()}"></span>
                            ${tag}
                        </div>
                        <span class="tag-count">0 notes</span>
                    `;
                tagsGrid.appendChild(tagCard);
            });
        }
    } catch (error) {
        console.error('Render tags error:', error);
    }
}

// Add note on Enter key
try {
    const noteMessage = document.getElementById('noteMessage');
    if (noteMessage) {
        noteMessage.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                const noteForm = document.getElementById('noteForm');
                if (noteForm) {
                    noteForm.dispatchEvent(new Event('submit'));
                }
            }
        });
    }
} catch (error) {
    console.error('Add note on Enter key error:', error);
}

try {
    renderTags();
} catch (error) {
    console.error('Initial render error:', error);
}


try {
    const fab = document.querySelector('.fab');
    if (fab) {
        fab.addEventListener('click', () => {
            const noteName = document.getElementById('noteName');
            if (noteName) {
                noteName.focus();
            }
        });
    }
} catch (error) {
    console.error('FAB click error:', error);
}

try {
    const flashMessages = document.querySelectorAll('.flash-message');
    if (flashMessages) {
        flashMessages.forEach(message => {
            setTimeout(() => {
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 500);
            }, 3000);
        });
    }
} catch (error) {
    console.error('Flash messages error:', error);
}
// Virtual Keyboard Implementation for Google Notes
// Add this to your dashbord.js file

// Keyboard layouts for different languages
const keyboardLayouts = {
    en: {
        name: 'English',
        keys: [
            ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '=', 'Backspace'],
            ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', '[', ']'],
            ['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', ';', "'", 'Enter'],
            ['Shift', 'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '/', 'Shift'],
            ['Space']
        ]
    },
    bn: {
        name: 'Bengali',
        keys: [
            ['১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', '-', '=', 'Backspace'],
            ['ঙ', 'য', 'ড', 'প', 'ট', 'চ', 'জ', 'হ', 'গ', 'ঘ', 'ঞ', 'ঋ'],
            ['ো', 'ে', '্', 'ি', 'ু', 'প', 'র', 'ক', 'ত', 'দ', 'Enter'],
            ['Shift', 'ৎ', 'ং', 'ম', 'ন', 'ব', 'ল', 'স', ',', '.', 'য়', 'Shift'],
            ['Space']
        ]
    },
    hi: {
        name: 'Hindi',
        keys: [
            ['१', '२', '३', '४', '५', '६', '७', '८', '९', '०', '-', '=', 'Backspace'],
            ['ौ', 'ै', 'ा', 'ी', 'ू', 'ब', 'ह', 'ग', 'द', 'ज', 'ड', 'ॉ'],
            ['ो', 'े', '्', 'ि', 'ु', 'प', 'र', 'क', 'त', 'च', 'ट', 'Enter'],
            ['Shift', 'ॆ', 'ं', 'म', 'न', 'व', 'ल', 'स', ',', '.', 'य', 'Shift'],
            ['Space']
        ]
    },
    ar: {
        name: 'Arabic',
        keys: [
            ['١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', '٠', '-', '=', 'Backspace'],
            ['ض', 'ص', 'ث', 'ق', 'ف', 'غ', 'ع', 'ه', 'خ', 'ح', 'ج', 'د'],
            ['ش', 'س', 'ي', 'ب', 'ل', 'ا', 'ت', 'ن', 'م', 'ك', 'ط', 'Enter'],
            ['Shift', 'ئ', 'ء', 'ؤ', 'ر', 'لا', 'ى', 'ة', 'و', 'ز', 'ظ', 'Shift'],
            ['Space']
        ]
    },
    es: {
        name: 'Spanish',
        keys: [
            ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '=', 'Backspace'],
            ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', 'ñ', 'á'],
            ['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'é', 'í', 'Enter'],
            ['Shift', 'z', 'x', 'c', 'v', 'b', 'n', 'm', 'ó', 'ú', 'ü', 'Shift'],
            ['Space']
        ]
    },
    // Add more language layouts as needed
};

// DOM elements for keyboard
let virtualKeyboard;
let keyboardOpen = false;
let currentLayout = 'en';
let currentFocusElement = null;

// Create keyboard toggle button
function createKeyboardToggleButton() {
    const keyboardButton = document.createElement('button');
    keyboardButton.className = 'keyboard-toggle-btn';
    keyboardButton.innerHTML = '<i class="ri-keyboard-line"></i>';
    keyboardButton.setAttribute('aria-label', 'Toggle virtual keyboard');
    keyboardButton.title = 'Open virtual keyboard';

    keyboardButton.addEventListener('click', toggleKeyboard);

    // Add to note input controls
    const inputControls = document.querySelector('.input-controls');
    if (inputControls) {
        // Add before language selector
        const languageSelector = document.querySelector('.language-selector');
        if (languageSelector) {
            inputControls.insertBefore(keyboardButton, languageSelector);
        } else {
            inputControls.insertBefore(keyboardButton, document.getElementById('btn'));
        }
    }

    // Add event listeners to input fields
    const noteInputFields = [document.getElementById('noteName'), document.getElementById('noteMessage')];
    noteInputFields.forEach(field => {
        if (field) {
            field.addEventListener('focus', function () {
                currentFocusElement = this;
                // If keyboard is already open, update layout based on language
                if (keyboardOpen) {
                    updateKeyboardLayout(field.getAttribute('lang') || 'en');
                }
            });
        }
    });
}

// Toggle virtual keyboard
function toggleKeyboard() {
    if (keyboardOpen) {
        hideKeyboard();
    } else {
        showKeyboard();
    }
}

// Create and show virtual keyboard
function showKeyboard() {
    const activeElement = document.activeElement;
    if (activeElement && (activeElement.id === 'noteName' || activeElement.id === 'noteMessage')) {
        currentFocusElement = activeElement;
    } else {
        // Default to note message if no input is focused
        currentFocusElement = document.getElementById('noteMessage');
        if (currentFocusElement) {
            currentFocusElement.focus();
        }
    }

    if (!currentFocusElement) return;

    // Get language from current focus element
    const lang = currentFocusElement.getAttribute('lang') || 'en';
    currentLayout = lang;

    // Create keyboard if it doesn't exist
    if (!virtualKeyboard) {
        virtualKeyboard = document.createElement('div');
        virtualKeyboard.className = 'virtual-keyboard';
        document.body.appendChild(virtualKeyboard);

        // Create keyboard header
        const keyboardHeader = document.createElement('div');
        keyboardHeader.className = 'keyboard-header';

        const keyboardTitle = document.createElement('div');
        keyboardTitle.className = 'keyboard-title';
        keyboardTitle.textContent = `${keyboardLayouts[currentLayout].name} Keyboard`;

        const closeButton = document.createElement('button');
        closeButton.className = 'keyboard-close';
        closeButton.innerHTML = '<i class="ri-close-line"></i>';
        closeButton.onclick = hideKeyboard;

        keyboardHeader.appendChild(keyboardTitle);
        keyboardHeader.appendChild(closeButton);
        virtualKeyboard.appendChild(keyboardHeader);

        // Create keyboard body
        const keyboardBody = document.createElement('div');
        keyboardBody.className = 'keyboard-body';
        virtualKeyboard.appendChild(keyboardBody);
    }

    // Update keyboard layout based on selected language
    updateKeyboardLayout(currentLayout);

    // Show keyboard with animation
    setTimeout(() => {
        virtualKeyboard.classList.add('show');
    }, 10);

    keyboardOpen = true;

    // Update toggle button
    const toggleBtn = document.querySelector('.keyboard-toggle-btn');
    if (toggleBtn) {
        toggleBtn.innerHTML = '<i class="ri-keyboard-fill"></i>';
        toggleBtn.title = 'Close virtual keyboard';
    }
}

// Hide virtual keyboard
function hideKeyboard() {
    if (virtualKeyboard) {
        virtualKeyboard.classList.remove('show');
        keyboardOpen = false;

        // Update toggle button
        const toggleBtn = document.querySelector('.keyboard-toggle-btn');
        if (toggleBtn) {
            toggleBtn.innerHTML = '<i class="ri-keyboard-line"></i>';
            toggleBtn.title = 'Open virtual keyboard';
        }
    }
}

// Update keyboard layout based on language
function updateKeyboardLayout(lang) {
    if (!keyboardLayouts[lang]) {
        lang = 'en'; // Fallback to English
    }

    currentLayout = lang;

    // Update keyboard title
    const keyboardTitle = virtualKeyboard.querySelector('.keyboard-title');
    if (keyboardTitle) {
        keyboardTitle.textContent = `${keyboardLayouts[lang].name} Keyboard`;
    }

    // Clear existing keys
    const keyboardBody = virtualKeyboard.querySelector('.keyboard-body');
    keyboardBody.innerHTML = '';

    // Create keys based on layout
    keyboardLayouts[lang].keys.forEach(row => {
        const keyRow = document.createElement('div');
        keyRow.className = 'keyboard-row';

        row.forEach(key => {
            const keyButton = document.createElement('button');
            keyButton.className = 'keyboard-key';

            // Special keys
            if (key === 'Space') {
                keyButton.className += ' key-space';
                keyButton.textContent = ' ';
            } else if (key === 'Backspace') {
                keyButton.className += ' key-backspace';
                keyButton.innerHTML = '<i class="ri-delete-back-2-line"></i>';
            } else if (key === 'Enter') {
                keyButton.className += ' key-enter';
                keyButton.innerHTML = '<i class="ri-arrow-go-back-line"></i>';
            } else if (key === 'Shift') {
                keyButton.className += ' key-shift';
                keyButton.innerHTML = '<i class="ri-arrow-up-s-line"></i>';
            } else {
                keyButton.textContent = key;
            }

            // Add click event for key
            keyButton.addEventListener('click', () => handleKeyPress(key));

            keyRow.appendChild(keyButton);
        });

        keyboardBody.appendChild(keyRow);
    });
}

// Handle key press events
function handleKeyPress(key) {
    if (!currentFocusElement) return;

    const start = currentFocusElement.selectionStart;
    const end = currentFocusElement.selectionEnd;
    const text = currentFocusElement.value;

    switch (key) {
        case 'Backspace':
            if (start === end) {
                if (start > 0) {
                    currentFocusElement.value = text.slice(0, start - 1) + text.slice(end);
                    currentFocusElement.selectionStart = currentFocusElement.selectionEnd = start - 1;
                }
            } else {
                currentFocusElement.value = text.slice(0, start) + text.slice(end);
                currentFocusElement.selectionStart = currentFocusElement.selectionEnd = start;
            }
            break;

        case 'Enter':
            if (currentFocusElement.tagName.toLowerCase() === 'textarea') {
                currentFocusElement.value = text.slice(0, start) + '\n' + text.slice(end);
                currentFocusElement.selectionStart = currentFocusElement.selectionEnd = start + 1;
            } else {
                // For input element, submit the form
                const form = currentFocusElement.closest('form');
                if (form) form.submit();
            }
            break;

        case 'Shift':
            // Toggle uppercase/lowercase for keyboard keys
            const keys = virtualKeyboard.querySelectorAll('.keyboard-key:not(.key-shift):not(.key-backspace):not(.key-enter):not(.key-space)');
            keys.forEach(keyEl => {
                if (keyEl.textContent && keyEl.textContent.length === 1) {
                    if (keyEl.textContent === keyEl.textContent.toLowerCase()) {
                        keyEl.textContent = keyEl.textContent.toUpperCase();
                    } else {
                        keyEl.textContent = keyEl.textContent.toLowerCase();
                    }
                }
            });
            break;

        case 'Space':
            currentFocusElement.value = text.slice(0, start) + ' ' + text.slice(end);
            currentFocusElement.selectionStart = currentFocusElement.selectionEnd = start + 1;
            break;

        default:
            currentFocusElement.value = text.slice(0, start) + key + text.slice(end);
            currentFocusElement.selectionStart = currentFocusElement.selectionEnd = start + key.length;
    }

    // Trigger input event for any validation
    const event = new Event('input', { bubbles: true });
    currentFocusElement.dispatchEvent(event);

    // Keep focus on the input element
    currentFocusElement.focus();
}

// Listen for language changes to update keyboard layout
function setupLanguageChangeListener() {
    const languageSelect = document.getElementById('languageSelect');
    if (languageSelect) {
        languageSelect.addEventListener('change', function () {
            const lang = this.value;
            if (keyboardOpen && virtualKeyboard) {
                updateKeyboardLayout(lang);
            }
        });
    }
}

// Connect language selection with keyboard layout
document.addEventListener('DOMContentLoaded', function () {
    // Create keyboard toggle button
    createKeyboardToggleButton();

    // Setup language change listener
    setupLanguageChangeListener();

    // Close keyboard when clicking outside
    document.addEventListener('click', function (event) {
        if (keyboardOpen &&
            !event.target.closest('.virtual-keyboard') &&
            !event.target.closest('.keyboard-toggle-btn') &&
            !event.target.closest('#noteName') &&
            !event.target.closest('#noteMessage')) {
            hideKeyboard();
        }
    });
});