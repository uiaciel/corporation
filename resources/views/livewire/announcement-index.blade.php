<div class="container-fluid">
    <x-corporation-import-export-offcanvas />

     <header class="page-header d-flex justify-content-between align-items-center mb-3">
         <h3 class="fw-bold mb-2">Announcements

         </h3>
         <nav aria-label="breadcrumb">
             <ol class="breadcrumb mb-0">
                 <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Admin</a></li>
                 <li class="breadcrumb-item"><a href="/admin/corporation/announcements">Announcements</a></li>
                 <li class="breadcrumb-item active">All {{ $titlePage }}</li>
             </ol>
         </nav>
     </header>

    <x-corporation-session-status />

<div class="card border-0 shadow rounded">
 <div class="card-header d-flex justify-content-between align-items-center">

        <div class="input-group w-25">
            <span class="input-group-text" id="basic-addon1">Search: </span>
            <input type="text" class="form-control form-control-sm" placeholder="Search by title or category..." aria-label="Search" aria-describedby="basic-addon1" wire:model.live="search">

        </div>

        <div class="d-flex">

               <div class="btn-group me-3" role="group" aria-label="Filter options">
                   <button type="button" class="btn btn-sm {{ $filterHomepage ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="filterByHomepage">Homepage</button>
                   <button type="button" class="btn btn-sm {{ $filterStatus ? 'btn-success' : 'btn-outline-success' }}" wire:click="filterByStatus">Status</button>
                   <button type="button" class="btn btn-sm {{ $filterDateModified ? 'btn-info' : 'btn-outline-info' }}" wire:click="filterByDateModified">Date Modified</button>
               </div>

             <a href="{{ route('admin.announcement.create') }}" wire:navigate class="btn btn-sm btn-primary">Add New</a>

         </div>

 </div>

    <div class="card-body">

    <div class="table-responsive">
         <table class="table table-hover">
             <thead class="bg-dark">
                 <tr>
                     <th class="" scope="col">No</th>
                     <th class="" scope="col">Title</th>

                     <th class="" scope="col">Status</th>
                     <th class="" scope="col">Date Publish</th>
                     <th class="" scope="col">Action</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($announcementz as $announcementx)
                 <tr>
                     <th scope="row">{{ $loop->iteration }}</th>
                     <td>
                         <div class="fw-bold mb-0">{{ $announcementx->title }} @if($announcementx->status == 'publish')<span class="badge text-bg-primary">Homepage</span>@endif <span><a href="/announcement/{{ $announcementx->slug }}" target="_blank"><i class="ti ti-external-link"></i></a></span></div><br>

                         <small><em>Category: {{ $announcementx->category }}</em></small>
                     </td>

                     <td>{{ $announcementx->status }}</td>
                     <td>{{ formatDate($announcementx->datepublish) }}</td>

                     <td><a href="#" class="btn btn-link" wire:click.prevent="showEditModal({{ $announcementx->id }})">Edit</a> / <button class="btn btn-link" onclick="confirm('Are you sure you want to delete this Announcement?') || event.stopImmediatePropagation()" wire:click="delete({{ $announcementx->id }})">Delete</button></td>
                 </tr>
                 @endforeach

             </tbody>
         </table>

    </div>
    </div>
</div>
    <div wire:ignore.self class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="updateAnnouncement">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMenuModalLabel">Edit Announcement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <img src="/storage/{{ $this->editImage }}" class="img-fluid border shadow">
                                <p class="text-center">PDF File : <a href="/storage/{{ $this->editPdf }}">{{
                                        $this->editPdf }}</a></p>
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
                                    <label class="form-label fw-bold">Homepage</label>
                                    <select class="form-select" wire:model.defer="editHomepage">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select class="form-select" wire:model.defer="editStatus">
                                        <option value="Publish">Publish</option>
                                        <option value="Draf">Draf</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
