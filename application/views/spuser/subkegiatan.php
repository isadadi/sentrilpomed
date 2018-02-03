              <div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Tabel<small>Subkegiatan</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li> -->
                      <!-- <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li> -->
                    </ul>
                    <div class="clearfix"></div>
                  </div>
    
              <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Data kegiatan
                    </p>
                    <form method="post" action="<?=base_url('superuser/home/delete_subkegiatan')?>">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th><i class="fa fa-trash"></i></th>
                          <th>Kode</th>
                          <th>Tanggal</th>
                          <th>Waktu</th>
                          <th>Anggaran</th>
                          <th>Lokasi</th>
                          <th>Penanggungjawab</th>
                          <th>Keterangan</th>
                          <th>File</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- <input type="checkbox" id="check-all" class="flat"> -->
                       <?php foreach ($row as $rows) {?>
                          <tr>
                            <td><input type="checkbox" name="checkbox[]" id="check-all" class="flat" value="<?php echo $rows['id_subkegiatan'];?>"></td>
                            <td><?php echo $rows['id_kegiatan'];?></td>
                            <td><?php echo $rows['tanggal_kegiatan'];?></td>
                            <td><?php echo $rows['jam'];?></td>
                            <td><?php echo "Rp.".number_format($rows['anggaran'],0,'','.');?></td>
                            <td><?php echo $rows['lokasi'];?></td>
                            <td><?php echo $rows['pj_kegiatan'];?></td>
                            <td><?php echo $rows['keterangan'];?></td>
                            <td><?php echo $rows['file'];?></td>
                            <td>
                              <?php if($rows['status']=='belum verifikasi'){?>
                                <a href="<?=base_url().'superuser/home/verifikasi?id='?><?php echo $rows['id_subkegiatan'];?>&&id_keg=<?php echo $rows['id_kegiatan'];?>" onclick="return confirm('yakin ingin verifikasi?')" class="btn btn-primary"><i class="fa fa-file-text"></i></a>
                              <?php }else{?>
                                verified
                              <?php }?>
                                <button onclick="return confirm('yakin ingin menghpus?')" class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                            </td>
                          </tr>
                       <?php }?>
                      </tbody>
                    </table>
                    </form>
          
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
