@if(auth()->user()->can('users.edit') || auth()->user()->can('users.password') || auth()->user()->can('users.delete'))
    @can('users.edit')
        <a href="{{ route('users.edit', ['id' => $id_hash]) }}" class="btn btn-outline-success btn-elevate-hover btn-circle btn-icon btn-sm" title="تعديل">
            <i class="la la-edit"></i>
        </a>
    @endcan
    &nbsp;
    @can('users.password')
        <a href="{{ route('users.password', ['id' => $id_hash]) }}" class="btn btn-outline-warning btn-elevate-hover btn-circle btn-icon btn-sm" title="كلمة المرور">
            <i class="la la-unlock"></i>
        </a>
    @endcan
    &nbsp;
    @can('users.permissions')
        <a href="{{ route('users.permissions',[ 'id' => $id_hash]) }}" class="btn btn-outline-info btn-elevate-hover btn-circle btn-icon btn-sm" title="الصلاحيات">
            <i class="fa fa-lock"></i>
        </a>
    @endcan

    @can('users.delete')
        <a href="javascript:;" data-url="{{ route('users.delete', ['id' => $id_hash]) }}" class="btn btn-outline-danger btn-elevate-hover btn-circle btn-icon btn-sm delete_btn" title="حذف">
            <i class="la la-trash"></i>
        </a>
    @endcan
@endif
