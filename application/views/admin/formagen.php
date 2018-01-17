<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt"></span> Form agen</h3>
              </div>
              <div class="panel-body">
                  <form action="#">
                      <div class="form-group">
                        <label for="namaagen">Nama agen</label>
                        <input type="text" class="form-control" id="namaagen" placeholder="">
                        <input type="hidden" name="id_agen" id="id_agen" value="">
                      </div>
                      <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan"></textarea>
                      </div>
                      <div class="form-group">
                        <button type="button" name="simpanagen" id="simpanagen" class="btn btn-primary">Simpan</button>
                        <button type="button" name="resetagen"  id="resetagen" class="btn btn-warning">Reset</button>
                        <button type="button" name="updateagen" id="updateagen" class="btn btn-info" disabled="true">Update</button>
                      </div>
                  </form>
              </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-list"></span> Daftar agen</h3>
              </div>
              <div class="panel-body">
                  <table class="table table-bordered">
                      <th>No</th>
                      <th>Nama agen</th>
                      <th>Keterangan</th>
                      <th></th>
                      <tbody id="daftaragen">
                          <?php
                          $no = 1;
                          foreach ($itemagen->result() as $agen) {
                              ?>
                              <tr>
                                  <td><?php echo $no;?></td>
                                  <td><?php echo $agen->namaagen;?></td>
                                  <td><?php echo $agen->keterangan;?></td>
                                  <td>
                                      <button type="button" class="btn btn-sm btn-info" data-idagen="<?php echo $agen->id_agen;?>" name="editagen<?php echo $agen->id_agen;?>" id="editagen"><span class="glyphicon glyphicon-edit"></span></button>
                                      <button type="button" class="btn btn-sm btn-danger" data-idagen="<?php echo $agen->id_agen;?>" name="deleteagen<?php echo $agen->id_agen;?>" id="deleteagen"><span class="glyphicon glyphicon-trash"></span></button>
                                  </td>
                              </tr>
                              <?php
                              $no++;
                          }
                           ?>
                      </tbody>
                  </table>
              </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click','#simpanagen',simpanagen)
    .on('click','#resetagen',resetagen)
    .on('click','#updateagen',updateagen)
    .on('click','#editagen',editagen)
    .on('click','#deleteagen',deleteagen);
    function simpanagen() {//simpan agen
        var dataagen = {'namaagen':$('#namaagen').val(),
        'keterangan':$('#keterangan').val()};console.log(dataagen);
        $.ajax({
            url : '<?php echo site_url("admin/agen/create");?>',
            data : dataagen,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('#daftaragen').load('<?php echo current_url()." #daftaragen > *";?>');
                    resetagen();//form langsung dikosongkan pas selesai input data
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function resetagen() {//reset form agen
        $('#namaagen').val('');
        $('#keterangan').val('');
        $('#id_agen').val('');
        $('#simpanagen').attr('disabled',false);
        $('#updateagen').attr('disabled',true);
    }
    function updateagen() {//update agen
        var dataagen = {'namaagen':$('#namaagen').val(),
        'keterangan':$('#keterangan').val(),
        'id_agen':$('#id_agen').val()};console.log(dataagen);
        $.ajax({
            url : '<?php echo site_url("admin/agen/update");?>',
            data : dataagen,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('#daftaragen').load('<?php echo current_url()." #daftaragen > *";?>');
                    resetagen();//form langsung dikosongkan pas selesai input data
                }else{
                    alert(data.msg);
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
            }
        })
    }
    function editagen() {//edit agen
        var id = $(this).data('idagen');
        var dataagen = {'id_agen':id};console.log(dataagen);
        $('input[name=editagen'+id+']').attr('disabled',true);//biar ga di klik dua kali, maka di disabled
        $.ajax({
            url : '<?php echo site_url("admin/agen/edit");?>',
            data : dataagen,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('input[name=editagen'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
                    $('#simpanagen').attr('disabled',true);
                    $('#updateagen').attr('disabled',false);
                    $.each(data.msg,function(k,v){
                        $('#id_agen').val(v['id_agen']);
                        $('#namaagen').val(v['namaagen']);
                        $('#keterangan').val(v['keterangan']);
                    })
                }else{
                    alert(data.msg);
                    $('input[name=editagen'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
                }
            },
            error : function(x,t,m){
                alert(x.responseText);
                $('input[name=editagen'+id+']').attr('disabled',false);//disabled di set false, karena transaksi berhasil
            }
        })
    }
    function deleteagen() {//delete agen
        if (confirm("Anda yakin akan menghapus data agen ini?")) {
            var id = $(this).data('idagen');
            var dataagen = {'id_agen':id};console.log(dataagen);
            $.ajax({
                url : '<?php echo site_url("admin/agen/delete");?>',
                data : dataagen,
                dataType : 'json',
                type : 'POST',
                success : function(data,status){
                    if (data.status!='error') {
                        $('#daftaragen').load('<?php echo current_url()." #daftaragen > *";?>');
                        resetagen();//form langsung dikosongkan pas selesai input data
                    }else{
                        alert(data.msg);
                    }
                },
                error : function(x,t,m){
                    alert(x.responseText);
                }
            })
        }
    }
</script>