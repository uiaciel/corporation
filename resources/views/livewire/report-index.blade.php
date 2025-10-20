<div class="container-fluid">

    <x-import-export-offcanvas />

    <header class="page-header d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex">

        <h3 class="fw-bold me-3">All Reports

        </h3>

        <a href="{{ route('admin.report.create') }}" wire:navigate class="btn btn-sm btn-primary">Add New</a>

        </div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="/admin/announcements">Reports</a></li>
                <li class="breadcrumb-item active">All {{ $titlePage }}</li>
            </ol>
        </nav>
    </header>

   <div>
    <div class="table-responsive mb-3">

        <table class="table caption-top table-striped table-hover table-sm table-responsive-sm">
            <caption class="fw-bold fs-4">Annual Reports</caption>

            <thead class="fw-bold table-dark">
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">TITLE</th>
                    <th scope="col">DATE PUBLISH</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reportx->where('category', 'Annual Report') as $annual)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td>{{ $annual->title }}</td>
                    <td>{{ formatDate($annual->datepublish) }}</td>
                    <td>{{ Str::upper($annual->status) }}</td>
                    <td>
                        <a href="#" class="btn btn-link" wire:click.prevent="showEditModal({{ $annual->id }})">Edit</a> / <button class="btn btn-link" onclick="confirm('Are you sure you want to delete this Report?') || event.stopImmediatePropagation()" wire:click="delete({{ $annual->id }})">Delete</button>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5">Data Kosong</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-responsive mb-3">

        <table class="table caption-top  table-striped table-hover table-sm table-responsive-sm">
            <caption class="fw-bold fs-4">Financial Reports</caption>

            <thead class="fw-bold table-dark">
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">TITLE</th>
                    <th scope="col">DATE PUBLISH</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reportx->where('category', 'Financial Report') as $financial)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td>{{ $financial->title }}</td>
                    <td>{{ formatDate($financial->datepublish) }}</td>
                    <td>{{ Str::upper($financial->status) }}</td>
                    <td>
                        <a href="#" class="btn btn-link" wire:click.prevent="showEditModal({{ $financial->id }})">Edit</a> / <button class="btn btn-link" onclick="confirm('Are you sure you want to delete this Report?') || event.stopImmediatePropagation()" wire:click="delete({{ $financial->id }})">Delete</button>
                    </td>
                    <!-- Modal -->

                </tr>
                @empty
                <tr>
                    <td colspan="5">Data Kosong</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="table-responsive mb-3">
        <table class="table caption-top table-striped table-hover table-sm table-responsive-sm">
            <caption class="fw-bold fs-4">Public Offering Prospectus</caption>

            <thead class="fw-bold table-dark">
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">TITLE</th>
                    <th scope="col">DATE PUBLISH</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reportx->where('category', 'Public Offering Prospectus') as $offering)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td>{{ $offering->title }}</td>
                    <td>{{ formatDate($offering->datepublish) }}</td>
                    <td>{{ $offering->status }}</td>
                    <td>
                        <a href="#" class="btn btn-link" wire:click.prevent="showEditModal({{ $offering->id }})">Edit</a> / <button class="btn btn-link" onclick="confirm('Are you sure you want to delete this Report?') || event.stopImmediatePropagation()" wire:click="delete({{ $offering->id }})">Delete</button>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5">Data Kosong</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-responsive mb-3">
        <table class="table caption-top table-striped table-hover table-sm table-responsive-sm">
            <caption class="fw-bold fs-4">Audit Committee Charter</caption>
            <thead class="fw-bold rounded table-dark">

                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">TITLE</th>
                    <th scope="col">DATE PUBLISH</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reportx->where("category", "Audit Committee Charter") as $acc)
                <tr>
                    <td scope="row">{{ $loop->iteration }}</td>
                    <td>{{ $acc->title }}</td>
                    <td>{{ formatDate($acc->datepublish) }}</td>
                    <td>{{ $acc->status }}</td>
                    <td>
                        <a href="#" class="btn btn-link" wire:click.prevent="showEditModal({{ $acc->id }})">Edit</a> / <button class="btn btn-link" onclick="confirm('Are you sure you want to delete this Report?') || event.stopImmediatePropagation()" wire:click="delete({{ $acc->id }})">Delete</button>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5">Data Kosong</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

   </div>

    <div wire:ignore.self class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="updateReport">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMenuModalLabel">Edit Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <img src="/storage/{{ $this->editImage }}" class="img-fluid">

                            </div>
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Title</label>
                                    <input type="text" class="form-control" wire:model.defer="editTitle">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Date Publish</label>
                                    <input type="date" class="form-control" wire:model.defer="editDatepublish">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Category</label>
                                    <input type="text" class="form-control" wire:model.defer="editCategory">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select class="form-select" wire:model.defer="editStatus">
                                        <option value="Publish">Publish</option>
                                        <option value="Unpublish">Unpublish</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <p class="text-center text-wrap">PDF File : <a href="/storage/{{ $this->editPdf }}"
                                        class="text-wrap">{{
                                        $this->editPdf }}</a></p>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        window.addEventListener('showEditMenuModal', () => {
                    var modal = new bootstrap.Modal(document.getElementById('editMenuModal'));
                    modal.show();
                });
                window.addEventListener('hideEditMenuModal', () => {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('editMenuModal'));
                    if(modal) modal.hide();
                });
    </script>
    @endpush
</div>
