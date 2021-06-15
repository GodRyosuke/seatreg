@can('ユーザ管理')
<div class="card">
    <div class="card-header">
        <h4>ユーザ管理</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('users.assign_roles') }}">
            @csrf
            <x-form-element type="option" name="role_name" value="{{ $room->building->id ?? '' }}"  label="役割名称" :items="Spatie\Permission\Models\Role::all()->implode('name', ',')"/>
            <x-form-element name="ocuids" label="対象者（OCUID）" value="" />
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">追加</button>
            </div>
        </form>
    </div>
</div>
@endcan

