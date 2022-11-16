
<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Nama</label>
            <input required type="text" value="{{ $user->nama }}" class="form-control" name="name">
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label for="">Email</label>
            <input required type="email" value="{{ $user->email }}" class="form-control" name="email">
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="">Role</label>
            <select name="role" id="" class="form-control select2">
                <option {{ $user->name == 'presiden' ? 'selected' : '' }} value="1">Presiden</option>
                <option {{ $user->name == 'admin' ? 'selected' : '' }} value="2">Admin</option>
            </select>
        </div>
    </div>
</div>