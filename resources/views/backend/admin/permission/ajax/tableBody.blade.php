<table class="table table-bordered table-striped" id="">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Permision Name (English)</th>
            {{-- <th class="text-left">Permision Name (Bangla)</th>            --}}
            <th class="text-left">Created By</th>
            @can('edit_permission')

                <th>Actions</th>
            @endcan

        </tr>
    </thead>
    <tbody>
            @php
                $i = (($permissions->currentPage() - 1) * $permissions->perPage() + 1);
            @endphp
        @foreach ($permissions as $permission)
        <tr>
            <td>{{$i}}</td>
            <td align="left">{{ $permission->name_en }}</td>
            {{-- <td align="left">{{ $permission->name_bn }}</td> --}}

            <td align="left">{{ $permission->user ? ucfirst($permission->user->username) : '' }}</td>
            <td>
                @can('edit_permission')
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button  class="btn btn-sm btn-clean btn-icon" data-toggle="modal" data-target="#edit_permission{{ $permission->id }}">
                            <i class="la la-edit text-warning"></i>
                        </button>
                    </div>
                @endcan
            </td>
        </tr>

        <!--begin::Role Edit Modal-->
        <div id="edit_permission{{ $permission->id }}" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="min-height: 350px;">
                    <div class="modal-header py-5">
                        <h5 class="modal-title">Edit Permision
                        <span class="d-block text-muted font-size-sm"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="container">
                            <form class="form" action="{{ route('admin.permission.update', $permission->id) }}" method="POST">
                                @csrf

                                {{-- <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-3 col-sm-12">Permission Name (Bangla) <span style="color: red;">*</span></label>

                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                        <input type="text" required class="form-control {{ $errors->has('perm_name_bn') ? ' is-invalid' : '' }}" value="{{ $permission->name_bn}}" name="perm_name_bn" placeholder="Enter Permission Name (Bangla)" />
                                    </div>
                                </div> --}}

                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-3 col-sm-12">Permission Name (English) <span style="color: red;">*</span> </label>

                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                        <input type="text" required class="form-control {{ $errors->has('perm_name_en') ? ' is-invalid' : '' }}" name="perm_name_en" value="{{ $permission->name_en}}"placeholder="Enter Permission Name (English)" />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-3 offset-lg-4">
                                        <button class="btn btn-bg-success btn-block" style="color: aliceblue">Update</button>
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Role Modal-->

        @php
            $i++;
        @endphp
        @endforeach
    </tbody>
</table>

{{-- <div class="ajax-pagination-area">
    {{ $permissions->appends(['permissions' =>$permissions, 'q' => isset($q) ? $q : null, ])->links() }}
</div> --}}
