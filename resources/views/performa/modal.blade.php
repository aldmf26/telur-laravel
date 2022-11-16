<input type="hidden" name="id_performa" value="{{ $performa->id_peformance }}">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered table-info">
                <tr class="text-dark">
                    <th>Umur (minggu)</th>
                    <th>% Telur</th>
                    <th>Berat Badan (g)</th>
                    <th>Feed Intake</th>
                    <th>Berat telur (g)</th>
                </tr>
                <tr>
                    <td><input type="text" value="{{ $performa->umur }}" name="umur" class="form-control"></td>
                    <td><input type="text" value="{{ $performa->telur }}" name="telur" class="form-control"></td>
                    <td><input type="text" value="{{ $performa->berat }}" name="berat" class="form-control"></td>
                    <td><input type="text" value="{{ $performa->feed }}" name="feed" class="form-control"></td>
                    <td><input type="text" value="{{ $performa->berat_telur }}" name="berat_telur" class="form-control"></td>
                </tr>
            </table>
        </div>
    </div>
