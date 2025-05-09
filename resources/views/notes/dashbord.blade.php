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
    <style>
        /* Add basic styles to fix overlay issues */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s, visibility 0.5s;
        }

        .welcome-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
        }

        .welcome-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .custom-cursor {
            display: none;
            /* Disable custom cursor by default */
            position: fixed;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: rgba(66, 133, 244, 0.4);
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 9999;
            transition: transform 0.1s ease;
        }

        /* Fix for settings overlay */
        .settings-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 8000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
        }

        .settings-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .settings-panel {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background-color: var(--card-background, #ffffff);
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 8001;
            transition: right 0.3s ease;
            overflow-y: auto;
        }

        .settings-panel.show {
            right: 0;
        }

        /* Mobile menu fixes */
        .mobile-menu {
            position: fixed;
            top: 0;
            left: -280px;
            width: 280px;
            height: 100%;
            background-color: var(--card-background, #ffffff);
            z-index: 8500;
            transition: left 0.3s ease;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu.show {
            left: 0;
        }
    </style>
</head>

<body>

    

    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::guard('web')->user();
        $profilePhoto = $user && $user->avatar ? 'storage/' . $user->avatar : 'images/default-profile.png';
        $initials = $user ? strtoupper(substr($user->name, 0, 2)) : 'GU';
    @endphp
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
                    <img class="profile-circle" src="{{ asset($profilePhoto) }}" class="profile-image" alt="Profile">
                    {{-- <div class="profile-circle"></div> --}}
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
                    <h1>Google Notes</h1>
                </div>
            </div>
            <form id="searchForm" action="{{ route('note.index') }}" method="GET" class="search-bar">
                <i class="ri-search-line"></i>
                <input type="text" id="searchInput" name="search" placeholder="Search notes..."
                    aria-label="Search notes" value="{{ $search ?? '' }}">
                @if (isset($search) && $search !== '')
                    <button type="button" class="clear-btn" onclick="clearSearch()" aria-label="Clear search">
                        <i class="ri-close-line"></i>
                    </button>
                @endif
                <button type="submit" class="search-submit" aria-label="Submit search">
                    <i class="ri-search-line"></i>
                </button>
            </form>
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
                <!-- Display flash messages -->
                @if (session('success'))
                    <div class="flash-message success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="flash-message error">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Note Input -->
                <div class="note-input">
                    <form id="noteForm" action="{{ route('note.store') }}" method="POST"
                        onsubmit="addNote(event)">
                        @csrf
                        <input type="text" id="noteName" name="name" placeholder="Note name..."
                            aria-label="Note name" required lang="en" dir="ltr">
                        <textarea id="noteMessage" name="message" placeholder="Take a note..." aria-label="Note message" required
                            lang="en" dir="ltr"></textarea>
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
                            <!-- Language selector will be inserted here by JavaScript -->
                            <button name="add_note" id="btn" type="submit">Add Note</button>
                        </div>
                    </form>
                </div>

                <!-- Notes Grid -->
                <div class="notes-grid" id="notesGrid">
                    @if (isset($notes) && $notes->isNotEmpty())
                        <div class="notes-section">
                            <h2>Pinned</h2>
                            <div class="notes-list" id="pinnedNotes">
                                @php $hasPinned = false; @endphp
                                @foreach ($notes as $note)
                                    @if ($note->is_pinned)
                                        @php $hasPinned = true; @endphp
                                        <div class="note-card" style="background-color: {{ $note->color }}">
                                            <i class="ri-pushpin-fill pin-icon"></i>
                                            <div class="category">
                                                <span class="category-dot {{ $note->category }}"></span>
                                                {{ ucfirst($note->category) }}
                                            </div>
                                            <div class="name">{{ $note->name }}</div>
                                            <div class="content">{{ $note->message }}</div>
                                            <div class="actions">
                                                <form action="{{ route('note.pin', $note->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" aria-label="Unpin note">
                                                        <i class="ri-pushpin-fill"></i>
                                                    </button>
                                                </form>
                                                <button onclick="editNote({{ $note->id }})"
                                                    aria-label="Edit note">
                                                    <i class="ri-edit-line"></i>
                                                </button>
                                                <form action="{{ route('note.destroy', $note->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" aria-label="Delete note"
                                                        onclick="return confirm('Are you sure you want to delete this note?')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @if (!$hasPinned)
                                    <div class="empty-state">
                                        <i class="ri-sticky-note-line"></i>
                                        <h3>No pinned notes</h3>
                                        <p>Pin a note to see it here!</p>
                                    </div>
                                @endif
                                @if ($hasPinned)
                                    <div class="empty-state"> </div>
                                @endif
                            </div>
                        </div>
                        <div class="notes-section">
                            <h2>Others</h2>
                            <div class="notes-list" id="otherNotes">
                                @php $hasUnpinned = false; @endphp
                                @foreach ($notes as $note)
                                    @if (!$note->is_pinned)
                                        @php $hasUnpinned = true; @endphp
                                        <div class="note-card" style="background-color: {{ $note->color }}">
                                            <div class="category">
                                                <span class="category-dot {{ $note->category }}"></span>
                                                {{ ucfirst($note->category) }}
                                            </div>
                                            <div class="name">{{ $note->name }}</div>
                                            <div class="content">{{ $note->message }}</div>
                                            <div class="actions">
                                                <form action="{{ route('note.pin', $note->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" aria-label="Pin note">
                                                        <i class="ri-pushpin-line"></i>
                                                    </button>
                                                </form>
                                                <button onclick="editNote({{ $note->id }})"
                                                    aria-label="Edit note">
                                                    <i class="ri-edit-line"></i>
                                                </button>
                                                <form action="{{ route('note.destroy', $note->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" aria-label="Delete note"
                                                        onclick="return confirm('Are you sure you want to delete this note?')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @if (!$hasUnpinned && $hasPinned)
                                    <div class="empty-state">
                                        <i class="ri-sticky-note-line"></i>
                                        <h3>No other notes</h3>
                                        <p>Add a note to see it here!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="ri-sticky-note-line"></i>
                            <h3>{{ isset($search) && $search !== '' ? 'No matching notes found' : 'No notes yet' }}
                            </h3>
                            <p>{{ isset($search) && $search !== '' ? 'Try a different search term' : 'Add your first note to get started!' }}
                            </p>
                        </div>
                    @endif
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
        <button class="fab" onclick="document.getElementById('noteName').focus()">
            <i class="ri-add-line"></i>
        </button>
    </div>
    {{-- import { useState } from 'react';

    export default function VirtualKeyboardDemo() {
      const [inputValue, setInputValue] = useState('');
      const [currentLanguage, setCurrentLanguage] = useState('en');
      const [isKeyboardOpen, setIsKeyboardOpen] = useState(false);
      
      // Language names
      const languages = {
        en: 'English',
        bn: 'Bengali',
        hi: 'Hindi',
        ar: 'Arabic',
        es: 'Spanish'
      };
      
      // Keyboard layouts (simplified for demo)
      const keyboardLayouts = {
        en: [
          ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p'],
          ['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l'],
          ['z', 'x', 'c', 'v', 'b', 'n', 'm', '.', ',']
        ],
        bn: [
          ['ঙ', 'য', 'ড', 'প', 'ট', 'চ', 'জ', 'হ', 'গ', 'ঘ'],
          ['ো', 'ে', '্', 'ি', 'ু', 'প', 'র', 'ক', 'ত', 'দ'],
          ['ৎ', 'ং', 'ম', 'ন', 'ব', 'ল', 'স', '।', ',']
        ],
        hi: [
          ['ौ', 'ै', 'ा', 'ी', 'ू', 'ब', 'ह', 'ग', 'द', 'ज'],
          ['ो', 'े', '्', 'ि', 'ु', 'प', 'र', 'क', 'त', 'च'],
          ['ॆ', 'ं', 'म', 'न', 'व', 'ल', 'स', '।', ',']
        ],
        ar: [
          ['ض', 'ص', 'ث', 'ق', 'ف', 'غ', 'ع', 'ه', 'خ', 'ح'],
          ['ش', 'س', 'ي', 'ب', 'ل', 'ا', 'ت', 'ن', 'م', 'ك'],
          ['ئ', 'ء', 'ؤ', 'ر', 'لا', 'ى', 'ة', 'و', 'ز', 'ظ']
        ],
        es: [
          ['q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p'],
          ['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'ñ'],
          ['z', 'x', 'c', 'v', 'b', 'n', 'm', 'á', 'é', 'í']
        ]
      };
      
      // Handle key press
      const handleKeyPress = (key) => {
        setInputValue(prev => prev + key);
      };
      
      // Toggle keyboard
      const toggleKeyboard = () => {
        setIsKeyboardOpen(!isKeyboardOpen);
      };
      
      // Change language
      const changeLanguage = (lang) => {
        setCurrentLanguage(lang);
      };
      
      // Determine text direction
      const getTextDirection = (lang) => {
        return lang === 'ar' ? 'rtl' : 'ltr';
      };
      
      return (
        <div className="flex flex-col items-center w-full max-w-md mx-auto p-4 bg-gray-50 rounded-lg shadow">
          <h2 className="text-xl font-bold text-gray-800 mb-4">Google Notes Virtual Keyboard</h2>
          
          {/* Note Input Area */}
          <div className="w-full mb-4">
            <input 
              type="text"
              value={inputValue}
              onChange={(e) => setInputValue(e.target.value)}
              placeholder="Type a note..."
              className="w-full p-3 border border-gray-300 rounded-lg mb-2"
              dir={getTextDirection(currentLanguage)}
            />
            
            <div className="flex justify-between items-center">
              {/* Keyboard Toggle Button */}
              <button 
                onClick={toggleKeyboard}
                className="flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 text-white hover:bg-blue-600"
              >
                {isKeyboardOpen ? '✕' : '⌨️'}
              </button>
              
              {/* Language Selector */}
              <select 
                value={currentLanguage}
                onChange={(e) => changeLanguage(e.target.value)}
                className="p-2 border border-gray-300 rounded-lg"
              >
                {Object.entries(languages).map(([code, name]) => (
                  <option key={code} value={code}>{name}</option>
                ))}
              </select>
            </div>
          </div>
          
          {/* Virtual Keyboard */}
          {isKeyboardOpen && (
            <div className="w-full bg-white border border-gray-300 rounded-lg shadow-lg p-2">
              <div className="flex justify-between items-center mb-2 p-2 bg-blue-500 text-white rounded-t-lg">
                <span>{languages[currentLanguage]} Keyboard</span>
                <button onClick={toggleKeyboard} className="text-white">✕</button>
              </div>
              
              <div className="keyboard-layout">
                {keyboardLayouts[currentLanguage].map((row, rowIndex) => (
                  <div key={rowIndex} className="flex justify-center mb-1">
                    {row.map((key, keyIndex) => (
                      <button
                        key={keyIndex}
                        onClick={() => handleKeyPress(key)}
                        className="min-w-8 h-10 mx-1 px-2 border border-gray-300 rounded bg-gray-50 hover:bg-gray-100"
                      >
                        {key}
                      </button>
                    ))}
                  </div>
                ))}
                
                {/* Space and Backspace row */}
                <div className="flex justify-center mb-1">
                  <button
                    onClick={() => setInputValue(prev => prev.slice(0, -1))}
                    className="min-w-16 h-10 mx-1 px-3 border border-gray-300 rounded bg-gray-200 hover:bg-gray-300"
                  >
                    ←
                  </button>
                  <button
                    onClick={() => handleKeyPress(' ')}
                    className="w-32 h-10 mx-1 border border-gray-300 rounded bg-gray-200 hover:bg-gray-300"
                  >
                    Space
                  </button>
                  <button
                    onClick={() => handleKeyPress('\n')}
                    className="min-w-16 h-10 mx-1 px-3 border border-gray-300 rounded bg-gray-200 hover:bg-gray-300"
                  >
                    ↵
                  </button>
                </div>
              </div>
            </div>
          )}
        </div>
      );
    } --}}
    <script src="{{ asset('asset/js/dashbord.js') }}"></script>
</body>
