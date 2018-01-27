              <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Data kegiatan
                    </p>
                    <!-- <form method="post" action="<?=base_url('admin/home/delete')?>"> -->
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Kode</th>
                          <th>Nama Kegiatan</th>
                          <th>Target</th>
                          <th>Realisasi target</th>
                          <th>Sisa Target</th>
                          <th>Anggaran</th>
                          <th>Realisasi Anggaran</th>
                          <th>Sisa Anggaran</th>
                          <th>Tanggal mulai</th>
                          <th>Lokasi</th>
                          <th>Penanggungjawab</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- <input type="checkbox" id="check-all" class="flat"> -->
                       <?php foreach ($row as $rows) {?>
                          <tr>
                            <td><?php echo $rows['id_kegiatan'];?></td>
                            <td><?php echo $rows['nama_kegiatan'];?></td>
                            <td><?php echo $rows['target'];?></td>
                            <td><?php echo $rows['realisasi'];?></td>
                            <td><?php echo ($rows['target']-$rows['realisasi']);?></td>
                            <td><?php echo "Rp.".number_format($rows['anggaran'],0,'','.');?></td>
                            <td><?php echo "Rp.".number_format($rows['realisasi_anggaran'],0,'','.');?></td>
                            <td><?php echo "Rp.".number_format($rows['sisa_anggaran'],0,'','.');?></td>
                            <td><?php echo $rows['tanggal'];?></td>
                            <td><?php echo $rows['lokasi'];?></td>
                            <td><?php echo $rows['nama_pj'];?></td>
                            <td><?php echo $rows['keterangan'];?></td>
                          </tr>
                       <?php }?>
                      </tbody>
                    </table>
            <!--         </form> -->
          
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
