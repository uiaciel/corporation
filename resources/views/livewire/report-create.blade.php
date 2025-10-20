<div>
    <form wire:submit.prevent="store">

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title"><i class="bi bi-filetype-pdf"></i> Submit Report</h4>

                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="card-body">

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

                <div class="row">
                    <div class="col-lg-4">
                    <div class="card rounded rounded-3 h-100">
                        @if ($coverPreview)
                            <div class="card-body text-center">
                                <label class="form-label fw-bold fw-bold d-block">Cover Preview:</label>
                                <img src="{{ $coverPreview }}" alt="Cover Preview" class="img-fluid border shadow rounded" style="max-height: 250px;">
                            </div>
                        @else
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <label for="pdf-upload" class="text-center" style="cursor: pointer; border: 2px dashed #ccc; padding: 2rem; border-radius: .5rem; width: 100%;">
                                    <i class="bi bi-cloud-arrow-up fs-1"></i>
                                    <p class="mb-1 mt-2">Please Upload PDF File</p>
                                    <p class="text-muted mb-2">to generate Preview</p>
                                    <span class="btn btn-primary">Upload File</span>
                                </label>
                            </div>
                        @endif
                    </div>

                    </div>
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold fw-bold">Upload File Pdf <span class="text-danger">*</span></label>
                            <input type="file" id="pdf-upload" class="form-control @error('pdf') is-invalid @enderror" wire:model="pdf"
                                required accept="application/pdf">

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
                            <label for="title" class="form-label fw-bold">Title</label>
                            <input type="text" class="form-control" id="title" wire:model.defer="title">
                            @error('title')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div
                                x-data="{ selectedCategory: @entangle('category'), categories: @js($this->categories) }">
                                <label for="category" class="form-label fw-bold">Category <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="categoryID" x-model="selectedCategory"
                                        class="form-control @error('category') is-invalid @enderror"
                                        placeholder="Select or type a category">
                                    <button class="btn btn-outline-secondary" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-list"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <template x-for="category in categories" :key="category">
                                            <li>
                                                <a href="#" class="dropdown-item"
                                                    @click.prevent="selectedCategory = category" x-text="category"></a>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                @error('category')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Date Publish</label>
                            <input class="form-control" type="date" wire.model.defer="datepublish">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select class="form-select" wire.model.defer="status">
                                <option value="Publish">Publish</option>
                                <option value="Unpublish">Unpublish</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <hr />
                        @if ($pdfPreview)
                        <div class="mb-3">
                            <label class="form-label fw-bold">PDF Preview:</label>
                            <iframe src="{{ $pdfPreview }}" width="100%" height="400px"></iframe>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
