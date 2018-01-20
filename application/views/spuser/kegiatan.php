<div class="row">
             <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Tabel<small>Kegiatan</small></h2>
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
                      <li>
                          <a href="<?=base_url('superuser/home/add_kegiatan')?>">
                            <button class="btn btn-primary">
                            <i class="fa fa-plus"></i> Tambah
                          </button>
                          </a>
                        </a>  
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
    

              <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Data kegiatan
                    </p>
                    <form method="post" action="<?=base_url('superuser/home/delete')?>">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th><i class="fa fa-trash"></i></th>
                          <th>Kode</th>
                          <th>Nama Kegiatan</th>
                          <th>Target</th>
                          <th>Anggaran</th>
                          <th>Realisasi target</th>
                          <th>Tanggal mulai</th>
                          <th>Lokasi</th>
                          <th>Penanggungjawab</th>
                          <th>Realisasi Anggaran</th>
                          <th>Sisa Anggaran</th>
                          <th>Keterangan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- <input type="checkbox" id="check-all" class="flat"> -->
                       <?php foreach ($row as $rows) {?>
                          <tr>
                            <td><input type="checkbox" name="checkbox[]" id="check-all" class="flat" value="<?php echo $rows['id_kegiatan'];?>"></td>
                            <td><?php echo $rows['id_kegiatan'];?></td>
                            <td><?php echo $rows['nama_kegiatan'];?></td>
                            <td><?php echo $rows['target'];?></td>
                            <td><?php echo "Rp.".number_format($rows['anggaran'],0,'','.');?></td>
                            <td><?php echo $rows['realisasi'];?></td>
                            <td><?php echo $rows['tanggal'];?></td>
                            <td><?php echo $rows['lokasi'];?></td>
                            <td><?php echo $rows['nama_pj'];?></td>
                            <td><?php echo "Rp.".number_format($rows['realisasi_anggaran'],0,'','.');?></td>
                            <td><?php echo "Rp.".number_format($rows['sisa_anggaran'],0,'','.');?></td>
                            <td><?php echo $rows['keterangan'];?></td>
                            <td>
                                <a href="#" class="btn btn-primary"><i class="fa fa-file-text"></i></a>
                                <button onclick="return confirm('yakin ingin menghpus?')" class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                            </td>
                          </tr>
                       <?php }?>

                      </tbody>
                    </table>
                    </form>
                    <table>
                      <?php foreach($total as $row){?>
                      <tr>
                        <td>Total kegiatan &nbsp</td>
                        <td> : </td>
                        <td>&nbsp <?php echo $row->total_kegiatan;?></td>
                      </tr>
                      <tr>
                        <td>Total Anggaran &nbsp</td>
                        <td> : </td>
                        <td>&nbsp <?php echo "Rp. ".number_format($row->total_anggaran,0,'','.');?></td>
                      </tr>
                      <tr>
                        <td>Total Sisa Anggaran &nbsp</td>
                        <td> : </td>
                        <td>&nbsp <?php echo "Rp. ".number_format($row->sisa_anggaran,0,'','.');?></td>
                      </tr>
                      <?php }?>
                    </table>
                    <br>
                    <a href="#" class="btn btn-success"><i class="fa fa-print"></i> print</a>
                    <br>1.kalau di klik terbuka tampilan pdf (pake mpdf) dan tinggal download atau print senpai,<br>
                    2. kemudian tampilan edit button di sebelah hapus button buat kek kemarin senpai yang pake modal<br>
                    3. di side menu ada laporan kegiatan, itu isinya nanti folder-folder tempat simpan link2 file subkegiatan yang di upload, dipisah berdasarkan tanggal kegiatan dia senpai foldernya<br>
                    4. ke side menu data user,perbaiki CRUD add usernya senpai, itu baru bisa add dan delete, tapi passnya ga aku md5 kan, karena gatau cek loginnya apakah cuma md5 apa cemana <br>
                    5. Buat di CRUD kegiatannya, pas kegiatan dihapus maka di sub kegiatan dengan id yang sama terhapus juga,begitu juga dengan filenya di unlink
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
