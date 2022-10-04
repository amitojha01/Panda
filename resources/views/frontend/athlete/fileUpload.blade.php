<form id="import_excl" enctype="multipart/form-data" method="post" action="{{ route('file.save') }}"
class="mainbluepanelddd">
@csrf
    <div class="col-md-6">
        <div class="form-group">
            <label for="vendor_id"></label>
            <input type="file" name="distributer_medicine"
                   style="opacity:1;"
                   accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
        </div>
    </div>
    
    <input type="submit" name="sbmt"
    class="btn btn-default"
    value="Import List"
    style="border:1px solid #314b9b; color:#314b9b; height: 35px;"/>
</form>