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
        <form wire:submit.prevent="save">
        <div class="col-xl-12">
        @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session()->has('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>Info!</strong> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Validation Error!</strong> Please check the form for errors.
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="row mt-3">
                        <div class="col-md-3 ms-auto text-start mt-n1 mb-3">
                            <div class="mb-3">
                                <div x-data="{ selectedCategory: @entangle('category'), categories: @js($this->categories) }">
                                    <label for="category" class="form-label fw-bold">CATEGORY <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="categoryID" x-model="selectedCategory" class="form-control @error('category') is-invalid @enderror" placeholder="Select or type a category">
                                        <button class="btn btn-outline-secondary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-list"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <template x-for="category in categories" :key="category">
                                                <li>
                                                    <a href="#" class="dropdown-item" @click.prevent="selectedCategory = category" x-text="category"></a>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                    @error('category')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="col mb-3">
                            <label for="" class="form-label fw-bold">Status</label>
                            <select id="status" wire:model="status" class="form-control">
                                <option value="Publish">Publish</option>
                                <option value="Draf">Draf</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="" class="form-label fw-bold">Date Publish</label>
                            <input type="date" id="datepublish" wire:model="datepublish" class="form-control">
                        </div>

                        <div class="col">
                            <label for="homepage" class="form-label fw-bold">Show to Homepage</label>
                            <select id="homepage" wire:model.defer="homepage" class="form-control">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                            @error('homepage')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label fw-bold">Title</label>
                                <input type="text" class="form-control" id="title" wire:model.defer="title">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Upload File Pdf <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('pdf') is-invalid @enderror" wire:model="pdf" required accept="application/pdf">

                                @error('pdf')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                                <div wire:loading wire:target="pdf" class="mt-2">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Uploading...</span>
                                    </div>
                                    <span class="ms-2">Uploading PDF...</span>
                                </div>
                            </div>
                            <hr />

                            <div class="mb-3">
                                <label for="content" class="form-label fw-bold">Content</label>
                                <textarea class="form-control" id="content" rows="3" wire:model.defer="content"></textarea>
                                @error('content')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-6">
                            {{-- PDF Preview --}}

                            @if ($pdfPreview)
                            <div class="mb-3">
                                <label class="form-label fw-bold">PDF Preview:</label>
                                <iframe src="{{ $pdfPreview }}" width="100%" height="400px"></iframe>
                            </div>
                            @endif

                            {{-- Cover Preview --}}
                            @if ($coverPreview)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cover Preview:</label>
                                <img src="{{ $coverPreview }}" alt="Cover Preview" class="img-fluid">
                            </div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>
        </div>

        </form>
    </div>
</div>
