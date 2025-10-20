<div class="container-fluid">
    <header class="page-header d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-2">Create Announcement</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.announcement.index') }}" wire:navigate>Announcements</a></li>
                <li class="breadcrumb-item active">Create New</li>
            </ol>
        </nav>
    </header>

    <x-session-status />

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow rounded mb-3">
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title">
                            @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror" wire:model="category">
                            @error('category') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" rows="5" wire:model="content"></textarea>
                            @error('content') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" wire:model="image">
                            <div class="form-text">Accepted file types: .jpg, .png, .gif (Max: 2MB)</div>
                            @error('image') <span class="invalid-feedback">{{ $message }}</span> @enderror

                            @if ($image)
                                <img src="{{ $image->temporaryUrl() }}" class="mt-2 img-fluid img-thumbnail">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">PDF Document</label>
                            <input type="file" class="form-control @error('pdf') is-invalid @enderror" wire:model="pdf">
                            <div class="form-text">Accepted file type: .pdf (Max: 5MB)</div>
                            @error('pdf') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Show on Homepage</label>
                                    <select class="form-select @error('homepage') is-invalid @enderror" wire:model="homepage">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    @error('homepage') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" wire:model="status">
                                        <option value="Publish">Publish</option>
                                        <option value="Draf">Draft</option>
                                    </select>
                                    @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Publish Date</label>
                                    <input type="date" class="form-control @error('datepublish') is-invalid @enderror" wire:model="datepublish">
                                    @error('datepublish') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.announcement.index') }}" wire:navigate class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading.remove wire:target="save">Save Announcement</span>
                                <span wire:loading wire:target="save">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Saving...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow rounded">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Help & Tips</h5>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Creating an Announcement</h6>
                    <ul class="text-muted">
                        <li>Title should be clear and descriptive</li>
                        <li>Choose relevant category for better organization</li>
                        <li>Use the content area for detailed information</li>
                        <li>Images should be high quality but optimized</li>
                        <li>PDF documents should be readable and properly formatted</li>
                    </ul>

                    <h6 class="fw-bold mt-4">Display Settings</h6>
                    <ul class="text-muted">
                        <li>"Show on Homepage" makes it visible on the main page</li>
                        <li>Draft status keeps it hidden from public view</li>
                        <li>Publish date determines when it becomes visible</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
