<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Projects Repository') }}
            </h2>
            @auth
            <button 
                onclick="openModal()"
                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700 transition">
                + Add Project
            </button>
            @endauth
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="project-card bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Search Bar -->
                <input type="text" id="searchInput" onkeyup="filterProjects()" 
                    class="w-full mb-4 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                    placeholder="Search projects...">
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; padding: 20px;">
                @foreach ($data as $project)
                <div class="project-item" style="background-color: #2d2d2d; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15); overflow: hidden; transition: transform 0.3s; padding: 15px;">
                    <!-- Image -->
                    <img src="{{ asset('projects/'.$project->image) }}" 
                        style="width: 100%; height: 200px; object-fit: cover; border-radius: 10px;" 
                        alt="{{ $project->title }}">

                    <!-- Project Info -->
                    <div style="padding: 10px;">
                        <h3 style="color: #f8f8f8; font-size: 18px; font-weight: bold; margin-top: 10px;">
                            {{ $project->title }}
                        </h3>
                        <p style="color: #b0b0b0; font-size: 14px; margin-top: 5px;">
                            {{ $project->description }}
                        </p>

                        <!-- Buttons and Source Code Link -->
                        <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                        @auth
    <a href="{{ $project->source_code }}" 
        style="color: #4A90E2; text-decoration: none; font-size: 14px;" target="_blank">
        🔗 View Source Code
    </a>
@else
    <a href="#" 
        style="color: #E53935; text-decoration: none; font-size: 14px; cursor: not-allowed;" 
        onclick="alert('You don\'t have access to source code.')">
        🔗 View Source Code
    </a>
@endauth


                            @auth
                            <div style="display: flex; gap: 5px;">
                                <button onclick="openEditModal({{ $project->id }})" 
                                    style="background-color: #FFC107; color: #2d2d2d; border: none; padding: 6px 12px; border-radius: 5px; cursor: pointer; font-weight: bold;">
                                    ✏️ Edit
                                </button>

                                <a href="{{ route('delete', $project->id) }}" style="text-decoration: none;">
                                    <button style="background-color: #E53935; color: white; border: none; padding: 6px 12px; border-radius: 5px; cursor: pointer; font-weight: bold;">
                                        ❌ Delete
                                    </button>
                                </a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
        <div id="modal-content" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-lg mx-auto transform scale-95 opacity-0 transition-transform transition-opacity duration-300">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Add New Project</h2>
            
            <form class="mt-4" action="{{ route('add') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Project Title</label>
                <input type="text" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter project title" name="title">
                @error('title') <span class="text-red-500">{{ $message }}</span> @enderror

                <label class="block mt-3 text-gray-700 dark:text-gray-300 text-sm font-medium">Short Description</label>
                <textarea class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" rows="2" placeholder="Brief project description" name="description"></textarea>
                @error('description') <span class="text-red-500">{{ $message }}</span> @enderror

                <label class="block mt-3 text-gray-700 dark:text-gray-300 text-sm font-medium">Source Code Link (Optional)</label>
                <input type="url" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter GitHub/Bitbucket link" name="source">
                @error('source') <span class="text-red-500">{{ $message }}</span> @enderror

                <div class="mt-3">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Upload Project Image</label>
                    <input type="file" class="w-full text-gray-600 dark:text-gray-300" name="img">
                    @error('img') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
        <div id="edit-modal-content" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-lg mx-auto">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Project</h2>

            <form id="editForm" action="{{ route('save_project') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit_project_id" name="project_id">

                <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Project Title</label>
                <input type="text" id="edit_title" name="title"
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                <label class="block mt-3 text-gray-700 dark:text-gray-300 text-sm font-medium">Short Description</label>
                <textarea id="edit_description" name="description"
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>

                <label class="block mt-3 text-gray-700 dark:text-gray-300 text-sm font-medium">Source Code Link (Optional)</label>
                <input type="url" id="edit_source" name="source"
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                <div class="mt-3">
                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-medium">Upload New Image (Optional)</label>
                    <input type="file" id="edit_img" name="img" class="w-full text-gray-600 dark:text-gray-300">
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
    <div id="success-message" 
        style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
               background-color: #38a169; color: white; padding: 15px 25px; 
               border-radius: 8px; font-size: 18px; font-weight: bold; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
               z-index: 9999;">
        {{ session('success') }}
    </div>
    @endif

    <footer class="w-full bg-gray-700 text-white text-center py-4 shadow-md mt-10 flex flex-col items-center">
        <p class="text-sm mb-1">&copy; {{ date('Y') }} Jerico Bautista Garcia. All Rights Reserved.</p>
        <p class="text-xs">All Projects Created and Developed by <span class="font-bold text-indigo-400">Jerico Bautista Garcia</span></p>
    </footer>

    <script src="{{ asset('js/index.js') }}"></script>
    </x-app-layout>
