<?php
  $tanggal = explode('-', $tanggal);
?>
                  <h5><a href="<?=$_SERVER['HTTP_REFERER']?>"> < kembali </a> | Tanggal : <?=$tanggal[2].'-'.$tanggal[1].'-'.$tanggal[0]?></h5>
                    <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                         <th>No</th>                          
                          <th>Lokasi</th>
                          <th>PJ Kegiatan</th>                          
                          <th>File</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- <input type="checkbox" id="check-all" class="flat"> -->
                       <?php $i=1; foreach ($file as $rows) {?>
                          <tr>
                            <td><?=$i++;?></td>                           
                            <td><?php echo $rows['lokasi'];?></td>
                            <td><?php echo $rows['pj_kegiatan'];?></td>                            
                            <?php if($rows['file'] != ''){ ?>
                             <td><a href="<?=base_url('assets/file/').$rows['file'];?>">download</a></td>
                            <?php }else{ ?>
                            <td>Tidak ada file</td>
                            <?php } ?>
                          </tr>
                       <?php }?>
                      </tbody>
                    </table>